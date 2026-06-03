<?php $section = $landingPage->footer; ?>
<form action="{{ route('admin.footer.update') }}" method="POST" class="space-y-6">
    @csrf @method('PUT')
    
    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-slate-200 rounded-lg flex items-center justify-center">
                <i class="fas fa-grip-lines text-slate-600"></i>
            </div>
            <div>
                <p class="font-medium text-slate-800">Enable Footer</p>
                <p class="text-sm text-slate-500">Show page footer</p>
            </div>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ $section?->is_active ? 'checked' : '' }} class="sr-only peer">
            <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500"></div>
        </label>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Description (English)</label>
            <textarea name="description_en" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">{{ $section?->description_en }}</textarea>
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Description (Arabic)</label>
            <textarea name="description_ar" rows="3" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">{{ $section?->description_ar }}</textarea>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Copyright (English)</label>
            <input type="text" name="copyright_en" value="{{ $section?->copyright_en }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">Copyright (Arabic)</label>
            <input type="text" name="copyright_ar" value="{{ $section?->copyright_ar }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" dir="rtl">
        </div>
    </div>
    
    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-link text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Link Groups</h3>
        </div>
        <div class="space-y-4" id="linkgroups-container">
            @foreach($section?->linkGroups ?? [] as $gIndex => $group)
            <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                <input type="hidden" name="link_groups[{{ $gIndex }}][id]" value="{{ $group->id }}">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-semibold text-slate-700">Group {{ $gIndex + 1 }}</span>
                    <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <input type="text" name="link_groups[{{ $gIndex }}][key]" value="{{ $group->key }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Key (e.g., product)">
                    <input type="text" name="link_groups[{{ $gIndex }}][title_en]" value="{{ $group->title_en }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title EN">
                    <input type="text" name="link_groups[{{ $gIndex }}][title_ar]" value="{{ $group->title_ar }}" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title AR" dir="rtl">
                </div>
                <div class="pl-4 border-l-2 border-slate-300 space-y-2">
                    @foreach($group->links as $lIndex => $link)
                    <div class="flex gap-2 items-center item-item">
                        <input type="hidden" name="link_groups[{{ $gIndex }}][links][{{ $lIndex }}][id]" value="{{ $link->id }}">
                        <input type="text" name="link_groups[{{ $gIndex }}][links][{{ $lIndex }}][label_en]" value="{{ $link->label_en }}" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Label EN">
                        <input type="text" name="link_groups[{{ $gIndex }}][links][{{ $lIndex }}][label_ar]" value="{{ $link->label_ar }}" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="Label AR" dir="rtl">
                        <input type="text" name="link_groups[{{ $gIndex }}][links][{{ $lIndex }}][url]" value="{{ $link->url }}" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="URL">
                        <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                    </div>
                    @endforeach
                    <button type="button" class="text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1 add-link-btn" data-group="{{ $gIndex }}">+ Add Link</button>
                </div>
            </div>
            @endforeach
            <template class="item-template hidden">
                <div class="p-5 bg-slate-50 rounded-xl border border-slate-200 item-item">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold text-slate-700">New Group</span>
                        <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <input type="text" name="link_groups[__INDEX__][key]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Key (e.g., product)">
                        <input type="text" name="link_groups[__INDEX__][title_en]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title EN">
                        <input type="text" name="link_groups[__INDEX__][title_ar]" class="border border-slate-300 rounded-lg px-3 py-2" placeholder="Title AR" dir="rtl">
                    </div>
                    <div class="pl-4 border-l-2 border-slate-300 space-y-2 link-container">
                        <button type="button" class="text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1 add-link-btn" data-group="__INDEX__">+ Add Link</button>
                    </div>
                </div>
            </template>
        </div>
        <button type="button" class="add-group-btn mt-4 text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1" data-target="linkgroups-container">
            <i class="fas fa-plus-circle"></i> Add Group
        </button>
    </div>
    
    <div class="border-t border-slate-200 pt-6">
        <div class="flex items-center gap-2 mb-4">
            <i class="fas fa-share-alt text-slate-400"></i>
            <h3 class="font-semibold text-slate-700">Social Links</h3>
        </div>
        <div class="space-y-4" id="sociallinks-container">
            @foreach($section?->socialLinks ?? [] as $i => $link)
            <div class="flex gap-4 items-center p-4 bg-slate-50 rounded-xl border border-slate-200 item-item">
                <input type="hidden" name="social_links[{{ $i }}][id]" value="{{ $link->id }}">
                <input type="text" name="social_links[{{ $i }}][platform]" value="{{ $link->platform }}" class="border border-slate-300 rounded-lg px-3 py-2 w-40" placeholder="Platform (e.g., facebook)">
                <input type="text" name="social_links[{{ $i }}][url]" value="{{ $link->url }}" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="URL">
                <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
            </div>
            @endforeach
            <template class="item-template hidden">
                <div class="flex gap-4 items-center p-4 bg-slate-50 rounded-xl border border-slate-200 item-item">
                    <input type="text" name="social_links[__INDEX__][platform]" class="border border-slate-300 rounded-lg px-3 py-2 w-40" placeholder="Platform (e.g., facebook)">
                    <input type="text" name="social_links[__INDEX__][url]" class="border border-slate-300 rounded-lg px-3 py-2 flex-1" placeholder="URL">
                    <button type="button" class="remove-item-btn text-red-500 hover:bg-red-50 p-2 rounded-lg"><i class="fas fa-trash"></i></button>
                </div>
            </template>
        </div>
        <button type="button" class="add-social-btn mt-4 text-sm text-blue-500 hover:text-blue-600 font-medium flex items-center gap-1" data-target="sociallinks-container">
            <i class="fas fa-plus-circle"></i> Add Social Link
        </button>
    </div>
    
    <div class="flex justify-end pt-4 border-t border-slate-100">
        <button type="submit" class="px-6 py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition flex items-center gap-2">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>
</form>
