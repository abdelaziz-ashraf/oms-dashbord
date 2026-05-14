<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('subtitle_en');
            $table->text('subtitle_ar');
            $table->text('button_text_en');
            $table->text('button_text_ar');
            $table->string('button_link')->default('#packages');
            $table->text('secondary_button_text_en')->nullable();
            $table->text('secondary_button_text_ar')->nullable();
            $table->string('secondary_button_link')->nullable();
            $table->text('trusted_badge_en');
            $table->text('trusted_badge_ar');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};