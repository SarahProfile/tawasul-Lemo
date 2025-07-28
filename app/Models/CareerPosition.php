<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerPosition extends Model
{
    protected $fillable = [
        'title',
        'image',
        'responsibilities',
        'is_active',
        'order'
    ];

    protected $casts = [
        'responsibilities' => 'array',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
