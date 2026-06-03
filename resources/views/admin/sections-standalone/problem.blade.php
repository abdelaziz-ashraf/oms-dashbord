<form action="{{ route('admin.problem.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-exclamation-circle text-red-600"></i>
            </div>
            <div>
                <p class="font-medium text-slate-800">Enable Problem Section</p>
                <p class="text-sm text-slate-500">Show problem section on the landing page</p>
            </div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ $landingPage->problem?->is_active ? 'checked' : '' }} class="sr-only peer">
            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
        </label>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Title (English)</label>
            <input type="text" name="title_en" value="{{ $landingPage->problem?->title_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Title (Arabic)</label>
            <input type="text" name="title_ar" value="{{ $landingPage->problem?->title_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Description (English)</label>
            <textarea name="description_en" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">{{ $landingPage->problem?->description_en }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Description (Arabic)</label>
            <textarea name="description_ar" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">{{ $landingPage->problem?->description_ar }}</textarea>
        </div>
    </div>
    
    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-list text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Problem Items</h3>
        </div>
        <div class="space-y-3" id="items-container">
            @foreach($landingPage->problem?->items ?? [] as $index => $item)
            <div class="flex gap-3 items-start p-3 bg-slate-50 rounded-xl item-item">
                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                <input type="text" name="items[{{ $index }}][title_en]" value="{{ $item->title_en }}" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Title EN">
                <input type="text" name="items[{{ $index }}][title_ar]" value="{{ $item->title_ar }}" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Title AR" dir="rtl">
                <input type="text" name="items[{{ $index }}][description_en]" value="{{ $item->description_en }}" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Description EN">
                <input type="text" name="items[{{ $index }}][description_ar]" value="{{ $item->description_ar }}" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Description AR" dir="rtl">
                <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            @endforeach
        </div>
        <button type="button" class="add-item-btn mt-3 text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1">
            <i class="fas fa-plus"></i> Add Problem Item
        </button>
    </div>
    
    <template class="item-template">
        <div class="flex gap-3 items-start p-3 bg-slate-50 rounded-xl item-item">
            <input type="text" name="items[__INDEX__][title_en]" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Title EN">
            <input type="text" name="items[__INDEX__][title_ar]" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Title AR" dir="rtl">
            <input type="text" name="items[__INDEX__][description_en]" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Description EN">
            <input type="text" name="items[__INDEX__][description_ar]" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Description AR" dir="rtl">
            <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </template>
    
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-save"></i>
            Save Changes
        </button>
    </div>
</form>
