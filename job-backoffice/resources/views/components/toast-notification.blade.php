
<div class="absolute inset-x-0 bottom-0 z-50">
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
            class="relative px-4 py-3 mx-auto mb-4 text-green-700 bg-green-100 border border-green-400 rounded w-[300px]"
            role="alert">
            {{ session('success') }}
        </div>
                
    @endif
</div>