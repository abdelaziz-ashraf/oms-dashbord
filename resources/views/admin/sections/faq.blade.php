<?php $section = $landingPage->faq; ?>
<div id="faq" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">FAQ</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $section?->is_active ? 'active-badge' : 'inactive-badge' }}">{{ $section?->is_active ? 'Active' : 'Inactive' }}</span>
    </div>
    <form action="{{ route('admin.faq.update') }}" method="POST" class="space-y-4">
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
            <h3 class="font-medium mb-3">Questions</h3>
            <div class="space-y-3" id="faq-container">
                @foreach($section?->items ?? [] as $i => $item)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="flex justify-between mb-2"><span>FAQ {{ $i+1 }}</span><button type="button" class="text-red-500" onclick="this.parentElement.parentElement.remove()">×</button></div>
                    <div class="grid grid-cols-2 gap-2"><input type="text" name="items[{{ $i }}][question_en]" value="{{ $item->question_en }}" class="border rounded px-2 py-1" placeholder="Question EN"><input type="text" name="items[{{ $i }}][question_ar]" value="{{ $item->question_ar }}" class="border rounded px-2 py-1" placeholder="Question AR"></div>
                    <div class="grid grid-cols-2 gap-2 mt-2"><textarea name="items[{{ $i }}][answer_en]" class="border rounded px-2 py-1" placeholder="Answer EN">{{ $item->answer_en }}</textarea><textarea name="items[{{ $i }}][answer_ar]" class="border rounded px-2 py-1" placeholder="Answer AR">{{ $item->answer_ar }}</textarea></div>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addFaqItem()" class="mt-2 text-sm text-branding hover:underline">+ Add FAQ</button>
        </div>
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>
<script>let faqIndex = {{ $section?->items->count() ?? 0 }}; function addFaqItem() { document.getElementById('faq-container').insertAdjacentHTML('beforeend', `<div class="p-3 bg-gray-50 rounded-lg"><div class="flex justify-between mb-2"><span>FAQ ${faqIndex+1}</span><button type="button" class="text-red-500" onclick="this.parentElement.parentElement.remove()">×</button></div><div class="grid grid-cols-2 gap-2"><input type="text" name="items[${faqIndex}][question_en]" class="border rounded px-2 py-1" placeholder="Question EN"><input type="text" name="items[${faqIndex}][question_ar]" class="border rounded px-2 py-1" placeholder="Question AR"></div><div class="grid grid-cols-2 gap-2 mt-2"><textarea name="items[${faqIndex}][answer_en]" class="border rounded px-2 py-1" placeholder="Answer EN"></textarea><textarea name="items[${faqIndex}][answer_ar]" class="border rounded px-2 py-1" placeholder="Answer AR"></textarea></div></div>`); faqIndex++; }</script>