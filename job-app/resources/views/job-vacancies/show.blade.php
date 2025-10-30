<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="p-6 mx-auto rounded-lg shadow-lg bg-black/30 max-w-7xl sm:px-6 lg:px-8">
            
            {{-- Back to Jobs Button --}}
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-4 py-2 mb-6 text-sm font-medium text-indigo-400 transition-all duration-200 border border-indigo-500 rounded-lg hover:bg-indigo-600 hover:text-white hover:shadow-md">
                {{-- Arrow Left Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" 
                     fill="none" 
                     viewBox="0 0 24 24" 
                     stroke-width="2" 
                     stroke="currentColor" 
                     class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Jobs
            </a>

            {{-- Job Details --}}
            <div class="pb-10 border-b border-white/10">

                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $jobVacancy->title }}</h1>
                        <p class="text-gray-400 text-md">{{ $jobVacancy->company->name }}</p>

                        <div class="flex items-center gap-4">
                            <p class="text-sm text-gray-400">{{ $jobVacancy->location }}</p>
                            <span class="text-sm text-gray-400">-</span>
                            <p class="text-sm text-gray-400">£{{ $jobVacancy->salary }}/Year</p>
                            <span class="p-2 text-sm text-white bg-indigo-500 rounded-lg">{{ $jobVacancy->type }}</span>
                        </div>
                    </div>

                    <div>
                        <a href="{{ route('job-vacancies.apply', $jobVacancy->id) }}" class="relative inline-flex items-center justify-center px-6 py-2.5 rounded-lg font-semibold text-white
                            bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
                            hover:from-indigo-400 hover:via-purple-400 hover:to-pink-400
                            shadow-lg shadow-indigo-500/30 hover:shadow-purple-500/40
                            transition-all duration-300 ease-in-out">
                            Apply Now
                        </a>
                    </div>

                </div>
            </div>
            
            <div class="grid grid-cols-3 gap-4 mt-6">
                <div class="col-span-2">
                    <h2 class="text-lg font-bold text-white">Job Description</h2>
                    <p class="text-gray-400">{{ $jobVacancy->description }}</p>
                </div>
                <div class="col-span-1">
                    <h2 class="text-lg font-bold text-white">Job Overview</h2>
                    <div class="p-6 space-y-4 bg-gray-900 rounded-lg">
                        <div>
                            <p class="text-gray-400">Published Date</p>
                            <p class="text-white">{{ $jobVacancy->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Company</p>
                            <p class="text-white">{{ $jobVacancy->company->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Location</p>
                            <p class="text-white">{{ $jobVacancy->location }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Salary</p>
                            <p class="text-white">£{{ $jobVacancy->salary }}/Year</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Type</p>
                            <p class="text-white">{{ $jobVacancy->type }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Category</p>
                            <p class="text-white">{{ $jobVacancy->jobCategory->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>