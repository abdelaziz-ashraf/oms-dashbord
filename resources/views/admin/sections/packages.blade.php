<div id="packages" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Packages / Pricing</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $landingPage->packages?->is_active ? 'active-badge' : 'inactive-badge' }}">
            {{ $landingPage->packages?->is_active ? 'Active' : 'Inactive' }}
        </span>
    </div>
    
    <form action="{{ route('admin.packages.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div class="flex items-center gap-3 mb-4">
            <input type="checkbox" name="is_active" value="1" {{ $landingPage->packages?->is_active ? 'checked' : '' }} class="w-5 h-5">
            <label class="font-medium">Enable Section</label>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Title (English)</label>
                <input type="text" name="title_en" value="{{ $landingPage->packages?->title_en }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Title (Arabic)</label>
                <input type="text" name="title_ar" value="{{ $landingPage->packages?->title_ar }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Popular Badge (EN)</label>
                <input type="text" name="popular_badge_en" value="{{ $landingPage->packages?->popular_badge_en }}" class="w-full border rounded-lg px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Popular Badge (AR)</label>
                <input type="text" name="popular_badge_ar" value="{{ $landingPage->packages?->popular_badge_ar }}" class="w-full border rounded-lg px-3 py-2">
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Billing Period (EN)</label>
                <input type="text" name="billing_period_en" value="{{ $landingPage->packages?->billing_period_en }}" class="w-full border rounded-lg px-3 py-2" placeholder="/month">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Billing Period (AR)</label>
                <input type="text" name="billing_period_ar" value="{{ $landingPage->packages?->billing_period_ar }}" class="w-full border rounded-lg px-3 py-2" placeholder="/شهرياً">
            </div>
        </div>
        
        <div class="border-t pt-4 mt-4">
            <h3 class="font-medium mb-3">Pricing Plans</h3>
            <div class="space-y-4" id="packages-container">
                @foreach($landingPage->packages?->packages ?? [] as $pIndex => $package)
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-medium">Plan {{ $pIndex + 1 }}</span>
                        <button type="button" class="text-red-500" onclick="this.closest('.p-4').remove()">Remove</button>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <input type="text" name="packages[{{ $pIndex }}][name_en]" value="{{ $package->name_en }}" class="border rounded px-2 py-1" placeholder="Name EN">
                        <input type="text" name="packages[{{ $pIndex }}][name_ar]" value="{{ $package->name_ar }}" class="border rounded px-2 py-1" placeholder="Name AR">
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <input type="text" name="packages[{{ $pIndex }}][users_en]" value="{{ $package->users_en }}" class="border rounded px-2 py-1" placeholder="Users EN">
                        <input type="text" name="packages[{{ $pIndex }}][users_ar]" value="{{ $package->users_ar }}" class="border rounded px-2 py-1" placeholder="Users AR">
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <textarea name="packages[{{ $pIndex }}][description_en]" class="border rounded px-2 py-1" placeholder="Description EN">{{ $package->description_en }}</textarea>
                        <textarea name="packages[{{ $pIndex }}][description_ar]" class="border rounded px-2 py-1" placeholder="Description AR">{{ $package->description_ar }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <input type="number" name="packages[{{ $pIndex }}][price]" value="{{ $package->price }}" class="border rounded px-2 py-1" placeholder="Price">
                        <input type="text" name="packages[{{ $pIndex }}][button_text_en]" value="{{ $package->button_text_en }}" class="border rounded px-2 py-1" placeholder="Button Text EN">
                    </div>
                    <input type="text" name="packages[{{ $pIndex }}][button_text_ar]" value="{{ $package->button_text_ar }}" class="border rounded px-2 py-1 w-full mb-2" placeholder="Button Text AR">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Features (one per line - EN | AR)</label>
                        <textarea name="packages[{{ $pIndex }}][features_text]" class="border rounded px-2 py-1 w-full text-sm" rows="3" placeholder="Feature 1 EN | Feature 1 AR&#10;Feature 2 EN | Feature 2 AR">{{ $package->features->map(fn($f) => $f->name_en . ' | ' . $f->name_ar)->join("\n") }}</textarea>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addPackage()" class="mt-2 text-sm text-branding hover:underline">+ Add Plan</button>
        </div>
        
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>

<script>
let pkgIndex = {{ $landingPage->packages?->packages->count() ?? 0 }};
function addPackage() {
    const html = `
        <div class="p-4 bg-gray-50 rounded-lg">
            <div class="flex justify-between items-center mb-2">
                <span class="font-medium">Plan ${pkgIndex + 1}</span>
                <button type="button" class="text-red-500" onclick="this.closest('.p-4').remove()">Remove</button>
            </div>
            <div class="grid grid-cols-2 gap-2 mb-2">
                <input type="text" name="packages[${pkgIndex}][name_en]" class="border rounded px-2 py-1" placeholder="Name EN">
                <input type="text" name="packages[${pkgIndex}][name_ar]" class="border rounded px-2 py-1" placeholder="Name AR">
            </div>
            <div class="grid grid-cols-2 gap-2 mb-2">
                <input type="text" name="packages[${pkgIndex}][users_en]" class="border rounded px-2 py-1" placeholder="Users EN">
                <input type="text" name="packages[${pkgIndex}][users_ar]" class="border rounded px-2 py-1" placeholder="Users AR">
            </div>
            <div class="grid grid-cols-2 gap-2 mb-2">
                <textarea name="packages[${pkgIndex}][description_en]" class="border rounded px-2 py-1" placeholder="Description EN"></textarea>
                <textarea name="packages[${pkgIndex}][description_ar]" class="border rounded px-2 py-1" placeholder="Description AR"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-2 mb-2">
                <input type="number" name="packages[${pkgIndex}][price]" class="border rounded px-2 py-1" placeholder="Price">
                <input type="text" name="packages[${pkgIndex}][button_text_en]" class="border rounded px-2 py-1" placeholder="Button Text EN">
            </div>
            <input type="text" name="packages[${pkgIndex}][button_text_ar]" class="border rounded px-2 py-1 w-full mb-2" placeholder="Button Text AR">
            <div>
                <label class="text-xs text-gray-500 mb-1 block">Features (one per line - EN | AR)</label>
                <textarea name="packages[${pkgIndex}][features_text]" class="border rounded px-2 py-1 w-full text-sm" rows="3" placeholder="Feature 1 EN | Feature 1 AR"></textarea>
            </div>
        </div>
    `;
    document.getElementById('packages-container').insertAdjacentHTML('beforeend', html);
    pkgIndex++;
}
</script>