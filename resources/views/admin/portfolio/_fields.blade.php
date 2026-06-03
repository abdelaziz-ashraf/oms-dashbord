@foreach($config['fields'] as $name => $field)
    @php
        $field = is_array($field) ? $field : ['label' => $field, 'type' => 'text'];
        $type = $field['type'] ?? 'text';
        $value = old($name, $item?->{$name});

        if ($value instanceof \DateTimeInterface) {
            $value = $value->format('Y-m-d H:i:s');
        }

        $isRtl = str_ends_with($name, '_ar');
    @endphp

    @if($type === 'checkbox')
        <label class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
            <input type="checkbox" name="{{ $name }}" value="1" {{ old($name, $item?->{$name} ?? ($field['default'] ?? false)) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300">
            <span class="text-sm font-medium text-slate-700">{{ $field['label'] }}</span>
        </label>
    @elseif($type === 'textarea')
        <div class="space-y-2 md:col-span-2">
            <label class="block text-sm font-semibold text-slate-700">{{ $field['label'] }}</label>
            <textarea name="{{ $name }}" rows="4" dir="{{ $isRtl ? 'rtl' : 'ltr' }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">{{ $value }}</textarea>
        </div>
    @elseif($type === 'project-select')
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">{{ $field['label'] }}</label>
            <select name="{{ $name }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
                <option value="">No linked project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ (string) $value === (string) $project->id ? 'selected' : '' }}>{{ $project->title_en }}</option>
                @endforeach
            </select>
        </div>
    @elseif($type === 'file')
        @php
            $previewUrl = null;
            if ($value) {
                $previewUrl = \Illuminate\Support\Str::startsWith($value, ['http://', 'https://', '/'])
                    ? $value
                    : \Illuminate\Support\Facades\Storage::disk('public')->url($value);
            }
        @endphp
        <div class="space-y-2 md:col-span-2">
            <label class="block text-sm font-semibold text-slate-700">{{ $field['label'] }}</label>
            @if($previewUrl)
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                    <img src="{{ $previewUrl }}" alt="{{ $field['label'] }}" class="w-16 h-16 rounded-lg object-cover bg-white border border-slate-200">
                    <span class="text-xs text-slate-500 break-all">{{ $value }}</span>
                </div>
            @endif
            <input type="file" name="{{ $name }}_file" accept="image/*" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
            <input type="text" name="{{ $name }}" value="{{ $value }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition" placeholder="Optional external URL or existing storage path">
        </div>
    @else
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-slate-700">{{ $field['label'] }}</label>
            <input type="{{ $type === 'number' ? 'number' : 'text' }}" name="{{ $name }}" value="{{ $value }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}" class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition">
        </div>
    @endif
@endforeach
