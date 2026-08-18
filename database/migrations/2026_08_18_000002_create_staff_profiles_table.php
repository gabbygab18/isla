<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('role_title');
            $table->string('category')->nullable();
            $table->string('photo_url')->nullable();
            $table->text('about_me')->nullable();
            $table->string('rate')->nullable();
            $table->string('work_preference')->nullable();
            $table->string('availability')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('core_skills')->nullable();
            $table->json('software_expertise')->nullable();
            $table->json('certifications')->nullable();
            $table->json('affiliations')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_profiles');
    }
};
