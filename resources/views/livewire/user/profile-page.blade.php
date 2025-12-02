<div>
    <div class="mb-8">
        <h2 class="text-2xl font-serif font-bold text-gray-900">Profil Saya</h2>
        <p class="text-gray-500 text-sm mt-1">Kelola informasi akun dan data pribadi Anda.</p>
    </div>

    <div class="space-y-8">
        {{-- Update Profile Information --}}
        <x-panel.card>
            <form wire:submit.prevent="updateProfile">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Informasi Profil</h3>
                    <p class="text-sm text-gray-500">Perbarui data nama, email, dan nomor telepon Anda.</p>
                </div>
                <div class="p-6 space-y-4">
                    {{-- Name --}}
                    <div>
                        <x-util.form.label for="name" value="Nama Lengkap" />
                        <x-util.form.input wire:model="profileState.name" id="name" type="text" class="mt-1" />
                        @error('name', 'updateProfile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    {{-- Email --}}
                    <div>
                        <x-util.form.label for="email" value="Email" />
                        <x-util.form.input wire:model="profileState.email" id="email" type="email" class="mt-1" />
                        @error('email', 'updateProfile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                     {{-- Phone --}}
                    <div>
                        <x-util.form.label for="phone" value="Nomor Telepon" />
                        <x-util.form.input wire:model="profileState.phone" id="phone" type="tel" class="mt-1" />
                        @error('phone', 'updateProfile') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50/50 flex justify-end">
                    <x-util.button type="submit" wire:target="updateProfile">
                        Simpan Perubahan
                    </x-util.button>
                </div>
            </form>
        </x-panel.card>
        
        {{-- Update Password --}}
        <x-panel.card>
            <form wire:submit.prevent="updatePassword">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-900">Ubah Password</h3>
                    <p class="text-sm text-gray-500">Pastikan Anda menggunakan password yang kuat dan mudah diingat.</p>
                </div>
                <div class="p-6 space-y-4">
                    {{-- Current Password --}}
                    <div>
                        <x-util.form.label for="current_password" value="Password Saat Ini" />
                        <x-util.form.input wire:model="passwordState.current_password" id="current_password" type="password" class="mt-1" />
                        @error('current_password', 'updatePassword') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    {{-- New Password --}}
                    <div>
                        <x-util.form.label for="password" value="Password Baru" />
                        <x-util.form.input wire:model="passwordState.password" id="password" type="password" class="mt-1" />
                        @error('password', 'updatePassword') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                     {{-- Confirm Password --}}
                    <div>
                        <x-util.form.label for="password_confirmation" value="Konfirmasi Password Baru" />
                        <x-util.form.input wire:model="passwordState.password_confirmation" id="password_confirmation" type="password" class="mt-1" />
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50/50 flex justify-end">
                    <x-util.button type="submit" wire:target="updatePassword">
                        Ubah Password
                    </x-util.button>
                </div>
            </form>
        </x-panel.card>
    </div>
</div>
