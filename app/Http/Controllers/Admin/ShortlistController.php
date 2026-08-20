<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TalentShortlist;
use Inertia\Inertia;
use Inertia\Response;

class ShortlistController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Shortlists/Index', [
            'shortlists' => TalentShortlist::with(['role:id,name', 'subRole:id,name'])
                ->latest()
                ->paginate(15)
                ->through(fn ($s) => [
                    ...$s->only(['id', 'client_name', 'client_email', 'client_company', 'is_read', 'created_at']),
                    'role'    => $s->role?->name,
                    'subRole' => $s->subRole?->name,
                    'picks'   => count($s->selections ?? []),
                ]),
        ]);
    }

    public function show(TalentShortlist $shortlist): Response
    {
        if (! $shortlist->is_read) {
            $shortlist->update(['is_read' => true]);
        }

        $shortlist->load(['role:id,name', 'subRole:id,name']);

        return Inertia::render('Admin/Shortlists/Show', [
            'shortlist' => [
                ...$shortlist->only(['id', 'client_name', 'client_email', 'client_company', 'notes', 'created_at']),
                'interview_date' => $shortlist->interview_date?->format('l, j F Y'),
                'interview_time_availability' => $shortlist->interview_time_availability,
                'interview_schedule' => collect($shortlist->interview_schedule ?? [])->map(fn ($slot) => [
                    'profile_id' => $slot['profile_id'] ?? null,
                    'date'  => isset($slot['date']) ? \Carbon\Carbon::parse($slot['date'])->format('D, j M Y') : null,
                    'times' => $slot['times'] ?? null,
                    'note'  => $slot['note'] ?? null,
                ])->all(),
                'role'    => $shortlist->role?->name,
                'subRole' => $shortlist->subRole?->name,
            ],
            'candidates' => $shortlist->rankedProfiles()->map->only([
                'id', 'name', 'slug', 'role_title', 'rate', 'availability', 'photo_display_url',
            ]),
        ]);
    }

    public function destroy(TalentShortlist $shortlist)
    {
        $shortlist->delete();

        return redirect()->route('admin.shortlists')->with('success', 'Shortlist deleted.');
    }
}
