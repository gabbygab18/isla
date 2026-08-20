<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TalentShortlist extends Model
{
    protected $fillable = [
        'talent_role_id', 'talent_sub_role_id',
        'client_name', 'client_email', 'client_company', 'notes',
        'interview_date', 'interview_time_availability', 'interview_schedule', 'reference',
        'selections', 'is_read',
    ];

    protected $casts = [
        'selections'         => 'array',
        'is_read'            => 'boolean',
        'interview_date'     => 'date',
        'interview_schedule' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $shortlist) {
            $shortlist->reference ??= Str::lower(Str::random(24));
        });
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(TalentRole::class, 'talent_role_id');
    }

    public function subRole(): BelongsTo
    {
        return $this->belongsTo(TalentSubRole::class, 'talent_sub_role_id');
    }

    /** Ordered profiles as the client ranked them (DB order is not preserved by whereIn). */
    public function rankedProfiles()
    {
        // Multipart submissions arrive as numeric strings; keyBy() uses int keys.
        $ids = array_map('intval', $this->selections ?? []);
        $profiles = StaffProfile::whereIn('id', $ids)->get()->keyBy('id');

        return collect($ids)->map(fn ($id) => $profiles->get($id))->filter()->values();
    }
}
