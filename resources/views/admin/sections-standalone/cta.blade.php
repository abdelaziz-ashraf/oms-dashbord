<form action="{{ route('admin.cta.update') }}" method="POST" class="space-y-6">
    @csrf @method('PUT')
    
    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-hand-pointer text-indigo-600"></i>
            </div>
            <div>
                <p class="font-medium text-slate-800">Enable CTA Section</p>
                <p class="text-sm text-slate-500">Show call to action banner</p>
            </div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ $landingPage->cta?->is_active ? 'checked' : '' }} class="sr-only peer">
            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
        </label>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Eyebrow (English)</label>
            <input type="text" name="eyebrow_en" value="{{ $landingPage->cta?->eyebrow_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Eyebrow (Arabic)</label>
            <input type="text" name="eyebrow_ar" value="{{ $landingPage->cta?->eyebrow_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Title (English)</label>
            <input type="text" name="title_en" value="{{ $landingPage->cta?->title_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Title (Arabic)</label>
            <input type="text" name="title_ar" value="{{ $landingPage->cta?->title_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Description (English)</label>
            <textarea name="description_en" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">{{ $landingPage->cta?->description_en }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Description (Arabic)</label>
            <textarea name="description_ar" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">{{ $landingPage->cta?->description_ar }}</textarea>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Button Text (English)</label>
            <input type="text" name="button_text_en" value="{{ $landingPage->cta?->button_text_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Button Text (Arabic)</label>
            <input type="text" name="button_text_ar" value="{{ $landingPage->cta?->button_text_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Button Link</label>
            <input type="text" name="button_link" value="{{ $landingPage->cta?->button_link }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="#packages">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Secondary Button Text (English)</label>
            <input type="text" name="secondary_button_text_en" value="{{ $landingPage->cta?->secondary_button_text_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Secondary Button Text (Arabic)</label>
            <input type="text" name="secondary_button_text_ar" value="{{ $landingPage->cta?->secondary_button_text_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Secondary Button Link</label>
            <input type="text" name="secondary_button_link" value="{{ $landingPage->cta?->secondary_button_link }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
    </div>

    <div class="space-y-2">
        <label class="block text-sm font-semibold text-slate-700">Badges (one per line - EN | AR)</label>
        <textarea name="badges_text" rows="4" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">{{ collect($landingPage->cta?->badges ?? [])->map(fn($badge) => ($badge['text_en'] ?? '') . ' | ' . ($badge['text_ar'] ?? ''))->join("\n") }}</textarea>
    </div>
    
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>
</form>
