<form action="{{ route('admin.features.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-star text-yellow-600"></i>
            </div>
            <div>
                <p class="font-medium text-slate-800">Enable Features Section</p>
                <p class="text-sm text-slate-500">Show features section on the landing page</p>
            </div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ $landingPage->features?->is_active ? 'checked' : '' }} class="sr-only peer">
            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
        </label>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Title (English)</label>
            <input type="text" name="title_en" value="{{ $landingPage->features?->title_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Title (Arabic)</label>
            <input type="text" name="title_ar" value="{{ $landingPage->features?->title_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Description (English)</label>
            <textarea name="description_en" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">{{ $landingPage->features?->description_en }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Description (Arabic)</label>
            <textarea name="description_ar" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">{{ $landingPage->features?->description_ar }}</textarea>
        </div>
    </div>
    
    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-th-large text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Features</h3>
        </div>
        <div class="space-y-4 items-container" id="features-container">
            @foreach($landingPage->features?->features ?? [] as $index => $feature)
            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold text-slate-700 flex items-center gap-2">
                        <i class="fas fa-grip-vertical text-slate-400"></i>
                        Feature {{ $index + 1 }}
                    </span>
                    <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <input type="text" name="features[{{ $index }}][title_en]" value="{{ $feature->title_en }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title EN">
                    <input type="text" name="features[{{ $index }}][title_ar]" value="{{ $feature->title_ar }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title AR" dir="rtl">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <textarea name="features[{{ $index }}][description_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description EN" rows="2">{{ $feature->description_en }}</textarea>
                    <textarea name="features[{{ $index }}][description_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description AR" rows="2" dir="rtl">{{ $feature->description_ar }}</textarea>
                </div>
                <input type="text" name="features[{{ $index }}][icon]" value="{{ $feature->icon }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Icon class (e.g., fas fa-check)">
            </div>
            @endforeach
            <template class="item-template hidden">
                <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold text-slate-700 flex items-center gap-2">
                            <i class="fas fa-grip-vertical text-slate-400"></i>
                            New Feature
                        </span>
                        <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <input type="text" name="features[__INDEX__][title_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title EN">
                        <input type="text" name="features[__INDEX__][title_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title AR" dir="rtl">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <textarea name="features[__INDEX__][description_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description EN" rows="2"></textarea>
                        <textarea name="features[__INDEX__][description_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description AR" rows="2" dir="rtl"></textarea>
                    </div>
                    <input type="text" name="features[__INDEX__][icon]" class="w-full border border-slate-300 rounded-lg px-3 py-2" placeholder="Icon class (e.g., fas fa-check)">
                </div>
            </template>
        </div>
        <button type="button" class="add-item-btn mt-4 text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1" data-target="features-container" data-index="features">
            <i class="fas fa-plus-circle"></i> Add Feature
        </button>
    </div>
    
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-save"></i>
            Save Changes
        </button>
    </div>
</form>