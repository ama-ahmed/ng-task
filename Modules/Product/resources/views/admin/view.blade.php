<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Details') }}
            </h2>
            <a href="{{ route('admin.product.index') }}" class="px-4 py-2 bg-gray-200 rounded-md text-gray-700 text-sm font-medium hover:bg-gray-300 transition duration-150 ease-in-out">
                Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Product Image -->
                        <div class="w-full md:w-1/3">
                            @if($model->getFirstMediaUrl())
                                <img src="{{ $model->getFirstMediaUrl() }}" alt="{{ $model->name }}" class="w-full h-auto rounded-lg shadow-md object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">No image available</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Details -->
                        <div class="w-full md:w-2/3">
                            <div class="mb-6">
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $model->name }}</h1>
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        {{ $model->category->name ?? 'Uncategorized' }}
                                    </span>
                                    <span class="text-2xl font-bold text-green-600">${{ number_format($model->price, 2) }}</span>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <h2 class="text-xl font-semibold mb-2">Description</h2>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $model->description }}</p>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <h2 class="text-xl font-semibold mb-2">Product Details</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Product ID</p>
                                        <p class="font-medium">{{ $model->id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Category</p>
                                        <p class="font-medium">{{ $model->category->name ?? 'Uncategorized' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Created At</p>
                                        <p class="font-medium">{{ $model->created_at->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Last Updated</p>
                                        <p class="font-medium">{{ $model->updated_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 flex gap-4">
                                <a href="{{ route('admin.product.edit', $model->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-150 ease-in-out">
                                    Edit Product
                                </a>
                                <form action="{{ route('admin.product.destroy', $model->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-150 ease-in-out" onclick="return confirm('Are you sure you want to delete this product?')">
                                        Delete Product
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>