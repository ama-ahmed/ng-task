<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('order list') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto relative">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="py-3 px-6">ID</th>
                                    <th scope="col" class="py-3 px-6">full name</th>
                                    <th scope="col" class="py-3 px-6">phone</th>
                                    <th scope="col" class="py-3 px-6">address</th>
                                    <th scope="col" class="py-3 px-6">total</th>
                                    <th scope="col" class="py-3 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-4 px-6">{{ $item->id }}</td>
                                    <td class="py-4 px-6">{{ $item->full_name ?? 'N/A' }}</td>
                                    <td class="py-4 px-6">{{ $item->phone ?? 'N/A' }}</td>
                                    <td class="py-4 px-6">{{ $item->address ?? 'N/A' }}</td>
                                    <td class="py-4 px-6">{{ $item->total ?? 'N/A' }}</td>
                                    <td class="py-4 px-6 flex space-x-2">
                                        <a href="{{ route('admin.order.show', $item->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white border-b">
                                    <td colspan="4" class="py-4 px-6 text-center">No orders found</td>
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