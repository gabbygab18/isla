<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TalentRole extends Model
{
    protected $fillable = ['name', 'slug', 'category', 'share_token', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function (self $role) {
            $role->share_token = $role->share_token ?: self::newShareToken();
        });
    }

    public static function newShareToken(): string
    {
        do {
            $token = Str::lower(Str::random(24));
        } while (self::where('share_token', $token)->exists());

        return $token;
    }

    public function subRoles(): HasMany
    {
        return $this->hasMany(TalentSubRole::class)->orderBy('sort_order');
    }

    public function profiles(): HasMany
    {
        return $this->hasMany(StaffProfile::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
