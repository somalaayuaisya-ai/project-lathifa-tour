<div>
    <x-panel.card>
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="font-serif font-bold text-lg text-gray-900">Manajemen Pengguna</h3>
                <p class="text-sm text-gray-500">Kelola semua pengguna terdaftar (Jamaah & Admin).</p>
            </div>
            <div>
                <x-util.button 
                    type="button" 
                    variant="primary"
                    wire:click="$dispatch('open-user-form')"
                >
                    <x-slot:icon>
                        <x-phosphor-plus-bold class="w-4 h-4"/>
                    </x-slot:icon>
                    Tambah Pengguna
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
                            placeholder="Cari nama, email, telepon..."
                            class="pl-10 pr-4 py-2.5 w-full bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        />
                        <x-phosphor-magnifying-glass class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                    </div>
                </x-slot:search>

                <x-slot:filters>
                    <select wire:model.live="filterRole" class="bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Semua Role</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </x-slot:filters>
            </x-panel.toolbar>

            <x-panel.table :packages="$users">
                <x-slot:head>
                    <th class="px-6 py-4">Pengguna</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Telepon</th>
                    <th class="px-6 py-4">Tanggal Bergabung</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </x-slot:head>
                <x-slot:body>
                    @forelse ($users as $user)
                        <tr wire:key="{{ $user->id }}" class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <x-panel.user-info :user="$user" />
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->role->value === 'admin' ? 'bg-primary-100 text-primary-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $user->role->value }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->phone ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    type="button"
                                    wire:click="$dispatch('open-user-form', { userId: {{ $user->id }} })"
                                    class="text-gray-400 hover:text-primary-600 mx-1"
                                    title="Edit Pengguna"
                                >
                                    <x-phosphor-pencil class="w-5 h-5"/>
                                </button>
                                @if(Auth::id() !== $user->id)
                                <button
                                    type="button"
                                    wire:click="deleteUser({{ $user->id }})"
                                    wire:confirm="Anda yakin ingin menghapus pengguna ini?"
                                    class="text-gray-400 hover:text-red-600 mx-1"
                                    title="Hapus Pengguna"
                                >
                                    <x-phosphor-trash class="w-5 h-5"/>
                                </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <x-phosphor-users-four class="w-12 h-12 mx-auto text-gray-300"/>
                                <p class="mt-2">Tidak ada pengguna ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </x-slot:body>
            </x-panel.table>
        </div>
    </x-panel.card>

    <livewire:admin.users.user-form-modal />
</div>
