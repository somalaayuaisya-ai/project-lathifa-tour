<div>
    <div class="mb-8">
        <h2 class="text-2xl font-serif font-bold text-gray-900">Riwayat Pesanan Paket Anda</h2>
        <p class="text-gray-500 text-sm mt-1">Semua riwayat pemesanan paket umroh Anda di Lathifa Tour.</p>
    </div>

    <x-panel.card>
        <div class="divide-y divide-gray-100">
            @forelse ($bookings as $booking)
                <div class="p-6 flex flex-col sm:flex-row gap-6">
                    <img src="{{ Storage::url($booking->package->featured_image) }}" alt="{{ $booking->package->title }}" class="w-full sm:w-48 h-48 sm:h-auto object-cover rounded-lg">
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs text-primary-600 font-semibold">{{ $booking->package->duration_days }} HARI PERJALANAN</p>
                                <h3 class="font-bold text-lg text-gray-900 mt-1">{{ $booking->package->title }}</h3>
                                <p class="text-sm text-gray-500">Dipesan pada: {{ $booking->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                @php
                                    $statusColors = [
                                        'pending_payment' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-blue-100 text-blue-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-gray-100 text-gray-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$booking->status->value] ?? 'bg-gray-100' }}">
                                    {{ str_replace('_', ' ', $booking->status->value) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 border-t border-gray-100 pt-4 flex justify-between items-center">
                             <div>
                                <p class="text-xs text-gray-500">Total Pembayaran</p>
                                <p class="font-bold text-primary-800 text-lg">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <a wire:navigate href="{{ route('user.bookings.show', $booking) }}" class="btn btn-outline py-2 px-4">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <x-phosphor-briefcase class="w-12 h-12 mx-auto text-gray-300"/>
                    <h3 class="mt-4 font-bold text-lg text-gray-800">Belum Ada Pesanan</h3>
                    <p class="mt-1">Anda belum pernah memesan paket. Mari wujudkan perjalanan ibadah Anda.</p>
                </div>
            @endforelse
        </div>
        
        @if ($bookings->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $bookings->links() }}
            </div>
        @endif
    </x-panel.card>
</div>
