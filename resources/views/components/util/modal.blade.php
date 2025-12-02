@props([
    'name',
    'title' => null,
    'maxWidth' => '2xl'
])

@php
$maxWidthClasses = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '5xl' => 'sm:max-w-5xl',
    '7xl' => 'sm:max-w-7xl',
][$maxWidth];
@endphp

<div
    x-data="{ show: @entangle($attributes->wire('model')) }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    x-cloak
    class="relative z-[100]"
    aria-labelledby="modal-title" role="dialog" aria-modal="true"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        x-transition.opacity
        class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity"
        x-on:click="show = false"
    ></div>

    {{-- Modal Panel --}}
    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                x-show="show"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-on:click.outside="show = false"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full {{ $maxWidthClasses }}"
            >
                {{-- Modal Content --}}
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
