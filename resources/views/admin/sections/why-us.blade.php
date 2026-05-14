<?php $section = $landingPage->whyUs; ?>
<div id="why-us" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Why Us</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $section?->is_active ? 'active-badge' : 'inactive-badge' }}">{{ $section?->is_active ? 'Active' : 'Inactive' }}</span>
    </div>
    <form action="{{ route('admin.why-us.update') }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div class="flex items-center gap-3 mb-4">
            <input type="checkbox" name="is_active" value="1" {{ $section?->is_active ? 'checked' : '' }} class="w-5 h-5">
            <label class="font-medium">Enable Section</label>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Title (EN)</label><input type="text" name="title_en" value="{{ $section?->title_en }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">Title (AR)</label><input type="text" name="title_ar" value="{{ $section?->title_ar }}" class="w-full border rounded-lg px-3 py-2"></div>
        </div>
        <div class="border-t pt-4">
            <h3 class="font-medium mb-3">Reasons</h3>
            <div class="space-y-3" id="whyus-container">
                @foreach($section?->items ?? [] as $i => $item)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="flex justify-between mb-2"><span>Item {{ $i+1 }}</span><button type="button" class="text-red-500" onclick="this.parentElement.parentElement.remove()">×</button></div>
                    <div class="grid grid-cols-2 gap-2"><input type="text" name="items[{{ $i }}][title_en]" value="{{ $item->title_en }}" class="border rounded px-2 py-1" placeholder="Title EN"><input type="text" name="items[{{ $i }}][title_ar]" value="{{ $item->title_ar }}" class="border rounded px-2 py-1" placeholder="Title AR"></div>
                    <div class="grid grid-cols-2 gap-2 mt-2"><textarea name="items[{{ $i }}][description_en]" class="border rounded px-2 py-1" placeholder="Description EN">{{ $item->description_en }}</textarea><textarea name="items[{{ $i }}][description_ar]" class="border rounded px-2 py-1" placeholder="Description AR">{{ $item->description_ar }}</textarea></div>
                    <input type="text" name="items[{{ $i }}][icon]" value="{{ $item->icon }}" class="border rounded px-2 py-1 w-full mt-2" placeholder="Icon">
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addWhyUsItem()" class="mt-2 text-sm text-branding hover:underline">+ Add Item</button>
        </div>
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>
<script>let whyUsIndex = {{ $section?->items->count() ?? 0 }}; function addWhyUsItem() { document.getElementById('whyus-container').insertAdjacentHTML('beforeend', `<div class="p-3 bg-gray-50 rounded-lg"><div class="flex justify-between mb-2"><span>Item ${whyUsIndex+1}</span><button type="button" class="text-red-500" onclick="this.parentElement.parentElement.remove()">×</button></div><div class="grid grid-cols-2 gap-2"><input type="text" name="items[${whyUsIndex}][title_en]" class="border rounded px-2 py-1" placeholder="Title EN"><input type="text" name="items[${whyUsIndex}][title_ar]" class="border rounded px-2 py-1" placeholder="Title AR"></div><div class="grid grid-cols-2 gap-2 mt-2"><textarea name="items[${whyUsIndex}][description_en]" class="border rounded px-2 py-1" placeholder="Description EN"></textarea><textarea name="items[${whyUsIndex}][description_ar]" class="border rounded px-2 py-1" placeholder="Description AR"></textarea></div><input type="text" name="items[${whyUsIndex}][icon]" class="border rounded px-2 py-1 w-full mt-2" placeholder="Icon"></div>`); whyUsIndex++; }</script>