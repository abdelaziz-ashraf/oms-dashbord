@extends('layouts.admin')

@section('title', 'Dashboard - OMS')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Welcome Back!</h1>
            <p class="text-slate-500 mt-1">Manage your landing page sections</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-external-link-alt"></i>
            View Live Site
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @php
    $stats = [
        ['icon' => 'fa-eye', 'color' => 'blue', 'label' => 'Active Sections', 'value' => '14'],
        ['icon' => 'fa-bullhorn', 'color' => 'amber', 'label' => 'Announcement', 'value' => $landingPage->is_announcement_active ? 'On' : 'Off'],
        ['icon' => 'fa-image', 'color' => 'cyan', 'label' => 'Hero Section', 'value' => $landingPage->hero?->is_active ? 'On' : 'Off'],
        ['icon' => 'fa-star', 'color' => 'yellow', 'label' => 'Features', 'value' => count($landingPage->features?->features ?? [])],
    ];
    @endphp
    @foreach($stats as $stat)
    <div class="bg-white rounded-xl p-5 border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-{{ $stat['color'] }}-100 rounded-xl flex items-center justify-center">
            <i class="fas {{ $stat['icon'] }} text-{{ $stat['color'] }}-600"></i>
        </div>
        <div>
            <p class="text-slate-500 text-sm">{{ $stat['label'] }}</p>
            <p class="text-xl font-bold text-slate-800">{{ $stat['value'] }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @php
    $sections = [
        ['key' => 'announcement', 'icon' => 'bullhorn', 'color' => 'amber', 'name' => 'Announcement', 'desc' => 'Top bar notification'],
        ['key' => 'hero', 'icon' => 'image', 'color' => 'cyan', 'name' => 'Hero', 'desc' => 'Main banner section'],
        ['key' => 'problem', 'icon' => 'exclamation-circle', 'color' => 'red', 'name' => 'Problem', 'desc' => 'Pain point section'],
        ['key' => 'features', 'icon' => 'star', 'color' => 'yellow', 'name' => 'Features', 'desc' => 'Product features'],
        ['key' => 'packages', 'icon' => 'box', 'color' => 'green', 'name' => 'Packages', 'desc' => 'Pricing plans'],
        ['key' => 'audience', 'icon' => 'users', 'color' => 'blue', 'name' => 'Target Audience', 'desc' => 'Who it\'s for'],
        ['key' => 'social-proof', 'icon' => 'award', 'color' => 'purple', 'name' => 'Social Proof', 'desc' => 'Testimonials'],
        ['key' => 'why-us', 'icon' => 'check-circle', 'color' => 'emerald', 'name' => 'Why Us', 'desc' => 'Benefits'],
        ['key' => 'how-it-works', 'icon' => 'cogs', 'color' => 'orange', 'name' => 'How It Works', 'desc' => 'Step by step'],
        ['key' => 'comparison', 'icon' => 'balance-scale', 'color' => 'teal', 'name' => 'Comparison', 'desc' => 'Feature table'],
        ['key' => 'faq', 'icon' => 'question-circle', 'color' => 'pink', 'name' => 'FAQ', 'desc' => 'Questions'],
        ['key' => 'cta', 'icon' => 'hand-pointer', 'color' => 'indigo', 'name' => 'CTA', 'desc' => 'Call to action'],
        ['key' => 'contact', 'icon' => 'envelope', 'color' => 'cyan', 'name' => 'Contact', 'desc' => 'Contact info'],
        ['key' => 'footer', 'icon' => 'grip-lines', 'color' => 'slate', 'name' => 'Footer', 'desc' => 'Page footer'],
    ];
    @endphp
    
    @foreach($sections as $section)
    <a href="{{ route('admin.section', $section['key']) }}" class="group bg-white rounded-xl p-6 border border-slate-200 hover:border-{{ $section['color'] }}-300 hover:shadow-lg transition-all">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-{{ $section['color'] }}-100 rounded-xl flex items-center justify-center group-hover:bg-{{ $section['color'] }}-200 transition">
                <i class="fas fa-{{ $section['icon'] }} text-{{ $section['color'] }}-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-slate-800">{{ $section['name'] }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $section['desc'] }}</p>
            </div>
            <i class="fas fa-chevron-right text-slate-400 group-hover:text-{{ $section['color'] }}-500 transition"></i>
        </div>
    </a>
    @endforeach
</div>
@endsection