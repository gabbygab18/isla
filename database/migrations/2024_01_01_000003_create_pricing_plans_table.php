<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tag')->nullable();             // e.g. "Part-time support"
            $table->string('detail')->nullable();          // e.g. "20 hrs / week · one dedicated VA"
            $table->text('summary')->nullable();           // card blurb
            $table->longText('body')->nullable();          // detail page copy
            $table->json('features')->nullable();          // feature checklist on the detail page
            $table->string('ribbon')->nullable();          // e.g. "Most popular"
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
