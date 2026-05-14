<div id="announcement" class="section-card bg-white rounded-xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Announcement Bar</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $landingPage->is_announcement_active ? 'active-badge' : 'inactive-badge' }}">
            {{ $landingPage->is_announcement_active ? 'Active' : 'Inactive' }}
        </span>
    </div>
    
    <form action="{{ route('admin.announcement.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div class="flex items-center gap-3 mb-4">
            <input type="checkbox" name="is_active" id="announcement_active" value="1" {{ $landingPage->is_announcement_active ? 'checked' : '' }} class="w-5 h-5">
            <label for="announcement_active" class="font-medium">Enable Announcement</label>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Text (English)</label>
                <input type="text" name="text_en" value="{{ $landingPage->announcement?->text_en }}" class="w-full border rounded-lg px-3 py-2" placeholder="Limited Offer: Get 30% off...">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Text (Arabic)</label>
                <input type="text" name="text_ar" value="{{ $landingPage->announcement?->text_ar }}" class="w-full border rounded-lg px-3 py-2" placeholder="عرض محدود: احصل على خصم 30%...">
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium mb-1">Link (optional)</label>
            <input type="text" name="link" value="{{ $landingPage->announcement?->link }}" class="w-full border rounded-lg px-3 py-2" placeholder="#packages">
        </div>
        
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>