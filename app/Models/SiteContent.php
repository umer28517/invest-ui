<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'group',
        'section',
        'label',
        'type',
        'value',
        'default_value',
    ];

    /**
     * Get value or fallback to default value.
     */
    public function getEffectiveValueAttribute(): string
    {
        if (!empty($this->value) && trim($this->value) !== '') {
            return $this->value;
        }

        return $this->default_value ?? '';
    }
}
