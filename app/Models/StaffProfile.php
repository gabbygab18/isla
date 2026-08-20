<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StaffProfile extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'role_title',
        'talent_role_id',
        'talent_sub_role_id',
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

    protected $appends = ['photo_display_url'];

    /**
     * photo_url holds either a pasted external URL (CSV imports) or a path on
     * the public disk (admin uploads) — resolve both to something renderable.
     */
    public function getPhotoDisplayUrlAttribute(): ?string
    {
        if (! $this->photo_url) {
            return null;
        }

        return Str::startsWith($this->photo_url, ['http://', 'https://', '/'])
            ? $this->photo_url
            : Storage::disk('public')->url($this->photo_url);
    }

    public function talentRole()
    {
        return $this->belongsTo(TalentRole::class, 'talent_role_id');
    }

    public function talentSubRole()
    {
        return $this->belongsTo(TalentSubRole::class, 'talent_sub_role_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
