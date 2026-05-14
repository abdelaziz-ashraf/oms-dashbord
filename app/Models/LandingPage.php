<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandingPage extends Model
{
    protected $fillable = ['slug', 'name', 'logo_text_en', 'logo_text_ar', 'is_announcement_active'];

    public function announcement()
    {
        return $this->hasOne(Announcement::class)->where('is_active', true);
    }

    public function hero()
    {
        return $this->hasOne(HeroSection::class);
    }

    public function problem()
    {
        return $this->hasOne(ProblemSection::class);
    }

    public function features()
    {
        return $this->hasOne(FeaturesSection::class);
    }

    public function packages()
    {
        return $this->hasOne(PackagesSection::class);
    }

    public function targetAudience()
    {
        return $this->hasOne(TargetAudience::class);
    }

    public function socialProof()
    {
        return $this->hasOne(SocialProof::class);
    }

    public function whyUs()
    {
        return $this->hasOne(WhyUsSection::class);
    }

    public function howItWorks()
    {
        return $this->hasOne(HowItWorksSection::class);
    }

    public function comparison()
    {
        return $this->hasOne(ComparisonSection::class);
    }

    public function faq()
    {
        return $this->hasOne(FaqSection::class);
    }

    public function cta()
    {
        return $this->hasOne(CtaSection::class);
    }

    public function contact()
    {
        return $this->hasOne(ContactSection::class);
    }

    public function footer()
    {
        return $this->hasOne(FooterSection::class);
    }
}