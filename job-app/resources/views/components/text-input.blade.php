@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block w-full mt-1 text-white rounded-lg bg-white/10 border-white/10 focus:border-indigo-500']) }}>
