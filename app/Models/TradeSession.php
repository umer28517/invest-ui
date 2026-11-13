<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'amount',
        'rate_percent',
        'profit_earned',
        'started_at',
        'completes_at',
        'settled_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'rate_percent' => 'decimal:2',
            'profit_earned' => 'decimal:2',
            'started_at' => 'datetime',
            'completes_at' => 'datetime',
            'settled_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function isRunning(): bool
    {
        return $this->status === 'running';
    }

    public function isSettled(): bool
    {
        return $this->status === 'settled';
    }

    public function isCompleted(): bool
    {
        return $this->completes_at !== null && now()->greaterThanOrEqualTo($this->completes_at);
    }

    public function secondsRemaining(): int
    {
        if (! $this->isRunning() || ! $this->completes_at) {
            return 0;
        }

        return max(0, now()->diffInSeconds($this->completes_at, false));
    }
}
