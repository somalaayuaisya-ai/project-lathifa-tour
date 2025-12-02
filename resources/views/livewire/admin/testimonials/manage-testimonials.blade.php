<div>
    <x-panel.card>
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="font-serif font-bold text-lg text-gray-900">Manajemen Testimoni</h3>
                <p class="text-sm text-gray-500">Kelola testimoni yang akan ditampilkan di halaman utama.</p>
            </div>
            <div>
                <x-util.button 
                    type="button" 
                    variant="primary"
                    wire:click="$dispatch('open-testimonial-form')"
                >
                    <x-slot:icon><x-phosphor-plus-bold class="w-4 h-4"/></x-slot:icon>
                    Tambah Testimoni
                </x-util.button>
            </div>
        </div>

        <div class="p-6">
            <x-panel.toolbar>
                 <x-slot:search>
                    <div class="relative w-full">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Cari nama atau isi testimoni..."
                            class="pl-10 pr-4 py-2.5 w-full bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        />
                        <x-phosphor-magnifying-glass class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                    </div>
                </x-slot:search>

                <x-slot:filters>
                    <select wire:model.live="filterStatus" class="bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Status</option>
                        <option value="1">Ditampilkan</option>
                        <option value="0">Disembunyikan</option>
                    </select>
                </x-slot:filters>
            </x-panel.toolbar>

            <x-panel.table :packages="$testimonials">
                <x-slot:head>
                    <th class="px-6 py-4">Pengirim</th>
                    <th class="px-6 py-4">Isi Testimoni</th>
                    <th class="px-6 py-4 text-center">Rating</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </x-slot:head>
                <x-slot:body>
                    @forelse ($testimonials as $testimonial)
                        <tr wire:key="{{ $testimonial->id }}" class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <x-panel.user-info :user="$testimonial" />
                            </td>
                            <td class="px-6 py-4 text-gray-600 max-w-sm">
                                <p class="line-clamp-2">{{ $testimonial->content }}</p>
                            </td>
                            <td class="px-6 py-4 text-center text-yellow-500 flex justify-center items-center">
                                {{ $testimonial->rating }} <x-phosphor-star-fill class="w-4 h-4 ml-1"/>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <x-panel.toggle-switch :model="$testimonial" field="is_show" onText="Tampil" offText="Sembunyi" wire:click="toggleShow({{ $testimonial->id }})" />
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button type="button" wire:click="$dispatch('open-testimonial-form', { testimonialId: {{ $testimonial->id }} })" class="text-gray-400 hover:text-primary-600 mx-1" title="Edit">
                                    <x-phosphor-pencil class="w-5 h-5"/>
                                </button>
                                <button type="button" wire:click="deleteTestimonial({{ $testimonial->id }})" wire:confirm="Anda yakin ingin menghapus testimoni ini?" class="text-gray-400 hover:text-red-600 mx-1" title="Hapus">
                                    <x-phosphor-trash class="w-5 h-5"/>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <p>Tidak ada testimoni ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-panel.table>
        </div>
    </x-panel.card>
    
    <livewire:admin.testimonials.testimonial-form-modal />
</div>
