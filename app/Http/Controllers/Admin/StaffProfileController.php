<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffProfile;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class StaffProfileController extends Controller
{
    /**
     * CSV columns, in template/import order. Repeatable groups (education,
     * experience) are flattened into numbered columns since a plain CSV/XLS
     * grid can't express nested arrays — pipe ( | ) separates list values
     * within a single cell (skills, software, certifications, bullets).
     */
    private const EDUCATION_SLOTS = 2;
    private const EXPERIENCE_SLOTS = 4;

    public function index(): Response
    {
        return Inertia::render('Admin/StaffProfiles/Index', [
            'profiles' => StaffProfile::orderBy('sort_order')->get([
                'id', 'name', 'slug', 'role_title', 'category', 'photo_url', 'about_me', 'rate', 'availability', 'is_active',
            ]),
        ]);
    }

    public function show(StaffProfile $staffProfile): Response
    {
        return Inertia::render('Admin/StaffProfiles/Show', [
            'profile' => $staffProfile,
            'others'  => StaffProfile::where('is_active', true)->where('id', '!=', $staffProfile->id)->take(4)->get([
                'id', 'name', 'slug', 'role_title', 'category', 'photo_url',
            ]),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/StaffProfiles/Form', ['profile' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateProfile($request);
        $data['slug'] = $this->uniqueSlug($data['name'], $data['role_title']);
        StaffProfile::create($data);

        return redirect()->route('admin.staff-profiles')->with('success', 'Profile created.');
    }

    public function edit(StaffProfile $staffProfile): Response
    {
        return Inertia::render('Admin/StaffProfiles/Form', ['profile' => $staffProfile]);
    }

    public function update(Request $request, StaffProfile $staffProfile)
    {
        $data = $this->validateProfile($request);
        if ($data['name'] !== $staffProfile->name || $data['role_title'] !== $staffProfile->role_title) {
            $data['slug'] = $this->uniqueSlug($data['name'], $data['role_title'], $staffProfile->id);
        }
        $staffProfile->update($data);

        return redirect()->route('admin.staff-profiles')->with('success', 'Profile updated.');
    }

    public function destroy(StaffProfile $staffProfile)
    {
        $staffProfile->delete();

        return back()->with('success', 'Profile deleted.');
    }

    /* =========================================================
     |  CSV import / export
     | ========================================================= */

    public function importForm(): Response
    {
        return Inertia::render('Admin/StaffProfiles/Import');
    }

    public function template(): HttpResponse
    {
        $headers = $this->csvHeaders();
        $example = [
            'jane-example-role-title', 'Jane Doe', 'Virtual Assistant', 'NDIS', '16 AUD per hour',
            'Full Time (40hrs per week)', 'Immediately',
            'Detail-oriented virtual assistant with experience in...',
            'Client Intake|Scheduling|Documentation', 'Microsoft Office|ShiftCare', 'Cert IV in Business', 'Member, Example Association',
        ];
        // pad the example row out to the full column count (education/experience slots left blank)
        $example = array_pad($example, count($headers), '');

        $rows = [$headers, $example];
        $csv = collect($rows)->map(fn ($row) => $this->csvLine($row))->implode('');

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="staff-profiles-template.csv"',
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($request->file('file')->getRealPath(), 'r');
        $header = fgetcsv($handle);
        if (! $header) {
            fclose($handle);
            return back()->with('error', 'Could not read the file — is it empty?');
        }
        $header = array_map(fn ($h) => trim((string) $h), $header);

        $created = 0;
        $updated = 0;
        $skipped = [];
        $rowNum = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            if (count(array_filter($row, fn ($v) => trim((string) $v) !== '')) === 0) {
                continue; // blank row
            }

            $cells = array_combine($header, array_pad($row, count($header), ''));
            $name = trim((string) ($cells['name'] ?? ''));
            $roleTitle = trim((string) ($cells['role_title'] ?? ''));

            if ($name === '' || $roleTitle === '') {
                $skipped[] = "Row {$rowNum}: missing name or role_title";
                continue;
            }

            $data = $this->rowToProfileData($cells);
            $slug = trim((string) ($cells['slug'] ?? ''));
            $existing = $slug !== '' ? StaffProfile::where('slug', $slug)->first() : null;

            if ($existing) {
                $existing->update($data);
                $updated++;
            } else {
                $data['slug'] = $this->uniqueSlug($name, $roleTitle);
                StaffProfile::create($data);
                $created++;
            }
        }

        fclose($handle);

        $message = "Import complete — {$created} created, {$updated} updated.";
        if ($skipped) {
            $message .= ' Skipped: ' . implode('; ', array_slice($skipped, 0, 10)) . (count($skipped) > 10 ? '…' : '');
        }

        return back()->with($skipped ? 'error' : 'success', $message);
    }

    /* =========================================================
     |  Helpers
     | ========================================================= */

    private function validateProfile(Request $request): array
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'role_title'        => 'required|string|max:255',
            'category'          => 'nullable|string|max:100',
            'rate'              => 'nullable|string|max:100',
            'work_preference'   => 'nullable|string|max:255',
            'availability'      => 'nullable|string|max:255',
            'about_me'          => 'nullable|string',
            'core_skills'       => 'nullable|array',
            'software_expertise' => 'nullable|array',
            'certifications'    => 'nullable|array',
            'affiliations'      => 'nullable|array',
            'education'         => 'nullable|array',
            'education.*.school' => 'nullable|string|max:255',
            'education.*.degree' => 'nullable|string|max:255',
            'education.*.period' => 'nullable|string|max:100',
            'experience'        => 'nullable|array',
            'experience.*.company' => 'nullable|string|max:255',
            'experience.*.title'   => 'nullable|string|max:255',
            'experience.*.period'  => 'nullable|string|max:100',
            'experience.*.bullets' => 'nullable|array',
            'sort_order'        => 'nullable|integer',
            'is_active'         => 'nullable|boolean',
        ]);

        $validated['core_skills'] = array_values(array_filter($validated['core_skills'] ?? []));
        $validated['software_expertise'] = array_values(array_filter($validated['software_expertise'] ?? []));
        $validated['certifications'] = array_values(array_filter($validated['certifications'] ?? []));
        $validated['affiliations'] = array_values(array_filter($validated['affiliations'] ?? []));

        $validated['education'] = collect($validated['education'] ?? [])
            ->filter(fn ($e) => trim((string) ($e['school'] ?? '')) !== '')
            ->values()->all();

        $validated['experience'] = collect($validated['experience'] ?? [])
            ->filter(fn ($e) => trim((string) ($e['company'] ?? '')) !== '')
            ->map(fn ($e) => [
                'company' => $e['company'] ?? '',
                'title'   => $e['title'] ?? '',
                'period'  => $e['period'] ?? '',
                'bullets' => array_values(array_filter($e['bullets'] ?? [])),
            ])->values()->all();

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }

    private function uniqueSlug(string $name, string $roleTitle, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name . '-' . $roleTitle) ?: Str::random(8);
        $base = $slug;
        $i = 2;

        while (StaffProfile::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function csvHeaders(): array
    {
        $headers = ['slug', 'name', 'role_title', 'category', 'rate', 'work_preference', 'availability', 'about_me', 'core_skills', 'software_expertise', 'certifications', 'affiliations'];

        for ($i = 1; $i <= self::EDUCATION_SLOTS; $i++) {
            $headers = [...$headers, "education_{$i}_school", "education_{$i}_degree", "education_{$i}_period"];
        }
        for ($i = 1; $i <= self::EXPERIENCE_SLOTS; $i++) {
            $headers = [...$headers, "experience_{$i}_company", "experience_{$i}_title", "experience_{$i}_period", "experience_{$i}_bullets"];
        }
        $headers = [...$headers, 'is_active', 'sort_order'];

        return $headers;
    }

    private function rowToProfileData(array $cells): array
    {
        $pipeList = fn (string $key) => array_values(array_filter(array_map('trim', explode('|', (string) ($cells[$key] ?? '')))));

        $education = [];
        for ($i = 1; $i <= self::EDUCATION_SLOTS; $i++) {
            $school = trim((string) ($cells["education_{$i}_school"] ?? ''));
            if ($school === '') {
                continue;
            }
            $education[] = [
                'school' => $school,
                'degree' => trim((string) ($cells["education_{$i}_degree"] ?? '')),
                'period' => trim((string) ($cells["education_{$i}_period"] ?? '')),
            ];
        }

        $experience = [];
        for ($i = 1; $i <= self::EXPERIENCE_SLOTS; $i++) {
            $company = trim((string) ($cells["experience_{$i}_company"] ?? ''));
            if ($company === '') {
                continue;
            }
            $experience[] = [
                'company' => $company,
                'title'   => trim((string) ($cells["experience_{$i}_title"] ?? '')),
                'period'  => trim((string) ($cells["experience_{$i}_period"] ?? '')),
                'bullets' => array_values(array_filter(array_map('trim', explode('|', (string) ($cells["experience_{$i}_bullets"] ?? ''))))),
            ];
        }

        $isActiveCell = strtolower(trim((string) ($cells['is_active'] ?? '')));

        return [
            'name'               => trim((string) $cells['name']),
            'role_title'         => trim((string) $cells['role_title']),
            'category'           => trim((string) ($cells['category'] ?? '')) ?: null,
            'rate'               => trim((string) ($cells['rate'] ?? '')) ?: null,
            'work_preference'    => trim((string) ($cells['work_preference'] ?? '')) ?: null,
            'availability'       => trim((string) ($cells['availability'] ?? '')) ?: null,
            'about_me'           => trim((string) ($cells['about_me'] ?? '')) ?: null,
            'core_skills'        => $pipeList('core_skills'),
            'software_expertise' => $pipeList('software_expertise'),
            'certifications'     => $pipeList('certifications'),
            'affiliations'       => $pipeList('affiliations'),
            'education'          => $education,
            'experience'         => $experience,
            'is_active'          => $isActiveCell === '' ? true : in_array($isActiveCell, ['1', 'true', 'yes', 'active'], true),
            'sort_order'         => is_numeric($cells['sort_order'] ?? null) ? (int) $cells['sort_order'] : 0,
        ];
    }

    private function csvLine(array $fields): string
    {
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $fields);
        rewind($handle);
        $line = stream_get_contents($handle);
        fclose($handle);

        return $line;
    }
}
