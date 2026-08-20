<?php

namespace App\Console\Commands;

use App\Models\StaffProfile;
use App\Models\TalentRole;
use App\Models\TalentSubRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Reshapes the talent taxonomy so a share link covers an industry rather than
 * a single job title: each existing role becomes a sub-role of its category.
 *
 * Old role share tokens are carried onto the sub-roles they become, so links
 * already sent to clients keep resolving to the same people.
 *
 * Idempotent — running it twice is a no-op.
 */
class RegroupTalentByIndustry extends Command
{
    protected $signature = 'talent:regroup-by-industry {--dry-run : Show what would change without writing}';

    protected $description = 'Regroup talent roles under industry roles, demoting each job title to a sub-role';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');

        // Roles that already act as industries (their own name is the category)
        // are left alone, which is what makes a second run a no-op.
        $jobTitleRoles = TalentRole::all()->filter(fn (TalentRole $r) => $r->name !== ($r->category ?: $r->name));

        if ($jobTitleRoles->isEmpty()) {
            $this->info('Nothing to do — every role is already an industry.');

            return self::SUCCESS;
        }

        $industries = $jobTitleRoles->groupBy(fn (TalentRole $r) => $r->category ?: 'General');

        $this->table(
            ['Industry', 'Becomes sub-roles', 'Profiles'],
            $industries->map(fn ($roles, $industry) => [
                $industry,
                $roles->count(),
                $roles->sum(fn (TalentRole $r) => StaffProfile::where('talent_role_id', $r->id)->count()),
            ])->values()->all(),
        );

        // Generic placeholder sub-roles seeded under the old job-title roles
        // carry no profiles and make no sense under industries.
        $strandedSubRoles = TalentSubRole::whereIn('talent_role_id', $jobTitleRoles->pluck('id'))->get();
        $this->warn(sprintf('%d placeholder sub-role(s) will be deleted (they have no candidates).', $strandedSubRoles->count()));

        if ($dry) {
            $this->info('Dry run — nothing written.');

            return self::SUCCESS;
        }

        if (! $this->confirm('Apply this regrouping?', true)) {
            return self::FAILURE;
        }

        DB::transaction(function () use ($industries, $strandedSubRoles) {
            $stranded = $strandedSubRoles->pluck('id');

            // Detach before deleting so the FK's nullOnDelete doesn't matter.
            StaffProfile::whereIn('talent_sub_role_id', $stranded)->update(['talent_sub_role_id' => null]);
            TalentSubRole::whereIn('id', $stranded)->delete();

            $industrySort = 0;

            foreach ($industries as $industryName => $roles) {
                $industry = TalentRole::firstOrCreate(
                    ['name' => $industryName],
                    [
                        'slug'       => Str::slug($industryName),
                        'category'   => $industryName,
                        'is_active'  => true,
                        'sort_order' => ++$industrySort,
                    ],
                );

                $subSort = 0;

                foreach ($roles->sortBy('sort_order') as $role) {
                    // The old role's token moves onto the sub-role so links
                    // already in clients' inboxes keep working.
                    $subRole = TalentSubRole::create([
                        'talent_role_id' => $industry->id,
                        'name'           => $role->name,
                        'slug'           => $role->slug,
                        'share_token'    => $role->share_token,
                        'is_active'      => $role->is_active,
                        'sort_order'     => ++$subSort,
                    ]);

                    StaffProfile::where('talent_role_id', $role->id)->update([
                        'talent_role_id'     => $industry->id,
                        'talent_sub_role_id' => $subRole->id,
                    ]);

                    $role->delete();
                }
            }
        });

        $this->info('Done. Roles are now industries; job titles are sub-roles.');
        $this->line(sprintf(
            'Industries: %d · Sub-roles: %d · Profiles assigned: %d',
            TalentRole::count(),
            TalentSubRole::count(),
            StaffProfile::whereNotNull('talent_sub_role_id')->count(),
        ));

        return self::SUCCESS;
    }
}
