<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $jobApplication->user->name }} | {{ $jobApplication->jobVacancy->title }}
        </h2>
    </x-slot>

    
    <div class="p-6 overflow-x-auto">
        {{-- Success Message --}}
        <x-toast-notification />

        {{-- Back Button --}}
        <a href="{{ route('job-applications.index') }}" 
            class="px-4 py-2 mb-4 font-semibold text-white bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
            ← Back
        </a>

        {{-- Wrapper --}}
        <div class="w-full p-6 mx-auto mt-4 bg-white rounded-lg shadow">
            {{-- Company Details --}}
            <div class="mb-6 space-y-2">
                <h3 class="text-lg font-bold">Application Information</h3>
                <p><strong>Applicant:</strong> {{ $jobApplication->user->name }}</p>
                <p><strong>Job Vacancy:</strong> {{ $jobApplication->jobVacancy->title }}</p>
                <p><strong>Company:</strong> {{ $jobApplication->jobVacancy->company->name }}</p>
                <p><strong>Status:</strong>
                    <span class="p-1 @if($jobApplication->status == 'accepted') text-white bg-green-600 @elseif($jobApplication->status == 'pending') text-white bg-amber-500 @elseif($jobApplication->status == 'rejected') text-white bg-rose-500 @endif">
                        {{ $jobApplication->status }}
                    </span>
                </p>
                <p><strong>Resume:</strong>
                    <a href="{{ $jobApplication->resume->fileUri }}" class="text-blue-500 underline" target="_blank">
                         {{ $jobApplication->resume->fileUri }}
                    </a>
                </p>
            </div>
            
            {{-- Edit and Archive Buttons --}}
            <div class="flex mb-6 space-x-4">
                <a href="{{ route('job-applications.edit', ['job_application' => $jobApplication->id, 'redirectToList' => 'false']) }}" 
                    class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Edit Application
                </a>

                <form action="{{ route('job-applications.destroy', $jobApplication->id)}}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 font-semibold text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to archive this Application?');">
                        Archive Application
                    </button>
                </form>
            </div>

            {{-- Tabs Navigation --}}
            <div class="mb-6">
                <ul class="flex space-x-4">
    
                    <li>
                        <a href="{{ route('job-applications.show',['job_application' => $jobApplication->id, 'tab' => 'resume']) }}" 
                            class="px-4 py-2 font-semibold text-gray-800 {{ request('tab') == 'resume' || request('tab') == ''  ? 'border-b-2 border-blue-600' : '' }}">
                            Resume
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('job-applications.show',['job_application' => $jobApplication->id, 'tab' => 'AIFeedback']) }}" 
                            class="px-4 py-2 font-semibold text-gray-800 {{ request('tab') == 'AIFeedback'  ? 'border-b-2 border-blue-600' : '' }}">
                            AI Feedback
                        </a>
                    </li>

                </ul>
            </div>

            {{-- Tabs Content --}}
            <div>
                {{-- Resume Tab --}}
                <div id="resume" class="{{ request('tab') == 'resume' || request('tab') == '' ? 'block' : 'hidden' }}">
                    <table class="min-w-full mt-4 bg-white divide-y divide-gray-200 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">Summary</th>
                                <th class="px-4 py-2 text-left bg-gray-100">Skills</th>
                                <th class="px-4 py-2 text-left bg-gray-100">Experience</th>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tr-lg">Education</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 border-b">{{ $jobApplication->resume->summary }}</td>
                                <td class="px-4 py-2 border-b">{{ $jobApplication->resume->skills }}</td>
                                <td class="px-4 py-2 border-b">{{ $jobApplication->resume->experience }}</td>
                                <td class="px-4 py-2 border-b">{{ $jobApplication->resume->education }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- AI Feedback Tab --}}
                <div id="AIFeedback" class="{{ request('tab') == 'AIFeedback' ? 'block' : 'hidden' }}">
                    <table class="min-w-full mt-4 bg-white divide-y divide-gray-200 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">AI Score</th>
                                <th class="px-4 py-2 text-left bg-gray-100">Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 border-b">{{ $jobApplication->aiGeneratedScore }}</td>
                                <td class="px-4 py-2 border-b">{{ $jobApplication->aiGeneratedFeedback }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

        </div>

    </div>
</x-app-layout>