<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Job Vacancy') }}
        </h2>
    </x-slot>

    <div class="p-6 overflow-x-auto">
        <div class="max-w-2xl p-6 mx-auto bg-white rounded-lg shadow-md">
            <form action="{{ route('job-vacancies.store') }}" method="POST">
                @csrf

                {{-- Job Vacancy Details  --}}
                <div class="p-6 mb-4 border border-gray-100 rounded-lg shadow-sm bg-gray-50">
                    <h3 class="text-lg font-bold">Job vacancy Details</h3>
                    <p class="mb-2 text-sm text-gray-500">Enter Job vacancy Details</p>
                    

                    {{-- Title --}}
                    <div class="mb-4">
                        <label for="title" class="block mb-2 text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title')}}"
                            class="{{ $errors->has('title') ? 'outline-red-500 outline outline-1' : '' }} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Location --}}
                    <div class="mb-4">
                        <label for="location" class="block mb-2 text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" value="{{ old('location')}}"
                            class="{{ $errors->has('location') ? 'outline-red-500 outline outline-1' : '' }} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('location')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Salary --}}
                    <div class="mb-4">
                        <label for="salary" class="block mb-2 text-sm font-medium text-gray-700">Expected Salary (£)</label>
                        <input type="text" name="salary" id="salary" value="{{ old('salary')}}"
                            class="{{ $errors->has('salary') ? 'outline-red-500 outline outline-1' : '' }} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('salary')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Type --}}
                    <div class="mb-4">
                        <label for="type" class="block mb-2 text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type" class="{{ $errors->has('type') ? 'outline-red-500 outline outline-1' : '' }} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Full-Time" {{ old('type') == 'Full-Time' ? 'selected' : ''}}>Full-Time</option>
                            <option value="Part-Time" {{ old('type') == 'Part-Time' ? 'selected' : ''}}>Part-Time</option>
                            <option value="Remote" {{ old('type') == 'Remote' ? 'selected' : ''}}>Remote</option>
                            <option value="Hybrid" {{ old('type') == 'Hybrid' ? 'selected' : ''}}>Hybrid</option>
                            <option value="Volunteer" {{ old('type') == 'Volunteer' ? 'selected' : ''}}>Volunteer</option>
                        </select>
                        @error('type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Company Select Dropdown --}}
                    @if (auth()->user()->role === 'admin')
                        <div class="mb-4">
                            <label for="companyId" class="block mb-2 text-sm font-medium text-gray-700">Company</label>
                            <select name="companyId" id="companyId" class="{{ $errors->has('companyId') ? 'outline-red-500 outline outline-1' : '' }}w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('companyId') == $company->id ? 'selected' : ''}}>{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @error('companyId')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                    @if (auth()->user()->role == 'company-owner')
                        <div class="mb-4">
                            <label for="companyId" class="block mb-2 text-sm font-medium text-gray-700">Company</label>
                            <input
                                type="text"
                                id="companyName"
                                name="companyName"
                                value="{{ auth()->user()->company->first()->name }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed"
                                disabled
                            >
                            {{-- hidden input to submit the company ID --}}
                            <input type="hidden" name="companyId" value="{{ auth()->user()->company->first()->id }}">
                        </div>
                    @endif



                    {{-- Job Category Select Dropdown --}}
                    <div class="mb-4">
                        <label for="categoryId" class="block mb-2 text-sm font-medium text-gray-700">Job Category</label>
                        <select name="categoryId" id="categoryId" class="{{ $errors->has('categoryId') ? 'outline-red-500 outline outline-1' : '' }} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach ($jobCategories as $jobCategory)
                                <option value="{{ $jobCategory->id }}" {{ old('categoryId') == $jobCategory->id ? 'selected' : ''}}>{{ $jobCategory->name }}</option>
                            @endforeach
                        </select>
                        @error('categoryId')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Job Description --}}
                    <div class="mb-4">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Job Description</label>
                        <textarea rows="4" name="description" id="description" value="{{ old('description')}}" class="{{ $errors->has('description') ? 'outline-red-500 outline outline-1' : '' }} resize-none w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                
                </div>
                
                <div class="flex items-center justify-end">
                    <a href="{{ route('job-vacancies.index') }}" class="px-4 mr-4 text-gray-500 rounded-md hover:text-gray-700">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Add Job Vacancy
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>