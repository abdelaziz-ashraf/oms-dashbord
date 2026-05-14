<div id="problem" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Problem Section</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $landingPage->problem?->is_active ? 'active-badge' : 'inactive-badge' }}">
            {{ $landingPage->problem?->is_active ? 'Active' : 'Inactive' }}
        </span>
    </div>
    
    <form action="{{ route('admin.problem.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div class="flex items-center gap-3 mb-4">
            <input type="checkbox" name="is_active" value="1" {{ $landingPage->problem?->is_active ? 'checked' : '' }} class="w-5 h-5">
            <label class="font-medium">Enable Section</label>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Title (English)</label>
                <input type="text" name="title_en" value="{{ $landingPage->problem?->title_en }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Title (Arabic)</label>
                <input type="text" name="title_ar" value="{{ $landingPage->problem?->title_ar }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Description (English)</label>
                <textarea name="description_en" rows="4" class="w-full border rounded-lg px-3 py-2">{{ $landingPage->problem?->description_en }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Description (Arabic)</label>
                <textarea name="description_ar" rows="4" class="w-full border rounded-lg px-3 py-2">{{ $landingPage->problem?->description_ar }}</textarea>
            </div>
        </div>
        
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>