@extends('layouts.admin')

@section('title', 'Demo Request - OMS Dashboard')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.demo-requests.index') }}" class="p-2 hover:bg-slate-200 rounded-lg transition text-slate-600">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Demo Request</h1>
            <p class="text-slate-500 text-sm mt-1">{{ $contactMessage->created_at->format('Y-m-d H:i') }}</p>
        </div>
        @php
            $statusColors = [
                'new'      => 'bg-blue-100 text-blue-700',
                'read'     => 'bg-green-100 text-green-700',
                'replied'  => 'bg-purple-100 text-purple-700',
                'archived' => 'bg-slate-100 text-slate-500',
            ];
        @endphp
        <span class="ms-auto px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$contactMessage->status] ?? '' }}">
            {{ ucfirst($contactMessage->status) }}
        </span>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- Left: main info --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Contact info --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="text-base font-bold text-slate-800 mb-5 flex items-center gap-2">
                <i class="fas fa-user text-blue-400"></i> Applicant Info
            </h2>
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Full Name</p>
                    <p class="font-semibold text-slate-800">{{ $contactMessage->full_name ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Email</p>
                    <a href="mailto:{{ $contactMessage->email }}" class="font-semibold text-blue-500 hover:text-blue-700">
                        {{ $contactMessage->email }}
                    </a>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Phone</p>
                    <p class="font-semibold text-slate-800">
                        @if($contactMessage->phone)
                            <a href="tel:{{ $contactMessage->phone }}" class="hover:text-blue-500">{{ $contactMessage->phone }}</a>
                        @else
                            -
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Job Title</p>
                    <p class="font-semibold text-slate-800">{{ $contactMessage->job_title ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Language</p>
                    <p class="font-semibold text-slate-800 uppercase">{{ $contactMessage->locale ?: '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Company info --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="text-base font-bold text-slate-800 mb-5 flex items-center gap-2">
                <i class="fas fa-building text-orange-400"></i> Company Info
            </h2>
            <div class="grid sm:grid-cols-3 gap-5">
                <div>
                    <p class="text-xs text-slate-400 mb-1">Company</p>
                    <p class="font-semibold text-slate-800">{{ $contactMessage->company ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Industry</p>
                    <p class="font-semibold text-slate-800">{{ $contactMessage->industry ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-1">Expected Users</p>
                    @if($contactMessage->company_size)
                        <span class="inline-block px-3 py-1 bg-orange-50 text-orange-600 text-sm font-bold rounded-full border border-orange-100">
                            {{ $contactMessage->company_size }} users
                        </span>
                    @else
                        <p class="font-semibold text-slate-800">-</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- What they want to improve --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="text-base font-bold text-slate-800 mb-5 flex items-center gap-2">
                <i class="fas fa-chart-line text-green-400"></i> Areas to Improve
            </h2>
            @php
                $improvements = $contactMessage->improvements ?? [];
                $labels = [
                    'operations' => 'Operations Management',
                    'hr'         => 'HR Management',
                    'customers'  => 'Customer Management',
                    'vendors'    => 'Vendor Management',
                    'contracts'  => 'Contract Management',
                    'finance'    => 'Financial Tracking',
                ];
            @endphp
            @if(count($improvements))
                <div class="flex flex-wrap gap-2">
                    @foreach($improvements as $item)
                        <span class="px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-xl border border-blue-100">
                            <i class="fas fa-check-circle text-blue-400 me-1.5"></i>
                            {{ $labels[$item] ?? ucfirst(str_replace('_', ' ', $item)) }}
                        </span>
                    @endforeach
                </div>
            @else
                <p class="text-slate-400 text-sm">No selections provided.</p>
            @endif
        </div>

    </div>

    {{-- Right sidebar --}}
    <aside class="space-y-6">

        {{-- Quick actions --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-3">
            <h3 class="font-semibold text-slate-800 text-sm">Quick Actions</h3>
            <a href="mailto:{{ $contactMessage->email }}"
               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition text-sm font-medium">
                <i class="fas fa-paper-plane"></i> Send Email
            </a>
            @if($contactMessage->phone)
            <a href="https://wa.me/{{ preg_replace('/\D/', '', $contactMessage->phone) }}" target="_blank"
               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-[#25D366] text-white rounded-xl hover:opacity-90 transition text-sm font-medium">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
            @endif
        </div>

        {{-- Status --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <form method="POST" action="{{ route('admin.demo-requests.status', $contactMessage) }}" class="space-y-3">
                @csrf
                @method('PATCH')
                <label class="block text-sm font-semibold text-slate-700">Update Status</label>
                <select name="status" class="w-full border border-slate-300 rounded-xl px-3 py-2 text-sm">
                    @foreach(['new', 'read', 'replied', 'archived'] as $s)
                        <option value="{{ $s }}" {{ $contactMessage->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="w-full px-4 py-2.5 bg-slate-800 text-white rounded-xl hover:bg-slate-700 text-sm font-medium transition">
                    Save Status
                </button>
            </form>
        </div>

        {{-- Meta --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 space-y-3 text-sm">
            <h3 class="font-semibold text-slate-800">Details</h3>
            <div class="flex justify-between text-slate-600">
                <span class="text-slate-400">Submitted</span>
                <span>{{ $contactMessage->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="flex justify-between text-slate-600">
                <span class="text-slate-400">Read at</span>
                <span>{{ $contactMessage->read_at?->format('d M Y, H:i') ?: 'Not read' }}</span>
            </div>
            <div class="flex justify-between text-slate-600">
                <span class="text-slate-400">Source</span>
                <span class="font-mono text-xs bg-slate-100 px-2 py-0.5 rounded">{{ $contactMessage->source }}</span>
            </div>
        </div>

        {{-- Delete --}}
        <form method="POST" action="{{ route('admin.demo-requests.destroy', $contactMessage) }}"
              onsubmit="return confirm('Delete this demo request?')">
            @csrf
            @method('DELETE')
            <button class="w-full px-4 py-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 text-sm font-medium transition">
                <i class="fas fa-trash me-1"></i> Delete Request
            </button>
        </form>
    </aside>
</div>
@endsection
