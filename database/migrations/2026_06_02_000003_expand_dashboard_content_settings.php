<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $eyebrowTables = [
        'problem_sections',
        'features_sections',
        'packages_sections',
        'target_audiences',
        'social_proofs',
        'why_us_sections',
        'how_it_works_sections',
        'comparison_sections',
        'faq_sections',
        'cta_sections',
        'contact_sections',
    ];

    public function up(): void
    {
        foreach ($this->eyebrowTables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                if (!Schema::hasColumn($table, 'eyebrow_en')) {
                    $blueprint->text('eyebrow_en')->nullable();
                }

                if (!Schema::hasColumn($table, 'eyebrow_ar')) {
                    $blueprint->text('eyebrow_ar')->nullable();
                }
            });
        }

        Schema::table('landing_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('landing_pages', 'logo_image_path')) {
                $table->string('logo_image_path')->nullable();
            }
        });

        Schema::table('packages', function (Blueprint $table) {
            if (!Schema::hasColumn('packages', 'is_popular')) {
                $table->boolean('is_popular')->default(false)->index();
            }
        });

        Schema::table('comparison_sections', function (Blueprint $table) {
            foreach ([
                'before_title_en', 'before_title_ar', 'before_subtitle_en', 'before_subtitle_ar',
                'after_title_en', 'after_title_ar', 'after_subtitle_en', 'after_subtitle_ar',
            ] as $column) {
                if (!Schema::hasColumn('comparison_sections', $column)) {
                    $table->text($column)->nullable();
                }
            }
        });

        Schema::table('how_it_works_sections', function (Blueprint $table) {
            foreach ([
                'cta_title_en', 'cta_title_ar', 'cta_description_en', 'cta_description_ar',
                'cta_button_text_en', 'cta_button_text_ar', 'cta_button_link',
                'cta_secondary_button_text_en', 'cta_secondary_button_text_ar', 'cta_secondary_button_link',
            ] as $column) {
                if (!Schema::hasColumn('how_it_works_sections', $column)) {
                    $table->text($column)->nullable();
                }
            }
        });

        Schema::table('cta_sections', function (Blueprint $table) {
            foreach (['secondary_button_text_en', 'secondary_button_text_ar', 'secondary_button_link'] as $column) {
                if (!Schema::hasColumn('cta_sections', $column)) {
                    $table->text($column)->nullable();
                }
            }

            if (!Schema::hasColumn('cta_sections', 'badges')) {
                $table->json('badges')->nullable();
            }
        });

        Schema::table('contact_sections', function (Blueprint $table) {
            foreach ([
                'form_title_en', 'form_title_ar', 'form_description_en', 'form_description_ar',
                'form_button_text_en', 'form_button_text_ar', 'form_success_text_en', 'form_success_text_ar',
                'form_error_text_en', 'form_error_text_ar', 'form_sending_text_en', 'form_sending_text_ar',
                'form_name_label_en', 'form_name_label_ar', 'form_name_placeholder_en', 'form_name_placeholder_ar',
                'form_email_label_en', 'form_email_label_ar', 'form_email_placeholder_en', 'form_email_placeholder_ar',
                'form_company_label_en', 'form_company_label_ar', 'form_company_placeholder_en', 'form_company_placeholder_ar',
            ] as $column) {
                if (!Schema::hasColumn('contact_sections', $column)) {
                    $table->text($column)->nullable();
                }
            }

            if (!Schema::hasColumn('contact_sections', 'form_badges')) {
                $table->json('form_badges')->nullable();
            }
        });

        Schema::create('portfolio_sections', function (Blueprint $table) {
            $table->id();
            $table->string('module')->unique();
            $table->text('title_en');
            $table->text('title_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('order')->default(0);
            $table->unsignedInteger('limit')->default(6);
            $table->timestamps();
        });

        $this->backfillDashboardContent();
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_sections');

        Schema::table('contact_sections', function (Blueprint $table) {
            $this->dropExistingColumns('contact_sections', $table, [
                'form_title_en', 'form_title_ar', 'form_description_en', 'form_description_ar',
                'form_button_text_en', 'form_button_text_ar', 'form_success_text_en', 'form_success_text_ar',
                'form_error_text_en', 'form_error_text_ar', 'form_sending_text_en', 'form_sending_text_ar',
                'form_name_label_en', 'form_name_label_ar', 'form_name_placeholder_en', 'form_name_placeholder_ar',
                'form_email_label_en', 'form_email_label_ar', 'form_email_placeholder_en', 'form_email_placeholder_ar',
                'form_company_label_en', 'form_company_label_ar', 'form_company_placeholder_en', 'form_company_placeholder_ar',
                'form_badges',
            ]);
        });

        Schema::table('cta_sections', function (Blueprint $table) {
            $this->dropExistingColumns('cta_sections', $table, [
                'secondary_button_text_en', 'secondary_button_text_ar', 'secondary_button_link', 'badges',
            ]);
        });

        Schema::table('how_it_works_sections', function (Blueprint $table) {
            $this->dropExistingColumns('how_it_works_sections', $table, [
                'cta_title_en', 'cta_title_ar', 'cta_description_en', 'cta_description_ar',
                'cta_button_text_en', 'cta_button_text_ar', 'cta_button_link',
                'cta_secondary_button_text_en', 'cta_secondary_button_text_ar', 'cta_secondary_button_link',
            ]);
        });

        Schema::table('comparison_sections', function (Blueprint $table) {
            $this->dropExistingColumns('comparison_sections', $table, [
                'before_title_en', 'before_title_ar', 'before_subtitle_en', 'before_subtitle_ar',
                'after_title_en', 'after_title_ar', 'after_subtitle_en', 'after_subtitle_ar',
            ]);
        });

        Schema::table('landing_pages', function (Blueprint $table) {
            $this->dropExistingColumns('landing_pages', $table, ['logo_image_path']);
        });

        Schema::table('packages', function (Blueprint $table) {
            $this->dropExistingColumns('packages', $table, ['is_popular']);
        });

        foreach ($this->eyebrowTables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $this->dropExistingColumns($tableName, $table, ['eyebrow_en', 'eyebrow_ar']);
            });
        }
    }

    private function dropExistingColumns(string $tableName, Blueprint $table, array $columns): void
    {
        $existing = array_values(array_filter(
            $columns,
            fn (string $column) => Schema::hasColumn($tableName, $column)
        ));

        if ($existing !== []) {
            $table->dropColumn($existing);
        }
    }

    private function backfillDashboardContent(): void
    {
        DB::table('packages')->where('order', 1)->update(['is_popular' => true]);

        foreach ([
            'problem_sections' => ['The Problem', 'المشكلة'],
            'features_sections' => ['Features', 'الميزات'],
            'packages_sections' => ['Pricing', 'الأسعار'],
            'target_audiences' => ['Perfect For', 'مثالي لـ'],
            'social_proofs' => ['Social Proof', 'شهادات العملاء'],
            'why_us_sections' => ['Why Choose Us', 'لماذا تختارنا'],
            'how_it_works_sections' => ['How It Works', 'كيف يعمل'],
            'comparison_sections' => ['Comparison', 'مقارنة'],
            'faq_sections' => ['FAQ', 'الأسئلة الشائعة'],
            'cta_sections' => ['Start Your Free Trial Today', 'ابدأ تجربتك المجانية اليوم'],
            'contact_sections' => ['Contact Us', 'اتصل بنا'],
        ] as $table => [$en, $ar]) {
            DB::table($table)->update([
                'eyebrow_en' => $en,
                'eyebrow_ar' => $ar,
            ]);
        }

        DB::table('comparison_sections')->update([
            'before_title_en' => 'Without OMS',
            'before_title_ar' => 'بدون النظام',
            'before_subtitle_en' => 'The old way',
            'before_subtitle_ar' => 'الطريقة القديمة',
            'after_title_en' => 'With OMS',
            'after_title_ar' => 'مع النظام',
            'after_subtitle_en' => 'The smart way',
            'after_subtitle_ar' => 'الطريقة الذكية',
        ]);

        DB::table('how_it_works_sections')->update([
            'cta_title_en' => 'See OMS in Action',
            'cta_title_ar' => 'شاهد OMS أثناء العمل',
            'cta_description_en' => 'Watch our 5-minute demo to see how OMS can transform your operations.',
            'cta_description_ar' => 'شاهد عرضنا التوضيحي لمدة 5 دقائق.',
            'cta_button_text_en' => 'Watch Demo',
            'cta_button_text_ar' => 'شاهد العرض',
            'cta_button_link' => '#contact',
            'cta_secondary_button_text_en' => 'Read Documentation',
            'cta_secondary_button_text_ar' => 'اقرأ التوثيق',
            'cta_secondary_button_link' => '#faq',
        ]);

        DB::table('cta_sections')->update([
            'secondary_button_text_en' => 'Talk to Sales',
            'secondary_button_text_ar' => 'تحدث مع المبيعات',
            'secondary_button_link' => '#contact',
            'badges' => json_encode([
                ['text_en' => 'No credit card required', 'text_ar' => 'لا بطاقة ائتمان مطلوبة'],
                ['text_en' => '14-day free trial', 'text_ar' => '14 يوماً تجربة مجانية'],
                ['text_en' => 'Cancel anytime', 'text_ar' => 'إلغاء في أي وقت'],
            ]),
        ]);

        DB::table('contact_sections')->update([
            'form_title_en' => 'Get Started Today',
            'form_title_ar' => 'ابدأ اليوم',
            'form_description_en' => 'Enter your email and we will send you a quick start guide.',
            'form_description_ar' => 'أدخل بريدك الإلكتروني وسنرسل لك دليلاً سريعاً للبدء.',
            'form_button_text_en' => 'Get Free Consultation',
            'form_button_text_ar' => 'احصل على استشارة مجانية',
            'form_success_text_en' => 'Sent Successfully!',
            'form_success_text_ar' => 'تم الإرسال بنجاح!',
            'form_error_text_en' => 'Could not send your message. Please try again.',
            'form_error_text_ar' => 'تعذر إرسال الرسالة. حاول مرة أخرى.',
            'form_sending_text_en' => 'Sending...',
            'form_sending_text_ar' => 'جار الإرسال...',
            'form_name_label_en' => 'Full Name',
            'form_name_label_ar' => 'الاسم الكامل',
            'form_name_placeholder_en' => 'Your name',
            'form_name_placeholder_ar' => 'اسمك',
            'form_email_label_en' => 'Email Address',
            'form_email_label_ar' => 'البريد الإلكتروني',
            'form_email_placeholder_en' => 'your@email.com',
            'form_email_placeholder_ar' => 'your@email.com',
            'form_company_label_en' => 'Company Name',
            'form_company_label_ar' => 'اسم الشركة',
            'form_company_placeholder_en' => 'Your company',
            'form_company_placeholder_ar' => 'شركتك',
            'form_badges' => json_encode([
                ['text_en' => 'No spam', 'text_ar' => 'لا بريد عشوائي'],
                ['text_en' => 'Free consultation', 'text_ar' => 'استشارة مجانية'],
            ]),
        ]);

        foreach ([
            ['services', 'Services', 'الخدمات', 'Core capabilities managed from the dashboard.', 'الخدمات الأساسية المدارة من لوحة التحكم', 0],
            ['projects', 'Projects', 'المشاريع', 'Selected work and implementations.', 'أعمال وتطبيقات مختارة', 1],
            ['case-studies', 'Case Studies', 'دراسات الحالة', 'Detailed stories behind delivered results.', 'قصص تفصيلية للنتائج المنجزة', 2],
            ['team', 'Team', 'الفريق', 'People behind the product and delivery.', 'الفريق وراء المنتج والتنفيذ', 3],
            ['testimonials', 'Testimonials', 'آراء العملاء', 'Client feedback and outcomes.', 'آراء العملاء والنتائج', 4],
            ['clients', 'Clients', 'العملاء', 'Organizations that trust the team.', 'جهات تثق بالفريق', 5],
            ['blog', 'Blog', 'المدونة', 'Latest articles and updates.', 'أحدث المقالات والتحديثات', 6],
        ] as [$module, $titleEn, $titleAr, $descriptionEn, $descriptionAr, $order]) {
            DB::table('portfolio_sections')->insert([
                'module' => $module,
                'title_en' => $titleEn,
                'title_ar' => $titleAr,
                'description_en' => $descriptionEn,
                'description_ar' => $descriptionAr,
                'is_active' => true,
                'order' => $order,
                'limit' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
};
