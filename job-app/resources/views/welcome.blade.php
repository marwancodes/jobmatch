<x-main-layout title="JobMatch - Find your dream job">
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)">
        <div class="mb-2" x-cloak x-show="show" x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <h3 class="font-bold text-md text-white/60">Job Match</h3>
        </div>
    </div>
    
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)">
        <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <h1 class="mt-4 mb-2 text-4xl font-bold tracking-tight sm:text-6xl md:text-8xl">
                <span class="text-white">Find your</span>
                <br>
                <span class="italic text-white/60">Dream Job</span>
            </h1>
        </div>
    </div>
    
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)">
        <div class="mb-6" x-cloak x-show="show" x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <p class="text-lg text-white/60">connect with top employers, and find exciting opportunities</p>
        </div>
    </div>
    
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)">
        <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
            <a href="{{ route('register') }}"
            class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg font-semibold text-white
                    bg-white/10 hover:bg-white/20
                    transition-all duration-300 ease-in-out">
                Create an Account
            </a>

            <a href="{{ route('login') }}"
            class="relative inline-flex items-center justify-center px-6 py-2.5 rounded-lg font-semibold text-white
                    bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
                    hover:from-indigo-400 hover:via-purple-400 hover:to-pink-400
                    shadow-lg shadow-indigo-500/30 hover:shadow-purple-500/40
                    transition-all duration-300 ease-in-out">
                Login
            </a>
        </div>
    </div>

</x-main-layout>