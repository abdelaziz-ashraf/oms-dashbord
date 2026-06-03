<?php
    $section = $landingPage->footer;
    $socialPlatforms = [
        'facebook' => 'Facebook',
        'linkedin' => 'LinkedIn',
        'instagram' => 'Instagram',
        'tiktok' => 'TikTok',
    ];
?>
<div id="footer" class="section-card bg-white rounded-xl shadow-sm p-6 mt-6 mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-dark">Footer</h2>
        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $section?->is_active ? 'active-badge' : 'inactive-badge' }}">{{ $section?->is_active ? 'Active' : 'Inactive' }}</span>
    </div>
    <form action="{{ route('admin.footer.update') }}" method="POST" class="space-y-4">
        @csrf @method('PUT')
        <div class="flex items-center gap-3 mb-4">
            <input type="checkbox" name="is_active" value="1" {{ $section?->is_active ? 'checked' : '' }} class="w-5 h-5">
            <label class="font-medium">Enable Section</label>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Description (EN)</label><textarea name="description_en" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $section?->description_en }}</textarea></div>
            <div><label class="block text-sm font-medium mb-1">Description (AR)</label><textarea name="description_ar" rows="3" class="w-full border rounded-lg px-3 py-2">{{ $section?->description_ar }}</textarea></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Copyright (EN)</label><input type="text" name="copyright_en" value="{{ $section?->copyright_en }}" class="w-full border rounded-lg px-3 py-2"></div>
            <div><label class="block text-sm font-medium mb-1">Copyright (AR)</label><input type="text" name="copyright_ar" value="{{ $section?->copyright_ar }}" class="w-full border rounded-lg px-3 py-2"></div>
        </div>
        
        <div class="border-t pt-4">
            <h3 class="font-medium mb-3">Link Groups</h3>
            <div class="space-y-4" id="linkgroups-container">
                @foreach($section?->linkGroups ?? [] as $gIndex => $group)
                <div class="p-3 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-medium">Group {{ $gIndex + 1 }}</span>
                        <button type="button" class="text-red-500" onclick="this.parentElement.parentElement.remove()">×</button>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mb-2">
                        <input type="text" name="link_groups[{{ $gIndex }}][key]" value="{{ $group->key }}" class="border rounded px-2 py-1" placeholder="Key (e.g., product)">
                        <input type="text" name="link_groups[{{ $gIndex }}][title_en]" value="{{ $group->title_en }}" class="border rounded px-2 py-1" placeholder="Title EN">
                        <input type="text" name="link_groups[{{ $gIndex }}][title_ar]" value="{{ $group->title_ar }}" class="border rounded px-2 py-1" placeholder="Title AR">
                    </div>
                    <div class="pl-4 border-l-2 border-gray-300 space-y-2">
                        @foreach($group->links as $lIndex => $link)
                        <div class="flex gap-2 items-center">
                            <input type="text" name="link_groups[{{ $gIndex }}][links][{{ $lIndex }}][label_en]" value="{{ $link->label_en }}" class="border rounded px-2 py-1 flex-1" placeholder="Label EN">
                            <input type="text" name="link_groups[{{ $gIndex }}][links][{{ $lIndex }}][label_ar]" value="{{ $link->label_ar }}" class="border rounded px-2 py-1 flex-1" placeholder="Label AR">
                            <input type="text" name="link_groups[{{ $gIndex }}][links][{{ $lIndex }}][url]" value="{{ $link->url }}" class="border rounded px-2 py-1 flex-1" placeholder="URL">
                            <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
                        </div>
                        @endforeach
                        <button type="button" class="text-sm text-branding hover:underline" onclick="addLink(this)">+ Add Link</button>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addLinkGroup()" class="mt-2 text-sm text-branding hover:underline">+ Add Group</button>
        </div>
        
        <div class="border-t pt-4">
            <h3 class="font-medium mb-3">Social Links</h3>
            <div class="space-y-2" id="sociallinks-container">
                @foreach($section?->socialLinks ?? [] as $i => $link)
                <div class="flex gap-2 items-center">
                    <select name="social_links[{{ $i }}][platform]" class="border rounded px-2 py-1 w-40 bg-white">
                        <option value="">Select platform</option>
                        @foreach($socialPlatforms as $platform => $label)
                            <option value="{{ $platform }}" @selected(strtolower((string) $link->platform) === $platform)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="social_links[{{ $i }}][url]" value="{{ $link->url }}" class="border rounded px-2 py-1 flex-1" placeholder="URL">
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
                </div>
                @endforeach
            </div>
            <button type="button" onclick="addSocialLink()" class="mt-2 text-sm text-branding hover:underline">+ Add Social Link</button>
        </div>
        
        <button type="submit" class="px-4 py-2 bg-branding text-white rounded-lg hover:opacity-90">Save Changes</button>
    </form>
</div>

<script>
let lgIndex = {{ $section?->linkGroups->count() ?? 0 }};
let slIndex = {{ $section?->socialLinks->count() ?? 0 }};

function addLinkGroup() {
    document.getElementById('linkgroups-container').insertAdjacentHTML('beforeend', `
        <div class="p-3 bg-gray-50 rounded-lg">
            <div class="flex justify-between items-center mb-2">
                <span class="font-medium">Group ${lgIndex + 1}</span>
                <button type="button" class="text-red-500" onclick="this.parentElement.parentElement.remove()">×</button>
            </div>
            <div class="grid grid-cols-3 gap-2 mb-2">
                <input type="text" name="link_groups[${lgIndex}][key]" class="border rounded px-2 py-1" placeholder="Key">
                <input type="text" name="link_groups[${lgIndex}][title_en]" class="border rounded px-2 py-1" placeholder="Title EN">
                <input type="text" name="link_groups[${lgIndex}][title_ar]" class="border rounded px-2 py-1" placeholder="Title AR">
            </div>
            <div class="pl-4 border-l-2 border-gray-300 space-y-2">
                <div class="flex gap-2 items-center">
                    <input type="text" name="link_groups[${lgIndex}][links][0][label_en]" class="border rounded px-2 py-1 flex-1" placeholder="Label EN">
                    <input type="text" name="link_groups[${lgIndex}][links][0][label_ar]" class="border rounded px-2 py-1 flex-1" placeholder="Label AR">
                    <input type="text" name="link_groups[${lgIndex}][links][0][url]" class="border rounded px-2 py-1 flex-1" placeholder="URL">
                    <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
                </div>
                <button type="button" class="text-sm text-branding hover:underline" onclick="addLink(this)">+ Add Link</button>
            </div>
        </div>
    `);
    lgIndex++;
}

function addLink(btn) {
    const container = btn.previousElementSibling;
    const linkIndex = container.children.length;
    const groupIndex = lgIndex - 1;
    container.insertAdjacentHTML('beforeend', `
        <div class="flex gap-2 items-center">
            <input type="text" name="link_groups[${groupIndex}][links][${linkIndex}][label_en]" class="border rounded px-2 py-1 flex-1" placeholder="Label EN">
            <input type="text" name="link_groups[${groupIndex}][links][${linkIndex}][label_ar]" class="border rounded px-2 py-1 flex-1" placeholder="Label AR">
            <input type="text" name="link_groups[${groupIndex}][links][${linkIndex}][url]" class="border rounded px-2 py-1 flex-1" placeholder="URL">
            <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
        </div>
    `);
}

function addSocialLink() {
    document.getElementById('sociallinks-container').insertAdjacentHTML('beforeend', `
        <div class="flex gap-2 items-center">
            <select name="social_links[${slIndex}][platform]" class="border rounded px-2 py-1 w-40 bg-white">
                <option value="">Select platform</option>
                @foreach($socialPlatforms as $platform => $label)
                    <option value="{{ $platform }}">{{ $label }}</option>
                @endforeach
            </select>
            <input type="text" name="social_links[${slIndex}][url]" class="border rounded px-2 py-1 flex-1" placeholder="URL">
            <button type="button" class="text-red-500" onclick="this.parentElement.remove()">×</button>
        </div>
    `);
    slIndex++;
}
</script>
