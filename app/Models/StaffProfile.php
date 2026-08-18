<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'role_title',
        'category',
        'photo_url',
        'about_me',
        'rate',
        'work_preference',
        'availability',
        'experience',
        'education',
        'core_skills',
        'software_expertise',
        'certifications',
        'affiliations',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'experience'          => 'array',
        'education'           => 'array',
        'core_skills'         => 'array',
        'software_expertise'  => 'array',
        'certifications'      => 'array',
        'affiliations'        => 'array',
        'is_active'           => 'boolean',
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
