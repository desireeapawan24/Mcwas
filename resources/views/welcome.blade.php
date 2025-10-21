<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Macwas</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-orange-100 via-white to-yellow-50 min-h-screen flex items-center justify-center">
    <div class="text-center p-8 bg-white shadow-xl rounded-2xl max-w-md">
        <h1 class="text-4xl font-bold text-orange-600 mb-4">Welcome to Macwas</h1>
        <p class="text-gray-600 mb-8">
            Manage your water services efficiently with the Macwas system.
        </p>

        <div class="flex flex-col gap-3">
            <a href="{{ route('login') }}" 
               class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                Login
            </a>

            <a href="{{ route('register') }}" 
               class="border border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                Register
            </a>
        </div>
    </div>

    <footer class="absolute bottom-4 text-gray-500 text-sm text-center w-full">
        © {{ date('Y') }} Macwas Water System. All rights reserved.
    </footer>
</body>
</html>
