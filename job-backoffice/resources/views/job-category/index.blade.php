<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Job Categories') }}
        </h2>
    </x-slot>
    
    <div class="p-6 overflow-x-auto">
        

        {{-- Add Category Button --}}
        <div class="flex items-center justify-end">
            <a href="{{ route('job-categories.create') }}" class="px-4 py-2 font-semibold text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                Add Job Category
            </a>
        </div>

        {{-- Job Category Table --}}
        <table class="min-w-full mt-4 bg-white divide-y divide-gray-200 rounded-lg shadow">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Category Name</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-gray-800">{{ $category->name }}</td>
                        <td>
                            <div class="flex space-x-4">
                                {{-- Edit Button --}}
                                <a href="{{ route('job-categories.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700">
                                    Edit
                                </a>
    
                                {{-- Delete Button --}}
                                <form action="{{ route('job-categories.destroy', $category->id)}}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-4 text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this category?');">
                                        Archive
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach 
            </tbody>
        </table>

        {{-- Pagination Links --}}
        <div class="mt-4">
            {{ $categories->links() }}
        </div>

    </div>

</x-app-layout>
