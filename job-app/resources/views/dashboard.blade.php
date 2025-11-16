<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="p-6 mx-auto rounded-lg shadow-lg bg-black/30 max-w-7xl sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold text-white">
                {{ __('Welcome back') }} {{ Auth::user()->name }}!
            </h3>

            {{-- Search & Filters --}}
            <div class="flex items-center justify-between">
                {{-- Search Bar --}}
                <form action="{{ route('dashboard') }}" method="get" class="flex items-center justify-center w-1/4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search jobs..." class="mt-4 rounded-l-lg text-white/50 bg-white/10 w-96 focus:border-indigo-500" />
                    <button type="submit" class="px-4 py-2 mt-4 font-semibold text-white transition duration-300 bg-indigo-500 border border-indigo-500 rounded-r-lg hover:bg-indigo-400">
                        Search
                    </button>
                    @if (request('search'))
                            <a href="{{ route('dashboard', ['filter' => request('filter')]) }}" class="px-4 py-2 mt-4 underline transition duration-300 text-white/50 hover:text-white/70">
                                Clear
                            </a>
                        @endif
                </form>

                {{-- Filters --}}
                <div>
                    <a href="{{ route('dashboard', ['filter' => 'Full-Time', 'search' => request('search')]) }}"
                        class="p-2 text-white bg-indigo-500 rounded-lg">Full Time</a>
                    <a href="{{ route('dashboard', ['filter' => 'Part-Time', 'search' => request('search')]) }}" 
                        class="p-2 text-white bg-indigo-500 rounded-lg">Part Time</a>
                    <a href="{{ route('dashboard', ['filter' => 'Remote', 'search' => request('search')]) }}"
                        class="p-2 text-white bg-indigo-500 rounded-lg">Remote</a>
                    <a href="{{ route('dashboard', ['filter' => 'Hybrid', 'search' => request('search')]) }}" 
                        class="p-2 text-white bg-indigo-500 rounded-lg">Hybrid</a>
                    <a href="{{ route('dashboard', ['filter' => 'Volunteer', 'search' => request('search')]) }}" 
                        class="p-2 text-white bg-indigo-500 rounded-lg">Volunteer</a>

                    @if (request('filter'))
                        <a href="{{ route('dashboard', ['search' => request('search')]) }}" class="p-2 underline text-white/50">
                            Clear
                        </a>
                    @endif
                </div>

            </div>
            
            {{-- Job List --}}
            <div class="mt-6 space-y-4">

                @forelse ($jobs as $job)
                    <div class="p-5 transition-all duration-300 border shadow-lg rounded-xl bg-white/5 border-white/10 hover:shadow-xl backdrop-blur-sm">

                        {{-- Top Row --}}
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <a href="{{ route('job-vacancies.show', $job->id) }}"
                                class="text-xl font-semibold text-blue-400 hover:underline">
                                    {{ $job->title }}
                                </a>

                                <p class="flex items-center gap-1 mt-1 text-sm text-gray-300">
                                    {{ $job->company->name }} • {{ $job->location }}
                                </p>

                                <p class="text-sm text-gray-400">£{{ $job->salary }} / Year</p>
                            </div>

                            {{-- Job Type Badge --}}
                            <span class="px-3 py-1 text-xs font-semibold text-white bg-indigo-600 rounded-full h-fit">
                                {{ $job->type }}
                            </span>
                        </div>

                    </div>
                @empty
                    <p class="m-20 text-xl font-bold text-center text-white/50">No Jobs found!</p>
                @endforelse

            </div>


            {{-- Pagination --}}
            <div class="mt-6">
                {{ $jobs->links() }}
            </div>
    </div>
</x-app-layout>
