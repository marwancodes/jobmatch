<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $company->name }}
        </h2>
    </x-slot>
    
    <div class="p-6 overflow-x-auto">
        {{-- Success Message --}}
        <x-toast-notification />

        @if (auth()->user()->role == 'admin')
            {{-- Back Button --}}
            <a href="{{ route('companies.index') }}" 
                class="px-4 py-2 mb-4 font-semibold text-white bg-gray-500 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                ← Back
            </a>
        @endif

        {{-- Wrapper --}}
        <div class="w-full p-6 mx-auto mt-4 bg-white rounded-lg shadow">
            {{-- Company Details --}}
            <div class="mb-6 space-y-2">
                <h3 class="text-lg font-bold">Company Information</h3>
                <p><strong>Owner:</strong> {{ $company->owner->name }}</p>
                <p><strong>Email:</strong> {{ $company->owner->email }}</p>
                <p><strong>Address:</strong> {{ $company->address }}</p>
                <p><strong>Industry:</strong> {{ $company->industry }}</p>
                <p><strong>Website:</strong> <a href="{{ $company->website }}" class="text-blue-500 underline hover:text-blue-700" target="_blank">{{ $company->website }}</a></p>
            </div>

            {{-- Edit and Archive Buttons --}}
            <div class="flex mb-6 space-x-4">
                @if (auth()->user()->role == 'company-owner')
                    <a href="{{ route('my-company.edit') }}" 
                        class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Edit Company
                    </a>
                @else
                    <a href="{{ route('companies.edit', ['company' => $company->id, 'redirectToList' => 'false']) }}" 
                        class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Edit Company
                    </a>
                @endif
                @if (auth()->user()->role == 'admin')
                    <form action="{{ route('companies.destroy', $company->id)}}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 font-semibold text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to archive this company?');">
                            Archive Company
                        </button>
                    </form>
                @endif
            </div>

            @if (auth()->user()->role == 'admin')
                {{-- Tabs Navigation --}}
                <div class="mb-6">
                    <ul class="flex space-x-4">
                        <li>
                            <a href="{{ route('companies.show', ['company' => $company->id, 'tab' => 'jobs']) }}" 
                                class="px-4 py-2 font-semibold text-gray-800 {{ request('tab') == 'jobs' || request('tab') == '' ? 'border-b-2 border-blue-600' : '' }}">
                                Jobs
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('companies.show',['company' => $company->id, 'tab' => 'applications']) }}" 
                                class="px-4 py-2 font-semibold text-gray-800 {{ request('tab') == 'applications' ? 'border-b-2 border-blue-600' : '' }}">
                                Applications
                            </a>
                        </li>
                    </ul>
                </div>
                
                {{-- Tabs Content --}}
                <div>
                    {{-- Jobs Tab --}}
                    <div id="jobs" class="{{ request('tab') == 'jobs' || request('tab') == '' ? 'block' : 'hidden' }}">
                        <table class="min-w-full mt-4 bg-white divide-y divide-gray-200 rounded-lg shadow">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left bg-gray-100 rounded-tl-lg">Title</th>
                                    <th class="px-4 py-2 text-left bg-gray-100">Type</th>
                                    <th class="px-4 py-2 text-left bg-gray-100">Location</th>
                                    <th class="px-4 py-2 text-left bg-gray-100 rounded-tr-lg">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Get data from jobVacancies (HasMany) --}}
                                @foreach ($company->jobVacancies as $job)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $job->title }}</td>
                                    <td class="px-4 py-2 border-b">{{ $job->type }}</td>
                                    <td class="px-4 py-2 border-b">{{ $job->location }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <a href="{{ route('job-vacancies.show', $job->id) }}" class="text-blue-500 underline hover:text-blue-700">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Applications Tab --}}
                    <div id="applications" class="{{ request('tab') == 'applications' ? 'block' : 'hidden' }}">
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
                                {{-- Get data from jobVacancies (HasMany) --}}
                                @foreach ($applications as $application)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $application->user->name }}</td>
                                    <td class="px-4 py-2 border-b">{{ $application->jobVacancy->title }}</td>
                                    <td class="px-4 py-2 border-b">{{ $application->status }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <a href="{{ route('job-applications.show', $application->id) }}" class="text-blue-500 underline hover:text-blue-700">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            
        </div>

    </div>
</x-app-layout>
