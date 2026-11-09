<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class YieldDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'starting_balance',
        'rate_percent',
        'profit_earned',
        'new_balance',
    ];

    protected $casts = [
        'starting_balance' => 'decimal:2',
        'rate_percent' => 'decimal:2',
        'profit_earned' => 'decimal:2',
        'new_balance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
