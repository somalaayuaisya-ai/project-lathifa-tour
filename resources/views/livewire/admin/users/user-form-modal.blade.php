<x-util.modal wire:model.live="modalOpen" maxWidth="3xl">
    <form wire:submit.prevent="save" class="p-6">
        <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6">
            {{ $userId ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
        </h2>

        <div class="grid grid-cols-1 gap-6">
            {{-- Name --}}
            <div>
                <x-util.form.label for="name" value="Nama Lengkap" />
                <x-util.form.input wire:model="name" id="name" type="text" class="mt-1 block w-full" />
                @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Email --}}
            <div>
                <x-util.form.label for="email" value="Email" />
                <x-util.form.input wire:model="email" id="email" type="email" class="mt-1 block w-full" />
                @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Phone --}}
            <div>
                <x-util.form.label for="phone" value="Nomor Telepon" />
                <x-util.form.input wire:model="phone" id="phone" type="tel" class="mt-1 block w-full" />
                @error('phone') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            
            {{-- Role --}}
            <div>
                <x-util.form.label for="role" value="Role" />
                <select wire:model="role" id="role" class="mt-1 block w-full bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                    @foreach(\App\Enums\UserRole::cases() as $role)
                        <option value="{{ $role->value }}">{{ ucfirst($role->value) }}</option>
                    @endforeach
                </select>
                @error('role') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Password --}}
            <div>
                <x-util.form.label for="password" value="Password" />
                <x-util.form.input wire:model="password" id="password" type="password" class="mt-1 block w-full" placeholder="{{ $userId ? 'Isi untuk mengubah password' : '' }}" />
                @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Password Confirmation --}}
            <div>
                <x-util.form.label for="password_confirmation" value="Konfirmasi Password" />
                <x-util.form.input wire:model="password_confirmation" id="password_confirmation" type="password" class="mt-1 block w-full" />
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
            <x-util.button type="button" variant="outline" wire:click="closeModal">
                Batal
            </x-util.button>
            <x-util.button type="submit" wire:target="save">
                {{ $userId ? 'Simpan Perubahan' : 'Buat Pengguna' }}
            </x-util.button>
        </div>
    </form>
</x-util.modal>
