<?php

namespace App\Console\Commands;

use App\Models\StaffProfile;
use App\Models\TalentRole;
use App\Models\TalentShortlist;
use App\Models\TalentSubRole;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Folds a duplicate industry into the one that should survive, carrying its
 * roles, its people and its share tokens across.
 *
 * The seeded staff groupings ("Construction", "Marketing") say the same thing
 * as the services-derived industries, so the bench listed each concept twice.
 *
 * Idempotent — once the source is gone there is nothing left to move.
 */
class MergeTalentIndustries extends Command
{
    protected $signature = 'talent:merge-industries {--dry-run : Show what would change without writing}';

    protected $description = 'Merge duplicate talent industries into their services-derived equivalent';

    /** [source industry, industry that survives] */
    private const MERGES = [
        ['Construction', 'Construction Administration and Estimating'],
        ['Marketing', 'Marketing and Creative Support'],
    ];

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $plan = [];

        foreach (self::MERGES as [$sourceName, $targetName]) {
            $source = TalentRole::where('name', $sourceName)->first();
            $target = TalentRole::where('name', $targetName)->first();

            if (! $source || ! $target) {
                continue;
            }

            $plan[] = [$source, $target];
        }

        if (! $plan) {
            $this->info('Nothing to merge — no duplicate industries left.');

            return self::SUCCESS;
        }

        $this->table(
            ['Merging away', 'Into', 'Roles moved', 'Profiles moved'],
            array_map(fn ($p) => [
                $p[0]->name,
                $p[1]->name,
                $p[0]->subRoles()->count(),
                StaffProfile::where('talent_role_id', $p[0]->id)->count(),
            ], $plan),
        );

        if ($dry) {
            $this->info('Dry run — nothing written.');

            return self::SUCCESS;
        }

        if (! $this->confirm('Apply this merge?', true)) {
            return self::FAILURE;
        }

        DB::transaction(function () use ($plan) {
            foreach ($plan as [$source, $target]) {
                $sort = (int) $target->subRoles()->max('sort_order');

                foreach ($source->subRoles as $subRole) {
                    // A role of the same name already under the target would break
                    // the (industry, slug) unique key — drop the empty placeholder
                    // and let the populated one through, tokens intact.
                    $clash = TalentSubRole::where('talent_role_id', $target->id)
                        ->where('slug', $subRole->slug)
                        ->first();

                    if ($clash) {
                        StaffProfile::where('talent_sub_role_id', $clash->id)
                            ->update(['talent_sub_role_id' => $subRole->id]);
                        TalentShortlist::where('talent_sub_role_id', $clash->id)
                            ->update(['talent_sub_role_id' => $subRole->id]);
                        $clash->delete();
                    }

                    $subRole->update([
                        'talent_role_id' => $target->id,
                        'sort_order'     => ++$sort,
                    ]);
                }

                StaffProfile::where('talent_role_id', $source->id)
                    ->update(['talent_role_id' => $target->id]);
                TalentShortlist::where('talent_role_id', $source->id)
                    ->update(['talent_role_id' => $target->id]);

                // Sub-roles are already reparented, so the cascade takes nothing
                // with it. The source's own share link dies with it.
                $source->delete();
            }
        });

        $this->info('Merged.');
        $this->line(sprintf(
            'Industries: %d · Roles: %d · Profiles linked: %d',
            TalentRole::count(),
            TalentSubRole::count(),
            StaffProfile::whereNotNull('talent_sub_role_id')->count(),
        ));

        return self::SUCCESS;
    }
}
