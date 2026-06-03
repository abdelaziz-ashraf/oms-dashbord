<?php $section = $landingPage->cta; ?>
<div id="cta" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Call to Action</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $section?->is_active ? 'active-badge' : 'inactive-badge' }}">{{ $section?->is_active ? 'Active' : 'Inactive' }}</span>
    </div>
    <form action="{{ route('admin.cta.update') }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div class="flex items-center gap-3 mb-4">
            <input type="checkbox" name="is_active" value="1" {{ $section?->is_active ? 'checked' : '' }} class="w-5 h-5">
            <label class="font-medium">Enable Section</label>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Title (EN)</label><input type="text" name="title_en" value="{{ $section?->title_en }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">Title (AR)</label><input type="text" name="title_ar" value="{{ $section?->title_ar }}" class="w-full border rounded-lg px-3 py-2"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Description (EN)</label><textarea name="description_en" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $section?->description_en }}</textarea></div>
            <div><label class="block text-sm font-medium mb-1">Description (AR)</label><textarea name="description_ar" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $section?->description_ar }}</textarea></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Button Text (EN)</label><input type="text" name="button_text_en" value="{{ $section?->button_text_en }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">Button Text (AR)</label><input type="text" name="button_text_ar" value="{{ $section?->button_text_ar }}" class="w-full border rounded-lg px-3 py-2"></div>
        </div>
        <div><label class="block text-sm font-medium mb-1">Button Link</label><input type="text" name="button_link" value="{{ $section?->button_link }}" class="w-full border rounded-lg px-3 py-2"></div>
        <div><label class="block text-sm font-medium mb-1">Sales WhatsApp Number</label><input type="text" name="whatsapp_number" value="{{ $section?->whatsapp_number }}" class="w-full border rounded-lg px-3 py-2" placeholder="+1234567890" dir="ltr"></div>
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>
