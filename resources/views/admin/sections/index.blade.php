@extends('layouts.admin')

@section('title', $sectionConfig['title'] . ' - OMS Dashboard')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="p-2 hover:bg-slate-200 rounded-lg transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-{{ $sectionConfig['color'] }}-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-{{ $sectionConfig['icon'] }} text-{{ $sectionConfig['color'] }}-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $sectionConfig['title'] }}</h1>
                    <p class="text-slate-500 text-sm">Edit and manage section content</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="h-px bg-slate-200 mt-6"></div>
</div>

<div id="{{ $section }}" class="section-card bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
    @include("admin.sections-standalone.{$section}", ['landingPage' => $landingPage])
</div>
@endsection