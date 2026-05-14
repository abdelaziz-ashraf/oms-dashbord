<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('problem_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('features_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('features_section_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('packages_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('popular_badge_en');
            $table->text('popular_badge_ar');
            $table->text('billing_period_en');
            $table->text('billing_period_ar');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packages_section_id')->constrained()->onDelete('cascade');
            $table->text('name_en');
            $table->text('name_ar');
            $table->text('users_en');
            $table->text('users_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->decimal('price', 10, 2);
            $table->text('button_text_en');
            $table->text('button_text_ar');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('package_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->text('name_en');
            $table->text('name_ar');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('target_audiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('audience_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('target_audience_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('social_proofs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('social_proof_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('social_proof_id')->constrained()->onDelete('cascade');
            $table->string('company');
            $table->string('metric');
            $table->text('quote_en')->nullable();
            $table->text('quote_ar')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('why_us_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('why_us_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('why_us_section_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('how_it_works_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('how_it_works_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('how_it_works_section_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('comparison_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('comparison_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comparison_section_id')->constrained()->onDelete('cascade');
            $table->string('icon')->nullable();
            $table->text('text_en');
            $table->text('text_ar');
            $table->string('color')->default('branding');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('faq_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('faq_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faq_section_id')->constrained()->onDelete('cascade');
            $table->text('question_en');
            $table->text('question_ar');
            $table->text('answer_en');
            $table->text('answer_ar');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('cta_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('button_text_en');
            $table->text('button_text_ar');
            $table->string('button_link')->default('#contact');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('title_en');
            $table->text('title_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_section_id')->constrained()->onDelete('cascade');
            $table->string('icon');
            $table->text('label_en');
            $table->text('label_ar');
            $table->string('value');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('footer_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('landing_page_id')->constrained()->onDelete('cascade');
            $table->text('description_en');
            $table->text('description_ar');
            $table->text('copyright_en');
            $table->text('copyright_ar');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('footer_link_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('footer_section_id')->constrained()->onDelete('cascade');
            $table->string('key');
            $table->string('title_en');
            $table->string('title_ar');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('footer_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('footer_link_group_id')->constrained()->onDelete('cascade');
            $table->text('label_en');
            $table->text('label_ar');
            $table->string('url');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('footer_section_id')->constrained()->onDelete('cascade');
            $table->string('platform');
            $table->string('url');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
        Schema::dropIfExists('footer_links');
        Schema::dropIfExists('footer_link_groups');
        Schema::dropIfExists('footer_sections');
        Schema::dropIfExists('contact_items');
        Schema::dropIfExists('contact_sections');
        Schema::dropIfExists('cta_sections');
        Schema::dropIfExists('faq_items');
        Schema::dropIfExists('faq_sections');
        Schema::dropIfExists('comparison_items');
        Schema::dropIfExists('comparison_sections');
        Schema::dropIfExists('how_it_works_steps');
        Schema::dropIfExists('how_it_works_sections');
        Schema::dropIfExists('why_us_items');
        Schema::dropIfExists('why_us_sections');
        Schema::dropIfExists('social_proof_items');
        Schema::dropIfExists('social_proofs');
        Schema::dropIfExists('audience_items');
        Schema::dropIfExists('target_audiences');
        Schema::dropIfExists('package_features');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('packages_sections');
        Schema::dropIfExists('features');
        Schema::dropIfExists('features_sections');
        Schema::dropIfExists('problem_sections');
        Schema::dropIfExists('hero_statistics');
        Schema::dropIfExists('hero_sections');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('landing_pages');
    }
};