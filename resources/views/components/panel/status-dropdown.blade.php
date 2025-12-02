@props(['inquiry'])

@php
    $statusOptions = \App\Enums\InquiryStatus::cases();
    $statusColors = [
        'new' => 'bg-blue-100 text-blue-800',
        'contacted' => 'bg-green-100 text-green-800',
        'spam' => 'bg-red-100 text-red-800',
    ];
@endphp

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" @click.outside="open = false" class="inline-flex items-center gap-2 text-left w-full">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$inquiry->status->value] }}">
            <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ str_replace(['-100', '-800'], ['-500', ''], $statusColors[$inquiry->status->value]) }}"></span>
            {{ $inquiry->status->value }}
        </span>
        <x-phosphor-caret-down-bold class="w-3 h-3 text-gray-400" />
    </button>

    <div
        x-show="open"
        x-transition
        x-cloak
        class="absolute z-10 mt-2 w-40 bg-white rounded-lg shadow-lg border border-gray-100 py-1"
    >
        @foreach ($statusOptions as $status)
            <a 
                href="#"
                wire:click.prevent="updateStatus({{ $inquiry->id }}, '{{ $status->value }}')"
                x-on:click="open = false"
                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            >
                Ubah ke {{ $status->value }}
            </a>
        @endforeach
    </div>
</div>
