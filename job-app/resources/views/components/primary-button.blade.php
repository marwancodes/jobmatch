<button {{ $attributes->merge(['type' => 'submit', 'class' => 'justify-center relative inline-flex items-center justify-center px-6 py-2.5 rounded-lg font-semibold text-white
                    bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
                    hover:from-indigo-400 hover:via-purple-400 hover:to-pink-400
                    shadow-lg shadow-indigo-500/30 hover:shadow-purple-500/40
                    transition-all duration-300 ease-in-out']) }}>
    {{ $slot }}
</button>
