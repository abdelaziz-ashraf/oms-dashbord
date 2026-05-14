<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('problem_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('problem_section_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('problem_items');
    }
};