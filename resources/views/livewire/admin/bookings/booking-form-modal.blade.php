<x-util.modal wire:model.live="modalOpen" maxWidth="3xl">
    <form wire:submit.prevent="save" class="p-6">
        <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6">
            {{ $bookingId ? 'Edit Booking' : 'Tambah Booking Manual' }}
        </h2>

        <div class="grid grid-cols-1 gap-6">
            {{-- User Search --}}
            <div x-data="{}" @click.away="$wire.set('users', []); $wire.set('userSearch', $wire.get('selectedUserName'))">
                <x-util.form.label for="userSearch" value="Cari & Pilih Jamaah" />
                <div class="relative">
                    <x-util.form.input wire:model.live.debounce.300ms="userSearch" id="userSearch" type="text" class="mt-1" placeholder="Ketik nama atau email..." autocomplete="off" />
                    
                    @if (!empty($userSearch) && !empty($users))
                        <div class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg">
                            @forelse($users as $user)
                                <div wire:click="selectUser({{ $user->id }})" class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                                   <p class="font-semibold">{{ $user->name }}</p>
                                   <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            @empty
                                <p class="px-4 py-2 text-sm text-gray-500">User tidak ditemukan.</p>
                            @endforelse
                        </div>
                    @endif
                </div>
                <input type="hidden" wire:model="user_id"> {{-- Hidden input to bind selected user ID --}}
                @error('user_id') <span class="text-red-500 text-sm mt-1">Jamaah harus dipilih.</span> @enderror
            </div>
            
            {{-- Package --}}
            <div>
                <x-util.form.label for="package_id" value="Pilih Paket" />
                <select wire:model.live="package_id" id="package_id" class="mt-1 block w-full bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500 h-12 px-4">
                    <option value="">-- Pilih Paket --</option>
                    @foreach($allPackages as $package)
                        <option value="{{ $package->id }}">{{ $package->title }}</option>
                    @endforeach
                </select>
                @error('package_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Total Amount --}}
            <div>
                <x-util.form.label for="total_amount" value="Total Tagihan (Rp)" />
                <x-util.form.input wire:model.live="total_amount" id="total_amount" type="number" step="any" class="mt-1 block w-full" />
                @error('total_amount') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            
            {{-- Status --}}
            <div>
                <x-util.form.label for="status" value="Status Booking" />
                <select wire:model="status" id="status" class="mt-1 block w-full bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500 h-12 px-4">
                    @foreach(\App\Enums\BookingStatus::cases() as $status)
                        <option value="{{ $status->value }}">{{ str_replace('_', ' ', Str::title($status->value)) }}</option>
                    @endforeach
                </select>
                @error('status') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Notes --}}
            <div>
                <x-util.form.label for="notes" value="Catatan Internal" />
                <textarea wire:model="notes" id="notes" rows="3" class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm mt-1 block w-full"></textarea>
                @error('notes') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
            <x-util.button type="button" variant="outline" wire:click="closeModal">
                Batal
            </x-util.button>
            <x-util.button type="submit" wire:target="save">
                {{ $bookingId ? 'Simpan Perubahan' : 'Buat Booking' }}
            </x-util.button>
        </div>
    </form>
</x-util.modal>
