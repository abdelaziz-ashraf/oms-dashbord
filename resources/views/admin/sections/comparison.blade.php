<?php $section = $landingPage->comparison; ?>
<div id="comparison" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Comparison</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $section?->is_active ? 'active-badge' : 'inactive-badge' }}">{{ $section?->is_active ? 'Active' : 'Inactive' }}</span>
    </div>
    <form action="{{ route('admin.comparison.update') }}" method="POST" class="space-y-4">
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
            <div><label class="block text-sm font-medium mb-1">Without OMS Title (EN)</label><input type="text" name="before_title_en" value="{{ $section?->before_title_en }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">Without OMS Title (AR)</label><input type="text" name="before_title_ar" value="{{ $section?->before_title_ar }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">Without OMS Subtitle (EN)</label><input type="text" name="before_subtitle_en" value="{{ $section?->before_subtitle_en }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">Without OMS Subtitle (AR)</label><input type="text" name="before_subtitle_ar" value="{{ $section?->before_subtitle_ar }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">With OMS Title (EN)</label><input type="text" name="after_title_en" value="{{ $section?->after_title_en }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">With OMS Title (AR)</label><input type="text" name="after_title_ar" value="{{ $section?->after_title_ar }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">With OMS Subtitle (EN)</label><input type="text" name="after_subtitle_en" value="{{ $section?->after_subtitle_en }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">With OMS Subtitle (AR)</label><input type="text" name="after_subtitle_ar" value="{{ $section?->after_subtitle_ar }}" class="w-full border rounded-lg px-3 py-2"></div>
        </div>
        <div class="border-t pt-4">
            <h3 class="font-medium mb-3">Items</h3>
            <div class="space-y-3" id="comparison-container">
                @foreach($section?->items ?? [] as $i => $item)
                <div class="flex gap-2 items-center p-3 bg-gray-50 rounded-lg">
                    <input type="text" name="items[{{ $i }}][icon]" value="{{ $item->icon }}" class="border rounded px-2 py-1 w-20" placeholder="Icon">
                    <input type="text" name="items[{{ $i }}][text_en]" value="{{ $item->text_en }}" class="border rounded px-2 py-1 flex-1" placeholder="Text EN">
                    <input type="text" name="items[{{ $i }}][text_ar]" value="{{ $item->text_ar }}" class="border rounded px-2 py-1 flex-1" placeholder="Text AR">
                    <select name="items[{{ $i }}][color]" class="border rounded px-2 py-1">
                        <option value="red" {{ $item->color == 'red' ? 'selected' : '' }}>Without OMS</option>
                        <option value="green" {{ $item->color == 'green' ? 'selected' : '' }}>With OMS</option>
                    </select>
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addComparisonItem()" class="mt-2 text-sm text-branding hover:underline">+ Add Item</button>
        </div>
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>
<script>let compIndex = {{ $section?->items->count() ?? 0 }}; function addComparisonItem() { document.getElementById('comparison-container').insertAdjacentHTML('beforeend', `<div class="flex gap-2 items-center p-3 bg-gray-50 rounded-lg"><input type="text" name="items[${compIndex}][icon]" class="border rounded px-2 py-1 w-20" placeholder="Icon"><input type="text" name="items[${compIndex}][text_en]" class="border rounded px-2 py-1 flex-1" placeholder="Text EN"><input type="text" name="items[${compIndex}][text_ar]" class="border rounded px-2 py-1 flex-1" placeholder="Text AR"><select name="items[${compIndex}][color]" class="border rounded px-2 py-1"><option value="red">Without OMS</option><option value="green">With OMS</option></select><button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button></div>`); compIndex++; }</script>
