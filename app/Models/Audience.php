<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'slug',
        'summary',
        'body',
        'points',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'points'    => 'array',
        'is_active' => 'boolean',
    ];

    // Use the slug in route-model binding (e.g. /who-we-work-with/ndis-disability-support)
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
