<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    private $sections = [
        'announcement' => ['title' => 'Announcement', 'icon' => 'bullhorn', 'color' => 'amber'],
        'hero' => ['title' => 'Hero', 'icon' => 'image', 'color' => 'cyan'],
        'problem' => ['title' => 'Problem', 'icon' => 'exclamation-circle', 'color' => 'red'],
        'features' => ['title' => 'Features', 'icon' => 'star', 'color' => 'yellow'],
        'packages' => ['title' => 'Packages', 'icon' => 'box', 'color' => 'green'],
        'audience' => ['title' => 'Target Audience', 'icon' => 'users', 'color' => 'blue'],
        'social-proof' => ['title' => 'Social Proof', 'icon' => 'award', 'color' => 'purple'],
        'why-us' => ['title' => 'Why Us', 'icon' => 'check-circle', 'color' => 'emerald'],
        'how-it-works' => ['title' => 'How It Works', 'icon' => 'cogs', 'color' => 'orange'],
        'comparison' => ['title' => 'Comparison', 'icon' => 'balance-scale', 'color' => 'teal'],
        'faq' => ['title' => 'FAQ', 'icon' => 'question-circle', 'color' => 'pink'],
        'cta' => ['title' => 'CTA', 'icon' => 'hand-pointer', 'color' => 'indigo'],
        'contact' => ['title' => 'Contact', 'icon' => 'envelope', 'color' => 'cyan'],
        'footer' => ['title' => 'Footer', 'icon' => 'grip-lines', 'color' => 'slate'],
    ];

    public function index()
    {
        $landingPage = LandingPage::with([
            'announcement',
            'hero.statistics',
            'problem',
            'features.features',
            'packages.packages.features',
            'targetAudience.items',
            'socialProof.items',
            'whyUs.items',
            'howItWorks.steps',
            'comparison.items',
            'faq.items',
            'cta',
            'contact.items',
            'footer.linkGroups.links',
            'footer.socialLinks',
        ])->first();

        return view('admin.dashboard', compact('landingPage'));
    }

    public function showSection($section)
    {
        if (!isset($this->sections[$section])) {
            return redirect()->route('admin.dashboard');
        }

        $landingPage = LandingPage::with([
            'announcement',
            'hero.statistics',
            'problem',
            'features.features',
            'packages.packages.features',
            'targetAudience.items',
            'socialProof.items',
            'whyUs.items',
            'howItWorks.steps',
            'comparison.items',
            'faq.items',
            'cta',
            'contact.items',
            'footer.linkGroups.links',
            'footer.socialLinks',
        ])->first();

        $sectionConfig = $this->sections[$section];
        return view('admin.sections.index', compact('landingPage', 'sectionConfig', 'section'));
    }

    public function update(Request $request)
    {
        $landingPage = LandingPage::first() ?? LandingPage::create([
            'slug' => 'oms',
            'name' => 'OMS Landing',
        ]);

        $data = $request->all();
        unset($data['_token'], $data['_method']);

        foreach ($data as $key => $value) {
            if (in_array($key, $landingPage->getFillable())) {
                $landingPage->$key = $value;
            }
        }
        $landingPage->save();

        return back()->with('success', 'Landing page updated successfully!');
    }
}