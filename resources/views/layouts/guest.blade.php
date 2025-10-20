<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 py-2">
            <div class="flex flex-col items-center justify-center">
                <h1 class="text-lg font-bold text-blue-600 mb-1">Macwas Billing</h1>
                <!-- Logo image - place your logo.png in public/images/ -->
                <img src="{{ asset('images/logo.png') }}" 
                     alt="Water Management Logo" 
                     class="w-auto object-contain"
                     style="height: 80px;"
                     onerror="this.style.display='none'; console.error('Logo image not found at: public/images/logo.png')">
            </div>
        </div>
    </header>

    @yield('content')
</body>
</html>