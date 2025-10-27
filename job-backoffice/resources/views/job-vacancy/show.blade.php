<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    
    <div class="p-6 overflow-x-auto">
        {{-- Success Message --}}
        <x-toast-notification />

        {{-- Back Button --}}
        <a href="{{ route('job-vacancies.index') }}" 
            class="px-4 py-2 mb-4 font-semibold text-white bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
            ← Back
        </a>

        {{-- Wrapper --}}
        <div class="w-full p-6 mx-auto mt-4 bg-white rounded-lg shadow">
            {{-- Company Details --}}
            <div class="mb-6 space-y-2">
                <h3 class="text-lg font-bold">Job Vacancy Information</h3>
                <p><strong>Company:</strong> {{ $jobVacancy->company->name }}</p>
                <p><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                <p><strong>Type:</strong> {{ $jobVacancy->type }}</p>
                <p><strong>Category:</strong> {{ $jobVacancy->jobCategory->name }}</p>
                <p><strong>Salary:</strong> {{ $jobVacancy->salary }}</p>
                <p><strong>Description:</strong>{{ $jobVacancy->description }}</p>
            </div>
            
            {{-- Edit and Archive Buttons --}}
            <div class="flex mb-6 space-x-4">
                <a href="{{ route('job-vacancies.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'false']) }}" 
                    class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Edit Job Vacancy
                </a>

                <form action="{{ route('job-vacancies.destroy', $jobVacancy->id)}}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 font-semibold text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to archive this job vacancy?');">
                        Archive Job Vacancy
                    </button>
                </form>
            </div>

            {{-- Tabs Navigation --}}
            <div class="mb-6">
                <ul class="flex space-x-4">
    
                    <li>
                        <a href="{{ route('job-vacancies.show',['job_vacancy' => $jobVacancy->id, 'tab' => 'applications']) }}" 
                            class="px-4 py-2 font-semibold text-gray-800 {{ request('tab') == 'applications' || request('tab') == ''  ? 'border-b-2 border-blue-600' : '' }}">
                            Applications
                        </a>
                    </li>

                </ul>
            </div>

            {{-- Tabs Content --}}
            <div>
                {{-- Applications Tab --}}
                <div id="applications" class="{{ request('tab') == 'applications' || request('tab') == '' ? 'block' : 'hidden' }}">
                    <table class="min-w-full mt-4 bg-white divide-y divide-gray-200 rounded-lg shadow">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">Applicant Name</th>
                                <th class="px-4 py-2 text-left bg-gray-100">Job Title</th>
                                <th class="px-4 py-2 text-left bg-gray-100">Status</th>
                                <th class="px-4 py-2 text-left bg-gray-100 rounded-tr-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- (HasMany) --}}
                            @forelse ($jobVacancy->jobApplications as $application)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $application->user->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $application->jobVacancy->title }}</td>
                                    <td class="px-4 py-2 border-b">{{ $application->status }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <a href="{{ route('job-applications.show', $application->id) }}" class="text-blue-500 underline hover:text-blue-700">View</a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="w-full px-6 py-4 text-center text-gray-500">
                                            No Applications found.
                                        </td>
                                    </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

        </div>

    </div>
</x-app-layout>