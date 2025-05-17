<x-client-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Your Cart') }}
      </h2>

      <a href="{{ route('product.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        Continue Shopping
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <h3 class="text-lg font-medium text-gray-900 mb-6">Checkout Information</h3>
          
          <form method="POST" action="{{ route('order.store') }}" class="space-y-6">
            @csrf
            
            <div>
              <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
              <div class="mt-1">
                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
              </div>
              @error('full_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div>
              <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
              <div class="mt-1">
                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
              </div>
              @error('phone')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div>
              <label for="address" class="block text-sm font-medium text-gray-700">Delivery Address</label>
              <div class="mt-1">
                <textarea name="address" id="address" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>{{ old('address') }}</textarea>
              </div>
              @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
            
            <div class="pt-4 border-t border-gray-200">
              <h4 class="text-md font-medium text-gray-900 mb-4">Order total price: ${{ number_format($cart->total, 2) }}</h4>
            </div>
            
            <div>
              <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Place Order
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-client-layout>