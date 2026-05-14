<?php $section = $landingPage->faq; ?>
<form action="{{ route('admin.faq.update') }}" method="POST" class="space-y-6">
    @csrf @method('PUT')
    
    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-question-circle text-pink-600"></i>
            </div>
            <div>
                <p class="font-medium text-slate-800">Enable FAQ</p>
                <p class="text-sm text-slate-500">Show frequently asked questions</p>
            </div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ $section?->is_active ? 'checked' : '' }} class="sr-only peer">
            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
        </label>
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
    
    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-question text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Questions</h3>
        </div>
        <div class="space-y-4" id="faq-container">
            @foreach($section?->items ?? [] as $i => $item)
            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold text-slate-700">Question {{ $i+1 }}</span>
                    <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                </div>
                <div class="space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="items[{{ $i }}][question_en]" value="{{ $item->question_en }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Question EN">
                        <input type="text" name="items[{{ $i }}][question_ar]" value="{{ $item->question_ar }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Question AR" dir="rtl">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <textarea name="items[{{ $i }}][answer_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Answer EN" rows="2">{{ $item->answer_en }}</textarea>
                        <textarea name="items[{{ $i }}][answer_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Answer AR" rows="2" dir="rtl">{{ $item->answer_ar }}</textarea>
                    </div>
                </div>
            </div>
            @endforeach
            <template class="item-template hidden">
                <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold text-slate-700">New Question</span>
                        <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="space-y-3">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="items[__INDEX__][question_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Question EN">
                            <input type="text" name="items[__INDEX__][question_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Question AR" dir="rtl">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <textarea name="items[__INDEX__][answer_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Answer EN" rows="2"></textarea>
                            <textarea name="items[__INDEX__][answer_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Answer AR" rows="2" dir="rtl"></textarea>
                        </div>
                    </div>
                </div>
            </template>
        </div>
        <button type="button" class="add-item-btn mt-4 text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1" data-target="faq-container" data-index="faq">
            <i class="fas fa-plus-circle"></i> Add Question
        </button>
    </div>
    
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>
</form>