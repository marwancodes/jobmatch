<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Job Match' }}</title>

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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="relative flex items-center justify-center min-h-screen overflow-hidden text-white bg-gradient-to-br from-gray-950 via-gray-900 to-black">

    <!-- Floating Gradient Orbs -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-[10%] left-[15%] w-[400px] h-[400px] bg-gradient-to-br from-indigo-500/40 to-purple-500/20 rounded-full blur-3xl float-slow"></div>
        <div class="absolute bottom-[10%] right-[10%] w-[350px] h-[350px] bg-gradient-to-tr from-rose-500/40 to-orange-400/20 rounded-full blur-3xl float-medium"></div>
        <div class="absolute top-[50%] left-[60%] w-[250px] h-[250px] bg-gradient-to-bl from-sky-500/30 to-cyan-400/10 rounded-full blur-2xl float-fast"></div>
        <div class="absolute bottom-[20%] left-[20%] w-[200px] h-[200px] bg-gradient-to-tr from-emerald-500/30 to-lime-400/10 rounded-full blur-2xl float-medium"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 text-center">
        {{ $slot }}
    </div>

    <!-- Soft bottom gradient overlay -->
    <div class="absolute inset-0 pointer-events-none bg-gradient-to-t from-black via-transparent to-black/70"></div>
</body>
</html>
