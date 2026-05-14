<form action="{{ route('admin.packages.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-box text-green-600"></i>
            </div>
            <div>
                <p class="font-medium text-slate-800">Enable Packages Section</p>
                <p class="text-sm text-slate-500">Show pricing packages on the landing page</p>
            </div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ $landingPage->packages?->is_active ? 'checked' : '' }} class="sr-only peer">
            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
        </label>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Title (English)</label>
            <input type="text" name="title_en" value="{{ $landingPage->packages?->title_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Title (Arabic)</label>
            <input type="text" name="title_ar" value="{{ $landingPage->packages?->title_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Popular Badge (English)</label>
            <input type="text" name="popular_badge_en" value="{{ $landingPage->packages?->popular_badge_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="Most Popular">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Popular Badge (Arabic)</label>
            <input type="text" name="popular_badge_ar" value="{{ $landingPage->packages?->popular_badge_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="الأكثر شيوعاً" dir="rtl">
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Billing Period (English)</label>
            <input type="text" name="billing_period_en" value="{{ $landingPage->packages?->billing_period_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="/month">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Billing Period (Arabic)</label>
            <input type="text" name="billing_period_ar" value="{{ $landingPage->packages?->billing_period_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="/شهرياً" dir="rtl">
        </div>
    </div>
    
    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-layer-group text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Pricing Plans</h3>
        </div>
        <div class="space-y-4" id="packages-container">
            @foreach($landingPage->packages?->packages ?? [] as $pIndex => $package)
            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold text-slate-700 flex items-center gap-2">
                        <i class="fas fa-grip-vertical text-slate-400"></i>
                        Plan {{ $pIndex + 1 }}
                    </span>
                    <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <input type="text" name="packages[{{ $pIndex }}][name_en]" value="{{ $package->name_en }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Name EN">
                    <input type="text" name="packages[{{ $pIndex }}][name_ar]" value="{{ $package->name_ar }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Name AR" dir="rtl">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <input type="text" name="packages[{{ $pIndex }}][users_en]" value="{{ $package->users_en }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Users EN">
                    <input type="text" name="packages[{{ $pIndex }}][users_ar]" value="{{ $package->users_ar }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Users AR" dir="rtl">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <textarea name="packages[{{ $pIndex }}][description_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description EN" rows="2">{{ $package->description_en }}</textarea>
                    <textarea name="packages[{{ $pIndex }}][description_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description AR" rows="2" dir="rtl">{{ $package->description_ar }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <input type="number" name="packages[{{ $pIndex }}][price]" value="{{ $package->price }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Price">
                    <input type="text" name="packages[{{ $pIndex }}][button_text_en]" value="{{ $package->button_text_en }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Button Text EN">
                </div>
                <input type="text" name="packages[{{ $pIndex }}][button_text_ar]" value="{{ $package->button_text_ar }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 mb-3" placeholder="Button Text AR" dir="rtl">
                <div>
                    <label class="text-xs text-slate-500 mb-1 block flex items-center gap-1">
                        <i class="fas fa-list"></i>
                        Features (one per line - EN | AR)
                    </label>
                    <textarea name="packages[{{ $pIndex }}][features_text]" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" rows="3" placeholder="Feature 1 EN | Feature 1 AR&#10;Feature 2 EN | Feature 2 AR">{{ $package->features->map(fn($f) => $f->name_en . ' | ' . $f->name_ar)->join("\n") }}</textarea>
                </div>
            </div>
            @endforeach
            <template class="item-template hidden">
                <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold text-slate-700 flex items-center gap-2">
                            <i class="fas fa-grip-vertical text-slate-400"></i>
                            New Plan
                        </span>
                        <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <input type="text" name="packages[__INDEX__][name_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Name EN">
                        <input type="text" name="packages[__INDEX__][name_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Name AR" dir="rtl">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <input type="text" name="packages[__INDEX__][users_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Users EN">
                        <input type="text" name="packages[__INDEX__][users_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Users AR" dir="rtl">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <textarea name="packages[__INDEX__][description_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description EN" rows="2"></textarea>
                        <textarea name="packages[__INDEX__][description_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Description AR" rows="2" dir="rtl"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <input type="number" name="packages[__INDEX__][price]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Price">
                        <input type="text" name="packages[__INDEX__][button_text_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Button Text EN">
                    </div>
                    <input type="text" name="packages[__INDEX__][button_text_ar]" class="w-full border border-slate-300 rounded-lg px-3 py-2 mb-3" placeholder="Button Text AR" dir="rtl">
                    <div>
                        <label class="text-xs text-slate-500 mb-1 block flex items-center gap-1">
                            <i class="fas fa-list"></i>
                            Features (one per line - EN | AR)
                        </label>
                        <textarea name="packages[__INDEX__][features_text]" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" rows="3" placeholder="Feature 1 EN | Feature 1 AR&#10;Feature 2 EN | Feature 2 AR"></textarea>
                    </div>
                </div>
            </template>
        </div>
        <button type="button" class="add-item-btn mt-4 text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1" data-target="packages-container" data-index="packages">
            <i class="fas fa-plus-circle"></i> Add Plan
        </button>
    </div>
    
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-save"></i>
            Save Changes
        </button>
    </div>
</form>