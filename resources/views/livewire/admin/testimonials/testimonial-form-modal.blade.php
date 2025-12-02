<x-util.modal wire:model.live="modalOpen" maxWidth="2xl">
    <form wire:submit.prevent="save" class="p-6">
        <h2 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6">
            {{ $testimonialId ? 'Edit Testimoni' : 'Tambah Testimoni' }}
        </h2>
        <div class="space-y-4">
            {{-- User Search (Searchable Dropdown) --}}
            <div x-data="{}" @click.away="$wire.set('users', []); $wire.set('userSearch', $wire.get('selectedUserName'))">
                <x-util.form.label for="userSearch" value="Cari & Pilih User (Opsional)" />
                <div class="relative">
                    <x-util.form.input wire:model.live.debounce.300ms="userSearch" id="userSearch" type="text" class="mt-1" placeholder="Ketik nama atau email user..." autocomplete="off" />
                    
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
                @error('user_id') <span class="text-red-500 text-sm mt-1">Pilih user dari daftar.</span> @enderror
            </div>

            {{-- Name (Conditional) --}}
            <div>
                <x-util.form.label for="name" value="Nama Pengirim" />
                <x-util.form.input wire:model="name" id="name" type="text" class="mt-1" :disabled="!is_null($user_id)" />
                @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            {{-- Job Title (Conditional) --}}
            <div>
                <x-util.form.label for="job_title" value="Pekerjaan/Jabatan" />
                <x-util.form.input wire:model="job_title" id="job_title" type="text" class="mt-1" :disabled="!is_null($user_id)" />
                @error('job_title') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Content --}}
            <div>
                <x-util.form.label for="content" value="Isi Testimoni" />
                <textarea wire:model.defer="content" id="content" rows="4" class="border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm mt-1 block w-full"></textarea>
                @error('content') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

             <div class="flex gap-4">
                {{-- Rating --}}
                <div class="flex-1">
                    <x-util.form.label for="rating" value="Rating (1-5)" />
                    <x-util.form.input wire:model="rating" id="rating" type="number" min="1" max="5" class="mt-1" />
                    @error('rating') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                {{-- Is Show --}}
                <div class="flex-1">
                    <x-util.form.label for="is_show" value="Status" />
                    <select wire:model="is_show" id="is_show" class="mt-1 block w-full bg-gray-50 border-gray-200 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500 h-12 px-4">
                        <option value="true">Tampilkan</option>
                        <option value="false">Sembunyikan</option>
                    </select>
                </div>
            </div>

            {{-- Avatar Upload --}}
            <div>
                <x-util.form.label value="Avatar Pengirim" />
                <div class="mt-1">
                    @if ($avatarUpload)
                        <img src="{{ $avatarUpload->temporaryUrl() }}" alt="Avatar Preview" class="rounded-full object-cover w-24 h-24 mb-4">
                    @elseif($testimonial && $testimonial->avatar_url)
                        <img src="{{ Str::contains($testimonial->avatar_url, 'ui-avatars.com') ? $testimonial->avatar_url : Storage::url($testimonial->avatar_url) }}" alt="Current Avatar" class="rounded-full object-cover w-24 h-24 mb-4">
                    @endif

                    <label for="avatar-upload" class="cursor-pointer flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 text-sm font-medium">
                        <x-phosphor-upload-simple class="w-5 h-5"/>
                        @if ($avatarUpload)
                            Ganti Avatar
                        @elseif($testimonial && $testimonial->avatar_url)
                            Ubah Avatar
                        @else
                            Upload Avatar
                        @endif
                        <div wire:loading wire:target="avatarUpload" class="text-xs text-gray-500 ml-auto">Uploading...</div>
                    </label>
                    <input type="file" wire:model="avatarUpload" id="avatar-upload" class="sr-only">
                    @if($testimonial && $testimonial->avatar_url)
                        <button type="button" wire:click="$set('avatarUpload', null); $set('testimonial.avatar_url', null)" class="text-red-500 hover:text-red-700 text-xs mt-2">
                            Hapus Avatar
                        </button>
                    @endif
                </div>
                @error('avatarUpload') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>

        </div>
        <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
            <x-util.button type="button" variant="outline" wire:click="closeModal">Batal</x-util.button>
            <x-util.button type="submit" wire:target="save, avatarUpload">Simpan</x-util.button>
        </div>
    </form>
</x-util.modal>
