<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('talent_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            // Unguessable public link — regenerable so a shared link can be revoked.
            $table->string('share_token', 32)->unique();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('talent_sub_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_role_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('share_token', 32)->unique();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['talent_role_id', 'slug']);
        });

        Schema::table('staff_profiles', function (Blueprint $table) {
            $table->foreignId('talent_role_id')->nullable()->after('role_title')->constrained()->nullOnDelete();
            $table->foreignId('talent_sub_role_id')->nullable()->after('talent_role_id')->constrained()->nullOnDelete();
        });

        Schema::create('talent_shortlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_role_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('talent_sub_role_id')->nullable()->constrained()->nullOnDelete();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_company')->nullable();
            $table->text('notes')->nullable();
            // Ordered staff_profile ids — the client's ranked top 3-5.
            $table->json('selections');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talent_shortlists');

        Schema::table('staff_profiles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('talent_sub_role_id');
            $table->dropConstrainedForeignId('talent_role_id');
        });

        Schema::dropIfExists('talent_sub_roles');
        Schema::dropIfExists('talent_roles');
    }
};
