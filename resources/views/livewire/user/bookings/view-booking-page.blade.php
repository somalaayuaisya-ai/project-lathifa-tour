<div>
    <div class="mb-8">
        <h2 class="text-2xl font-serif font-bold text-gray-900">Detail Pesanan #{{ $booking->id }}</h2>
        <p class="text-gray-500 text-sm mt-1">Dipesan pada {{ $booking->created_at->format('d M Y') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            <x-panel.card>
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row gap-6">
                        <img src="{{ Storage::url($booking->package->featured_image) }}" alt="{{ $booking->package->title }}" class="w-full sm:w-32 h-32 object-cover rounded-lg">
                        <div class="flex-1">
                             <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900">{{ $booking->package->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $booking->package->duration_days }} Hari &middot; {{ $booking->package->airline_name }}</p>
                                </div>
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
                                    {{ str_replace('_', ' ', Str::title($booking->status->value)) }}
                                </span>
                             </div>
                        </div>
                    </div>
                </div>
            </x-panel.card>

            <x-panel.card>
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Rencana Perjalanan (Itinerary)</h3>
                </div>
                <div class="p-6">
                     <div class="border-l-2 border-primary-100 ml-2 space-y-6 pl-6 relative">
                        @foreach ($booking->package->itineraries as $day)
                            <div class="relative">
                                <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full border-2 border-white shadow-sm bg-primary-500"></div>
                                <div class="text-xs font-bold text-primary-500 mb-1">Hari ke-{{ $day['day_number'] }}</div>
                                <div class="font-bold text-gray-900 text-sm mb-1">{{ $day['title'] }}</div>
                                <div class="text-xs text-gray-500 leading-relaxed">{{ $day['description'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-panel.card>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            <x-panel.card>
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Rincian Pembayaran</h3>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Total Tagihan:</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-6 border-t border-gray-100 pt-4">
                        @if($booking->status === \App\Enums\BookingStatus::PENDING_PAYMENT)
                            <h4 class="font-semibold text-gray-800 mb-2">Instruksi Pembayaran</h4>
                            <p class="text-sm text-gray-600 mb-4">Silakan lakukan pembayaran ke rekening berikut dan upload bukti pembayaran Anda.</p>
                            <div class="p-3 bg-gray-50 rounded-lg text-sm">
                                <p>Bank Syariah Indonesia (BSI)</p>
                                <p class="font-bold text-lg text-primary-800">7123456789</p>
                                <p>a.n. PT Lathifa Tour & Travel</p>
                            </div>

                            <form wire:submit.prevent="uploadProof" class="mt-4">
                                <x-util.form.label value="Upload Bukti Bayar" />
                                <input type="file" wire:model="paymentProofUpload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 mt-1">
                                <div wire:loading wire:target="paymentProofUpload" class="text-sm text-gray-500 mt-2">Uploading...</div>
                                @error('paymentProofUpload') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                                
                                @if ($paymentProofUpload)
                                    <div class="mt-4">
                                        <p class="text-sm font-semibold mb-2">Pratinjau:</p>
                                        <img src="{{ $paymentProofUpload->temporaryUrl() }}" class="rounded-lg w-full object-cover">
                                    </div>
                                @endif

                                <x-util.button type="submit" variant="primary" class="w-full mt-4" wire:target="uploadProof">
                                    Upload & Konfirmasi
                                </x-util.button>
                            </form>
                        @elseif($booking->status === \App\Enums\BookingStatus::PAID)
                             <div class="text-center text-blue-800 bg-blue-50 p-4 rounded-lg">
                                <x-phosphor-check-circle-bold class="w-8 h-8 mx-auto mb-2"/>
                                <p class="text-sm font-semibold">Terima kasih! Bukti pembayaran Anda sedang kami verifikasi.</p>
                            </div>
                        @elseif($booking->status === \App\Enums\BookingStatus::CONFIRMED)
                            <div class="text-center text-green-800 bg-green-50 p-4 rounded-lg">
                                <x-phosphor-seal-check-bold class="w-8 h-8 mx-auto mb-2"/>
                                <p class="text-sm font-semibold">Pesanan Anda telah dikonfirmasi! Selamat menikmati perjalanan ibadah Anda.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </x-panel.card>
        </div>
    </div>
</div>
