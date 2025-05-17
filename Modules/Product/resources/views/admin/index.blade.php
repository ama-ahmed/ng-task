<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('product list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <form action="{{ route('admin.product.index') }}" method="GET" class="flex items-center">
                            <div class="relative">
                                <input type="text" name="filter[name]" value="{{ request()->input('filter.name') }}" 
                                    placeholder="Search by name" 
                                    class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Search
                                </button>
                            </div>
                            @if(request()->has('filter'))
                                <a href="{{ route('admin.product.index') }}" class="ml-2 text-sm text-gray-600 hover:text-gray-900">
                                    Clear filters
                                </a>
                            @endif
                        </form>
                        
                        <a href="{{ route('admin.product.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add New Product</a>
                    </div>
                    
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">ID</th>
                                    <th scope="col" class="py-3 px-6">Name</th>
                                    <th scope="col" class="py-3 px-6">Price</th>
                                    <th scope="col" class="py-3 px-6">Category</th>
                                    <th scope="col" class="py-3 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="py-4 px-6">{{ $item->id }}</td>
                                        <td class="py-4 px-6">{{ $item->name ?? 'N/A' }}</td>
                                        <td class="py-4 px-6">{{ $item->price ?? 'N/A' }}</td>
                                        <td class="py-4 px-6">{{ $item->category->name?? 'N/A' }}</td>
                                        <td class="py-4 px-6 flex space-x-2">
                                            <a href="{{ route('admin.product.edit', $item->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>
                                            <a href="{{ route('admin.product.show', $item->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">View</a>
                                            <form action="{{ route('admin.product.destroy', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button  class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="5" class="py-4 px-6 text-center">No products found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>