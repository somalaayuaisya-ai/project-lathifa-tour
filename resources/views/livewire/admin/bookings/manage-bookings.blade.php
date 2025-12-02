<div>
    <x-panel.card>
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="font-serif font-bold text-lg text-gray-900">Manajemen Booking</h3>
                <p class="text-sm text-gray-500">Kelola semua pesanan paket yang masuk.</p>
            </div>
             <div>
                <x-util.button 
                    type="button" 
                    variant="primary"
                    wire:click="$dispatch('open-booking-form')"
                >
                    <x-slot:icon>
                        <x-phosphor-plus-bold class="w-4 h-4"/>
                    </x-slot:icon>
                    Tambah Booking Manual
                </x-util.button>
            </div>
        </div>
        <div class="p-6">
            <x-panel.table :packages="$bookings">
                 <x-slot:head>
                    <th class="px-6 py-4">Jamaah</th>
                    <th class="px-6 py-4">Paket</th>
                    <th class="px-6 py-4">Total Bayar</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Tgl. Pesan</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </x-slot:head>
                <x-slot:body>
                    @forelse ($bookings as $booking)
                        <tr wire:key="{{ $booking->id }}" class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <x-panel.user-info :user="$booking->user" />
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $booking->package->title }}
                            </td>
                             <td class="px-6 py-4">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </td>
                             <td class="px-6 py-4">
                                {{ $booking->status->value }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $booking->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="$dispatch('open-booking-form', { bookingId: {{ $booking->id }} })" class="text-gray-400 hover:text-primary-600 mx-1" title="Edit Booking">
                                    <x-phosphor-pencil-simple-line-bold class="w-5 h-5"/>
                                </button>
                                <a href="https://wa.me/{{ $booking->user->phone }}" target="_blank" class="inline-block text-gray-400 hover:text-green-600 mx-1" title="Hubungi via WhatsApp">
                                    <x-phosphor-whatsapp-logo-bold class="w-5 h-5"/>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <x-phosphor-briefcase class="w-12 h-12 mx-auto text-gray-300"/>
                                <p class="mt-2">Belum ada data booking.</p>
                            </td>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-panel.table>
        </div>
    </x-panel.card>
    
    <livewire:admin.bookings.booking-form-modal />
</div>
