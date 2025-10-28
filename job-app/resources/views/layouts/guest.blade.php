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

    <!-- Alpine.js Cloak -->
    <style>
        [x-cloak] { display: none !important; }

        /* Smooth floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .float-slow {
            animation: float 8s ease-in-out infinite;
        }

        .float-medium {
            animation: float 6s ease-in-out infinite;
        }

        .float-fast {
            animation: float 4s ease-in-out infinite;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative flex items-center justify-center min-h-screen overflow-hidden text-white bg-black">
    <!-- Floating Gradient Orbs -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-[10%] left-[15%] w-[400px] h-[400px] bg-gradient-to-br from-indigo-500/40 to-purple-500/20 rounded-full blur-3xl float-slow"></div>
        <div class="absolute bottom-[10%] right-[10%] w-[350px] h-[350px] bg-gradient-to-tr from-rose-500/40 to-orange-400/20 rounded-full blur-3xl float-medium"></div>
        <div class="absolute top-[50%] left-[60%] w-[250px] h-[250px] bg-gradient-to-bl from-sky-500/30 to-cyan-400/10 rounded-full blur-2xl float-fast"></div>
        <div class="absolute bottom-[20%] left-[20%] w-[200px] h-[200px] bg-gradient-to-tr from-emerald-500/30 to-lime-400/10 rounded-full blur-2xl float-medium"></div>
    </div>

    <!-- Bottom Gradient -->
    <div class="absolute inset-0 pointer-events-none bg-gradient-to-t from-black via-transparent to-black/80"></div>

    <!-- Main Content Container -->
    <div class="relative z-10 flex flex-col items-center w-full min-h-screen pt-6 sm:justify-center sm:pt-0"
        x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)">
        <!-- Application Logo -->
        <div class="mb-8" x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <a href="/">
                <x-application-logo class="w-20 h-20 text-gray-300 transition-colors fill-current hover:text-white" />
            </a>
        </div>

        <!-- Content Card -->
        <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
            class="w-full px-6 py-8 transition-all duration-300 border shadow-2xl sm:max-w-md bg-gray-800/50 backdrop-blur-sm border-white/10 rounded-xl hover:shadow-3xl">
            {{ $slot }}
        </div>
    </div>
</body>

</html>