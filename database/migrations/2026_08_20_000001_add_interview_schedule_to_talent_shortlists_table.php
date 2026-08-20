<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Interviews are booked per candidate, so each shortlisted person gets their own
 * date, time window and note. The single interview_date / time columns stay as a
 * summary of the earliest slot for listings that only need one line.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('talent_shortlists', function (Blueprint $table) {
            $table->json('interview_schedule')->nullable()->after('interview_time_availability');
        });
    }

    public function down(): void
    {
        Schema::table('talent_shortlists', function (Blueprint $table) {
            $table->dropColumn('interview_schedule');
        });
    }
};
