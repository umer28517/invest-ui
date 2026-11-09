<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BroadcastNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'body',
        'created_by',
        'recipients_count',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userNotifications(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'broadcast_id');
    }
}
