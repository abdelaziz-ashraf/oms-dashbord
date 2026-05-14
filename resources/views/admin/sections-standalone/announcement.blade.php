<form action="{{ route('admin.announcement.update') }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-bullhorn text-amber-600"></i>
            </div>
            <div>
                <p class="font-medium text-slate-800">Enable Announcement Bar</p>
                <p class="text-sm text-slate-500">Show announcement at the top of the page</p>
            </div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ $landingPage->is_announcement_active ? 'checked' : '' }} class="sr-only peer">
            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
        </label>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Text (English)</label>
            <input type="text" name="text_en" value="{{ $landingPage->announcement?->text_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="Limited Offer: Get 30% off...">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Text (Arabic)</label>
            <input type="text" name="text_ar" value="{{ $landingPage->announcement?->text_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="عرض محدود: احصل على خصم 30%...">
        </div>
    </div>
    
    <div class="space-y-2">
        <label class="block text-sm font-semibold text-slate-700">Link (optional)</label>
        <input type="text" name="link" value="{{ $landingPage->announcement?->link }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="#packages">
    </div>
    
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-save"></i>
            Save Changes
        </button>
    </div>
</form>