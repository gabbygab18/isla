<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Adds the "Careers" item to the dynamic navigation for sites whose
 * nav table is already seeded (so re-running the seeder isn't required).
 * Idempotent — safe to run more than once.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('nav_items')) {
            return;
        }

        $exists = DB::table('nav_items')->where('url', '/careers')->exists();

        if (! $exists) {
            $maxSort = (int) DB::table('nav_items')->max('sort_order');

            DB::table('nav_items')->insert([
                'label'      => 'Careers',
                'url'        => '/careers',
                'sort_order' => $maxSort + 1,
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('nav_items')) {
            DB::table('nav_items')->where('url', '/careers')->delete();
        }
    }
};
