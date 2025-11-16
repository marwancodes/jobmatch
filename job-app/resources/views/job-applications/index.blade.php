<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            {{ __('My Applications') }}
        </h2>
    </x-slot>

    {{-- Validate Session --}}
    @if (session('success'))
        <div class="relative w-full px-4 py-3 mb-2 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">
        <div class="p-6 mx-auto space-y-4 rounded-lg shadow-lg bg-black/30 max-w-7xl sm:px-6 lg:px-8">
            @forelse ($jobApplications as $jobApplication)
                <div class="p-5 mb-4 transition-all duration-300 border shadow-lg rounded-xl bg-white/5 border-white/10 hover:shadow-xl backdrop-blur-sm">

                    {{-- Header --}}
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-blue-400">
                                {{ $jobApplication->jobVacancy->title }}
                            </h3>
                            <p class="text-sm text-gray-300">
                                {{ $jobApplication->jobVacancy->company->name }}
                            </p>
                            <p class="text-sm text-gray-400">
                                {{ $jobApplication->jobVacancy->location }}
                            </p>
                        </div>

                        <span class="px-3 py-1 text-xs font-semibold text-white bg-indigo-600 rounded-full">
                            {{ $jobApplication->jobVacancy->type }}
                        </span>
                    </div>


                    {{-- Resume --}}
                    <div class="flex items-center gap-2 mt-4 text-gray-300">
                        <span class="text-sm underline">
                            {{ $jobApplication->resume->filename }}
                        </span>
                        <a href="{{ Storage::disk('cloud')->url($jobApplication->resume->fileUri) }}"
                        class="text-sm text-indigo-400 hover:underline">
                            View Resume
                        </a>
                    </div>


                    {{-- Status + Score + Date --}}
                    <div class="grid grid-cols-1 gap-3 mt-4 text-sm sm:grid-cols-3">

                        {{-- Status --}}
                        @php
                            $status = $jobApplication->status;
                            $statusColors = match ($status) {
                                'pending' => 'text-yellow-400 bg-yellow-400/10',
                                'accepted' => 'text-green-400 bg-green-400/10',
                                'rejected' => 'text-red-400 bg-red-400/10',
                            };
                        @endphp

                        <div class="p-3 rounded-lg {{ $statusColors }}">
                            <p class="font-semibold">Status</p>
                            <p class="font-bold text-white capitalize text-md">{{ $status }}</p>
                        </div>

                        {{-- Score --}}
                        <div class="p-3 text-indigo-300 rounded-lg bg-indigo-600/30">
                            <p class="font-semibold">Score</p>
                            <p class="font-bold text-white text-md">{{ $jobApplication->aiGeneratedScore }}</p>
                        </div>

                        {{-- Date --}}
                        <div class="p-3 rounded-lg bg-white/10">
                            <p class="font-semibold text-gray-200">Applied On</p>
                            <p class="text-gray-300">
                                {{ $jobApplication->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>


                    {{-- Feedback --}}
                    <div class="mt-4">
                        <p class="text-sm font-semibold text-gray-300">AI Feedback:</p>
                        <p class="text-gray-400">
                            {{ $jobApplication->aiGeneratedFeedback ?: 'No feedback found!' }}
                        </p>
                    </div>


                    {{-- Button --}}
                    <div class="mt-5">
                        <a href="{{ route('job-vacancies.show', $jobApplication->jobVacancy->id) }}"
                        class="inline-block px-4 py-2 text-sm font-medium text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            View Job Details
                        </a>
                    </div>

                </div>
            @empty
                <p class="text-white">You have not applied to any jobs yet.</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $jobApplications->links() }}
        </div>
    </div>

</x-app-layout>