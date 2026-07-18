<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audiences', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->default('i-users');   // svg symbol id used in the sprite
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();           // short copy shown on the card
            $table->longText('body')->nullable();          // long copy for the detail page
            $table->json('points')->nullable();            // bullet points on the detail page
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audiences');
    }
};
