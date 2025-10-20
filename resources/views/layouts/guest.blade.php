<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Macwas Billing') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Compiled Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <header class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 text-center">
            <h1 class="text-lg font-bold text-blue-600 mb-2">Macwas Billing</h1>
            <img src="{{ asset('images/logo.png') }}" 
                 alt="Macwas Logo" 
                 class="h-20 w-auto mx-auto object-contain"
                 onerror="this.style.display='none'; console.error('Logo not found: public/images/logo.png')">
        </div>
    </header>

    <main class="min-h-screen flex flex-col items-center justify-center">
        @yield('content')
    </main>
</body>
</html>
