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
        'daily_commission_percent',
        'min_withdrawal_limit',
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
            'daily_commission_percent' => 'decimal:2',
            'min_withdrawal_limit' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
