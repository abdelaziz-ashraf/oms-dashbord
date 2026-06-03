@extends('layouts.admin')

@section('title', 'Contact Message - OMS Dashboard')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.contact-messages.index') }}" class="p-2 hover:bg-slate-200 rounded-lg transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Contact Message</h1>
            <p class="text-slate-500 text-sm mt-1">{{ $contactMessage->created_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">{{ $contactMessage->subject ?: 'Landing page inquiry' }}</h2>

        <div class="prose max-w-none text-slate-700 whitespace-pre-wrap">
            {{ $contactMessage->message ?: 'No message body was provided.' }}
        </div>
    </div>

    <aside class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Sender</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-slate-500">Name</dt>
                    <dd class="font-medium text-slate-800">{{ $contactMessage->full_name ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Email</dt>
                    <dd><a class="text-blue-500 hover:text-blue-700" href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a></dd>
                </div>
                <div>
                    <dt class="text-slate-500">Phone</dt>
                    <dd class="text-slate-800">{{ $contactMessage->phone ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Company</dt>
                    <dd class="text-slate-800">{{ $contactMessage->company ?: '-' }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Locale / Source</dt>
                    <dd class="text-slate-800">{{ $contactMessage->locale ?: '-' }} / {{ $contactMessage->source }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <form method="POST" action="{{ route('admin.contact-messages.status', $contactMessage) }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <label class="block text-sm font-semibold text-slate-700">Status</label>
                <select name="status" class="w-full border border-slate-300 rounded-xl px-3 py-2">
                    @foreach(['new', 'read', 'replied', 'archived'] as $status)
                        <option value="{{ $status }}" {{ $contactMessage->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="w-full px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">Update Status</button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h3 class="font-semibold text-slate-800 mb-4">Reply</h3>
            <form method="POST" action="{{ route('admin.contact-messages.reply', $contactMessage) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Subject</label>
                    <input name="subject" value="Re: {{ $contactMessage->subject ?: 'Landing page inquiry' }}" class="w-full border border-slate-300 rounded-xl px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Message</label>
                    <textarea name="reply_message" rows="6" class="w-full border border-slate-300 rounded-xl px-3 py-2" required></textarea>
                </div>
                <button class="w-full px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">Send Reply</button>
            </form>
        </div>

        <form method="POST" action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" onsubmit="return confirm('Delete this message?')">
            @csrf
            @method('DELETE')
            <button class="w-full px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100">Delete Message</button>
        </form>
    </aside>
</div>
@endsection
