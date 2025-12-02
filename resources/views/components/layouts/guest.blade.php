<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lathifa Tour') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-600 bg-sand antialiased">
    <livewire:toasts />

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        {{-- Logo --}}
        <div>
            <a wire:navigate href="{{ route('home') }}" class="flex items-center gap-2">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-primary-800 to-primary-500 rounded-tr-2xl rounded-bl-2xl flex items-center justify-center text-white font-serif font-bold text-2xl shadow-lg">
                    L</div>
                <div>
                    <span class="block text-2xl font-serif font-bold leading-none text-primary-900">Lathifa</span>
                    <span class="text-xs uppercase tracking-[0.2em] font-medium text-gold-600">Tour & Travel</span>
                </div>
            </a>
        </div>

        {{-- Card --}}
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-soft overflow-hidden sm:rounded-2xl">
            {{ $slot }}
        </div>
    </div>

</body>

</html>
