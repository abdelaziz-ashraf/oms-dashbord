@extends('layouts.admin')

@section('title', 'Contact Messages - OMS Dashboard')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Contact Messages</h1>
            <p class="text-slate-500 text-sm mt-1">Review and manage landing page submissions</p>
        </div>
        <a href="{{ route('admin.contact-messages.export', request()->only(['status', 'search'])) }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 text-sm font-medium">
            Export CSV
        </a>
    </div>
</div>

<form method="GET" action="{{ route('admin.contact-messages.index') }}" class="bg-white border border-slate-200 rounded-2xl p-4 mb-6">
    <div class="grid md:grid-cols-[1fr_auto] gap-3">
        <input type="search" name="search" value="{{ $search }}" placeholder="Search name, email, company, subject, or message" class="w-full border border-slate-300 rounded-xl px-4 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        @if($status)
            <input type="hidden" name="status" value="{{ $status }}">
        @endif
        <button class="px-5 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">Search</button>
    </div>
</form>

<div class="flex flex-wrap gap-2 mb-6">
    @php
        $filters = [
            '' => 'All',
            'new' => 'New',
            'read' => 'Read',
            'replied' => 'Replied',
            'archived' => 'Archived',
        ];
    @endphp
    @foreach($filters as $key => $label)
        <a href="{{ route('admin.contact-messages.index', $key ? ['status' => $key] : []) }}"
           class="px-4 py-2 rounded-lg text-sm font-medium {{ ($status ?? '') === $key ? 'bg-blue-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            {{ $label }}
            @if($key)
                <span class="ms-1 text-xs opacity-75">{{ $counts[$key] ?? 0 }}</span>
            @endif
        </a>
    @endforeach
</div>

<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500">
            <tr>
                <th class="text-left px-5 py-3 font-semibold">Sender</th>
                <th class="text-left px-5 py-3 font-semibold">Company</th>
                <th class="text-left px-5 py-3 font-semibold">Status</th>
                <th class="text-left px-5 py-3 font-semibold">Received</th>
                <th class="text-right px-5 py-3 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($messages as $message)
                <tr class="{{ $message->status === 'new' ? 'bg-blue-50/40' : '' }}">
                    <td class="px-5 py-4">
                        <div class="font-semibold text-slate-800">{{ $message->full_name ?: 'Unknown' }}</div>
                        <div class="text-slate-500">{{ $message->email }}</div>
                    </td>
                    <td class="px-5 py-4 text-slate-600">{{ $message->company ?: '-' }}</td>
                    <td class="px-5 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                            {{ ucfirst($message->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-slate-500">{{ $message->created_at->diffForHumans() }}</td>
                    <td class="px-5 py-4 text-right">
                        <a href="{{ route('admin.contact-messages.show', $message) }}" class="text-blue-500 hover:text-blue-700 font-medium">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-12 text-center text-slate-500">No messages found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $messages->links() }}
</div>
@endsection
