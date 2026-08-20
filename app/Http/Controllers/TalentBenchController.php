<?php

namespace App\Http\Controllers;

use App\Models\StaffProfile;
use App\Models\TalentRole;
use App\Models\TalentShortlist;
use App\Models\TalentSubRole;
use App\Mail\InterviewRequestBooked;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Client-facing talent bench, reached only via an unguessable share token.
 * Deliberately not linked from anywhere on the public site and marked
 * noindex, because these pages expose CVs and hourly rates.
 */
class TalentBenchController extends Controller
{
    public const MIN_PICKS = 3;
    public const MAX_PICKS = 5;

    public function show(string $token): Response
    {
        [$role, $subRole] = $this->resolve($token);

        $profiles = StaffProfile::query()
            ->where('is_active', true)
            ->when($subRole, fn ($q) => $q->where('talent_sub_role_id', $subRole->id))
            ->when(! $subRole, fn ($q) => $q->where('talent_role_id', $role->id))
            ->orderBy('sort_order')
            ->get([
                'id', 'name', 'role_title', 'category', 'photo_url', 'about_me', 'rate',
                'work_preference', 'availability', 'core_skills', 'software_expertise',
                'experience', 'education', 'talent_sub_role_id',
            ]);

        // A role link covers a whole industry, so the client picks which
        // sub-role they're hiring for before meeting anyone. Sub-role links
        // are already narrowed, so they skip that step.
        $subRoles = $subRole ? [] : $role->subRoles()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name'])
            ->map(fn ($sr) => [
                'id'    => $sr->id,
                'name'  => $sr->name,
                'count' => $profiles->where('talent_sub_role_id', $sr->id)->count(),
            ])
            ->filter(fn ($sr) => $sr['count'] > 0)
            ->values()
            ->all();

        return Inertia::render('Talent/Bench', [
            'token'    => $token,
            'heading'  => $subRole?->name ?? $role->name,
            'roleName' => $role->name,
            'subRole'  => $subRole?->only(['id', 'name']),
            'subRoles' => $subRoles,
            'category' => $role->category,
            'profiles' => $profiles,
            'minPicks' => self::MIN_PICKS,
            'maxPicks' => self::MAX_PICKS,
        ]);
    }

    public function storeShortlist(Request $request, string $token)
    {
        [$role, $subRole] = $this->resolve($token);

        $validated = $request->validate([
            'client_name'    => 'required|string|max:255',
            'client_email'   => 'required|email|max:255',
            'client_company' => 'nullable|string|max:255',
            'notes'          => 'nullable|string|max:2000',
            'selections'     => 'required|array|min:1|max:' . self::MAX_PICKS,
            'selections.*'   => 'integer|exists:staff_profiles,id',
            // One interview per shortlisted candidate — each gets its own slot.
            'schedule'              => 'required|array|min:1|max:' . self::MAX_PICKS,
            'schedule.*.profile_id' => 'required|integer|exists:staff_profiles,id',
            'schedule.*.date'       => 'required|date|after_or_equal:today',
            'schedule.*.times'      => 'required|string|max:255',
            'schedule.*.note'       => 'nullable|string|max:500',
        ], [
            'selections.max' => 'You can shortlist up to ' . self::MAX_PICKS . ' candidates.',
            'schedule.*.date.required' => 'Please pick an interview date for every candidate.',
            'schedule.*.date.after_or_equal' => 'Please pick an interview date from today onwards.',
            'schedule.*.times.required' => 'Let us know which times you can make for every candidate.',
        ]);

        // Some roles only have one or two people on the bench, so the minimum
        // is capped at what's actually on offer rather than a flat three.
        $picked = StaffProfile::whereIn('id', $validated['selections'])->get(['id', 'talent_sub_role_id']);
        $pickedSubRoles = $picked->pluck('talent_sub_role_id')->unique();

        $available = StaffProfile::where('is_active', true)
            ->when(
                $subRole,
                fn ($q) => $q->where('talent_sub_role_id', $subRole->id),
                fn ($q) => $pickedSubRoles->count() === 1 && $pickedSubRoles->first()
                    // Industry link: the client narrowed to one role on the wheel.
                    ? $q->where('talent_sub_role_id', $pickedSubRoles->first())
                    : $q->where('talent_role_id', $role->id),
            )
            ->count();

        $minPicks = max(1, min(self::MIN_PICKS, $available));

        if (count($validated['selections']) < $minPicks) {
            return back()->withErrors([
                'selections' => 'Please choose at least ' . $minPicks . ' candidate' . ($minPicks === 1 ? '' : 's') . '.',
            ])->withInput();
        }

        $selections = array_map('intval', $validated['selections']);

        // Only keep slots for people actually shortlisted, ordered the way the
        // client ranked them.
        $schedule = collect($validated['schedule'])
            ->filter(fn ($slot) => in_array((int) $slot['profile_id'], $selections, true))
            ->keyBy(fn ($slot) => (int) $slot['profile_id']);

        if ($schedule->count() !== count($selections)) {
            return back()->withErrors([
                'schedule' => 'Please set a date and time for each shortlisted candidate.',
            ])->withInput();
        }

        $ordered = collect($selections)->map(fn ($id) => [
            'profile_id' => $id,
            'date'       => $schedule[$id]['date'],
            'times'      => $schedule[$id]['times'],
            'note'       => $schedule[$id]['note'] ?? null,
        ])->all();

        unset($validated['schedule']);

        $shortlist = TalentShortlist::create([
            ...$validated,
            'selections'         => $selections,
            'interview_schedule' => $ordered,
            // Summary of the earliest interview, so listings stay one line.
            'interview_date'              => collect($ordered)->min('date'),
            'interview_time_availability' => collect($ordered)->sortBy('date')->first()['times'],
            'talent_role_id'     => $role->id,
            'talent_sub_role_id' => $subRole?->id,
        ]);

        // Notifying the team is best-effort — a mail outage must not lose the
        // request, which is already saved above.
        try {
            $to = array_values(array_filter((array) config('mail.talent.to'), fn ($a) => filter_var($a, FILTER_VALIDATE_EMAIL)));
            $cc = array_values(array_diff(
                array_values(array_filter((array) config('mail.talent.cc'), fn ($a) => filter_var($a, FILTER_VALIDATE_EMAIL))),
                $to,
            ));

            if ($to) {
                $mailer = Mail::to($to);
                if ($cc) {
                    $mailer->cc($cc);
                }
                $mailer->send(new InterviewRequestBooked($shortlist->fresh(['role', 'subRole'])));
            }
        } catch (\Throwable $e) {
            report($e);
        }

        // The bench books its own interviews, so clients land on a confirmation
        // of their own request rather than the generic enquiry form.
        return redirect()->route('talent.booked', [$token, $shortlist->reference]);
    }

    /**
     * Confirmation for the interviews booked from the bench. Keyed on the
     * shortlist's unguessable reference so it survives a reload without
     * exposing anyone else's picks.
     */
    public function booked(string $token, string $reference): Response
    {
        [$role, $subRole] = $this->resolve($token);

        $shortlist = TalentShortlist::where('reference', $reference)
            ->where('talent_role_id', $role->id)
            ->firstOrFail();

        $slots = collect($shortlist->interview_schedule ?? [])->keyBy('profile_id');

        return Inertia::render('Talent/Booked', [
            'token'    => $token,
            'heading'  => $subRole?->name ?? $role->name,
            'shortlist' => [
                'client_name'  => $shortlist->client_name,
                'client_email' => $shortlist->client_email,
                'notes'        => $shortlist->notes,
            ],
            'candidates' => $shortlist->rankedProfiles()->map(function ($p) use ($slots) {
                $slot = $slots->get($p->id);

                return [
                    'id'         => $p->id,
                    'name'       => $p->name,
                    'role_title' => $p->role_title,
                    'photo_display_url' => $p->photo_display_url,
                    'date'  => isset($slot['date']) ? Carbon::parse($slot['date'])->format('l, j F Y') : null,
                    'times' => $slot['times'] ?? null,
                    'note'  => $slot['note'] ?? null,
                ];
            })->all(),
        ]);
    }

    /** @return array{0: TalentRole, 1: ?TalentSubRole} */
    private function resolve(string $token): array
    {
        if ($subRole = TalentSubRole::where('share_token', $token)->where('is_active', true)->first()) {
            abort_unless($subRole->role && $subRole->role->is_active, 404);

            return [$subRole->role, $subRole];
        }

        $role = TalentRole::where('share_token', $token)->where('is_active', true)->firstOrFail();

        return [$role, null];
    }
}
