<div>
    <h2 class="text-2xl font-serif font-bold text-gray-900 mb-2">Assalamualaikum, {{ Auth::user()->name }}!</h2>
    <p class="text-gray-500 text-sm mt-1 mb-8">Selamat datang di dashboard pribadi Anda. Berikut adalah ringkasan aktivitas Anda.</p>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <x-panel.stat-card 
            title="Paket Di-Wishlist" 
            :value="$wishlistCount"
            icon="heart-straight" 
            icon-style="fill" 
            icon-color-class="bg-red-50 text-red-500"
        />
        <x-panel.stat-card 
            title="Inquiry Terkirim" 
            :value="$inquiryCount"
            icon="whatsapp-logo" 
            icon-style="fill" 
            icon-color-class="bg-primary-50 text-primary-600"
        />
        <x-panel.stat-card 
            title="Paket Dipesan" 
            value="0" {{-- Placeholder for future --}}
            icon="airplane-tilt" 
            icon-style="fill" 
            icon-color-class="bg-gold-50 text-gold-600"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Wishlisted Packages --}}
        <div>
            <x-panel.card>
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-serif font-bold text-lg text-gray-900">Wishlist Paket Anda</h3>
                    <p class="text-sm text-gray-500">Paket-paket yang Anda minati.</p>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse ($wishlistedPackages as $package)
                        <div wire:key="wishlist-{{ $package->id }}" class="p-4">
                            <x-panel.wishlist-item :package="$package" />
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            <x-phosphor-heart-break-bold class="w-12 h-12 mx-auto text-gray-300"/>
                            <p class="mt-2">Belum ada paket di wishlist Anda.</p>
                            <a wire:navigate href="{{ route('home') }}#packages" class="mt-4 inline-flex items-center gap-2 text-primary-600 hover:underline">
                                <x-phosphor-plus-bold class="w-4 h-4"/> Tambah ke Wishlist
                            </a>
                        </div>
                    @endforelse
                </div>
            </x-panel.card>
        </div>

        {{-- Latest Inquiry --}}
        <div>
            <x-panel.card>
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-serif font-bold text-lg text-gray-900">Inquiry Terakhir Anda</h3>
                    <p class="text-sm text-gray-500">Status inquiry paket terakhir yang Anda ajukan.</p>
                </div>
                <div class="p-6">
                    @if ($latestInquiry)
                        <div class="mb-4">
                            <p class="text-xs text-gray-400 uppercase font-bold">Paket</p>
                            <p class="font-semibold text-gray-900">{{ $latestInquiry->package->title }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-gray-400 uppercase font-bold">Tanggal Kirim</p>
                            <p class="font-semibold text-gray-900">{{ $latestInquiry->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-gray-400 uppercase font-bold">Status</p>
                            <p class="font-semibold text-gray-900">
                                @php
                                    $statusColors = [
                                        'new' => 'bg-blue-100 text-blue-800',
                                        'contacted' => 'bg-green-100 text-green-800',
                                        'spam' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$latestInquiry->status->value] }}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ str_replace(['-100', '-800'], ['-500', ''], $statusColors[$latestInquiry->status->value]) }}"></span>
                                    {{ $latestInquiry->status->value }}
                                </span>
                            </p>
                        </div>
                        <div class="mt-6 border-t border-gray-100 pt-4 text-center">
                            <a href="#" class="text-primary-600 hover:underline text-sm">Lihat Semua Inquiry Anda</a>
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <x-phosphor-chat-centered-text-bold class="w-12 h-12 mx-auto text-gray-300"/>
                            <p class="mt-2">Belum ada inquiry yang Anda kirim.</p>
                            <a wire:navigate href="{{ route('home') }}#packages" class="mt-4 inline-flex items-center gap-2 text-primary-600 hover:underline">
                                <x-phosphor-plus-bold class="w-4 h-4"/> Kirim Inquiry Pertama Anda
                            </a>
                        </div>
                    @endif
                </div>
            </x-panel.card>
        </div>
    </div>
</div>
