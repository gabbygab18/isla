<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The talent bench books its own discovery call rather than handing clients to
 * the generic /book-a-call page, so the interview date and the times they can
 * make are captured explicitly instead of buried in free-text notes.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('talent_shortlists', function (Blueprint $table) {
            $table->date('interview_date')->nullable()->after('client_company');
            $table->string('interview_time_availability')->nullable()->after('interview_date');
            // Confirmation pages are reloadable/shareable, so the reference has
            // to be unguessable — it exposes the client's shortlist.
            $table->string('reference', 32)->nullable()->unique()->after('interview_time_availability');
        });
    }

    public function down(): void
    {
        Schema::table('talent_shortlists', function (Blueprint $table) {
            $table->dropUnique(['reference']);
            $table->dropColumn(['interview_date', 'interview_time_availability', 'reference']);
        });
    }
};
