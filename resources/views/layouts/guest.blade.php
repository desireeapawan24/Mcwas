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
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-center relative">
            <h1 class="text-2xl font-bold text-blue-600 pr-6">Water Management System</h1>
            <span class="wm-drop" aria-hidden="true"></span>
            <span class="wm-ripple" aria-hidden="true"></span>
        </div>
    </header>

    @yield('content')

    <style>
    /* Animated droplet beside header title */
    .wm-drop {
        position: absolute;
        top: 0.2rem;
        right: calc(50% - 3.25rem); /* approximate next to title end when centered */
        width: 10px; height: 10px;
        background: #3b82f6; /* blue-500 */
        border-radius: 50% 50% 60% 60%/60% 60% 80% 80%;
        box-shadow: 0 0 0 2px rgba(59,130,246,0.15);
        transform-origin: center;
        animation: drip 3s ease-in infinite;
    }
    .wm-ripple {
        position: absolute;
        right: calc(50% - 3.5rem);
        top: 3rem;
        width: 14px; height: 4px;
        background: radial-gradient(ellipse at center, rgba(59,130,246,0.35) 0%, rgba(59,130,246,0.15) 45%, rgba(59,130,246,0) 60%);
        border-radius: 9999px;
        opacity: 0;
        animation: ripple 3s ease-out infinite;
    }
    @keyframes drip {
        0% { transform: translateY(0) scale(1); opacity: 1; }
        65% { transform: translateY(26px) scale(1.05); opacity: 1; }
        70% { transform: translateY(30px) scale(0.96); opacity: 0.95; }
        72% { transform: translateY(34px) scale(0.92); opacity: 0.85; }
        75% { transform: translateY(40px) scale(0.88); opacity: 0; }
        100% { transform: translateY(0) scale(1); opacity: 0; }
    }
    @keyframes ripple {
        0%, 65% { opacity: 0; transform: scaleX(0.6); }
        75% { opacity: 1; transform: scaleX(1) translateY(0); }
        100% { opacity: 0; transform: scaleX(1.2) translateY(0); }
    }
    @media (prefers-reduced-motion: reduce) {
        .wm-drop, .wm-ripple { animation: none !important; opacity: 1; }
    }
    </style>
</body>
</html>




