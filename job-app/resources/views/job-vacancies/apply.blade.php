<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            {{ $jobVacancy->title }} - Apply
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
                Back to Job Details
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

                </div>
            </div>

            <form action="{{ route('job-vacancies.proccess-application', $jobVacancy->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                {{-- Resume Selection --}}
                <div>
                    <h3 class="mb-4 text-xl font-semibold text-white">Choose Your Resume</h3>

                    <div class="mb-6">
                        <x-input-label for="resume" value="Select from your existing resumes" class="mb-2"/>
                        {{-- List of Resumes --}}
                        <div class="space-y-4">
                            @forelse ($resumes as $resume)
                                <div class="flex items-center gap-2">
                                    <input type="radio" name="resume_option" id="{{ $resume->id }}" value="{{ $resume->id }}" class="w-5 h-5 text-indigo-500 transition-all duration-200 bg-transparent border-2 border-gray-600 rounded-full focus:ring-2 focus:ring-indigo-500 focus:ring-offset-0 checked:border-indigo-500 checked:bg-indigo-500/20"
                                        @error('resume_option') class="border-red-500" @else class="border-gray-600" @enderror
                                    />
                                    <x-input-label  for="{{ $resume->id }}" class="text-[#6366f1] cursor-pointer">
                                        {{ $resume->filename }}
                                        <span class="text-sm text-gray-400">(Last Updated: {{ $resume->created_at ? $resume->created_at->format('M d, Y') : 'N/A' }})</span>
                                    </x-input-label>
                                </div>
                            @empty
                                <span class="text-sm text-gray-400">No resumes found.</span>
                            @endforelse
                        </div>
                    </div>  
                </div>

                {{-- Upload New Resume --}}
                {{-- <div x-data="{ fileName: '' }">
                    <x-input-label for="resume" value="Or upload a new resume"/>
                    <div class="flex items-center">
                        <div class="flex-1">
                            <label for="new_resume_file" class="block text-white cursor-pointer">
                                <div class="p-4 duration-500 border-2 border-gray-600 border-dashed rounded-lg hover:border-blue-500 transtion"
                                    :class="{ 'boder-blue-500': fileName, 'border-red-500': {{ $errors->has('resume_file') ? 'true' : 'false' }} }">
                                    
                                    <input @change="fileName = $event.target.files[0].name" type="file" name="resume_file" id="new_resume_file" accept=".pdf" class="hidden">
                                    <div class="text-center">
                                        <template x-if="!fileName">
                                            <p class="text-gray-400">Click to upload PDF (Max 5MB)</p>
                                        </template>

                                        <template x-if="fileName">
                                            <div>
                                                <p x-text="fileName" class="mt-2 text-blue-400"></p>
                                                <p class="mt-1 text-sm text-gray-400">Click to change file</p>
                                            </div>
                                        </template>
                                    </div>
                                    
                                </div>
                            </label>
                        </div>
                    </div>
                </div> --}}

                {{-- Upload New Resume --}}
                <div x-data="{ fileName: '' }" class="mt-6">

                    <div class="flex items-center gap-2 mb-2">
                        <input x-ref="newResumeRadio" type="radio" name="resume_option" id="new_resume" value="new_resume" class="w-5 h-5 text-indigo-500 transition-all duration-200 bg-transparent border-2 border-gray-600 rounded-full focus:ring-2 focus:ring-indigo-500 focus:ring-offset-0 checked:border-indigo-500 checked:bg-indigo-500/20"
                            @error('resume_option') class="border-red-500" @else class="border-gray-600" @enderror
                        />
                        <x-input-label for="new_resume" value="Upload New Resume" class="text-lg font-semibold text-white cursor-pointer" />
                    </div>

                    <label for="new_resume_file" 
                        class="relative flex flex-col items-center justify-center w-full p-6 text-center transition-all duration-300 border-2 border-gray-600 border-dashed cursor-pointer group rounded-xl hover:border-indigo-500 hover:bg-indigo-500/10">
                        
                        {{-- Hidden Input --}}
                        <input 
                            @change="fileName = $event.target.files[0]?.name || '' ; $refs.newResumeRadio.checked = true" 
                            type="file" 
                            name="resume_file" 
                            id="new_resume_file" 
                            accept=".pdf" 
                            class="hidden"
                        >

                        {{-- Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" 
                            class="w-10 h-10 mb-3 text-indigo-400 transition-transform duration-300 group-hover:scale-110" 
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>

                        {{-- Text Feedback --}}
                        <template x-if="!fileName">
                            <p class="text-gray-400 transition-colors group-hover:text-indigo-400">
                                Click to upload your <span class="font-semibold">PDF Resume</span> (max 5 MB)
                            </p>
                        </template>

                        <template x-if="fileName">
                            <div>
                                <p x-text="fileName" class="mt-1 font-medium text-indigo-400"></p>
                                <p class="mt-1 text-sm text-gray-400">Click to change file</p>
                            </div>
                        </template>

                        {{-- Glow border when file selected --}}
                        <div x-show="fileName"
                            class="absolute inset-0 border-2 pointer-events-none rounded-xl border-indigo-500/40 animate-pulse">
                        </div>
                    </label>
                </div>



                {{-- Errors section --}}
                @if ($errors->any())
                    <div class="p-4 text-white bg-red-500 rounded-lg">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                {{-- Submit Button --}}
                <div>
                    <x-primary-button class="w-full">
                        Apply Now
                    </x-primary-button>
                </div>
            </form>

        </div>
    </div>

</x-app-layout>