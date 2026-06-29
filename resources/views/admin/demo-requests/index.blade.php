@extends('layouts.admin')

@section('title', 'Demo Requests - OMS Dashboard')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Demo Requests</h1>
            <p class="text-slate-500 text-sm mt-1">Free trial requests submitted from the landing page</p>
        </div>
        <a href="{{ route('admin.demo-requests.export', request()->only(['status', 'search'])) }}"
           class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 text-sm font-medium flex items-center gap-2">
            <i class="fas fa-download text-slate-400"></i>
            Export CSV
        </a>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    @php
        $statCards = [
            ['label' => 'Total', 'value' => $total, 'color' => 'slate', 'icon' => 'layer-group'],
            ['label' => 'New', 'value' => $counts['new'] ?? 0, 'color' => 'blue', 'icon' => 'bell'],
            ['label' => 'Read', 'value' => $counts['read'] ?? 0, 'color' => 'green', 'icon' => 'check'],
            ['label' => 'Archived', 'value' => $counts['archived'] ?? 0, 'color' => 'slate', 'icon' => 'archive'],
        ];
    @endphp
    @foreach($statCards as $card)
    <div class="bg-white rounded-xl border border-slate-200 p-4 flex items-center gap-3">
        <div class="w-9 h-9 bg-{{ $card['color'] }}-100 rounded-lg flex items-center justify-center shrink-0">
            <i class="fas fa-{{ $card['icon'] }} text-{{ $card['color'] }}-500 text-sm"></i>
        </div>
        <div>
            <p class="text-xs text-slate-500">{{ $card['label'] }}</p>
            <p class="text-xl font-bold text-slate-800">{{ $card['value'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.demo-requests.index') }}" class="bg-white border border-slate-200 rounded-2xl p-4 mb-4">
    <div class="grid md:grid-cols-[1fr_auto] gap-3">
        <input type="search" name="search" value="{{ $search }}"
               placeholder="Search name, email, company, industry, job title…"
               class="w-full border border-slate-300 rounded-xl px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-sm">
        @if($status)
            <input type="hidden" name="status" value="{{ $status }}">
        @endif
        <button class="px-5 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 text-sm font-medium">Search</button>
    </div>
</form>

{{-- Status filters --}}
<div class="flex flex-wrap gap-2 mb-6">
    @php
        $filters = ['' => 'All', 'new' => 'New', 'read' => 'Read', 'replied' => 'Replied', 'archived' => 'Archived'];
    @endphp
    @foreach($filters as $key => $label)
        <a href="{{ route('admin.demo-requests.index', array_filter(['status' => $key, 'search' => $search])) }}"
           class="px-4 py-2 rounded-lg text-sm font-medium {{ ($status ?? '') === $key ? 'bg-blue-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            {{ $label }}
            @if($key)
                <span class="ms-1 text-xs opacity-75">{{ $counts[$key] ?? 0 }}</span>
            @endif
        </a>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
            <tr>
                <th class="text-left px-5 py-3 font-semibold">Applicant</th>
                <th class="text-left px-5 py-3 font-semibold">Company / Industry</th>
                <th class="text-left px-5 py-3 font-semibold">Size</th>
                <th class="text-left px-5 py-3 font-semibold">Status</th>
                <th class="text-left px-5 py-3 font-semibold">Submitted</th>
                <th class="text-right px-5 py-3 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($messages as $message)
                <tr class="{{ $message->status === 'new' ? 'bg-blue-50/40' : '' }} hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-4">
                        <div class="font-semibold text-slate-800">{{ $message->full_name ?: 'Unknown' }}</div>
                        <div class="text-slate-500 text-xs">{{ $message->email }}</div>
                        @if($message->phone)
                            <div class="text-slate-400 text-xs">{{ $message->phone }}</div>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="text-slate-700 font-medium">{{ $message->company ?: '-' }}</div>
                        @if($message->industry)
                            <span class="inline-block mt-1 px-2 py-0.5 bg-slate-100 text-slate-500 text-xs rounded-full">
                                {{ $message->industry }}
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @if($message->company_size)
                            <span class="px-2.5 py-1 bg-orange-50 text-orange-600 text-xs font-semibold rounded-full border border-orange-100">
                                {{ $message->company_size }} users
                            </span>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @php
                            $statusColors = [
                                'new'      => 'bg-blue-100 text-blue-700',
                                'read'     => 'bg-green-100 text-green-700',
                                'replied'  => 'bg-purple-100 text-purple-700',
                                'archived' => 'bg-slate-100 text-slate-500',
                            ];
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$message->status] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ ucfirst($message->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-slate-500 text-xs">{{ $message->created_at->diffForHumans() }}</td>
                    <td class="px-5 py-4 text-right">
                        <a href="{{ route('admin.demo-requests.show', $message) }}"
                           class="px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded-lg hover:bg-blue-600 transition">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-16 text-center text-slate-400">
                        <i class="fas fa-inbox text-3xl mb-3 block"></i>
                        No demo requests yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $messages->links() }}
</div>
@endsection
