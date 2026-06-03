<?php $section = $landingPage->contact; ?>
<form action="{{ route('admin.contact.update') }}" method="POST" class="space-y-6">
    @csrf @method('PUT')
    
    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-envelope text-cyan-600"></i>
            </div>
            <div>
                <p class="font-medium text-slate-800">Enable Contact Section</p>
                <p class="text-sm text-slate-500">Show contact information</p>
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
            <i class="fas fa-paper-plane text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Lead Form Text</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="form_title_en" value="{{ $section?->form_title_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Form Title EN">
            <input type="text" name="form_title_ar" value="{{ $section?->form_title_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Form Title AR" dir="rtl">
            <textarea name="form_description_en" rows="3" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Form Description EN">{{ $section?->form_description_en }}</textarea>
            <textarea name="form_description_ar" rows="3" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Form Description AR" dir="rtl">{{ $section?->form_description_ar }}</textarea>
            <input type="text" name="form_button_text_en" value="{{ $section?->form_button_text_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Button EN">
            <input type="text" name="form_button_text_ar" value="{{ $section?->form_button_text_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Button AR" dir="rtl">
            <input type="text" name="form_success_text_en" value="{{ $section?->form_success_text_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Success EN">
            <input type="text" name="form_success_text_ar" value="{{ $section?->form_success_text_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Success AR" dir="rtl">
            <input type="text" name="form_error_text_en" value="{{ $section?->form_error_text_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Error EN">
            <input type="text" name="form_error_text_ar" value="{{ $section?->form_error_text_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Error AR" dir="rtl">
            <input type="text" name="form_sending_text_en" value="{{ $section?->form_sending_text_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Sending EN">
            <input type="text" name="form_sending_text_ar" value="{{ $section?->form_sending_text_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Sending AR" dir="rtl">
            <input type="text" name="form_name_label_en" value="{{ $section?->form_name_label_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Name Label EN">
            <input type="text" name="form_name_label_ar" value="{{ $section?->form_name_label_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Name Label AR" dir="rtl">
            <input type="text" name="form_name_placeholder_en" value="{{ $section?->form_name_placeholder_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Name Placeholder EN">
            <input type="text" name="form_name_placeholder_ar" value="{{ $section?->form_name_placeholder_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Name Placeholder AR" dir="rtl">
            <input type="text" name="form_email_label_en" value="{{ $section?->form_email_label_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Email Label EN">
            <input type="text" name="form_email_label_ar" value="{{ $section?->form_email_label_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Email Label AR" dir="rtl">
            <input type="text" name="form_email_placeholder_en" value="{{ $section?->form_email_placeholder_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Email Placeholder EN">
            <input type="text" name="form_email_placeholder_ar" value="{{ $section?->form_email_placeholder_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Email Placeholder AR" dir="rtl">
            <input type="text" name="form_company_label_en" value="{{ $section?->form_company_label_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Company Label EN">
            <input type="text" name="form_company_label_ar" value="{{ $section?->form_company_label_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Company Label AR" dir="rtl">
            <input type="text" name="form_company_placeholder_en" value="{{ $section?->form_company_placeholder_en }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Company Placeholder EN">
            <input type="text" name="form_company_placeholder_ar" value="{{ $section?->form_company_placeholder_ar }}" class="border border-slate-300 rounded-xl px-4 py-3" placeholder="Company Placeholder AR" dir="rtl">
        </div>
        <div class="space-y-2 mt-4">
            <label class="block text-sm font-semibold text-slate-700">Form Badges (one per line - EN | AR)</label>
            <textarea name="form_badges_text" rows="4" class="w-full border border-slate-300 rounded-xl px-4 py-3">{{ collect($section?->form_badges ?? [])->map(fn($badge) => ($badge['text_en'] ?? '') . ' | ' . ($badge['text_ar'] ?? ''))->join("\n") }}</textarea>
        </div>
    </div>
    
    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-address-card text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Contact Info</h3>
        </div>
        <div class="space-y-4 items-container" id="contact-container">
            @foreach($section?->items ?? [] as $i => $item)
            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                <input type="hidden" name="items[{{ $i }}][id]" value="{{ $item->id }}">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold text-slate-700">Item {{ $i+1 }}</span>
                    <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <input type="text" name="items[{{ $i }}][icon]" value="{{ $item->icon }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Icon class">
                    <input type="text" name="items[{{ $i }}][label_en]" value="{{ $item->label_en }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Label EN">
                    <input type="text" name="items[{{ $i }}][label_ar]" value="{{ $item->label_ar }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Label AR" dir="rtl">
                    <input type="text" name="items[{{ $i }}][value]" value="{{ $item->value }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Value">
                </div>
            </div>
            @endforeach
            <template class="item-template hidden">
                <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold text-slate-700">New Item</span>
                        <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="text" name="items[__INDEX__][icon]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Icon class">
                        <input type="text" name="items[__INDEX__][label_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Label EN">
                        <input type="text" name="items[__INDEX__][label_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Label AR" dir="rtl">
                        <input type="text" name="items[__INDEX__][value]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Value">
                    </div>
                </div>
            </template>
        </div>
        <button type="button" class="add-item-btn mt-4 text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1" data-target="contact-container" data-index="contact">
            <i class="fas fa-plus-circle"></i> Add Contact Info
        </button>
    </div>
    
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>
</form>
