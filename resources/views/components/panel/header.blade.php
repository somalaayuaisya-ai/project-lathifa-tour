<header class="sticky top-0 z-30 flex items-center justify-between h-20 px-6 bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-100">
    <div class="flex items-center gap-4">
        {{-- Hamburger menu for mobile --}}
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 lg:hidden focus:outline-none">
            <x-phosphor-list class="w-6 h-6" />
        </button>

        {{-- Search Bar --}}
        <div class="hidden md:flex items-center relative">
            <x-phosphor-magnifying-glass class="w-5 h-5 absolute left-3 text-gray-400" />
            <input type="text" placeholder="Cari jamaah, kode booking..."
                   class="pl-10 pr-4 py-2.5 w-64 bg-gray-50 border border-gray-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
        </div>
    </div>

    <div class="flex items-center gap-4">
        {{-- Notifications --}}
        <button class="relative p-2 text-gray-400 hover:text-primary-600 transition-colors">
            <x-phosphor-bell class="w-6 h-6" />
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
        </button>

        {{-- User Dropdown --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 focus:outline-none">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="w-9 h-9 rounded-full border-2 border-white shadow-sm cursor-pointer">
                <span class="hidden md:block text-sm font-semibold text-gray-700">Halo, {{ Str::words(Auth::user()->name, 1, '') }}</span>
                <x-phosphor-caret-down-bold class="w-3 h-3 text-gray-400" />
            </button>

            <div x-show="open" x-transition x-cloak
                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                <div class="px-4 py-2 border-b border-gray-100">
                    <p class="text-xs text-gray-500">Login sebagai</p>
                    <p class="text-sm font-bold text-primary-800 capitalize">{{ Auth::user()->role->value }}</p>
                </div>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700">Pengaturan Akun</a>
                <div class="border-t border-gray-100 my-1"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
