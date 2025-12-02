<div>
    <x-panel.card>
        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="font-serif font-bold text-lg text-gray-900">Inquiries Masuk</h3>
            <p class="text-sm text-gray-500">Kelola semua leads dan calon jamaah yang masuk.</p>
        </div>

        <div class="p-6">
            <x-panel.toolbar>
                <x-slot:search>
                    <div class="relative w-full">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Cari nama, telepon..."
                            class="pl-10 pr-4 py-2.5 w-full bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        />
                        <x-phosphor-magnifying-glass class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                    </div>
                </x-slot:search>

                <x-slot:filters>
                    <select wire:model.live="filterStatus" class="bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Status</option>
                        <option value="new">Baru</option>
                        <option value="contacted">Sudah Dihubungi</option>
                        <option value="spam">Spam</option>
                    </select>
                </x-slot:filters>
            </x-panel.toolbar>

            @php
                $table = (new \App\Livewire\Admin\Inquiries\ManageInquiries());
            @endphp
            <x-panel.table :packages="$inquiries">
                <x-slot:head>
                    <th class="px-6 py-4">Calon Jamaah</th>
                    <th class="px-6 py-4">Paket Diminati</th>
                    <th class="px-6 py-4">Tanggal Masuk</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </x-slot:head>
                <x-slot:body>
                    @forelse ($inquiries as $inquiry)
                        <tr wire:key="{{ $inquiry->id }}" class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $inquiry->guest_name ?? $inquiry->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $inquiry->guest_phone ?? $inquiry->user->phone }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700">{{ $inquiry->package->title }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-500">{{ $inquiry->created_at->format('d M Y, H:i') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <x-panel.status-dropdown :inquiry="$inquiry" />
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="https://wa.me/{{ $inquiry->guest_phone ?? $inquiry->user->phone }}" target="_blank" class="inline-block text-gray-400 hover:text-green-600 mx-1" title="Hubungi via WhatsApp">
                                    <x-phosphor-whatsapp-logo-bold class="w-5 h-5"/>
                                </a>
                                <button
                                    type="button"
                                    wire:click="deleteInquiry({{ $inquiry->id }})"
                                    wire:confirm="Anda yakin ingin menghapus inquiry ini?"
                                    class="text-gray-400 hover:text-red-600 mx-1"
                                    title="Hapus Inquiry"
                                >
                                    <x-phosphor-trash class="w-5 h-5"/>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                <div class="py-8">
                                    <x-phosphor-folder-open class="w-12 h-12 mx-auto text-gray-300"/>
                                    <p class="mt-2">Tidak ada inquiry ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-panel.table>
        </div>
    </x-panel.card>
</div>
