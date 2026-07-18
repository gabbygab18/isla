<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'icon',
        'title',
        'slug',
        'summary',
        'body',
        'deliverables',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'deliverables' => 'array',
        'roles'        => 'array',
        'is_active'    => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
