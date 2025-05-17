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
          <div id="cart-container">
            @if(isset($cart) && $cart->items->count() > 0)
            <div class="overflow-x-auto">
              <table class="min-w-full bg-white">
                <thead>
                  <tr class="w-full h-16 border-b border-gray-200 bg-gray-50">
                    <th class="pl-6 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cart->items as $item)
                  <tr class="border-b border-gray-200" id="cart-item-{{ $item->id }}">
                    <td class="pl-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        @if($item->product->getFirstMediaUrl())
                        <div class="flex-shrink-0 h-16 w-16">
                          <img class="h-16 w-16 object-cover rounded" src="{{ $item->product->getFirstMediaUrl() }}" alt="{{ $item->product->name }}">
                        </div>
                        @endif
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                          <div class="text-sm text-gray-500">{{ $item->product->category->name }}</div>
                        </div>
                      </div>
                    </td>
                    <td class="py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">${{ number_format($item->product->price, 2) }}</div>
                    </td>
                    <td class="py-4 whitespace-nowrap">
                      <div class="flex items-center {{ $item->quantity == 1 ? 'pl-7': '' }}">
                        @if($item->quantity > 1)
                        <button
                          onclick="updateQuantity({{ $item->id }}, -1)"
                          class="text-gray-500 focus:outline-none focus:text-gray-600 p-1 rounded-md hover:bg-gray-100">
                          <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M20 12H4"></path>
                          </svg>
                        </button>
                        @endif
                        <span class="text-gray-700 mx-2" id="quantity-{{ $item->id }}">{{ $item->quantity }}</span>
                        <button
                          onclick="updateQuantity({{ $item->id }}, 1)"
                          class="text-gray-500 focus:outline-none focus:text-gray-600 p-1 rounded-md hover:bg-gray-100">
                          <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 4v16m8-8H4"></path>
                          </svg>
                        </button>
                      </div>
                    </td>
                    <td class="py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900" id="item-total-{{ $item->id }}">${{ number_format($item->price, 2) }}</div>
                    </td>
                    <td class="py-4 whitespace-nowrap text-right text-sm font-medium pr-6">
                      <button
                        onclick="removeItem({{ $item->id }})"
                        class="text-red-600 hover:text-red-900 focus:outline-none">
                        <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                          <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                      </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            <div class="mt-8 flex justify-end">
              <div class="bg-gray-50 p-6 rounded-lg shadow-sm w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                <div class="border-t border-gray-200 pt-4">
                  <div class="flex justify-between items-center mb-2">
                    <span class="text-base font-medium text-gray-900">Subtotal</span>
                    <span class="text-base font-medium text-gray-900" id="cart-subtotal">${{ number_format($cart->total, 2) }}</span>
                  </div>
                  <div class="flex justify-between items-center mb-2 text-sm text-gray-600">
                    <span>Shipping</span>
                    <span>Calculated at checkout</span>
                  </div>
                  <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-900">Total</span>
                    <span class="text-lg font-bold text-gray-900" id="cart-total">${{ number_format($cart->total, 2) }}</span>
                  </div>
                </div>
                <div class="mt-6">
                  <a href="{{ route('order.checkout') }}" class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Proceed to Checkout
                  </a>
                </div>
              </div>
            </div>
            @else
            <div class="text-center py-12">
              <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
              <h3 class="mt-2 text-lg font-medium text-gray-900">Your cart is empty</h3>
              <p class="mt-1 text-sm text-gray-500">Start adding some items to your cart!</p>
              <div class="mt-6">
                <a href="{{ route('product.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  Continue Shopping
                </a>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Update item quantity
    function updateQuantity(itemId, change) {
      fetch("{{route('cart.update-quantity')}}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            item_id: itemId,
            change: change
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.status) {
            // Update quantity display
            const quantityElement = document.getElementById(`quantity-${itemId}`);
            quantityElement.textContent = data.item.quantity;

            // Update item total price
            const itemTotalElement = document.getElementById(`item-total-${itemId}`);
            itemTotalElement.textContent = `$${parseFloat(data.item.price).toFixed(2)}`;

            // Update cart subtotal and total
            document.getElementById('cart-subtotal').textContent = `$${parseFloat(data.cart.total).toFixed(2)}`;
            document.getElementById('cart-total').textContent = `$${parseFloat(data.cart.total).toFixed(2)}`;


            // Show/hide decrease button based on quantity
            const itemRow = document.getElementById(`cart-item-${itemId}`);
            if (data.item.quantity === 1) {
              const quantityCell = itemRow.querySelector(`td:nth-child(3) .flex`);
              quantityCell.classList.add('pl-7');
              // If quantity is 1, remove the decrease button if it exists
              const decreaseButton = itemRow.querySelector(`button[onclick="updateQuantity(${itemId}, -1)"]`);
              if (decreaseButton) {
                decreaseButton.remove();
              }
            } else if (data.item.quantity === 2 && change === 1) {
              // If quantity was just increased to 2, add the decrease button
              const quantityCell = itemRow.querySelector(`td:nth-child(3) .flex`);
              quantityCell.classList.remove('pl-7');
              if (!quantityCell.querySelector(`button[onclick="updateQuantity(${itemId}, -1)"]`)) {
                const decreaseButton = document.createElement('button');
                decreaseButton.setAttribute('onclick', `updateQuantity(${itemId}, -1)`);
                decreaseButton.className = 'text-gray-500 focus:outline-none focus:text-gray-600 p-1 rounded-md hover:bg-gray-100';
                decreaseButton.innerHTML = `<svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M20 12H4"></path></svg>`;

                const quantitySpan = quantityCell.querySelector('span');
                quantityCell.insertBefore(decreaseButton, quantitySpan);
              }
            }
          } else {
            alert(data.message || 'Failed to update quantity');
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred while updating the quantity');
        });
    }

    // Remove item from cart
    function removeItem(itemId) {
      if (confirm('Are you sure you want to remove this item from your cart?')) {
        fetch("{{route('cart.remove-item')}}", {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              item_id: itemId
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.status) {
              // Remove the item row
              const itemRow = document.getElementById(`cart-item-${itemId}`);
              itemRow.remove();

              // Update cart subtotal and total
              document.getElementById('cart-subtotal').textContent = `$${parseFloat(data.cart.total).toFixed(2)}`;
              document.getElementById('cart-total').textContent = `$${parseFloat(data.cart.total).toFixed(2)}`;


              // If cart is now empty, refresh the page to show empty cart message
              if (data.cartCount === 0) {
                window.location.reload();
              }
            } else {
              alert(data.message || 'Failed to remove item');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the item');
          });
      }
    }
  </script>
</x-client-layout>