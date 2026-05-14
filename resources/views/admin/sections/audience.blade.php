<?php
$section = $landingPage->targetAudience;
$items = $section?->items ?? collect();
?>
<div id="audience" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Target Audience</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $section?->is_active ? 'active-badge' : 'inactive-badge' }}">
            {{ $section?->is_active ? 'Active' : 'Inactive' }}
        </span>
    </div>
    
    <form action="{{ route('admin.audience.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div class="flex items-center gap-3 mb-4">
            <input type="checkbox" name="is_active" value="1" {{ $section?->is_active ? 'checked' : '' }} class="w-5 h-5">
            <label class="font-medium">Enable Section</label>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Title (English)</label>
                <input type="text" name="title_en" value="{{ $section?->title_en }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Title (Arabic)</label>
                <input type="text" name="title_ar" value="{{ $section?->title_ar }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        
        <div class="border-t pt-4 mt-4">
            <h3 class="font-medium mb-3">Audience Items</h3>
            <div class="space-y-3" id="audience-container">
                @foreach($items as $index => $item)
                <div class="flex gap-2 items-start p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1 grid grid-cols-2 gap-2">
                        <input type="text" name="items[{{ $index }}][title_en]" value="{{ $item->title_en }}" class="border rounded px-2 py-1" placeholder="Title EN">
                        <input type="text" name="items[{{ $index }}][title_ar]" value="{{ $item->title_ar }}" class="border rounded px-2 py-1" placeholder="Title AR">
                        <input type="text" name="items[{{ $index }}][description_en]" value="{{ $item->description_en }}" class="border rounded px-2 py-1 col-span-2" placeholder="Description EN">
                        <input type="text" name="items[{{ $index }}][description_ar]" value="{{ $item->description_ar }}" class="border rounded px-2 py-1 col-span-2" placeholder="Description AR">
                        <input type="text" name="items[{{ $index }}][icon]" value="{{ $item->icon }}" class="border rounded px-2 py-1 col-span-2" placeholder="Icon">
                    </div>
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addAudienceItem()" class="mt-2 text-sm text-branding hover:underline">+ Add Item</button>
        </div>
        
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>

<script>
let audienceIndex = {{ $items->count() }};
function addAudienceItem() {
    const html = `
        <div class="flex gap-2 items-start p-3 bg-gray-50 rounded-lg">
            <div class="flex-1 grid grid-cols-2 gap-2">
                <input type="text" name="items[${audienceIndex}][title_en]" class="border rounded px-2 py-1" placeholder="Title EN">
                <input type="text" name="items[${audienceIndex}][title_ar]" class="border rounded px-2 py-1" placeholder="Title AR">
                <input type="text" name="items[${audienceIndex}][description_en]" class="border rounded px-2 py-1 col-span-2" placeholder="Description EN">
                <input type="text" name="items[${audienceIndex}][description_ar]" class="border rounded px-2 py-1 col-span-2" placeholder="Description AR">
                <input type="text" name="items[${audienceIndex}][icon]" class="border rounded px-2 py-1 col-span-2" placeholder="Icon">
            </div>
            <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
        </div>
    `;
    document.getElementById('audience-container').insertAdjacentHTML('beforeend', html);
    audienceIndex++;
}
</script>