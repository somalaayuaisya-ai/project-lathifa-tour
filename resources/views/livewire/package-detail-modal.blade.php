<x-util.modal name="package-detail" maxWidth="5xl" wire:model="modalOpen">
    @if ($package)
    <div x-data="{
            activeImage: '{{ $activeImage }}',
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
            }
        }" class="flex flex-col lg:flex-row h-full max-h-[90vh]">
        {{-- Image Gallery --}}
        <div class="lg:w-5/12 bg-gray-100 relative flex flex-col">
            <div class="h-64 lg:h-3/4 relative">
                <img :src="activeImage" class="w-full h-full object-cover transition duration-300">
            </div>
            <div class="h-auto lg:h-1/4 bg-primary-900 p-4 flex gap-3 overflow-x-auto hide-scrollbar">
                <img src="{{ asset('storage/' . $package['featured_image']) }}"
                    @click="activeImage = '{{ asset('storage/' . $package['featured_image']) }}'"
                    class="h-full aspect-square object-cover rounded-lg cursor-pointer border-2"
                    :class="activeImage === '{{ asset('storage/' . $package['featured_image']) }}' ? 'border-gold-500' : 'border-transparent opacity-60 hover:opacity-100'">

                @foreach ($package['galleries'] as $gallery)
                <img src="{{asset('storage/'. $gallery['image_url']) }}" @click="activeImage = '{{asset('storage/' . $gallery['image_url']) }}'"
                    class="h-full aspect-square object-cover rounded-lg cursor-pointer border-2"
                    :class="activeImage === '{{asset('storage/'. $gallery['image_url']) }}' ? 'border-gold-500' : 'border-transparent opacity-60 hover:opacity-100'">
                @endforeach
            </div>
        </div>

        {{-- Package Details --}}
        <div class="lg:w-7/12 p-6 lg:p-8 overflow-y-auto bg-white relative">
            <div class="mb-6">
                <span class="text-primary-800 font-bold text-sm uppercase tracking-wider mb-1 block">{{
                    $package['duration_days'] }} HARI PERJALANAN</span>
                <h2 class="text-3xl font-serif font-bold text-gray-900 leading-tight mb-2">{{ $package['title'] }}</h2>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $package['description'] }}</p>
            </div>

            {{-- Price Tiers --}}
            <div class="bg-sand rounded-xl p-4 mb-8 border border-gold-500/20">
                <h3 class="font-bold text-primary-900 mb-3 text-sm uppercase flex items-center">
                    <span class="w-2 h-2 rounded-full bg-gold-500 mr-2"></span> Pilihan Kamar
                </h3>
                <div class="grid grid-cols-3 gap-2 md:gap-4 text-center">
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-[10px] text-gray-400 font-bold uppercase">Quad (4)</div>
                        <div class="text-primary-800 font-bold text-sm md:text-base"
                            x-text="formatRupiah({{ $package['price_quad'] }})"></div>
                    </div>
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-[10px] text-gray-400 font-bold uppercase">Triple (3)</div>
                        <div class="text-primary-800 font-bold text-sm md:text-base"
                            x-text="formatRupiah({{ $package['price_triple'] }})"></div>
                    </div>
                    <div class="bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-[10px] text-gray-400 font-bold uppercase">Double (2)</div>
                        <div class="text-primary-800 font-bold text-sm md:text-base"
                            x-text="formatRupiah({{ $package['price_double'] }})"></div>
                    </div>
                </div>
            </div>

            {{-- Itinerary --}}
            <div class="mb-8">
                <h3 class="font-bold text-gray-900 mb-4 font-serif text-lg">Rencana Perjalanan</h3>
                <div class="border-l-2 border-primary-100 ml-2 space-y-6 pl-6 relative">
                    @foreach ($package['itineraries'] as $day)
                    <div class="relative">
                        <div
                            class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-2 border-white shadow-sm bg-primary-500">
                        </div>
                        <div class="text-xs font-bold text-primary-500 mb-1">Hari ke-{{ $day['day_number'] }}</div>
                        <div class="font-bold text-gray-900 text-sm mb-1">{{ $day['title'] }}</div>
                        <div class="text-xs text-gray-500 leading-relaxed">{{ $day['description'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Sticky Footer Button --}}
            <div class="sticky bottom-0 bg-white/95 backdrop-blur pt-4 border-t border-gray-100 mt-auto">
                <x-util.button wire:click="bookViaWA" wire:target="bookViaWA" class="w-full">
                    <x-slot:icon>
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                    </x-slot:icon>
                    Book via WhatsApp
                </x-util.button>
            </div>
        </div>
    </div>
    @endif
</x-util.modal>