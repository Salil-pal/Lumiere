<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('About Us');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->string('image')->nullable();

            $table->string('mission_title')->nullable();
            $table->text('mission_text')->nullable();

            $table->string('vision_title')->nullable();
            $table->text('vision_text')->nullable();

            $table->string('experience_years')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
