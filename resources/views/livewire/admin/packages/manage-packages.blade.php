<x-panel.card>
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="font-serif font-bold text-lg text-gray-900">Manajemen Paket</h3>
        <p class="text-sm text-gray-500">Kelola daftar paket umroh Lathifa Tour.</p>
    </div>

    <div class="p-6">
        <x-panel.toolbar>
            <x-slot:search>
                <div class="relative">
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari paket, hotel, maskapai..."
                        class="pl-10 pr-4 py-2.5 w-full bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                    />
                    <x-phosphor-magnifying-glass class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                </div>
            </x-slot:search>

            <x-slot:filters>
                <select wire:model.live="filterStatus" class="bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </x-slot:filters>

            <x-slot:sort>
                <div class="flex items-center gap-3">
                    <select wire:model.live="sortBy" class="bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                        <option value="departure_date">Tanggal Berangkat</option>
                        <option value="title">Nama Paket</option>
                        <option value="price_quad">Harga (Termurah)</option>
                    </select>
                    <button wire:click="toggleSortDirection" class="p-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 transition">
                        <x-dynamic-component :component="$sortDirection === 'asc' ? 'phosphor-arrow-up-bold' : 'phosphor-arrow-down-bold'" class="w-5 h-5" />
                    </button>
                </div>
            </x-slot:sort>

            <x-slot:actions>
                 <x-util.button 
                    type="button" 
                    variant="primary"
                    wire:click="$dispatch('open-package-form')"
                 >
                    <x-slot:icon>
                        <x-phosphor-plus-bold class="w-4 h-4"/>
                    </x-slot:icon>
                    Tambah Paket
                </x-util.button>
            </x-slot:actions>
        </x-panel.toolbar>

        <x-panel.table :packages="$packages">
            <x-slot:head>
                <th class="px-6 py-4">Paket</th>
                <th class="px-6 py-4">Tanggal Berangkat</th>
                <th class="px-6 py-4">Harga Quad</th>
                <th class="px-6 py-4 text-center">Aktif</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </x-slot:head>
            <x-slot:body>
                @forelse ($packages as $package)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $package->title }}</div>
                            <div class="text-xs text-gray-500">{{ $package->airline_name }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $package->departure_date->format('d M Y') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($package->price_quad, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <x-panel.toggle-switch :model="$package" field="is_active" wire:click="toggleActive({{ $package->id }})" />
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button
                                type="button"
                                wire:click="$dispatch('open-package-form', { packageId: {{ $package->id }} })"
                                class="text-gray-400 hover:text-primary-600 mx-1"
                                title="Edit Paket"
                            >
                                <x-phosphor-pencil class="w-5 h-5"/>
                            </button>
                            <button
                                type="button"
                                wire:click="deletePackage({{ $package->id }})"
                                wire:confirm="Anda yakin ingin menghapus paket ini? Aksi ini tidak dapat dibatalkan."
                                class="text-gray-400 hover:text-red-600 mx-1"
                                title="Hapus Paket"
                            >
                                <x-phosphor-trash class="w-5 h-5"/>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada paket ditemukan.</td>
                    </tr>
                @endforelse
            </x-slot:body>
        </x-panel.table>
    </div>

    <livewire:admin.packages.package-form-modal />
</x-panel.card>
