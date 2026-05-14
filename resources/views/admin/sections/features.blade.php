<div id="features" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Features Section</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $landingPage->features?->is_active ? 'active-badge' : 'inactive-badge' }}">
            {{ $landingPage->features?->is_active ? 'Active' : 'Inactive' }}
        </span>
    </div>
    
    <form action="{{ route('admin.features.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div class="flex items-center gap-3 mb-4">
            <input type="checkbox" name="is_active" value="1" {{ $landingPage->features?->is_active ? 'checked' : '' }} class="w-5 h-5">
            <label class="font-medium">Enable Section</label>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Title (English)</label>
                <input type="text" name="title_en" value="{{ $landingPage->features?->title_en }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Title (Arabic)</label>
                <input type="text" name="title_ar" value="{{ $landingPage->features?->title_ar }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Description (English)</label>
                <textarea name="description_en" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $landingPage->features?->description_en }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Description (Arabic)</label>
                <textarea name="description_ar" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $landingPage->features?->description_ar }}</textarea>
            </div>
        </div>
        
        <div class="border-t pt-4 mt-4">
            <h3 class="font-medium mb-3">Features</h3>
            <div class="space-y-4" id="features-container">
                @foreach($landingPage->features?->features ?? [] as $index => $feature)
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-medium">Feature {{ $index + 1 }}</span>
                        <button type="button" class="text-red-500" onclick="this.closest('.p-4').remove()">Remove</button>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <input type="text" name="features[{{ $index }}][title_en]" value="{{ $feature->title_en }}" class="border rounded px-2 py-1" placeholder="Title EN">
                        <input type="text" name="features[{{ $index }}][title_ar]" value="{{ $feature->title_ar }}" class="border rounded px-2 py-1" placeholder="Title AR">
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <textarea name="features[{{ $index }}][description_en]" class="border rounded px-2 py-1" placeholder="Description EN">{{ $feature->description_en }}</textarea>
                        <textarea name="features[{{ $index }}][description_ar]" class="border rounded px-2 py-1" placeholder="Description AR">{{ $feature->description_ar }}</textarea>
                    </div>
                    <input type="text" name="features[{{ $index }}][icon]" value="{{ $feature->icon }}" class="border rounded px-2 py-1 w-full" placeholder="Icon (SVG path or class)">
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addFeature()" class="mt-2 text-sm text-branding hover:underline">+ Add Feature</button>
        </div>
        
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>

<script>
let featureIndex = {{ $landingPage->features?->features->count() ?? 0 }};
function addFeature() {
    const html = `
        <div class="p-4 bg-gray-50 rounded-lg">
            <div class="flex justify-between items-center mb-2">
                <span class="font-medium">Feature ${featureIndex + 1}</span>
                <button type="button" class="text-red-500" onclick="this.closest('.p-4').remove()">Remove</button>
            </div>
            <div class="grid grid-cols-2 gap-2 mb-2">
                <input type="text" name="features[${featureIndex}][title_en]" class="border rounded px-2 py-1" placeholder="Title EN">
                <input type="text" name="features[${featureIndex}][title_ar]" class="border rounded px-2 py-1" placeholder="Title AR">
            </div>
            <div class="grid grid-cols-2 gap-2 mb-2">
                <textarea name="features[${featureIndex}][description_en]" class="border rounded px-2 py-1" placeholder="Description EN"></textarea>
                <textarea name="features[${featureIndex}][description_ar]" class="border rounded px-2 py-1" placeholder="Description AR"></textarea>
            </div>
            <input type="text" name="features[${featureIndex}][icon]" class="border rounded px-2 py-1 w-full" placeholder="Icon (SVG path or class)">
        </div>
    `;
    document.getElementById('features-container').insertAdjacentHTML('beforeend', html);
    featureIndex++;
}
</script>