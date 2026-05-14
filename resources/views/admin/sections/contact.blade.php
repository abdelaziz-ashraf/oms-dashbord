<?php $section = $landingPage->contact; ?>
<div id="contact" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Contact Section</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $section?->is_active ? 'active-badge' : 'inactive-badge' }}">{{ $section?->is_active ? 'Active' : 'Inactive' }}</span>
    </div>
    <form action="{{ route('admin.contact.update') }}" method="POST" class="space-y-4">
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
            <h3 class="font-medium mb-3">Contact Info</h3>
            <div class="space-y-3" id="contact-container">
                @foreach($section?->items ?? [] as $i => $item)
                <div class="flex gap-2 items-center p-3 bg-gray-50 rounded-lg">
                    <input type="text" name="items[{{ $i }}][icon]" value="{{ $item->icon }}" class="border rounded px-2 py-1 w-24" placeholder="Icon">
                    <input type="text" name="items[{{ $i }}][label_en]" value="{{ $item->label_en }}" class="border rounded px-2 py-1 flex-1" placeholder="Label EN">
                    <input type="text" name="items[{{ $i }}][label_ar]" value="{{ $item->label_ar }}" class="border rounded px-2 py-1 flex-1" placeholder="Label AR">
                    <input type="text" name="items[{{ $i }}][value]" value="{{ $item->value }}" class="border rounded px-2 py-1 flex-1" placeholder="Value">
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addContactItem()" class="mt-2 text-sm text-branding hover:underline">+ Add Contact Info</button>
        </div>
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>
<script>let contactIndex = {{ $section?->items->count() ?? 0 }}; function addContactItem() { document.getElementById('contact-container').insertAdjacentHTML('beforeend', `<div class="flex gap-2 items-center p-3 bg-gray-50 rounded-lg"><input type="text" name="items[${contactIndex}][icon]" class="border rounded px-2 py-1 w-24" placeholder="Icon"><input type="text" name="items[${contactIndex}][label_en]" class="border rounded px-2 py-1 flex-1" placeholder="Label EN"><input type="text" name="items[${contactIndex}][label_ar]" class="border rounded px-2 py-1 flex-1" placeholder="Label AR"><input type="text" name="items[${contactIndex}][value]" class="border rounded px-2 py-1 flex-1" placeholder="Value"><button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button></div>`); contactIndex++; }</script>