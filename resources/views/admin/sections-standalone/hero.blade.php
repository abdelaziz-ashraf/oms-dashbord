<form action="{{ route('admin.hero.update') }}" method="POST" class="space-y-8" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                <i class="fas fa-image text-cyan-600"></i>
            </div>
            <div>
                <p class="font-medium text-slate-800">Enable Hero Section</p>
                <p class="text-sm text-slate-500">Show hero section on the landing page</p>
            </div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ $landingPage->hero?->is_active ? 'checked' : '' }} class="sr-only peer">
            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
        </label>
    </div>
    
    <div class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Title (English)</label>
                <input type="text" name="title_en" value="{{ $landingPage->hero?->title_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="Manage Your Business with Ease">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Title (Arabic)</label>
                <input type="text" name="title_ar" value="{{ $landingPage->hero?->title_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="إدارة عملك بسهولة">
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Subtitle (English)</label>
                <textarea name="subtitle_en" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">{{ $landingPage->hero?->subtitle_en }}</textarea>
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Subtitle (Arabic)</label>
                <textarea name="subtitle_ar" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">{{ $landingPage->hero?->subtitle_ar }}</textarea>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Button Text (English)</label>
                <input type="text" name="button_text_en" value="{{ $landingPage->hero?->button_text_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="Start Free Trial">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Button Text (Arabic)</label>
                <input type="text" name="button_text_ar" value="{{ $landingPage->hero?->button_text_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="ابدأ التجربة المجانية">
            </div>
        </div>
        
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Button Link</label>
            <input type="text" name="button_link" value="{{ $landingPage->hero?->button_link }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="#packages">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Secondary Button (English)</label>
                <input type="text" name="secondary_button_text_en" value="{{ $landingPage->hero?->secondary_button_text_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="Watch Demo">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Secondary Button (Arabic)</label>
                <input type="text" name="secondary_button_text_ar" value="{{ $landingPage->hero?->secondary_button_text_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="شاهد الفيديو">
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Trusted Badge (English)</label>
                <input type="text" name="trusted_badge_en" value="{{ $landingPage->hero?->trusted_badge_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="Trusted by 10,000+ businesses">
            </div>
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700">Trusted Badge (Arabic)</label>
                <input type="text" name="trusted_badge_ar" value="{{ $landingPage->hero?->trusted_badge_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="موثوق من أكثر من 10,000 شركة">
            </div>
        </div>
    </div>
    
    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-1">
            <i class="fas fa-image text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Hero Image</h3>
        </div>
        <p class="text-xs text-slate-400 mb-4">Replaces the dark statistics card on the right side of the hero. Max 5 MB. Leave empty to keep the current image.</p>

        @if($landingPage->hero?->image_path)
        <div class="mb-4">
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($landingPage->hero->image_path) }}"
                 alt="Hero image" class="h-40 rounded-xl object-cover border border-slate-200 shadow-sm">
        </div>
        @endif

        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-slate-300 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/30 transition-colors"
               id="image-drop-zone">
            <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 mb-2"></i>
            <span class="text-sm text-slate-500">Click to upload or drag & drop</span>
            <span class="text-xs text-slate-400 mt-1">PNG, JPG, WEBP</span>
            <input type="file" name="image" accept="image/*" class="hidden" id="hero-image-input"
                   onchange="previewHeroImage(this)">
        </label>
        <div id="hero-image-preview" class="mt-3 hidden">
            <img id="hero-preview-img" src="" alt="" class="h-40 rounded-xl object-cover border border-slate-200 shadow-sm">
            <p class="text-xs text-slate-400 mt-1" id="hero-image-name"></p>
        </div>
    </div>

    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-chart-bar text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Statistics</h3>
        </div>
        <div class="space-y-3" id="statistics-container">
            @foreach($landingPage->hero?->statistics ?? [] as $index => $stat)
            <div class="flex gap-3 items-center p-3 bg-slate-50 rounded-xl item-item">
                <input type="hidden" name="statistics[{{ $index }}][id]" value="{{ $stat->id }}">
                <input type="text" name="statistics[{{ $index }}][value]" value="{{ $stat->value }}" class="border border-slate-300 rounded-lg px-3 py-2 w-28" placeholder="10K+">
                <input type="text" name="statistics[{{ $index }}][label_en]" value="{{ $stat->label_en }}" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Label EN">
                <input type="text" name="statistics[{{ $index }}][label_ar]" value="{{ $stat->label_ar }}" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Label AR">
                <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            @endforeach
            <template class="item-template hidden">
                <div class="flex gap-3 items-center p-3 bg-slate-50 rounded-xl item-item">
                    <input type="text" name="statistics[__INDEX__][value]" class="border border-slate-300 rounded-lg px-3 py-2 w-28" placeholder="10K+">
                    <input type="text" name="statistics[__INDEX__][label_en]" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Label EN">
                    <input type="text" name="statistics[__INDEX__][label_ar]" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Label AR">
                    <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </template>
        </div>
        <button type="button" class="add-item-btn mt-3 text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1">
            <i class="fas fa-plus"></i> Add Statistic
        </button>
    </div>
    
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-save"></i>
            Save Changes
        </button>
    </div>
</form>

<script>
function previewHeroImage(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('hero-preview-img').src = e.target.result;
        document.getElementById('hero-image-name').textContent = file.name;
        document.getElementById('hero-image-preview').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

// Drag & drop
const dropZone = document.getElementById('image-drop-zone');
const fileInput = document.getElementById('hero-image-input');
if (dropZone) {
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-blue-400', 'bg-blue-50/50'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-blue-400', 'bg-blue-50/50'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50/50');
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            previewHeroImage(fileInput);
        }
    });
}
</script>
