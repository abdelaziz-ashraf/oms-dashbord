<?php $section = $landingPage->howItWorks; ?>
<div id="how-it-works" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">How It Works</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $section?->is_active ? 'active-badge' : 'inactive-badge' }}">{{ $section?->is_active ? 'Active' : 'Inactive' }}</span>
    </div>
    <form action="{{ route('admin.how-it-works.update') }}" method="POST" class="space-y-4">
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
            <h3 class="font-medium mb-3">Steps</h3>
            <div class="space-y-3" id="howitworks-container">
                @foreach($section?->steps ?? [] as $i => $step)
                <div class="flex gap-2 items-start p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1 grid grid-cols-2 gap-2">
                        <input type="text" name="steps[{{ $i }}][title_en]" value="{{ $step->title_en }}" class="border rounded px-2 py-1" placeholder="Title EN">
                        <input type="text" name="steps[{{ $i }}][title_ar]" value="{{ $step->title_ar }}" class="border rounded px-2 py-1" placeholder="Title AR">
                        <textarea name="steps[{{ $i }}][description_en]" class="border rounded px-2 py-1 col-span-2" placeholder="Description EN">{{ $step->description_en }}</textarea>
                        <textarea name="steps[{{ $i }}][description_ar]" class="border rounded px-2 py-1 col-span-2" placeholder="Description AR">{{ $step->description_ar }}</textarea>
                    </div>
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addHowItWorksStep()" class="mt-2 text-sm text-branding hover:underline">+ Add Step</button>
        </div>
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>
<script>let hiwIndex = {{ $section?->steps->count() ?? 0 }}; function addHowItWorksStep() { document.getElementById('howitworks-container').insertAdjacentHTML('beforeend', `<div class="flex gap-2 items-start p-3 bg-gray-50 rounded-lg"><div class="flex-1 grid grid-cols-2 gap-2"><input type="text" name="steps[${hiwIndex}][title_en]" class="border rounded px-2 py-1" placeholder="Title EN"><input type="text" name="steps[${hiwIndex}][title_ar]" class="border rounded px-2 py-1" placeholder="Title AR"><textarea name="steps[${hiwIndex}][description_en]" class="border rounded px-2 py-1 col-span-2" placeholder="Description EN"></textarea><textarea name="steps[${hiwIndex}][description_ar]" class="border rounded px-2 py-1 col-span-2" placeholder="Description AR"></textarea></div><button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button></div>`); hiwIndex++; }</script>