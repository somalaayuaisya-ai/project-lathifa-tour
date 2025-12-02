@props(['package', 'wishlistedPackageIds' => []])

@php
$isWishlisted = in_array($package->id, $wishlistedPackageIds);
@endphp

@php
$formatRupiah = fn($number) => 'Rp ' . number_format($number, 0, ',', '.');
$formatDate = fn($date) => \Carbon\Carbon::parse($date)->isoFormat('D MMMM YYYY');
@endphp

<div class="group card hover:shadow-2xl flex flex-col relative">
    <button wire:click.prevent="toggleWishlist({{ $package->id }})"
        class="absolute top-4 right-4 z-20 w-10 h-10 rounded-full bg-gray-900/60 backdrop-blur-md flex items-center justify-center shadow-md transition hover:scale-110 hover:bg-gray-900/80"
        title="Tambah ke Wishlist">
        <x-phosphor-heart-bold
            class="w-6 h-6 transition duration-300 {{ $isWishlisted ? 'fill-red-500 text-red-500' : ' text-white hover:text-red-500' }}"
            weight="{{ $isWishlisted ? 'fill' : 'bold' }}" />
    </button>

    <div class="relative h-64 overflow-hidden cursor-pointer" wire:click="showPackage({{ $package->id }})">
        <img src="{{ asset('storage/' . $package['featured_image']) }}"
            alt="{{ $package['title'] }}"
            class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
        <div class="absolute top-4 left-4 flex gap-2">
            @if($package['is_featured'])
            <span
                class="bg-gold-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">Featured</span>
            @endif
            <span
                class="bg-primary-800 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">{{
                $package['duration_days'] }} Hari</span>
        </div>
        <div class="absolute bottom-0 left-0 w-full bg-linear-to-t from-black/80 to-transparent p-4 pt-10">
            <p class="text-gold-400 text-xs font-bold uppercase tracking-wider mb-1">Keberangkatan: {{
                $formatDate($package['departure_date']) }}</p>
            <h3 class="text-xl font-serif font-bold text-white leading-tight">{{ $package['title'] }}</h3>
        </div>
    </div>

    <div class="p-6 flex flex-col grow">
        <div class="space-y-3 mb-6 text-sm text-gray-600">
            <div class="flex items-center gap-3">
                <div class="w-6 flex justify-center"><span class="text-lg">🕋</span></div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Makkah</p>
                    <p class="font-semibold text-primary-900 line-clamp-1">{{ $package['hotel_makkah'] }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-6 flex justify-center"><span class="text-lg">🕌</span></div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Madinah</p>
                    <p class="font-semibold text-primary-900 line-clamp-1">{{ $package['hotel_madinah'] }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-6 flex justify-center"><span class="text-lg">✈️</span></div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Maskapai</p>
                    <p class="font-semibold text-primary-900 line-clamp-1">{{ $package['airline_name'] }}</p>
                </div>
            </div>
        </div>

        <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-end">
            <div>
                <p class="text-xs text-gray-400 mb-1">Mulai dari (Quad)</p>
                <p class="text-2xl font-bold text-primary-800">{{ $formatRupiah($package['price_quad']) }}</p>
            </div>
            <button wire:click="showPackage({{ $package['id'] }})" class="btn btn-icon btn-outline">
                ➜
            </button>
        </div>
    </div>
</div>