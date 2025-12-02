@props(['value' => ''])

<div class="rounded-2xl shadow-sm focus-within:ring-2 focus-within:ring-primary-500 border border-gray-300" x-data="{
        value: @entangle($attributes->wire('model')).live,
        isFocused: false
    }" x-init="$nextTick(() => {
        // Load nilai awal dari Livewire ke Trix saat pertama kali render
        if ($refs.trix.editor && value) {
            $refs.trix.editor.loadHTML(value);
        }
    })" wire:ignore {{-- Penting: Mencegah Livewire merender ulang elemen ini --}}>
    {{-- Input hidden sebagai jembatan (best practice Trix) --}}
    <input id="trix-value-{{ $this->getId() }}" type="hidden" name="content" value="{{ $value }}">

    <trix-editor x-ref="trix" input="trix-value-{{ $this->getId() }}"
        class="trix-content min-h-[300px] outline-none border-none p-4 rounded-2xl" {{-- 1. Saat user mengetik (Trix ->
        Livewire) --}}
        x-on:trix-change="value = $refs.trix.value"

        {{-- 2. Saat Livewire mengupdate data dari luar (Livewire -> Trix) --}}
        x-effect="if($refs.trix.editor && value !== $refs.trix.value) { $refs.trix.editor.loadHTML(value) }"
        ></trix-editor>
</div>
