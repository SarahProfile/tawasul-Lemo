<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactLocation extends Model
{
    protected $fillable = [
        'name',
        'address', 
        'city',
        'country',
        'phone',
        'email',
        'latitude',
        'longitude',
        'map_embed_url',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
