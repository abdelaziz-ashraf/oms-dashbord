<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\HeroSection;
use App\Models\HeroStatistic;
use App\Models\Announcement;
use App\Models\ProblemSection;
use App\Models\FeaturesSection;
use App\Models\Feature;
use App\Models\PackagesSection;
use App\Models\Package;
use App\Models\PackageFeature;
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
use App\Models\FaqSection;
use App\Models\FaqItem;
use App\Models\CtaSection;
use App\Models\ContactSection;
use App\Models\ContactItem;
use App\Models\FooterSection;
use App\Models\FooterLinkGroup;
use App\Models\FooterLink;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    private function getLandingPage()
    {
        return LandingPage::first() ?? LandingPage::create([
            'slug' => 'oms',
            'name' => 'OMS Landing Page',
        ]);
    }

    public function updateAnnouncement(Request $request)
    {
        $page = $this->getLandingPage();
        $announcement = $page->announcement ?? new Announcement(['landing_page_id' => $page->id]);
        
        $announcement->fill($request->validate([
            'text_en' => 'required',
            'text_ar' => 'required',
            'link' => 'nullable',
            'is_active' => 'boolean',
        ]))->save();

        $page->is_announcement_active = $request->boolean('is_active', true);
        $page->save();

        return back()->with('success', 'Announcement updated!');
    }

    public function updateHero(Request $request)
    {
        $page = $this->getLandingPage();
        $hero = $page->hero ?? new HeroSection(['landing_page_id' => $page->id]);
        
        $hero->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'subtitle_en' => 'required',
            'subtitle_ar' => 'required',
            'button_text_en' => 'required',
            'button_text_ar' => 'required',
            'button_link' => 'nullable',
            'secondary_button_text_en' => 'nullable',
            'secondary_button_text_ar' => 'nullable',
            'secondary_button_link' => 'nullable',
            'trusted_badge_en' => 'required',
            'trusted_badge_ar' => 'required',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('statistics')) {
            $hero->statistics()->delete();
            foreach ($request->statistics as $stat) {
                if (!empty($stat['value'])) {
                    $hero->statistics()->create($stat);
                }
            }
        }

        return back()->with('success', 'Hero section updated!');
    }

    public function updateProblem(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->problem ?? new ProblemSection(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('items')) {
            $section->items()->delete();
            foreach ($request->items as $index => $item) {
                if (!empty($item['title_en'])) {
                    $section->items()->create(array_merge($item, ['order' => $index]));
                }
            }
        }

        return back()->with('success', 'Problem section updated!');
    }

    public function updateFeatures(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->features ?? new FeaturesSection(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('features')) {
            $section->features()->delete();
            foreach ($request->features as $index => $feature) {
                if (!empty($feature['title_en'])) {
                    $section->features()->create(array_merge($feature, ['order' => $index]));
                }
            }
        }

        return back()->with('success', 'Features section updated!');
    }

    public function updatePackages(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->packages ?? new PackagesSection(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'popular_badge_en' => 'required',
            'popular_badge_ar' => 'required',
            'billing_period_en' => 'required',
            'billing_period_ar' => 'required',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('packages')) {
            $section->packages()->delete();
            foreach ($request->packages as $index => $pkg) {
                if (!empty($pkg['name_en'])) {
                    $package = $section->packages()->create(array_merge($pkg, ['order' => $index]));
                    
                    if (isset($pkg['features_en'])) {
                        foreach ($pkg['features_en'] as $fIndex => $feature) {
                            if (!empty($feature)) {
                                $package->features()->create([
                                    'name_en' => $feature,
                                    'name_ar' => $pkg['features_ar'][$fIndex] ?? $feature,
                                    'order' => $fIndex,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return back()->with('success', 'Packages section updated!');
    }

    public function updateTargetAudience(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->targetAudience ?? new TargetAudience(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('items')) {
            $section->items()->delete();
            foreach ($request->items as $index => $item) {
                if (!empty($item['title_en'])) {
                    $section->items()->create(array_merge($item, ['order' => $index]));
                }
            }
        }

        return back()->with('success', 'Target audience section updated!');
    }

    public function updateSocialProof(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->socialProof ?? new SocialProof(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('items')) {
            $section->items()->delete();
            foreach ($request->items as $index => $item) {
                if (!empty($item['company'])) {
                    $section->items()->create(array_merge($item, ['order' => $index]));
                }
            }
        }

        return back()->with('success', 'Social proof section updated!');
    }

    public function updateWhyUs(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->whyUs ?? new WhyUsSection(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('items')) {
            $section->items()->delete();
            foreach ($request->items as $index => $item) {
                if (!empty($item['title_en'])) {
                    $section->items()->create(array_merge($item, ['order' => $index]));
                }
            }
        }

        return back()->with('success', 'Why us section updated!');
    }

    public function updateHowItWorks(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->howItWorks ?? new HowItWorksSection(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('steps')) {
            $section->steps()->delete();
            foreach ($request->steps as $index => $step) {
                if (!empty($step['title_en'])) {
                    $section->steps()->create(array_merge($step, ['order' => $index]));
                }
            }
        }

        return back()->with('success', 'How it works section updated!');
    }

    public function updateComparison(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->comparison ?? new ComparisonSection(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('items')) {
            $section->items()->delete();
            foreach ($request->items as $index => $item) {
                if (!empty($item['text_en'])) {
                    $section->items()->create(array_merge($item, ['order' => $index]));
                }
            }
        }

        return back()->with('success', 'Comparison section updated!');
    }

    public function updateFaq(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->faq ?? new FaqSection(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('items')) {
            $section->items()->delete();
            foreach ($request->items as $index => $item) {
                if (!empty($item['question_en'])) {
                    $section->items()->create(array_merge($item, ['order' => $index]));
                }
            }
        }

        return back()->with('success', 'FAQ section updated!');
    }

    public function updateCta(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->cta ?? new CtaSection(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'button_text_en' => 'required',
            'button_text_ar' => 'required',
            'button_link' => 'nullable',
            'is_active' => 'boolean',
        ]))->save();

        return back()->with('success', 'CTA section updated!');
    }

    public function updateContact(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->contact ?? new ContactSection(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('items')) {
            $section->items()->delete();
            foreach ($request->items as $index => $item) {
                if (!empty($item['icon'])) {
                    $section->items()->create(array_merge($item, ['order' => $index]));
                }
            }
        }

        return back()->with('success', 'Contact section updated!');
    }

    public function updateFooter(Request $request)
    {
        $page = $this->getLandingPage();
        $section = $page->footer ?? new FooterSection(['landing_page_id' => $page->id]);
        
        $section->fill($request->validate([
            'description_en' => 'required',
            'description_ar' => 'required',
            'copyright_en' => 'required',
            'copyright_ar' => 'required',
            'is_active' => 'boolean',
        ]))->save();

        if ($request->has('link_groups')) {
            $section->linkGroups()->delete();
            foreach ($request->link_groups as $gIndex => $group) {
                if (!empty($group['title_en'])) {
                    $linkGroup = $section->linkGroups()->create(array_merge($group, ['order' => $gIndex]));
                    
                    if (isset($group['links'])) {
                        foreach ($group['links'] as $lIndex => $link) {
                            if (!empty($link['label_en'])) {
                                $linkGroup->links()->create(array_merge($link, ['order' => $lIndex]));
                            }
                        }
                    }
                }
            }
        }

        if ($request->has('social_links')) {
            $section->socialLinks()->delete();
            foreach ($request->social_links as $index => $link) {
                if (!empty($link['platform'])) {
                    $section->socialLinks()->create(array_merge($link, ['order' => $index]));
                }
            }
        }

        return back()->with('success', 'Footer section updated!');
    }
}