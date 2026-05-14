<div id="hero" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Hero Section</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $landingPage->hero?->is_active ? 'active-badge' : 'inactive-badge' }}">
            {{ $landingPage->hero?->is_active ? 'Active' : 'Inactive' }}
        </span>
    </div>
    
    <form action="{{ route('admin.hero.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div class="flex items-center gap-3 mb-4">
            <input type="checkbox" name="is_active" id="hero_active" value="1" {{ $landingPage->hero?->is_active ? 'checked' : '' }} class="w-5 h-5">
            <label for="hero_active" class="font-medium">Enable Section</label>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Title (English)</label>
                <input type="text" name="title_en" value="{{ $landingPage->hero?->title_en }}" class="w-full border rounded-lg px-3 py-2" placeholder="Manage Your Business with Ease">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Title (Arabic)</label>
                <input type="text" name="title_ar" value="{{ $landingPage->hero?->title_ar }}" class="w-full border rounded-lg px-3 py-2" placeholder="إدارة عملك بسهولة">
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Subtitle (English)</label>
                <textarea name="subtitle_en" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $landingPage->hero?->subtitle_en }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Subtitle (Arabic)</label>
                <textarea name="subtitle_ar" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $landingPage->hero?->subtitle_ar }}</textarea>
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Button Text (English)</label>
                <input type="text" name="button_text_en" value="{{ $landingPage->hero?->button_text_en }}" class="w-full border rounded-lg px-3 py-2" placeholder="Start Free Trial">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Button Text (Arabic)</label>
                <input type="text" name="button_text_ar" value="{{ $landingPage->hero?->button_text_ar }}" class="w-full border rounded-lg px-3 py-2" placeholder="ابدأ التجربة المجانية">
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium mb-1">Button Link</label>
            <input type="text" name="button_link" value="{{ $landingPage->hero?->button_link }}" class="w-full border rounded-lg px-3 py-2" placeholder="#packages">
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Secondary Button (English)</label>
                <input type="text" name="secondary_button_text_en" value="{{ $landingPage->hero?->secondary_button_text_en }}" class="w-full border rounded-lg px-3 py-2" placeholder="Watch Demo">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Secondary Button (Arabic)</label>
                <input type="text" name="secondary_button_text_ar" value="{{ $landingPage->hero?->secondary_button_text_ar }}" class="w-full border rounded-lg px-3 py-2" placeholder="شاهد الفيديو">
            </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Trusted Badge (English)</label>
                <input type="text" name="trusted_badge_en" value="{{ $landingPage->hero?->trusted_badge_en }}" class="w-full border rounded-lg px-3 py-2" placeholder="Trusted by 10,000+ businesses">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Trusted Badge (Arabic)</label>
                <input type="text" name="trusted_badge_ar" value="{{ $landingPage->hero?->trusted_badge_ar }}" class="w-full border rounded-lg px-3 py-2" placeholder="موثوق من أكثر من 10,000 شركة">
            </div>
        </div>
        
        <div class="border-t pt-4 mt-4">
            <h3 class="font-medium mb-3">Statistics</h3>
            <div class="space-y-3" id="statistics-container">
                @foreach($landingPage->hero?->statistics ?? [] as $index => $stat)
                <div class="flex gap-2 items-center">
                    <input type="text" name="statistics[{{ $index }}][value]" value="{{ $stat->value }}" class="border rounded px-2 py-1 w-24" placeholder="10K+">
                    <input type="text" name="statistics[{{ $index }}][label_en]" value="{{ $stat->label_en }}" class="border rounded px-2 py-1 flex-1" placeholder="Label EN">
                    <input type="text" name="statistics[{{ $index }}][label_ar]" value="{{ $stat->label_ar }}" class="border rounded px-2 py-1 flex-1" placeholder="Label AR">
                    <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">×</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addStatistic()" class="mt-2 text-sm text-branding hover:underline">+ Add Statistic</button>
        </div>
        
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>

<script>
function addStatistic() {
    const container = document.getElementById('statistics-container');
    const index = container.children.length;
    const html = `
        <div class="flex gap-2 items-center">
            <input type="text" name="statistics[${index}][value]" class="border rounded px-2 py-1 w-24" placeholder="10K+">
            <input type="text" name="statistics[${index}][label_en]" class="border rounded px-2 py-1 flex-1" placeholder="Label EN">
            <input type="text" name="statistics[${index}][label_ar]" class="border rounded px-2 py-1 flex-1" placeholder="Label AR">
            <button type="button" class="text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">×</button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}
</script>