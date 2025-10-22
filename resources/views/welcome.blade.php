<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name','Macwas') }}</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    .text-3d {
      position: relative;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: #ffffff;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
    }

    .button-3d {
      position: relative;
      display: inline-block;
      background: linear-gradient(45deg, #00b4d8, #0077b6);
      padding: 12px 30px;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 700;
      color: white;
      letter-spacing: 0.5px;
      box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25);
      text-transform: uppercase;
      transition: all 0.3s ease;
    }

    .button-3d:hover {
      transform: translateY(-4px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.35);
    }

    .button-3d:active {
      transform: translateY(2px);
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 text-white flex flex-col">

  <!-- HEADER -->
  <header class="flex justify-center items-center py-6 bg-transparent">
    <div class="flex items-center space-x-4">
      <img src="{{ asset('images/logo.png') }}" alt="Macwas Logo" class="h-14 w-14 drop-shadow-lg">
      <span class="text-4xl font-extrabold text-3d" data-text="Macwas">{{ config('app.name','Macwas') }}</span>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="flex-1 flex flex-col justify-center items-center text-center px-6">
    <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight drop-shadow-lg text-3d" data-text="Manage Your Water Services with Ease">
      Manage Your Water Services with Ease
    </h1>

    <p class="text-lg md:text-xl mb-10 max-w-2xl mx-auto opacity-90">
      Empowering citizens and administrators to manage, monitor, and deliver efficient water services through innovation and transparency.
    </p>

    @auth
      <a href="{{ route('dashboard') }}" class="button-3d">Go to Dashboard</a>
    @else
      <div class="space-x-4">
        <a href="{{ url('auth/login') }}" class="button-3d">Login</a>
        <a href="{{ url('auth/register') }}" class="button-3d bg-gradient-to-r from-cyan-500 to-blue-600">Register</a>
      </div>
    @endauth
  </main>

  <!-- FEATURES SECTION -->
  <section class="py-20 bg-white/10 backdrop-blur-sm text-center space-y-14">
    <div>
      <h3 class="text-3xl font-semibold mb-3 text-cyan-300">Automated Billing</h3>
      <p class="text-lg max-w-2xl mx-auto opacity-90">Simplify invoicing and payment tracking with our modern billing engine.</p>
    </div>

    <div>
      <h3 class="text-3xl font-semibold mb-3 text-cyan-300">Service Monitoring</h3>
      <p class="text-lg max-w-2xl mx-auto opacity-90">Track consumption, maintenance schedules, and outages in real time.</p>
    </div>

    <div>
      <h3 class="text-3xl font-semibold mb-3 text-cyan-300">Citizen Portal</h3>
      <p class="text-lg max-w-2xl mx-auto opacity-90">Empower citizens to submit requests, track updates, and engage transparently.</p>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-black/50 py-6 text-center text-sm text-white tracking-wide">
    © {{ date('Y') }} {{ config('app.name','Macwas') }} Water System — All rights reserved.
  </footer>

</body>
</html>
