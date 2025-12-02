@props([
'type' => 'button',
'variant' => 'primary',
'target' => null,
'icon' => null
])

@php
$variants = [
'primary' => 'btn-primary',
'secondary' => 'btn-secondary',
'outline' => 'btn-outline',
];

$variantClass = $variants[$variant] ?? '';
$classes = "btn {$variantClass}";
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}

    {{-- Loading hanya aktif jika target diset --}}
    @if($target)
    wire:loading.attr="disabled"
    wire:loading.class="!opacity-75"
    wire:target="{{ $target }}"
    @endif
    >
    {{-- Spinner --}}
    @if($target)
    <div wire:loading.flex wire:target="{{ $target }}" class="items-center justify-center">
        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
    </div>
    @endif

    {{-- Isi tombol --}}
    <div @if($target) wire:loading.remove wire:target="{{ $target }}" @endif class="flex items-center justify-center">
        @if ($icon)
        <span class="shrink-0">
            {{ $icon }}
        </span>
        @endif

        <span @if($icon) class="hidden sm:block sm:ml-2" @endif>
            {{ $slot }}
        </span>
    </div>
</button>
