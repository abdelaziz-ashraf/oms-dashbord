<?php $section = $landingPage->socialProof; ?>
<div id="social-proof" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Social Proof</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $section?->is_active ? 'active-badge' : 'inactive-badge' }}">{{ $section?->is_active ? 'Active' : 'Inactive' }}</span>
    </div>
    <form action="{{ route('admin.social-proof.update') }}" method="POST" class="space-y-4">
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
            <h3 class="font-medium mb-3">Items</h3>
            <div class="space-y-3" id="social-container">
                @foreach($section?->items ?? [] as $i => $item)
                <div class="flex gap-2 items-center p-3 bg-gray-50 rounded-lg">
                    <input type="text" name="items[{{ $i }}][company]" value="{{ $item->company }}" class="border rounded px-2 py-1 w-32" placeholder="Company">
                    <input type="text" name="items[{{ $i }}][metric]" value="{{ $item->metric }}" class="border rounded px-2 py-1 w-32" placeholder="Metric">
                    <input type="text" name="items[{{ $i }}][quote_en]" value="{{ $item->quote_en }}" class="border rounded px-2 py-1 flex-1" placeholder="Quote EN">
                    <input type="text" name="items[{{ $i }}][quote_ar]" value="{{ $item->quote_ar }}" class="border rounded px-2 py-1 flex-1" placeholder="Quote AR">
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addSocialItem()" class="mt-2 text-sm text-branding hover:underline">+ Add Item</button>
        </div>
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>
<script>let socialIndex = {{ $section?->items->count() ?? 0 }}; function addSocialItem() { document.getElementById('social-container').insertAdjacentHTML('beforeend', `<div class="flex gap-2 items-center p-3 bg-gray-50 rounded-lg"><input type="text" name="items[${socialIndex}][company]" class="border rounded px-2 py-1 w-32" placeholder="Company"><input type="text" name="items[${socialIndex}][metric]" class="border rounded px-2 py-1 w-32" placeholder="Metric"><input type="text" name="items[${socialIndex}][quote_en]" class="border rounded px-2 py-1 flex-1" placeholder="Quote EN"><input type="text" name="items[${socialIndex}][quote_ar]" class="border rounded px-2 py-1 flex-1" placeholder="Quote AR"><button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button></div>`); socialIndex++; }</script>