<div>
    <form wire:submit.prevent="register">
        <!-- Name -->
        <div>
            <x-util.form.label for="name" value="Nama Lengkap" />
            <x-util.form.input wire:model.defer="name" id="name" type="text" name="name" required autofocus />
            @error('name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-util.form.label for="email" value="Email" />
            <x-util.form.input wire:model.defer="email" id="email" type="email" name="email" required />
            @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ showPassword: false }">
            <x-util.form.label for="password" value="Password" />
            <div class="relative mt-1">
                <x-util.form.input wire:model.defer="password" id="password" ::type="showPassword ? 'text' : 'password'" name="password" required />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <button type="button" @click="showPassword = !showPassword" class="text-gray-400 hover:text-gray-600">
                        <svg x-show="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" /><path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.18l.88-1.84a1.65 1.65 0 011.531-1.019H4.25a1.65 1.65 0 011.532 1.019l.88 1.84a1.651 1.651 0 010 1.18l-.88 1.84a1.65 1.65 0 01-1.532 1.019H4.25a1.65 1.65 0 01-1.531-1.019l-.88-1.84zM10 4a6.5 6.5 0 100 13 6.5 6.5 0 000-13z" clip-rule="evenodd" /></svg>
                        <svg x-show="showPassword" x-cloak class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.745-1.745a10.029 10.029 0 003.3-4.38 1.651 1.651 0 000-1.18l-.88-1.84a1.65 1.65 0 00-1.532-1.019H17.55l-1.076-1.076a4.5 4.5 0 00-6.434-6.434L6.71 4.545 3.28 2.22zM10 12.5a2.5 2.5 0 01-2.5-2.5l2.5 2.5z" clip-rule="evenodd" /><path d="M10 4a6.5 6.5 0 00-6.5 6.5c0 .314.026.622.074.926l-1.533 1.533A10.03 10.03 0 01.664 10.59a1.651 1.651 0 010-1.18l.88-1.84a1.65 1.65 0 011.532-1.019H4.25a1.65 1.65 0 011.531-1.019l.88 1.84a1.651 1.651 0 010 1.18l-.21.44a6.473 6.473 0 00-2.31.13L10 4z" /></svg>
                    </button>
                </div>
            </div>
            @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-util.form.label for="password_confirmation" value="Konfirmasi Password" />
            <x-util.form.input wire:model.defer="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a wire:navigate href="{{ route('login') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                Sudah punya akun?
            </a>

            <x-util.button type="submit" class="ml-4" wire:target="register">
                Daftar
            </x-util.button>
        </div>
    </form>
</div>
