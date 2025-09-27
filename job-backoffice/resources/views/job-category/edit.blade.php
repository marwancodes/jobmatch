<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Job Categories') }}
        </h2>
    </x-slot>

    <div class="p-6 overflow-x-auto">
        <div class="max-w-2xl p-6 mx-auto bg-white rounded-lg shadow-md">
            <form action="{{ route('job-categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                        class="{{ $errors->has('name') ? 'outline-red-500 outline outline-1' : '' }} w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('job-categories.index') }}" class="px-4 mr-4 text-gray-500 rounded-md hover:text-gray-700">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
