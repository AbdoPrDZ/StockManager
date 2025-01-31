<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Cart') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        @php
          $cart = session()->get('cart', []);
          dump($cart);
        @endphp

        @if(count($cart) > 0)
          @foreach($cart as $id => $item)
            <div class="p-4 border-b border-gray-200" aria-id="{{ $id }}">
              <div class="flex items-center">
                <div class="w-1/4 px-2">
                  <label>
                    {{ \App\Models\Product::find($id)->name }}
                  </label>
                </div>

                <div class="w-1/4 px-2">
                  <input type="number" name="quantity" value="{{ $item['quantity'] }}" class="form-input w-full">
                </div>

                <div class="w-1/4 px-2">
                  <input type="text" name="price" value="{{ $item['price'] }}" class="form-input w-full">
                </div>

                {{-- <div class="w-1/4 px-2">
                  <input type="text" name="purchase_price" value="{{ $item['purchase_price'] }}" class="form-input w-full">
                </div> --}}

                <div class="w-1/4 px-2">
                  <select name="type" value="{{ $item['type'] }}">
                    <option value="box">Carton</option>
                    <option value="pack">Pack</option>
                    <option value="unit">Unit</option>
                  </select>
                </div>

                <div class="w-1/4 px-2">
                  <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="updateCartItem({{ $id }})">
                    Save
                  </button>
                  <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="deleteCartItem({{ $id }})">
                    Delete
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        @else
          <p class="p-4">Your cart is empty.</p>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>

<script>
  function updateCartItem(id) {
    const quantity = document.querySelector(`[aria-id="${id}"] input[name="quantity"]`).value;
    const price = document.querySelector(`[aria-id="${id}"] input[name="price"]`).value;
    // const purchase_price = document.querySelector(`[aria-id="${id}"] input[name="purchase_price"]`).value;
    const type = document.querySelector(`[aria-id="${id}"] select[name="type"]`).value;

    window.addToCart(
      id,
      quantity,
      // purchase_price,
      price,
      type,
    )
  }

  function deleteCartItem(id) {
    fetch(`/cart/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        document.querySelector(`[aria-id="${id}"]`).remove();
      } else {
        alert('Failed to delete item');
      }
    })
    .catch(error => console.error('Error:', error));
  }

  function clearCart() {
    fetch('/cart', {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        document.querySelectorAll('[aria-id]').forEach(item => item.remove());
      } else {
        alert('Failed to clear cart');
      }
    })
    .catch(error => console.error('Error:', error));
  }

</script>
