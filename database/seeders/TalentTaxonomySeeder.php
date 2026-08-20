<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\StaffProfile;
use App\Models\TalentRole;
use App\Models\TalentSubRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * The taxonomy clients browse by: a share link covers an industry, and the
 * client picks the role they're hiring for on the wheel.
 *
 * Industries come from the services catalogue — every service becomes an
 * industry and its listed roles become that industry's roles, so the bench
 * always offers everything the site sells. The staff-profile groupings are
 * seeded on top for the people already on the bench.
 */
class TalentTaxonomySeeder extends Seeder
{
    public function run(): void
    {
        $this->seedFromServices();
        $this->seedProfileGroupings();
    }

    /** Every service becomes an industry; its roles become that industry's roles. */
    private function seedFromServices(): void
    {
        foreach (Service::orderBy('sort_order')->get() as $i => $service) {
            $industry = TalentRole::firstOrCreate(
                ['slug' => Str::slug($service->title)],
                [
                    'name'       => $service->title,
                    'category'   => $service->title,
                    'sort_order' => $i + 1,
                    'is_active'  => (bool) $service->is_active,
                ],
            );

            foreach (($service->roles ?? []) as $j => $roleName) {
                TalentSubRole::firstOrCreate(
                    ['talent_role_id' => $industry->id, 'slug' => Str::slug($roleName)],
                    ['name' => $roleName, 'sort_order' => $j + 1, 'is_active' => true],
                );
            }
        }
    }

    /**
     * The groupings the seeded staff profiles sit under. Kept separate from the
     * services catalogue because these are the sectors those people were hired
     * for, not service lines.
     */
    private function seedProfileGroupings(): void
    {
        // Industry first, then the job title as a role under it — the same shape
        // the services catalogue produces, so both halves stay consistent.
        $industrySort = Service::count();
        $seen = [];

        foreach ($this->profileRoles() as [$jobTitle, $industryName]) {
            if (! isset($seen[$industryName])) {
                $seen[$industryName] = TalentRole::firstOrCreate(
                    ['slug' => Str::slug($industryName)],
                    [
                        'name'       => $industryName,
                        'category'   => $industryName,
                        'sort_order' => ++$industrySort,
                        'is_active'  => true,
                    ],
                );
            }

            $industry = $seen[$industryName];

            $role = TalentSubRole::firstOrCreate(
                ['talent_role_id' => $industry->id, 'slug' => Str::slug($jobTitle)],
                ['name' => $jobTitle, 'sort_order' => count($seen), 'is_active' => true],
            );

            // Link profiles whose free-text role_title matches, so seeded people
            // land on the right client link without re-entry.
            StaffProfile::where('role_title', $jobTitle)->update([
                'talent_role_id'     => $industry->id,
                'talent_sub_role_id' => $role->id,
            ]);
        }
    }

    /**
     * [job title, industry] for the seeded staff profiles. The industries here
     * must match the services catalogue, or the bench lists the same concept
     * twice — NDIS is the exception, it has no service line of its own.
     */
    private function profileRoles(): array
    {
        return [
            ['Construction Cost Estimator', 'Construction Administration and Estimating'],
            ['Construction Cost Estimator | Quantity Surveyor', 'Construction Administration and Estimating'],
            ['Business Development & Client Acquisition Specialist', 'Marketing and Creative Support'],
            ['Email Marketing | Lead Generation Specialist', 'Marketing and Creative Support'],
            ['Client Intake Officer', 'NDIS'],
            ['Client Services & HR Coordinator', 'NDIS'],
            ['Administrative Support & Rostering Coordinator', 'NDIS'],
            ['Administrative Support & Client Relations Specialist', 'NDIS'],
            ['Compliance & Audit Support Specialist', 'NDIS'],
            ['Compliance & Administrative Support', 'NDIS'],
            ['NDIS Administrative Support', 'NDIS'],
            ['NDIS Rostering Coordinator', 'NDIS'],
        ];
    }
}
