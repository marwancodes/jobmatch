<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 flex flex-col gap-4">
        {{-- Overview Cards --}}
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            
            {{-- Active Users --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden p-6">
                <h3 class="text-lg font-medium text-gray-900">Active Users</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['activeUsers'] }}</p>
                <p class="text-sm text-gray-500">Last 30 days</p>
            </div>

            {{-- Total Jobs --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden p-6">
                <h3 class="text-lg font-medium text-gray-900">Total Jobs</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalJobs'] }}</p>
                <p class="text-sm text-gray-500">All time</p>
            </div>

            {{-- Total Applications --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden p-6">
                <h3 class="text-lg font-medium text-gray-900">Total Applications</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalApplications'] }}</p>
                <p class="text-sm text-gray-500">All time</p>
            </div>
            
        </div>

        {{-- Most Applied Jobs --}}
        <div class="bg-white rounded-lg shadow-sm overflow-hidden p-6">
            <h3 class="text-lg font-medium text-gray-900">Most Applied Jobs</h3>
            <div>
                <table class="w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr class="text-gray-500 uppercase text-sm">
                            <th class="text-left py-2">Job Title</th>
                            @if (Auth::user()->role === 'admin')
                                <th class="text-left py-2">Company</th>
                            @endif
                            <th class="text-left py-2">Total Applications</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($analytics['mostAppliedJobs'] as $job)
                            <tr>
                                <td class="py-4">{{ $job->title }}</td>
                                @if (Auth::user()->role === 'admin')
                                    <td class="py-4">{{ $job->company->name }}</td>
                                @endif
                                <td class="py-4">{{ $job->totalCount }}</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Conversion Rates --}}
        <div class="bg-white rounded-lg shadow-sm overflow-hidden p-6">
            <h3 class="text-lg font-medium text-gray-900">Top Conversion Job Posts</h3>
            <div>
                <table class="w-full divide-y divide-gray-200 mt-4">
                    <thead>
                        <tr class="text-gray-500 uppercase text-sm">
                            <th class="text-left py-2">Job Title</th>
                            <th class="text-left py-2">View</th>
                            <th class="text-left py-2">Applications</th>
                            <th class="text-left py-2">Conversion Rates</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($analytics['conversionRates']  as $conversionRate)
                            <tr>
                                <td class="py-4">{{ $conversionRate->title }}</td>
                                <td class="py-4">{{ $conversionRate->viewCount }}</td>
                                <td class="py-4">{{ $conversionRate->totalCount }}</td>
                                <td class="py-4">{{ $conversionRate->conversionRate }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
