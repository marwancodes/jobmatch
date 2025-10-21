<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Job Applications {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>
    
    <div class="p-6 overflow-x-auto">

        {{-- Success Message --}}
        <x-toast-notification />

        <div class="flex items-center justify-between">
            
            @if (request()->has('archived') && request()->input('archived') == 'true')
                {{-- Active --}}
                <a href="{{ route('job-applications.index') }}" 
                    class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Active Job Vacancies
                </a>
            @else
                {{-- Archived --}}
                <a href="{{ route('job-applications.index', ['archived' =>  'true' ]) }}" 
                    class="px-4 py-2 font-semibold text-white bg-gray-600 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Archived Job Vacancies
                </a>
            @endif
            

        </div>

        {{-- Job Category Table --}}
        <table class="min-w-full mt-4 bg-white divide-y divide-gray-200 rounded-lg shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Applicant Name</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Position (Job Vacancy)</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Company</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Status</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jobApplications as $jobApplication)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-500">
                            @if (request()->input('archived') == 'true')
                                <span>{{ $jobApplication->user->name }}</span>
                            @else
                                <a class="text-blue-500 underline hover:text-blue-700" href="{{ route('job-applications.show', $jobApplication->id)}}">{{ $jobApplication->user->name }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy->title }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->jobVacancy->company->name }}</td>
                        <td class="px-6 py-4 text-gray-800">{{ $jobApplication->status }}</td>
                        <td>
                            <div class="flex space-x-4">

                                @if (request()->has('archived') && request()->input('archived') == 'true')
                                    {{-- Restore Button --}}
                                    <form action="{{ route('job-applications.restore', $jobApplication->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-800" onclick="return confirm('Are you sure you want to restore this job vacancy?');">
                                            ♻️ Restore
                                        </button>
                                    </form>
                                @else 
                                    {{-- Edit Button --}}
                                    <a href="{{ route('job-applications.edit', $jobApplication->id)}}" class="text-blue-500 hover:text-blue-700">
                                        ✏️ Edit
                                    </a>
        
                                    {{-- Delete Button --}}
                                    <form action="{{ route('job-applications.destroy', $jobApplication->id)}}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ml-4 text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this job vacancy?');">
                                            🗂️ Archive
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="w-full px-6 py-4 text-center text-gray-500">
                            No job Applications found.
                        </td>
                    </tr>
                @endforelse 
            </tbody>
        </table>

        {{-- Pagination Links --}}
        <div class="mt-4">
            {{ $jobApplications->links() }}
        </div>

    </div>

</x-app-layout>
