<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Applicant Status') }}
        </h2>
    </x-slot>

    <div class="p-6 overflow-x-auto">
        <div class="max-w-2xl p-6 mx-auto bg-white rounded-lg shadow-md">
            <form action="{{ route('job-applications.update', ['job_application' => $jobApplication->id, 'redirectToList' => request()->query('redirectToList')]) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Job Application Details  --}}
                <div class="p-6 mb-4 border border-gray-100 rounded-lg shadow-sm bg-gray-50">
                    <h3 class="text-lg font-bold">Job Application Details</h3>
                    <br>
                    
                    {{-- Applicant Name --}}
                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-500">Applicant Name</label>
                        <span>{{ $jobApplication->user->name }}</span>
                    </div>
                    
                    {{-- Job Vacancy --}}
                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-500">Job Vacancy</label>
                        <span>{{ $jobApplication->jobVacancy->title }}</span>
                    </div>
                    
                    {{-- Company --}}
                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-500">Company</label>
                        <span>{{ $jobApplication->jobVacancy->company->name }}</span>
                    </div>
                    
                    {{-- AI Generated Score --}}
                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-500">AI Generated Score</label>
                        <span>{{ $jobApplication->aiGeneratedScore }}</span>
                    </div>
                    
                    {{-- AI Generated Feedback --}}
                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-500">AI Generated Feedback</label>
                        <span>{{ $jobApplication->aiGeneratedFeedback }}</span>
                    </div>


                    

                    

                    {{-- Type --}}
                    <div class="mb-4">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-500">Status</label>
                        <select name="status" id="status" class="{{ $errors->has('status') ? 'outline-red-500 outline outline-1' : '' }} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ old('status', $jobApplication->status) == 'pending' ? 'selected' : ''}}>Pending - Under Review</option>
                            <option value="accepted" {{ old('status', $jobApplication->status) == 'accepted' ? 'selected' : ''}}>Accepted - Qualified</option>
                            <option value="rejected" {{ old('status', $jobApplication->status) == 'rejected' ? 'selected' : ''}}>Rejected - Desqualified</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex items-center justify-end">
                    <a href="{{ route('job-applications.index') }}" class="px-4 mr-4 text-gray-500 rounded-md hover:text-gray-700">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Update Applicant Status
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>