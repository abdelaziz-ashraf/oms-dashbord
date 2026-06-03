@extends('layouts.admin')

@section('title', $config['title'].' - OMS Dashboard')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">{{ $config['title'] }}</h1>
            <p class="text-slate-500 text-sm mt-1">Create, update, and organize {{ strtolower($config['title']) }}</p>
        </div>
    </div>
</div>

<details class="bg-white rounded-2xl border border-slate-200 p-6 mb-8">
    <summary class="cursor-pointer font-semibold text-slate-800">Section Settings</summary>
    <form method="POST" action="{{ route('admin.portfolio.settings', $module) }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Title EN</label>
                <input name="title_en" value="{{ old('title_en', $settings->title_en) }}" class="w-full border border-slate-300 rounded-xl px-4 py-3">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Title AR</label>
                <input name="title_ar" value="{{ old('title_ar', $settings->title_ar) }}" dir="rtl" class="w-full border border-slate-300 rounded-xl px-4 py-3">
            </div>
            <div class="space-y-2 md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700">Description EN</label>
                <textarea name="description_en" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3">{{ old('description_en', $settings->description_en) }}</textarea>
            </div>
            <div class="space-y-2 md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700">Description AR</label>
                <textarea name="description_ar" rows="3" dir="rtl" class="w-full border border-slate-300 rounded-xl px-4 py-3">{{ old('description_ar', $settings->description_ar) }}</textarea>
            </div>
            <label class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $settings->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300">
                <span class="text-sm font-medium text-slate-700">Show on landing page</span>
            </label>
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700">Order</label>
                    <input type="number" name="order" value="{{ old('order', $settings->order) }}" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-slate-700">Limit</label>
                    <input type="number" name="limit" value="{{ old('limit', $settings->limit) }}" class="w-full border border-slate-300 rounded-xl px-4 py-3">
                </div>
            </div>
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition">
                Save Settings
            </button>
        </div>
    </form>
</details>

<form method="GET" action="{{ route('admin.portfolio.index', $module) }}" class="bg-white rounded-2xl border border-slate-200 p-4 mb-8">
    <div class="grid md:grid-cols-[1fr_auto_auto_auto] gap-3">
        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search {{ strtolower($config['title']) }}" class="w-full border border-slate-300 rounded-xl px-4 py-2">
        <select name="status" class="border border-slate-300 rounded-xl px-4 py-2">
            <option value="">All statuses</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <label class="flex items-center gap-2 border border-slate-300 rounded-xl px-4 py-2">
            <input type="checkbox" name="featured" value="1" {{ request('featured') === '1' ? 'checked' : '' }}>
            Featured
        </label>
        <button class="px-5 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">Filter</button>
    </div>
</form>

<details class="bg-white rounded-2xl border border-slate-200 p-6 mb-8" open>
    <summary class="cursor-pointer font-semibold text-slate-800">Create {{ $config['singular'] }}</summary>
    <form method="POST" action="{{ route('admin.portfolio.store', $module) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @include('admin.portfolio._fields', ['item' => null])
        </div>
        <div class="flex justify-end pt-4 border-t border-slate-100">
            <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition">
                Create {{ $config['singular'] }}
            </button>
        </div>
    </form>
</details>

<div class="space-y-4">
    @forelse($items as $item)
        <details class="bg-white rounded-2xl border border-slate-200 p-6">
            <summary class="cursor-pointer">
                <div class="inline-flex items-center gap-3">
                    <span class="font-semibold text-slate-800">{{ $item->{$config['primary']} }}</span>
                    @if(isset($item->is_active))
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $item->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    @endif
                    @if(isset($item->is_featured) && $item->is_featured)
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">Featured</span>
                    @endif
                </div>
            </summary>

            <form method="POST" action="{{ route('admin.portfolio.update', [$module, $item->id]) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @include('admin.portfolio._fields', ['item' => $item])
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition">
                        Save Changes
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('admin.portfolio.destroy', [$module, $item->id]) }}" class="mt-3 flex justify-end" onsubmit="return confirm('Delete this item?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100">
                    Delete
                </button>
            </form>
        </details>
    @empty
        <div class="bg-white rounded-2xl border border-slate-200 p-10 text-center text-slate-500">
            No {{ strtolower($config['title']) }} have been created yet.
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $items->links() }}
</div>
@endsection
