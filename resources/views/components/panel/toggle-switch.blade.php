@props(['model', 'field', 'onText' => 'Aktif', 'offText' => 'Non-aktif'])

<label class="relative inline-flex items-center cursor-pointer">
    <input
        type="checkbox"
        class="sr-only peer"
        wire:click="{{ $attributes->whereStartsWith('wire:click')->first() }}"
        @checked($model->{$field})
    >
    <div
        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"
    ></div>
    <span class="ml-3 text-sm font-medium text-gray-900 peer-checked:text-primary-600">
        {{ $model->{$field} ? $onText : $offText }}
    </span>
</label>