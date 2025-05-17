<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Order Details') }}
      </h2>
      <a href="{{ route('admin.order.index') }}" class="px-4 py-2 bg-gray-200 rounded-md text-gray-700 text-sm font-medium hover:bg-gray-300 transition duration-150 ease-in-out">
        Back to Orders
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="mb-6">
            <h4 class="text-md font-medium text-gray-700 mb-2">Order Information:</h4>
            <div class="grid grid-cols-2 gap-4 mb-4">
              <div>
                <p><span class="font-medium">Customer Name:</span> {{ $model->full_name }}</p>
                <p><span class="font-medium">Phone:</span> {{ $model->phone }}</p>
                <p><span class="font-medium">Delivery Address:</span> {{ $model->address }}</p>
              </div>
              <div class="text-right">
                <p><span class="font-medium">Order Date:</span> {{ $model->created_at->format('M d, Y') }}</p>
                <p><span class="font-medium">Order Total:</span> ${{ number_format($model->total, 2) }}</p>
              </div>
            </div>
          </div>

          <div class="mb-6">
            <h4 class="text-md font-medium text-gray-700 mb-2">Order Items:</h4>
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach($model->orderItems as $item)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                      <div class="flex items-center">
                        @if($item->product && $item->product->getFirstMediaUrl())
                        <div class="flex-shrink-0 h-12 w-12 mr-4">
                          <img class="h-12 w-12 object-cover rounded" src="{{ $item->product->getFirstMediaUrl() }}" alt="{{ $item->product->name ?? 'Product' }}">
                        </div>
                        @endif
                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'Product' }}</div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->price, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->price * $item->quantity, 2) }}</td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">Total:</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{ number_format($model->total, 2) }}</td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>