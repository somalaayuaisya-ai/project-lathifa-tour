@props(['package'])

@php
$formatRupiah = fn($number) => 'Rp ' . number_format($number, 0, ',', '.');
// Helper sederhana untuk icon hotel (opsional, bisa hardcode icon juga)
@endphp

<div
    class="group relative flex flex-col h-full bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300">

    {{-- 1. Bagian Atas: Gambar & Floating Actions --}}
    <div class="relative h-48 overflow-hidden">
        {{-- Gambar Paket --}}
        <img src="{{ $package->featured_image }}" alt="{{ $package->title }}"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

        {{-- Overlay Gradient (Supaya teks putih terbaca jika ada) --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60"></div>

        {{-- Badge Durasi --}}
        <div class="absolute top-4 left-4">
            <span
                class="bg-white/95 backdrop-blur text-primary-900 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                {{ $package->duration_days ?? '9' }} Hari
            </span>
        </div>

        {{-- Tombol Hapus (Floating) --}}
        <button wire:click="removeBookmark({{ $package->id }})" wire:loading.attr="disabled"
            class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-md hover:bg-red-500 text-white flex items-center justify-center transition-all duration-300 group/btn"
            title="Hapus dari Wishlist">
            {{-- Icon Default --}}
            <x-phosphor-trash-bold class="w-4 h-4 block group-hover/btn:hidden" />
            {{-- Icon Hover (Broken Heart) --}}
            <x-phosphor-heart-break-fill class="w-4 h-4 hidden group-hover/btn:block" />
        </button>
    </div>

    {{-- 2. Bagian Tengah: Informasi Paket --}}
    <div class="p-5 flex flex-col grow">
        {{-- Judul --}}
        <h4
            class="font-serif font-bold text-lg text-gray-900 leading-tight mb-3 line-clamp-2 group-hover:text-primary-800 transition-colors">
            {{ $package->title }}
        </h4>

        {{-- Info Hotel (Grid) --}}
        <div class="space-y-2 mb-6">
            <div class="flex items-start gap-3">
                <div class="w-5 flex justify-center text-gold-500 mt-0.5"><span class="text-xs">🕋</span></div>
                <div class="text-xs">
                    <span class="block text-gray-400 font-bold uppercase text-[10px]">Makkah</span>
                    <span class="text-gray-700 font-medium line-clamp-1">{{ $package->hotel_makkah }}</span>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="w-5 flex justify-center text-gold-500 mt-0.5"><span class="text-xs">🕌</span></div>
                <div class="text-xs">
                    <span class="block text-gray-400 font-bold uppercase text-[10px]">Madinah</span>
                    <span class="text-gray-700 font-medium line-clamp-1">{{ $package->hotel_madinah }}</span>
                </div>
            </div>
        </div>

        {{-- 3. Bagian Bawah: Harga & Tombol --}}
        <div class="mt-auto pt-4 border-t border-dashed border-gray-200">
            <div class="flex flex-col gap-3">
                <div>
                    <p class="text-[10px] text-gray-400 mb-0.5">Mulai dari</p>
                    <p class="text-xl font-bold text-primary-800">
                        {{ $formatRupiah($package->price_quad) }}
                    </p>
                </div>

                <a href="{{ route('home') }}#packages" wire:navigate
                    class="w-full text-center bg-primary-50 hover:bg-primary-900 text-primary-800 hover:text-white font-semibold text-xs py-2.5 rounded-lg transition-all duration-300 border border-primary-100 hover:border-primary-900">
                    Lihat Detail Paket ➜
                </a>
            </div>
        </div>
    </div>
</div>
