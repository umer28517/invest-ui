<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
        'balance',
        'withdrawn_total',
        'locked_until',
        'locked_principal',
        'active_daily_rate',
        'active_package_id',
        'referral_code',
        'referred_by',
    ];

    /**
     * Check if user has admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has standard user role.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user account is currently active.
     */
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Check if user's capital is locked under the 30-day rule.
     */
    public function isCapitalLocked(): bool
    {
        return $this->locked_until 
            && now()->lessThan($this->locked_until) 
            && (float) $this->locked_principal > 0;
    }

    /**
     * Days remaining until capital unlocks.
     */
    public function daysRemainingLocked(): int
    {
        if (! $this->isCapitalLocked()) {
            return 0;
        }

        return (int) ceil(now()->diffInSeconds($this->locked_until) / 86400);
    }

    /**
     * Get maximum balance withdrawable right now.
     * During 30-day lock: Base principal is protected, accrued daily profit can be withdrawn.
     * After 30 days: Full balance is withdrawable.
     * While in trade: Frozen balance is temporarily deducted from withdrawable funds.
     */
    public function getWithdrawableBalance(): float
    {
        $currentBalance = max(0, (float) $this->balance - (float) ($this->frozen_balance ?? 0));
        if ($this->isCapitalLocked()) {
            $withdrawable = max(0, $currentBalance - (float) $this->locked_principal);
            return round($withdrawable, 2);
        }

        return round($currentBalance, 2);
    }

    /**
     * User's trade sessions history.
     */
    public function tradeSessions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TradeSession::class);
    }

    /**
     * Active ongoing trade session, if any.
     */
    public function activeTradeSession(): ?TradeSession
    {
        return $this->tradeSessions()->where('status', 'running')->latest()->first();
    }

    /**
     * Check if a 30-minute trade session is actively in progress.
     */
    public function isTradeRunning(): bool
    {
        return $this->trade_active_until !== null && now()->lessThan($this->trade_active_until);
    }

    /**
     * Whether user is eligible to initiate a 24-hour cycle trade right now.
     */
    public function canTrade(): bool
    {
        $hasActivePackage = $this->active_package_id !== null || $this->deposits()->where('status', 'approved')->exists();
        if (! $hasActivePackage || (float) $this->balance <= 0) {
            return false;
        }

        if ($this->isTradeRunning()) {
            return false;
        }

        if ($this->next_trade_available_at !== null && now()->lessThan($this->next_trade_available_at)) {
            return false;
        }

        return true;
    }

    /**
     * Seconds remaining in 24-hour cooling window.
     */
    public function secondsUntilNextTrade(): int
    {
        if ($this->next_trade_available_at === null || now()->greaterThanOrEqualTo($this->next_trade_available_at)) {
            return 0;
        }

        return max(0, now()->diffInSeconds($this->next_trade_available_at, false));
    }

    /**
     * Compute dynamic effective tier and daily compounding percentage.
     * Rule:
     * 1. Subscribed package defines user's minimum guaranteed floor rate.
     * 2. If compounding balance reaches or exceeds a higher package threshold,
     *    user is automatically upgraded to the higher tier.
     * 3. If balance drops due to withdrawal, tier falls back but NEVER drops
     *    below the user's officially subscribed package rate.
     */
    public function getEffectiveTier(): array
    {
        $subscribedPackage = $this->activePackage;
        $baseRate = (float) ($subscribedPackage?->daily_commission_percent ?? $this->active_daily_rate ?? 0);
        $currentBalance = (float) $this->balance;

        if ($currentBalance <= 0 || $baseRate <= 0) {
            return [
                'package' => $subscribedPackage,
                'daily_rate' => $baseRate,
                'is_upgraded' => false,
            ];
        }

        // Search active packages qualifying by current compounding balance
        $qualifyingPackages = Package::where('is_active', true)
            ->where('investment_amount', '<=', $currentBalance)
            ->orderBy('investment_amount', 'desc')
            ->get();

        $bestPackage = $qualifyingPackages->first();

        if ($bestPackage && (float) $bestPackage->daily_commission_percent > $baseRate) {
            return [
                'package' => $bestPackage,
                'daily_rate' => (float) $bestPackage->daily_commission_percent,
                'is_upgraded' => true,
            ];
        }

        return [
            'package' => $subscribedPackage,
            'daily_rate' => $baseRate,
            'is_upgraded' => false,
        ];
    }

    /**
     * Dynamic effective daily compounding rate accessor.
     */
    public function getEffectiveDailyRateAttribute(): float
    {
        return $this->getEffectiveTier()['daily_rate'];
    }

    /**
     * Dynamic effective package tier accessor.
     */
    public function getEffectivePackageAttribute(): ?Package
    {
        return $this->getEffectiveTier()['package'];
    }

    /**
     * Check if user is currently auto-upgraded via compounding balance.
     */
    public function getIsTierUpgradedAttribute(): bool
    {
        return $this->getEffectiveTier()['is_upgraded'];
    }

    /**
     * Active package.
     */
    public function activePackage(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Package::class, 'active_package_id');
    }

    /**
     * Deposit requests made by this user.
     */
    public function deposits(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DepositRequest::class, 'user_id')->latest();
    }

    /**
     * Yield distributions earned by this user.
     */
    public function yieldDistributions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(YieldDistribution::class, 'user_id')->latest();
    }

    /**
     * Withdrawal requests submitted by this user.
     */
    public function withdrawals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WithdrawalRequest::class, 'user_id')->latest();
    }

    /**
     * Users referred by this user.
     */
    public function referrals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'referred_by', 'referral_code')->latest();
    }

    /**
     * The direct upline referrer of this user.
     */
    public function referrer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_by', 'referral_code');
    }

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                $user->referral_code = 'VERDANT_' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
            }
        });
    }

    /**
     * Notifications received by this user.
     */
    public function notifications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserNotification::class, 'user_id')->latest();
    }

    /**
     * Unread notifications count.
     */
    public function unreadNotificationsCount(): int
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'balance' => 'decimal:2',
            'withdrawn_total' => 'decimal:2',
            'locked_until' => 'datetime',
            'locked_principal' => 'decimal:2',
            'active_daily_rate' => 'decimal:2',
        ];
    }
}
