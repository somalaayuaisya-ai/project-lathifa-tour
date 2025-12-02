@props(['months', 'types'])

<header class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-primary-900/70 via-primary-900/40 to-sand"></div>
    </div>

    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-20">
        <div class="inline-block mb-4 px-4 py-1 rounded-full bg-white/10 backdrop-blur border border-white/20 text-white text-sm font-medium">
            ✨ Izin Resmi PPIU No. 123/2024
        </div>
        <h1 class="text-5xl md:text-7xl font-serif font-bold text-white mb-6 leading-tight drop-shadow-lg">
            Rindu Baitullah? <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-gold-400 to-gold-200 italic">Wujudkan Sekarang</span>
        </h1>
        <p class="text-lg text-white/90 mb-10 font-light max-w-2xl mx-auto">
            Kami menyediakan paket umroh dengan fasilitas hotel terbaik di Makkah & Madinah, dibimbing sesuai sunnah.
        </p>

        {{-- <div class="bg-white p-2 rounded-2xl shadow-2xl max-w-3xl mx-auto flex flex-col md:flex-row gap-2">
            <div class="flex-1 px-4 py-2 border-b md:border-b-0 md:border-r border-gray-100 text-left">
                <label class="text-xs font-bold text-gray-400 uppercase">Keberangkatan</label>
                <select wire:model.live="filterMonth" class="w-full bg-transparent font-bold text-gray-800 focus:outline-none cursor-pointer mt-1">
                    <option value="">Semua Bulan</option>
                    @foreach($months as $month)
                        <option value="{{ $month->month_value }}">{{ $month->month_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 px-4 py-2 text-left">
                <label class="text-xs font-bold text-gray-400 uppercase">Jenis Paket</label>
                <select wire:model.live="filterType" class="w-full bg-transparent font-bold text-gray-800 focus:outline-none cursor-pointer mt-1">
                    <option value="">Semua Jenis</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <x-util.button class="px-8 py-3" wire:click="$refresh">
                Cari
            </x-util.button>
        </div> --}}
    </div>
</header>
