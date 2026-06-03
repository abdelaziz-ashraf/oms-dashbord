<?php

namespace Database\Seeders;

use App\Models\LandingPage;
use App\Models\Announcement;
use App\Models\HeroSection;
use App\Models\HeroStatistic;
use App\Models\PackagesSection;
use App\Models\Package;
use App\Models\FaqSection;
use App\Models\FaqItem;
use App\Models\CtaSection;
use App\Models\ProblemSection;
use App\Models\ProblemItem;
use App\Models\FeaturesSection;
use App\Models\Feature;
use App\Models\TargetAudience;
use App\Models\AudienceItem;
use App\Models\SocialProof;
use App\Models\SocialProofItem;
use App\Models\WhyUsSection;
use App\Models\WhyUsItem;
use App\Models\HowItWorksSection;
use App\Models\HowItWorksStep;
use App\Models\ComparisonSection;
use App\Models\ComparisonItem;
use App\Models\ContactSection;
use App\Models\ContactItem;
use App\Models\FooterSection;
use App\Models\FooterLinkGroup;
use App\Models\FooterLink;
use App\Models\SocialLink;
use App\Models\PortfolioSection;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        $page = LandingPage::firstOrCreate(
            ['slug' => 'oms'],
            ['name' => 'OMS Landing Page', 'logo_text_en' => 'OMS', 'logo_text_ar' => 'OMS', 'is_announcement_active' => true]
        );

        foreach ([
            'announcement', 'hero', 'problem', 'features', 'packages',
            'targetAudience', 'socialProof', 'whyUs', 'howItWorks',
            'comparison', 'faq', 'cta', 'contact', 'footer',
        ] as $relation) {
            $page->{$relation}()?->delete();
        }

        $page->forceFill([
            'logo_text_en' => 'OMS',
            'logo_text_ar' => 'OMS',
            'is_announcement_active' => true,
        ])->save();

        Announcement::create([
            'landing_page_id' => $page->id,
            'text_en' => 'Limited Offer: Get 30% off on all plans. Use code OMS2026',
            'text_ar' => 'عرض محدود: احصل على خصم 30% على جميع الخطط. استخدم كود OMS2026',
            'link' => '#packages',
            'is_active' => true,
        ]);

        $hero = HeroSection::create([
            'landing_page_id' => $page->id,
            'title_en' => 'Manage Your Business with Ease',
            'title_ar' => 'إدارة عملك بسهولة',
            'subtitle_en' => 'The all-in-one solution for managing your contracts, clients, and revenue in one place.',
            'subtitle_ar' => 'الحل الشامل لإدارة عقودك وعملائك وإيراداتك في مكان واحد.',
            'button_text_en' => 'Start Free Trial',
            'button_text_ar' => 'ابدأ التجربة المجانية',
            'button_link' => '#contact',
            'secondary_button_text_en' => 'Watch Demo',
            'secondary_button_text_ar' => 'شاهد الفيديو',
            'secondary_button_link' => '#how-it-works',
            'trusted_badge_en' => 'Trusted by 10,000+ businesses',
            'trusted_badge_ar' => 'موثوق من أكثر من 10,000 شركة',
            'is_active' => true,
        ]);

        HeroStatistic::create(['hero_section_id' => $hero->id, 'value' => '10K+', 'label_en' => 'Contracts/Day', 'label_ar' => 'عقود/يوم']);
        HeroStatistic::create(['hero_section_id' => $hero->id, 'value' => '99.9%', 'label_en' => 'Uptime', 'label_ar' => 'وقت التشغيل']);
        HeroStatistic::create(['hero_section_id' => $hero->id, 'value' => '24/7', 'label_en' => 'Support', 'label_ar' => 'دعم']);

        $packages = PackagesSection::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'Pricing',
            'eyebrow_ar' => 'الأسعار',
            'title_en' => 'Simple, Transparent Pricing',
            'title_ar' => 'تسعير بسيط وشفاف',
            'description_en' => 'Choose the plan that fits your business needs',
            'description_ar' => 'اختر الخطة التي تناسب احتياجات عملك',
            'popular_badge_en' => 'Most Popular',
            'popular_badge_ar' => 'الأكثر شعبية',
            'billing_period_en' => '/month',
            'billing_period_ar' => '/شهرياً',
            'is_active' => true,
        ]);

        $starter = Package::create([
            'packages_section_id' => $packages->id,
            'name_en' => 'Starter',
            'name_ar' => 'المبتدئ',
            'users_en' => 'Up to 5 users',
            'users_ar' => 'حتى 5 مستخدمين',
            'description_en' => 'Perfect for small businesses',
            'description_ar' => 'مثالي للشركات الصغيرة',
            'price' => 29,
            'button_text_en' => 'Get Started',
            'button_text_ar' => 'ابدأ الآن',
            'order' => 0,
        ]);
        $starter->features()->createMany([
            ['name_en' => 'Up to 100 contracts', 'name_ar' => 'حتى 100 عقد', 'order' => 0],
            ['name_en' => 'Basic analytics', 'name_ar' => 'تحليلات أساسية', 'order' => 1],
            ['name_en' => 'Email support', 'name_ar' => 'دعم عبر البريد الإلكتروني', 'order' => 2],
        ]);

        $pro = Package::create([
            'packages_section_id' => $packages->id,
            'name_en' => 'Professional',
            'name_ar' => 'المهني',
            'users_en' => 'Up to 20 users',
            'users_ar' => 'حتى 20 مستخدم',
            'description_en' => 'For growing teams',
            'description_ar' => 'للteams المتنامية',
            'price' => 79,
            'button_text_en' => 'Get Started',
            'button_text_ar' => 'ابدأ الآن',
            'is_popular' => true,
            'order' => 1,
        ]);
        $pro->features()->createMany([
            ['name_en' => 'Unlimited contracts', 'name_ar' => 'عقود غير محدودة', 'order' => 0],
            ['name_en' => 'Advanced analytics', 'name_ar' => 'تحليلات متقدمة', 'order' => 1],
            ['name_en' => 'Priority support', 'name_ar' => 'دعم أولوية', 'order' => 2],
            ['name_en' => 'API access', 'name_ar' => 'وصول API', 'order' => 3],
        ]);

        $enterprise = Package::create([
            'packages_section_id' => $packages->id,
            'name_en' => 'Enterprise',
            'name_ar' => 'المؤسسات',
            'users_en' => 'Unlimited users',
            'users_ar' => 'مستخدمين غير محدودين',
            'description_en' => 'For large organizations',
            'description_ar' => 'للمنظمات الكبيرة',
            'price' => 199,
            'button_text_en' => 'Contact Sales',
            'button_text_ar' => 'تواصل مع المبيعات',
            'order' => 2,
        ]);
        $enterprise->features()->createMany([
            ['name_en' => 'Everything in Pro', 'name_ar' => 'كل شيء في المهني', 'order' => 0],
            ['name_en' => 'Custom integrations', 'name_ar' => 'تكاملات مخصصة', 'order' => 1],
            ['name_en' => 'Dedicated account manager', 'name_ar' => 'مدير حساب مخصص', 'order' => 2],
            ['name_en' => 'SLA guarantee', 'name_ar' => 'ضمان SLA', 'order' => 3],
        ]);

        $faq = FaqSection::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'FAQ',
            'eyebrow_ar' => 'الأسئلة الشائعة',
            'title_en' => 'Frequently Asked Questions',
            'title_ar' => 'الأسئلة الشائعة',
            'description_en' => 'Everything you need to know about our platform',
            'description_ar' => 'كل ما تحتاج معرفته عن منصتنا',
            'is_active' => true,
        ]);

        $faq->items()->createMany([
            ['question_en' => 'What is OMS?', 'question_ar' => 'ما هو OMS؟', 'answer_en' => 'OMS is an all-in-one business management platform that helps you manage contracts, clients, and revenue.', 'answer_ar' => 'OMS هي منصة إدارة أعمال شاملة تساعدك في إدارة العقود والعملاء والإيرادات.', 'order' => 0],
            ['question_en' => 'How do I get started?', 'question_ar' => 'كيف أبدأ؟', 'answer_en' => 'Simply sign up for a free trial and start managing your business in minutes.', 'answer_ar' => 'ما عليك سوى التسجيل للحصول على تجربة مجانية والبدء في إدارة عملك في دقائق.', 'order' => 1],
            ['question_en' => 'Can I cancel anytime?', 'question_ar' => 'هل يمكنني الإلغاء في أي وقت؟', 'answer_en' => 'Yes, you can cancel your subscription at any time with no hidden fees.', 'answer_ar' => 'نعم، يمكنك إلغاء اشتراكك في أي وقت دون أي رسوم مخفية.', 'order' => 2],
        ]);

        CtaSection::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'Start Your Free Trial Today',
            'eyebrow_ar' => 'ابدأ تجربتك المجانية اليوم',
            'title_en' => 'Ready to Get Started?',
            'title_ar' => 'هل أنت مستعد للبدء؟',
            'description_en' => 'Join thousands of businesses already using OMS',
            'description_ar' => 'انضم إلى آلاف الشركات التي تستخدم OMS بالفعل',
            'button_text_en' => 'Start Free Trial',
            'button_text_ar' => 'ابدأ التجربة المجانية',
            'button_link' => '#contact',
            'secondary_button_text_en' => 'Talk to Sales',
            'secondary_button_text_ar' => 'تحدث مع المبيعات',
            'secondary_button_link' => '#contact',
            'whatsapp_number' => '+1234567890',
            'badges' => [
                ['text_en' => 'No credit card required', 'text_ar' => 'لا بطاقة ائتمان مطلوبة'],
                ['text_en' => '14-day free trial', 'text_ar' => '14 يوماً تجربة مجانية'],
                ['text_en' => 'Cancel anytime', 'text_ar' => 'إلغاء في أي وقت'],
            ],
            'is_active' => true,
        ]);

        $problem = ProblemSection::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'The Problem',
            'eyebrow_ar' => 'المشكلة',
            'title_en' => 'The Problem',
            'title_ar' => 'المشكلة',
            'description_en' => 'Managing business operations manually is inefficient and error-prone. Spreadsheets, disconnected systems, and manual processes slow down growth and create costly mistakes.',
            'description_ar' => 'إدارة العمليات التجارية يدويًا غير فعالة وعرضة للخطاء. جداول البيانات والأنظمة غير المتصلة والعمليات اليدوية تبطئ النمو وتسبب أخطاء مكلفة.',
            'is_active' => true,
        ]);
        $problem->items()->createMany([
            ['title_en' => 'Lost Contracts', 'title_ar' => 'عقود ضائعة', 'description_en' => 'Managing contracts across multiple platforms leads to chaos and lost documents', 'description_ar' => 'إدارة العقود عبر منصات متعددة تؤدي إلى الفوضى والوثائق المفقودة', 'order' => 0],
            ['title_en' => 'Manual Work', 'title_ar' => 'عمل يدوي', 'description_en' => 'Repetitive manual tasks consume hours of your valuable time every day', 'description_ar' => 'المهام اليدوية المتكررة تستهلك ساعات من وقتك الثمين كل يوم', 'order' => 1],
            ['title_en' => 'Data Scattered', 'title_ar' => 'بيانات متناثرة', 'description_en' => 'Client information scattered across different systems and spreadsheets', 'description_ar' => 'معلومات العملاء متناثرة عبر أنظمة مختلفة وجداول بيانات', 'order' => 2],
            ['title_en' => 'Revenue Leaks', 'title_ar' => 'تسريبات الإيرادات', 'description_en' => 'Missing renewals and unpaid invoices cost you money every month', 'description_ar' => 'التجديدات الفائتة والفواتير غير المدفوعة تكلفك المال كل شهر', 'order' => 3],
        ]);

        $features = FeaturesSection::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'Features',
            'eyebrow_ar' => 'الميزات',
            'title_en' => 'Powerful Features',
            'title_ar' => 'ميزات قوية',
            'description_en' => 'Everything you need to manage your business in one place',
            'description_ar' => 'كل ما تحتاجه لإدارة عملك في مكان واحد',
            'is_active' => true,
        ]);
        $features->features()->createMany([
            ['title_en' => 'Contract Management', 'title_ar' => 'إدارة العقود', 'description_en' => 'Create, track, and manage all your contracts in one place', 'description_ar' => 'إنشاء وتتبع وإدارة جميع عقودك في مكان واحد', 'icon' => 'document-text', 'order' => 0],
            ['title_en' => 'Client Database', 'title_ar' => 'قاعدة بيانات العملاء', 'description_en' => 'Keep all client information organized and accessible', 'description_ar' => 'احتفظ بجميع معلومات العملاء منظمة ويمكن الوصول إليها', 'icon' => 'users', 'order' => 1],
            ['title_en' => 'Revenue Tracking', 'title_ar' => 'تتبع الإيرادات', 'description_en' => 'Monitor your income and financial performance', 'description_ar' => 'مراقبة دخلك وأدائك المالي', 'icon' => 'currency-dollar', 'order' => 2],
            ['title_en' => 'Automated Workflows', 'title_ar' => 'أتمتة سير العمل', 'description_en' => 'Streamline processes and reduce manual work', 'description_ar' => 'تبسيط العمليات وتقليل العمل اليدوي', 'icon' => 'cog', 'order' => 3],
        ]);

        $audience = TargetAudience::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'Perfect For',
            'eyebrow_ar' => 'مثالي لـ',
            'title_en' => 'Who Is This For?',
            'title_ar' => 'لمن هذا؟',
            'description_en' => 'Perfect for businesses of all sizes',
            'description_ar' => 'مثالي للشركات من جميع الأحجام',
            'is_active' => true,
        ]);
        AudienceItem::create([
            'target_audience_id' => $audience->id,
            'title_en' => 'Small Businesses',
            'title_ar' => 'الشركات الصغيرة',
            'description_en' => 'Streamline your operations from day one',
            'description_ar' => 'قم بتبسيط عملياتك من اليوم الأول',
            'icon' => 'office-building',
            'order' => 0,
        ]);
        AudienceItem::create([
            'target_audience_id' => $audience->id,
            'title_en' => 'Freelancers',
            'title_ar' => 'المستقلون',
            'description_en' => 'Manage clients and projects efficiently',
            'description_ar' => 'إدارة العملاء والمشاريع بكفاءة',
            'icon' => 'user',
            'order' => 1,
        ]);
        AudienceItem::create([
            'target_audience_id' => $audience->id,
            'title_en' => 'Agencies',
            'title_ar' => 'الوكالات',
            'description_en' => 'Scale your agency with proper tools',
            'description_ar' => 'قم بتوسيع وكالتك بأدوات مناسبة',
            'icon' => 'collection',
            'order' => 2,
        ]);
        AudienceItem::create([
            'target_audience_id' => $audience->id,
            'title_en' => 'Enterprises',
            'title_ar' => 'المؤسسات',
            'description_en' => 'Custom solutions for large organizations',
            'description_ar' => 'حلول مخصصة للمنظمات الكبيرة',
            'icon' => 'globe',
            'order' => 3,
        ]);

        $socialProof = SocialProof::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'Social Proof',
            'eyebrow_ar' => 'شهادات العملاء',
            'title_en' => 'Trusted by Industry Leaders',
            'title_ar' => 'موثوق من قادة الصناعة',
            'description_en' => 'Join thousands of satisfied customers',
            'description_ar' => 'انضم إلى آلاف العملاء satisfaits',
            'is_active' => true,
        ]);
        $socialProof->items()->createMany([
            ['company' => 'TechCorp', 'metric' => '150% ROI', 'quote_en' => 'OMS transformed how we manage our contracts.', 'quote_ar' => 'OMS غيرت طريقة إدارة عقودنا.', 'order' => 0],
            ['company' => 'GrowthStartup', 'metric' => '3x Faster', 'quote_en' => 'We scaled 3x faster with OMS.', 'quote_ar' => 'وسعنا نشاطنا 3 أضعاف مع OMS.', 'order' => 1],
            ['company' => 'GlobalInc', 'metric' => '10K+ Users', 'quote_en' => 'The best investment we made.', 'quote_ar' => 'أفضل استثمار قمنا به.', 'order' => 2],
        ]);

        $whyUs = WhyUsSection::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'Why Choose Us',
            'eyebrow_ar' => 'لماذا تختارنا',
            'title_en' => 'Why Choose Us',
            'title_ar' => 'لماذا تختارنا',
            'description_en' => 'What sets us apart from the competition',
            'description_ar' => 'ما يميزنا عن المنافسين',
            'is_active' => true,
        ]);
        $whyUs->items()->createMany([
            ['title_en' => 'Easy to Use', 'title_ar' => 'سهل الاستخدام', 'description_en' => 'Intuitive interface that your team will love', 'description_ar' => 'واجهة بديهية سيحبها فريقك', 'icon' => 'star', 'order' => 0],
            ['title_en' => 'Secure', 'title_ar' => 'آمن', 'description_en' => 'Bank-level security to protect your data', 'description_ar' => 'أمان على مستوى البنوك لحماية بياناتك', 'icon' => 'shield-check', 'order' => 1],
            ['title_en' => 'Scalable', 'title_ar' => 'قابل للتطوير', 'description_en' => 'Grows with your business', 'description_ar' => 'ينمو مع عملك', 'icon' => 'trending-up', 'order' => 2],
            ['title_en' => 'Dedicated Support', 'title_ar' => 'دعم مخصص', 'description_en' => 'Responsive assistance when you need it', 'description_ar' => 'مساعدة مستمرة عندما تحتاج إليها', 'icon' => 'phone', 'order' => 3],
        ]);

        $howItWorks = HowItWorksSection::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'How It Works',
            'eyebrow_ar' => 'كيف يعمل',
            'title_en' => 'How It Works',
            'title_ar' => 'كيف يعمل',
            'description_en' => 'Get started in minutes',
            'description_ar' => 'ابدأ في دقائق',
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
            'is_active' => true,
        ]);
        $howItWorks->steps()->createMany([
            ['title_en' => 'Sign Up', 'title_ar' => 'سجل', 'description_en' => 'Create your account in seconds', 'description_ar' => 'أنشئ حسابك في ثوانٍ', 'order' => 0],
            ['title_en' => 'Add Data', 'title_ar' => 'أضف البيانات', 'description_en' => 'Import your contracts and clients', 'description_ar' => 'استورد عقودك وعملائك', 'order' => 1],
            ['title_en' => 'Start Managing', 'title_ar' => 'ابدأ الإدارة', 'description_en' => 'Take control of your business', 'description_ar' => 'تحكم في عملك', 'order' => 2],
        ]);

        $comparison = ComparisonSection::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'Comparison',
            'eyebrow_ar' => 'مقارنة',
            'title_en' => 'Why OMS Wins',
            'title_ar' => 'لماذا OMS يفوز',
            'description_en' => 'See how we compare to alternatives',
            'description_ar' => 'انظر كيف نقارن بالبدائل',
            'before_title_en' => 'Without OMS',
            'before_title_ar' => 'بدون النظام',
            'before_subtitle_en' => 'The old way',
            'before_subtitle_ar' => 'الطريقة القديمة',
            'after_title_en' => 'With OMS',
            'after_title_ar' => 'مع النظام',
            'after_subtitle_en' => 'The smart way',
            'after_subtitle_ar' => 'الطريقة الذكية',
            'is_active' => true,
        ]);
        $comparison->items()->createMany([
            ['text_en' => 'Scattered tools', 'text_ar' => 'أدوات متفرقة', 'icon' => 'x-circle', 'color' => 'red', 'order' => 0],
            ['text_en' => 'Manual follow-up', 'text_ar' => 'متابعة يدوية', 'icon' => 'x-circle', 'color' => 'red', 'order' => 1],
            ['text_en' => 'Missed renewals', 'text_ar' => 'تجديدات فائتة', 'icon' => 'x-circle', 'color' => 'red', 'order' => 2],
            ['text_en' => 'Limited visibility', 'text_ar' => 'رؤية محدودة', 'icon' => 'x-circle', 'color' => 'red', 'order' => 3],
            ['text_en' => 'All-in-one solution', 'text_ar' => 'حل شامل', 'icon' => 'check-circle', 'color' => 'green', 'order' => 4],
            ['text_en' => 'No hidden fees', 'text_ar' => 'بدون رسوم مخفية', 'icon' => 'check-circle', 'color' => 'green', 'order' => 5],
            ['text_en' => 'Free onboarding', 'text_ar' => 'إعداد مجاني', 'icon' => 'check-circle', 'color' => 'green', 'order' => 6],
            ['text_en' => 'Cancel anytime', 'text_ar' => 'إلغاء في أي وقت', 'icon' => 'check-circle', 'color' => 'green', 'order' => 7],
        ]);

        $contact = ContactSection::create([
            'landing_page_id' => $page->id,
            'eyebrow_en' => 'Contact Us',
            'eyebrow_ar' => 'اتصل بنا',
            'title_en' => 'Get in Touch',
            'title_ar' => 'تواصل معنا',
            'description_en' => 'We are here to help',
            'description_ar' => 'نحن هنا لمساعدتك',
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
            'form_badges' => [
                ['text_en' => 'No spam', 'text_ar' => 'لا بريد عشوائي'],
                ['text_en' => 'Free consultation', 'text_ar' => 'استشارة مجانية'],
            ],
            'is_active' => true,
        ]);
        $contact->items()->createMany([
            ['label_en' => 'Email', 'label_ar' => 'البريد الإلكتروني', 'value' => 'support@oms.com', 'icon' => 'mail', 'order' => 0],
            ['label_en' => 'Phone', 'label_ar' => 'الهاتف', 'value' => '+1 234 567 890', 'icon' => 'phone', 'order' => 1],
            ['label_en' => 'Address', 'label_ar' => 'العنوان', 'value' => '123 Business St, Suite 100', 'icon' => 'location', 'order' => 2],
        ]);

        $footer = FooterSection::create([
            'landing_page_id' => $page->id,
            'description_en' => 'The all-in-one business management platform',
            'description_ar' => 'منصة إدارة الأعمال الشاملة',
            'copyright_en' => '© 2026 OMS. All rights reserved.',
            'copyright_ar' => '© 2026 OMS. جميع الحقوق محفوظة.',
            'is_active' => true,
        ]);

        $footerLinkGroup1 = FooterLinkGroup::create([
            'footer_section_id' => $footer->id,
            'key' => 'product',
            'title_en' => 'Product',
            'title_ar' => 'المنتج',
            'order' => 0,
        ]);
        $footerLinkGroup1->links()->createMany([
            ['label_en' => 'Features', 'label_ar' => 'الميزات', 'url' => '#features', 'order' => 0],
            ['label_en' => 'Pricing', 'label_ar' => 'التسعير', 'url' => '#packages', 'order' => 1],
            ['label_en' => 'FAQ', 'label_ar' => 'الأسئلة الشائعة', 'url' => '#faq', 'order' => 2],
        ]);

        $footerLinkGroup2 = FooterLinkGroup::create([
            'footer_section_id' => $footer->id,
            'key' => 'company',
            'title_en' => 'Company',
            'title_ar' => 'الشركة',
            'order' => 1,
        ]);
        $footerLinkGroup2->links()->createMany([
            ['label_en' => 'About', 'label_ar' => 'عن الشركة', 'url' => '#', 'order' => 0],
            ['label_en' => 'Contact', 'label_ar' => 'اتصل بنا', 'url' => '#contact', 'order' => 1],
            ['label_en' => 'Careers', 'label_ar' => 'وظائف', 'url' => '#', 'order' => 2],
        ]);

        SocialLink::create(['footer_section_id' => $footer->id, 'platform' => 'facebook', 'url' => 'https://facebook.com/oms', 'order' => 0]);
        SocialLink::create(['footer_section_id' => $footer->id, 'platform' => 'linkedin', 'url' => 'https://linkedin.com/company/oms', 'order' => 1]);
        SocialLink::create(['footer_section_id' => $footer->id, 'platform' => 'instagram', 'url' => 'https://instagram.com/oms', 'order' => 2]);
        SocialLink::create(['footer_section_id' => $footer->id, 'platform' => 'tiktok', 'url' => 'https://www.tiktok.com/@oms', 'order' => 3]);

        foreach ([
            ['services', 'Services', 'الخدمات', 'Core capabilities managed from the dashboard.', 'الخدمات الأساسية المدارة من لوحة التحكم', 0],
            ['projects', 'Projects', 'المشاريع', 'Selected work and implementations.', 'أعمال وتطبيقات مختارة', 1],
            ['case-studies', 'Case Studies', 'دراسات الحالة', 'Detailed stories behind delivered results.', 'قصص تفصيلية للنتائج المنجزة', 2],
            ['team', 'Team', 'الفريق', 'People behind the product and delivery.', 'الفريق وراء المنتج والتنفيذ', 3],
            ['testimonials', 'Testimonials', 'آراء العملاء', 'Client feedback and outcomes.', 'آراء العملاء والنتائج', 4],
            ['clients', 'Clients', 'العملاء', 'Organizations that trust the team.', 'جهات تثق بالفريق', 5],
            ['blog', 'Blog', 'المدونة', 'Latest articles and updates.', 'أحدث المقالات والتحديثات', 6],
        ] as [$module, $titleEn, $titleAr, $descriptionEn, $descriptionAr, $order]) {
            PortfolioSection::updateOrCreate(
                ['module' => $module],
                [
                    'title_en' => $titleEn,
                    'title_ar' => $titleAr,
                    'description_en' => $descriptionEn,
                    'description_ar' => $descriptionAr,
                    'is_active' => true,
                    'order' => $order,
                    'limit' => 6,
                ]
            );
        }
    }
}
