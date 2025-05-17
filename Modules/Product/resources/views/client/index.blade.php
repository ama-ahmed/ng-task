<x-client-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Products') }}
      </h2>

      <a href="{{ route('cart.index') }}" class="relative inline-flex items-center p-2 text-gray-700 hover:text-gray-900 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">0</span>
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @forelse ($items as $product)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-300 relative">
              <div class="relative pb-[100%] overflow-hidden bg-gray-100">
                @if($product->getFirstMediaUrl())
                <img src="{{ $product->getFirstMediaUrl() }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                @else
                <div class="absolute inset-0 flex items-center justify-center">
                  <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
                @endif
              </div>
              <div class="p-4">
                <div class="flex justify-between items-start mb-2">
                  <h3 class="text-lg font-medium text-gray-900 truncate">{{ $product->name }}</h3>
                  <span class="text-green-600 font-bold">${{ number_format($product->price, 2) }}</span>
                </div>
                <div class="mb-3 absolute top-2 right-2 z-20">
                  <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                    {{ $product->category->name }}
                  </span>
                </div>
                <button onclick="addToCart({{ $product->id }})" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition duration-300">
                  Add to Cart
                </button>
              </div>
            </div>
            @empty
            <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
              <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
              </svg>
              <p class="text-gray-500 text-lg">No products found</p>
            </div>
            @endforelse
          </div>

          <!-- Pagination -->
          <div class="mt-6">
            {{ $items->links() }}
          </div>
        </div>
      </div>
      <!-- Products Grid -->
    </div>
  </div>

  <script>
    // Cart functionality using AJAX
    function addToCart(id) {
      // Create the data to send
      const data = {
        product_id: id,
        quantity: 1
      };

      // Send AJAX request to add item to cart
      fetch("{{route('cart.add-item')}}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
      })
      .then(response => response.json())
      .then(data => {
        if (data.status) {
          // Update cart count from server response
          updateCartCount(data.cartCount);
          
          // Show success notification
          showNotification('Product added to cart!', 'success');
        } else {
          // Show error notification
          showNotification(data.message || 'Failed to add product to cart', 'error');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while adding to cart', 'error');
      });
    }

    function updateCartCount(count) {
      document.getElementById('cart-count').textContent = count;
    }
    
    function showNotification(message, type) {
      // You can replace this with a more sophisticated notification
      alert(message);
    }

    // Initialize cart count on page load
    document.addEventListener('DOMContentLoaded', function() {
      // Fetch current cart count from server
      fetch("{{route('cart.count')}}")
        .then(response => response.json())
        .then(data => {
          if (data.status) {
            updateCartCount(data.count);
          }
        })
        .catch(error => console.error('Error:', error));
    });
  </script>
</x-client-layout>