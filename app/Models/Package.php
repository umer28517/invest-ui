<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'investment_amount',
        'min_investment',
        'max_investment',
        'daily_commission_percent',
        'min_daily_profit_percent',
        'max_daily_profit_percent',
        'referral_commission_percent',
        'min_trade_profit_percent',
        'max_trade_profit_percent',
        'min_withdrawal_limit',
        'duration_days',
        'badge',
        'description',
        'is_active',
    ];

    /**
     * Users subscribed to this package tier.
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'active_package_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'investment_amount' => 'decimal:2',
            'min_investment' => 'decimal:2',
            'max_investment' => 'decimal:2',
            'daily_commission_percent' => 'decimal:2',
            'min_daily_profit_percent' => 'decimal:2',
            'max_daily_profit_percent' => 'decimal:2',
            'referral_commission_percent' => 'decimal:2',
            'min_trade_profit_percent' => 'decimal:2',
            'max_trade_profit_percent' => 'decimal:2',
            'min_withdrawal_limit' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Effective minimum investment amount for this package range.
     */
    public function getEffectiveMinInvestmentAttribute(): float
    {
        return (float) ($this->min_investment ?? $this->investment_amount);
    }

    /**
     * Effective maximum investment amount for this package range.
     */
    public function getEffectiveMaxInvestmentAttribute(): float
    {
        if ($this->max_investment !== null && (float) $this->max_investment > 0) {
            return (float) $this->max_investment;
        }

        return (float) ($this->investment_amount > 0 ? $this->investment_amount * 2 : 100000.00);
    }

    /**
     * Effective minimum daily profit percentage.
     */
    public function getEffectiveMinDailyProfitAttribute(): float
    {
        return (float) ($this->min_daily_profit_percent ?? $this->daily_commission_percent);
    }

    /**
     * Effective maximum daily profit percentage.
     */
    public function getEffectiveMaxDailyProfitAttribute(): float
    {
        if ($this->max_daily_profit_percent !== null && (float) $this->max_daily_profit_percent > 0) {
            return (float) $this->max_daily_profit_percent;
        }

        return (float) $this->daily_commission_percent;
    }

    /**
     * Formatted price range string (e.g. "$100.00 – $200.00").
     */
    public function getPriceRangeTextAttribute(): string
    {
        $min = $this->effective_min_investment;
        $max = $this->effective_max_investment;

        if ($max <= $min) {
            return '$' . number_format($min, 2);
        }

        return '$' . number_format($min, 2) . ' – $' . number_format($max, 2);
    }

    /**
     * Formatted daily profit range string (e.g. "2.00% – 3.00%").
     */
    public function getDailyProfitRangeTextAttribute(): string
    {
        $min = $this->effective_min_daily_profit;
        $max = $this->effective_max_daily_profit;

        if ($max <= $min) {
            return '+' . number_format($min, 2) . '%';
        }

        return '+' . number_format($min, 2) . '% – ' . number_format($max, 2) . '%';
    }

    /**
     * Generate a daily rate randomly within this package's profit percentage range.
     */
    public function generateRandomDailyRate(): float
    {
        $min = (float) $this->effective_min_daily_profit;
        $max = (float) $this->effective_max_daily_profit;

        if ($max <= $min) {
            return $min;
        }

        $minCents = (int) round($min * 100);
        $maxCents = (int) round($max * 100);

        if ($maxCents <= $minCents) {
            return $min;
        }

        $randomCents = mt_rand($minCents, $maxCents);

        return round($randomCents / 100, 2);
    }

    /**
     * Formatted trade profit percentage range.
     */
    public function getTradeProfitRangeTextAttribute(): string
    {
        $min = (float) ($this->min_trade_profit_percent ?? $this->effective_min_daily_profit);
        $max = (float) ($this->max_trade_profit_percent ?? $this->effective_max_daily_profit);

        if ($max <= $min) {
            return '+' . number_format($min, 2) . '%';
        }

        return '+' . number_format($min, 2) . '% – ' . number_format($max, 2) . '%';
    }

    /**
     * Generate a trade profit rate randomly within this package's trade range.
     */
    public function generateRandomTradeRate(): float
    {
        $min = (float) ($this->min_trade_profit_percent ?? $this->effective_min_daily_profit);
        $max = (float) ($this->max_trade_profit_percent ?? $this->effective_max_daily_profit);

        if ($max <= $min) {
            return $min;
        }

        $minCents = (int) round($min * 100);
        $maxCents = (int) round($max * 100);

        if ($maxCents <= $minCents) {
            return $min;
        }

        $randomCents = mt_rand($minCents, $maxCents);

        return round($randomCents / 100, 2);
    }
}
