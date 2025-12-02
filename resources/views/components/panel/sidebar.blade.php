{{-- This component receives $menu from the View Composer in AppServiceProvider --}}
<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-primary-900 to-primary-800 text-white transition-transform duration-300 ease-in-out transform lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl border-r border-white/5"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    {{-- Logo --}}
    <div class="flex items-center justify-center h-20 border-b border-white/10 shrink-0">
        <a wire:navigate href="{{ route('home') }}" class="flex items-center gap-3">
            <div
                class="w-10 h-10 bg-gradient-to-br from-gold-400 to-gold-600 rounded-xl flex items-center justify-center text-white shadow-glow">
                <span class="font-serif font-bold text-2xl">L</span>
            </div>
            <div>
                <h1 class="font-serif font-bold text-xl tracking-wide">Lathifa</h1>
                <p class="text-[10px] text-gold-400 uppercase tracking-[0.2em]">{{ Auth::user()->role->value }} Panel
                </p>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto custom-scrollbar py-6 px-3 space-y-1">
        @foreach ($menu as $item)
        @if (empty($item['children']))
        {{-- Single Menu Item --}}
        <a href="{{ route($item['route']) }}" wire:navigate
            class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 group {{ request()->routeIs($item['route'].'*') ? 'bg-white/10 text-gold-400 shadow-inner' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
            <x-dynamic-component
                :component="'phosphor-'.$item['icon'].($item['icon_style'] ? '-'.$item['icon_style'] : '')"
                class="w-5 h-5 text-xl {{ !request()->routeIs($item['route'].'*') ? 'group-hover:text-gold-400' : '' }} transition-colors" />
            {{ $item['title'] }}
        </a>
        @else
        {{-- Menu Item with Children --}}
        @php
        // Check if any child route is active to determine if the dropdown should be open.
        $isActive = collect($item['children'])->contains(fn ($child) => request()->routeIs($child['route']));
        @endphp
        <div x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-300 rounded-xl hover:bg-white/5 hover:text-white transition-colors group">
                <div class="flex items-center gap-3">
                    <x-dynamic-component
                        :component="'phosphor-'.$item['icon'].($item['icon_style'] ? '-'.$item['icon_style'] : '')"
                        class="w-5 h-5 text-xl group-hover:text-gold-400 transition-colors" />
                    {{ $item['title'] }}
                </div>
                <x-phosphor-caret-down-bold class="w-4 h-4 transition-transform duration-200"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>
            <div x-show="open" x-collapse x-cloak class="pl-11 pr-2 py-2 space-y-1">
                @foreach ($item['children'] as $child)
                <a href="{{ route($child['route']) }}" wire:navigate
                    class="block px-3 py-2 text-xs rounded-lg transition {{ request()->routeIs($child['route']) ? 'text-gold-400 bg-white/5' : 'text-gray-400 hover:text-gold-400 hover:bg-white/5' }}">
                    {{ $child['title'] }}
                </a>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach
    </nav>

    {{-- User Profile Footer --}}
    <div class="p-4 border-t border-white/10 bg-black/10 shrink-0">
        <div class="flex items-center gap-3">
            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                class="w-9 h-9 rounded-full border border-gold-500">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-white" title="Keluar">
                    <x-phosphor-sign-out class="w-5 h-5" />
                </button>
            </form>
        </div>
    </div>
</aside>
