<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TalentSubRole extends Model
{
    protected $fillable = ['talent_role_id', 'name', 'slug', 'share_token', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::creating(function (self $subRole) {
            $subRole->share_token = $subRole->share_token ?: self::newShareToken();
        });
    }

    public static function newShareToken(): string
    {
        do {
            $token = Str::lower(Str::random(24));
        } while (self::where('share_token', $token)->exists());

        return $token;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(TalentRole::class, 'talent_role_id');
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
