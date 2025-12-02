<nav class="fixed w-full z-50 transition-all duration-300"
    :class="{'bg-white/95 backdrop-blur-md shadow-soft py-3': scrolled, 'bg-transparent py-6': !scrolled}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">

            {{-- Logo --}}
            <a wire:navigate href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-800 to-primary-500 rounded-tr-2xl rounded-bl-2xl flex items-center justify-center text-white font-serif font-bold text-xl shadow-lg">L</div>
                <div>
                    <span class="block text-xl font-serif font-bold leading-none"
                        :class="{'text-primary-900': scrolled, 'text-white': !scrolled}">Lathifa</span>
                    <span class="text-[0.65rem] uppercase tracking-[0.2em] font-medium"
                        :class="{'text-gold-600': scrolled, 'text-white/80': !scrolled}">Tour & Travel</span>
                </div>
            </a>

            {{-- Menu --}}
            <div class="hidden md:flex items-center space-x-8">
                <a wire:navigate href="{{ route('home') }}" class="text-sm font-medium hover:text-gold-500 transition"
                    :class="{'text-gray-700': scrolled, 'text-white/90': !scrolled}">Beranda</a>

                <a href="#packages" class="text-sm font-medium hover:text-gold-500 transition"
                    :class="{'text-gray-700': scrolled, 'text-white/90': !scrolled}">Paket Umroh</a>

                <div class="flex items-center gap-3 border-l pl-6 border-gray-300/30">

                    {{-- Jika sudah login --}}
                    @auth
                    @php
                    $dashboardLink = auth()->user()->hasRole('admin')
                    ? route('admin.dashboard')
                    : route('user.dashboard');
                    @endphp

                    <div class="relative ml-3" x-data="{ open: false }">
                        <button @click="open = !open" @click.outside="open = false"
                            class="flex items-center gap-2 text-sm font-semibold transition"
                            :class="{'text-primary-800': scrolled, 'text-white': !scrolled}">
                            <span>Hi, {{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        {{-- Dropdown --}}
                        <div x-show="open" x-transition
                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">

                            <a href="{{ $dashboardLink }}" wire:navigate
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Dashboard
                            </a>

                            <a href="" wire:navigate
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Riwayat Jamaah
                            </a>
                     

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth

                    {{-- Jika belum login --}}
                    @guest
                    <a wire:navigate href="{{ route('login') }}" class="text-sm font-semibold"
                        :class="{'text-primary-800': scrolled, 'text-white': !scrolled}">Masuk</a>

                    <x-util.button wire:navigate href="{{ route('register') }}"
                        :class="scrolled ? 'btn-primary' : 'btn-secondary'" class="px-5 py-2">
                        Daftar
                    </x-util.button>
                    @endguest

                </div>
            </div>

        </div>
    </div>
</nav>