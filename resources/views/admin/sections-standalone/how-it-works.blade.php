<?php $section = $landingPage->howItWorks; ?>
<form action="{{ route('admin.how-it-works.update') }}" method="POST" class="space-y-6">
    @csrf @method('PUT')
    
    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-cogs text-orange-600"></i>
            </div>
            <div>
                <p class="font-medium text-slate-800">Enable How It Works</p>
                <p class="text-sm text-slate-500">Show step by step guide</p>
            </div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ $section?->is_active ? 'checked' : '' }} class="sr-only peer">
            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
        </label>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Eyebrow (English)</label>
            <input type="text" name="eyebrow_en" value="{{ $section?->eyebrow_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Eyebrow (Arabic)</label>
            <input type="text" name="eyebrow_ar" value="{{ $section?->eyebrow_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Title (English)</label>
            <input type="text" name="title_en" value="{{ $section?->title_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Title (Arabic)</label>
            <input type="text" name="title_ar" value="{{ $section?->title_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Description (English)</label>
            <textarea name="description_en" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">{{ $section?->description_en }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Description (Arabic)</label>
            <textarea name="description_ar" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">{{ $section?->description_ar }}</textarea>
        </div>
    </div>

    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-play-circle text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Section CTA</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <input type="text" name="cta_title_en" value="{{ $section?->cta_title_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="CTA Title EN">
            <input type="text" name="cta_title_ar" value="{{ $section?->cta_title_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="CTA Title AR" dir="rtl">
            <textarea name="cta_description_en" rows="3" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="CTA Description EN">{{ $section?->cta_description_en }}</textarea>
            <textarea name="cta_description_ar" rows="3" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="CTA Description AR" dir="rtl">{{ $section?->cta_description_ar }}</textarea>
            <input type="text" name="cta_button_text_en" value="{{ $section?->cta_button_text_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Primary Button EN">
            <input type="text" name="cta_button_text_ar" value="{{ $section?->cta_button_text_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Primary Button AR" dir="rtl">
            <input type="text" name="cta_button_link" value="{{ $section?->cta_button_link }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Primary Button Link">
            <input type="text" name="cta_secondary_button_link" value="{{ $section?->cta_secondary_button_link }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Secondary Button Link">
            <input type="text" name="cta_secondary_button_text_en" value="{{ $section?->cta_secondary_button_text_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Secondary Button EN">
            <input type="text" name="cta_secondary_button_text_ar" value="{{ $section?->cta_secondary_button_text_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Secondary Button AR" dir="rtl">
        </div>
    </div>
    
    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-list-ol text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Steps</h3>
        </div>
        <div class="space-y-4" id="howitworks-container">
            @foreach($section?->steps ?? [] as $i => $step)
            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                <input type="hidden" name="steps[{{ $i }}][id]" value="{{ $step->id }}">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold text-slate-700 flex items-center gap-2">
                        <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm">{{ $i+1 }}</span>
                        Step {{ $i+1 }}
                    </span>
                    <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <input type="text" name="steps[{{ $i }}][title_en]" value="{{ $step->title_en }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title EN">
                    <input type="text" name="steps[{{ $i }}][title_ar]" value="{{ $step->title_ar }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title AR" dir="rtl">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <textarea name="steps[{{ $i }}][description_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description EN" rows="2">{{ $step->description_en }}</textarea>
                    <textarea name="steps[{{ $i }}][description_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description AR" rows="2" dir="rtl">{{ $step->description_ar }}</textarea>
                </div>
            </div>
            @endforeach
            <template class="item-template hidden">
                <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold text-slate-700 flex items-center gap-2">
                            <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm">?</span>
                            New Step
                        </span>
                        <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <input type="text" name="steps[__INDEX__][title_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title EN">
                        <input type="text" name="steps[__INDEX__][title_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title AR" dir="rtl">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <textarea name="steps[__INDEX__][description_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description EN" rows="2"></textarea>
                        <textarea name="steps[__INDEX__][description_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description AR" rows="2" dir="rtl"></textarea>
                    </div>
                </div>
            </template>
        </div>
        <button type="button" class="add-item-btn mt-4 text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1" data-target="howitworks-container" data-index="howitworks">
            <i class="fas fa-plus-circle"></i> Add Step
        </button>
    </div>
    
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>
</form>
