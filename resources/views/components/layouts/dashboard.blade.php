<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Panel | {{ config('app.name', 'Lathifa Tour') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<livewire:toasts />

<body class="bg-sand font-sans text-gray-600 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <x-panel.sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative">

            <!-- Header -->
            <x-panel.header />

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto custom-scrollbar p-6">
                {{ $slot }}
            </main>
        </div>

        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-primary-900/80 backdrop-blur-sm z-40 lg:hidden" x-cloak>
        </div>
    </div>

    @livewireScripts
</body>

</html>
