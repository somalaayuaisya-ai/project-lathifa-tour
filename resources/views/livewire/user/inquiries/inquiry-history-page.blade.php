<div>
    <div class="mb-8">
        <h2 class="text-2xl font-serif font-bold text-gray-900">Riwayat Percakapan</h2>
        <p class="text-gray-500 text-sm mt-1">Daftar paket yang pernah Anda tanyakan via WhatsApp.</p>
    </div>

    @if($inquiries->count() > 0)
    <div class="space-y-4">
        @foreach($inquiries as $inquiry)
        <div
            class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row gap-4">

            {{-- Gambar Paket --}}
            <div class="w-full md:w-24 h-24 shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                @if($inquiry->package)
                <img src="{{ $inquiry->package->featured_image }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">Paket Dihapus</div>
                @endif
            </div>

            {{-- Detail Inquiry --}}
            <div class="grow flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-start">
                        <h4 class="font-bold text-gray-900">
                            {{ $inquiry->package->title ?? 'Paket Tidak Tersedia' }}
                        </h4>
                        <span class="text-xs text-gray-400 whitespace-nowrap">
                            {{ $inquiry->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1 line-clamp-2 italic">
                        "{{ $inquiry->message }}"
                    </p>
                </div>

                <div class="flex items-center justify-between mt-3">
                    {{-- Status Badge --}}
                    @php
                    $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'contacted' => 'bg-blue-100 text-blue-800',
                    'closed' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                    ];
                    // Pastikan property status di model dikonversi ke string/value jika pakai Enum
                    $statusValue = is_object($inquiry->status) ? $inquiry->status->value : $inquiry->status;
                    $badgeColor = $statusColors[$statusValue] ?? 'bg-gray-100 text-gray-800';
                    @endphp

                    <span
                        class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $badgeColor }}">
                        {{ $statusValue }}
                    </span>

                    {{-- Button Action --}}
                    <a href="https://wa.me/6285810975143?text={{ urlencode($inquiry->message) }}" target="_blank"
                        class="text-xs font-semibold text-primary-600 hover:text-primary-800 flex items-center gap-1">
                        <x-phosphor-whatsapp-logo class="w-4 h-4" />
                        Chat Lagi
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $inquiries->links() }}
    </div>
    @else
    {{-- Empty State --}}
    <div class="text-center py-12 bg-gray-50 rounded-xl border-dashed border-2 border-gray-200">
        <x-phosphor-chat-teardrop-text class="w-12 h-12 text-gray-300 mx-auto mb-3" />
        <h3 class="text-gray-900 font-bold">Belum ada riwayat</h3>
        <p class="text-gray-500 text-sm mb-4">Anda belum pernah menanyakan paket apapun.</p>
        <a href="{{ route('home') }}#packages" wire:navigate class="text-primary-600 font-bold text-sm hover:underline">
            Cari Paket Sekarang
        </a>
    </div>
    @endif
</div>
