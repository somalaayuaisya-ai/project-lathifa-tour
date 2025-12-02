<div>
    {{-- Header Section dengan Aksen Emas & Counter --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 border-b border-gray-100 pb-6">
        <div>
            <h2 class="text-3xl font-serif font-bold text-primary-900 relative inline-block">
                Wishlist Impian
                {{-- Dekorasi titik emas --}}
                <span class="absolute -top-1 -right-3 text-gold-500 text-4xl leading-none">.</span>
            </h2>
            <p class="text-gray-500 mt-2 text-base">
                Koleksi paket perjalanan spiritual yang Anda rencanakan.
            </p>
        </div>

        @if($wishlistedPackages->total() > 0)
        <div class="flex items-center gap-2 bg-primary-50 px-4 py-2 rounded-full border border-primary-100">
            <x-phosphor-heart-fill class="w-5 h-5 text-red-500" />
            <span class="text-primary-800 font-bold text-sm">
                {{ $wishlistedPackages->total() }} Paket Disimpan
            </span>
        </div>
        @endif
    </div>

    {{-- Content Section --}}
    <div class="relative min-h-[400px]">

        {{-- Loading State Overlay --}}
        <div wire:loading.flex
            class="absolute inset-0 z-10 bg-white/50 backdrop-blur-sm items-start justify-center pt-20">
            <div class="flex items-center gap-2 bg-white shadow-xl px-4 py-2 rounded-full text-primary-900 font-medium">
                <svg class="animate-spin h-5 w-5 text-gold-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Memuat data...
            </div>
        </div>

        @if ($wishlistedPackages->count() > 0)
        {{-- Grid Layout dengan Animasi Fade In --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8" x-data
            x-animate:enter="transition ease-out duration-300">
            @foreach ($wishlistedPackages as $package)
            <div wire:key="wishlist-page-{{ $package->id }}" class="h-full">
                {{-- Menggunakan component card yang sudah ada, dibungkus agar tingginya seragam --}}
                <div class="h-full transform transition duration-300 hover:-translate-y-1 hover:shadow-xl rounded-xl">
                    <x-panel.wishlist-item :package="$package" />
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination Modern --}}
        @if ($wishlistedPackages->hasPages())
        <div class="mt-12 border-t border-gray-100 pt-8 flex justify-center">
            {{ $wishlistedPackages->links() }}
        </div>
        @endif

        @else
        {{-- Empty State yang Lebih Menarik --}}
        <div
            class="flex flex-col items-center justify-center py-16 px-4 text-center rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50/50">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-sm mb-6 relative">
                <x-phosphor-heart-break-fill class="w-10 h-10 text-gray-300" />
                <div
                    class="absolute -bottom-1 -right-1 w-8 h-8 bg-gold-100 rounded-full flex items-center justify-center border-2 border-white">
                    <span class="text-lg">✈️</span>
                </div>
            </div>

            <h3 class="font-serif font-bold text-2xl text-primary-900 mb-2">
                Belum ada paket impian?
            </h3>
            <p class="text-gray-500 max-w-md mx-auto mb-8 leading-relaxed">
                Jangan biarkan niat suci Anda tertunda. Mulailah mencari paket Umroh terbaik dan simpan di sini untuk
                kemudahan perencanaan.
            </p>

            <x-util.button class="shadow-lg shadow-primary-500/20 hover:shadow-primary-500/40 transition-all px-8 py-3"
                variant="primary" wire:navigate href="{{ route('home') }}#packages">
                <span class="mr-2">🔍</span> Jelajahi Paket Umroh
            </x-util.button>
        </div>
        @endif
    </div>
</div>
