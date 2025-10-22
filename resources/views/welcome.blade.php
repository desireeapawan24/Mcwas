<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','Macwas') }}</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    /* 3D Text & Button Effects */
    .text-3d {
      position: relative;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: white;
      z-index: 1;
    }

    .text-3d::before {
      content: attr(data-text);
      position: absolute;
      top: 0;
      left: 0;
      z-index: -1;
      color: #00b4d8;
      transform: translate(4px, 4px);
      filter: blur(2px);
    }

    .button-3d {
      position: relative;
      display: inline-block;
      background: linear-gradient(45deg, #00b4d8, #0077b6);
      padding: 10px 25px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: bold;
      color: white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      text-transform: uppercase;
      transition: all 0.3s ease;
      z-index: 1;
    }

    .button-3d::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 8px;
      opacity: 0;
      transition: opacity 0.3s ease;
      transform: translate(-50%, -50%);
    }

    .button-3d:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
    }

    .button-3d:active::before {
      opacity: 1;
    }

    .button-3d:active {
      transform: translateY(2px);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
  </style>

</head>

<body class="relative min-h-screen text-white antialiased overflow-y-scroll bg-gradient-to-b from-blue-900 via-blue-800 to-blue-700">

  <!-- HEADER -->
  <header class="fixed top-0 left-0 w-full z-20 bg-white/60 backdrop-blur-md py-4 px-6 flex justify-between items-center shadow-md">
    <div class="flex items-center space-x-3">
      <img src="{{ asset('images/logo.png') }}" alt="Macwas Logo" class="h-10 w-10 drop-shadow-md">
      <span class="text-2xl font-bold text-primary text-3d" data-text="Macwas">{{ config('app.name','Macwas') }}</span>
    </div>

    <nav class="space-x-6 text-lg">
      <a href="{{ route('login') }}" class="text-accent hover:text-primary font-semibold transition transform hover:scale-105">Login</a>
      <a href="{{ route('register') }}" class="text-accent hover:text-primary font-semibold transition transform hover:scale-105">Register</a>
    </nav>
  </header>

  <!-- HERO SECTION -->
  <section class="pt-40 text-center px-6">
    <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight drop-shadow-lg text-3d" data-text="Manage Your Water Services with Ease">
      Manage Your Water Services with Ease
    </h1>
    <p class="text-lg md:text-xl mb-10 max-w-3xl mx-auto">Empowering citizens and administrators to manage, monitor, and deliver efficient water services through innovation and transparency.</p>

    @auth
      <a href="{{ route('dashboard') }}" class="inline-block button-3d">Go to Dashboard</a>
    @else
      <a href="{{ route('login') }}" class="inline-block button-3d mr-4">Login</a>
      <a href="{{ route('register') }}" class="inline-block button-3d">Register</a>
    @endauth
  </section>

  <!-- SCROLLABLE TEXT SECTIONS -->
  <section class="px-6 py-20 text-center space-y-12">
    <div>
      <h3 class="text-3xl font-semibold mb-3 text-accent drop-shadow-md">Automated Billing</h3>
      <p class="text-lg max-w-2xl mx-auto">Streamline invoicing and payment tracking effortlessly with our modern billing engine.</p>
    </div>

    <div>
      <h3 class="text-3xl font-semibold mb-3 text-accent drop-shadow-md">Service Monitoring</h3>
      <p class="text-lg max-w-2xl mx-auto">Monitor consumption, maintenance schedules, and outages in real time.</p>
    </div>

    <div>
      <h3 class="text-3xl font-semibold mb-3 text-accent drop-shadow-md">Citizen Portal</h3>
      <p class="text-lg max-w-2xl mx-auto">Empower citizens to submit requests, track updates, and engage with transparency.</p>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-black/70 py-6 text-center text-sm text-white">
    © {{ date('Y') }} {{ config('app.name','Macwas') }} Water System — All rights reserved.
  </footer>

</body>
</html>
