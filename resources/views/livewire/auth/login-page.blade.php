<div>
    @if (session()->has('status'))
    <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('status') }}
    </div>
    @endif

    <form wire:submit.prevent="login">
        <!-- Email Address -->
        <div>
            <x-util.form.label for="email" value="Email" />
            <div class="relative mt-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    </svg>
                </div>
                <x-util.form.input wire:model.defer="email" id="email" type="email" name="email" required autofocus
                    with-icon />
            </div>
            @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ showPassword: false }">
            <x-util.form.label for="password" value="Password" />
            <div class="relative mt-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <x-util.form.input wire:model.defer="password" id="password" ::type="showPassword ? 'text' : 'password'"
                    name="password" required with-icon />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <button type="button" @click="showPassword = !showPassword"
                        class="text-gray-400 hover:text-gray-600">
                        <svg x-show="!showPassword" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
                            <path fill-rule="evenodd"
                                d="M.664 10.59a1.651 1.651 0 010-1.18l.88-1.84a1.65 1.65 0 011.531-1.019H4.25a1.65 1.65 0 011.532 1.019l.88 1.84a1.651 1.651 0 010 1.18l-.88 1.84a1.65 1.65 0 01-1.532 1.019H4.25a1.65 1.65 0 01-1.531-1.019l-.88-1.84zM10 4a6.5 6.5 0 100 13 6.5 6.5 0 000-13z"
                                clip-rule="evenodd" />
                        </svg>
                        <svg x-show="showPassword" x-cloak class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3.28 2.22a.75.75 0 00-1.06 1.06l14.5 14.5a.75.75 0 101.06-1.06l-1.745-1.745a10.029 10.029 0 003.3-4.38 1.651 1.651 0 000-1.18l-.88-1.84a1.65 1.65 0 00-1.532-1.019H17.55l-1.076-1.076a4.5 4.5 0 00-6.434-6.434L6.71 4.545 3.28 2.22zM10 12.5a2.5 2.5 0 01-2.5-2.5l2.5 2.5z"
                                clip-rule="evenodd" />
                            <path
                                d="M10 4a6.5 6.5 0 00-6.5 6.5c0 .314.026.622.074.926l-1.533 1.533A10.03 10.03 0 01.664 10.59a1.651 1.651 0 010-1.18l.88-1.84a1.65 1.65 0 011.532-1.019H4.25a1.65 1.65 0 011.531 1.019l.88 1.84a1.651 1.651 0 010 1.18l-.21.44a6.473 6.473 0 00-2.31.13L10 4z" />
                        </svg>
                    </button>
                </div>
            </div>
            @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input wire:model.defer="remember" id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-primary-800 shadow-sm focus:ring-primary-800" name="remember">
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                Lupa password?
            </a>

            <x-util.button type="submit" class="ml-4" wire:target="login">
                Masuk
            </x-util.button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Belum punya akun?
                <a wire:navigate href="{{ route('register') }}"
                    class="font-medium text-primary-800 hover:text-primary-600">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>
</div>
