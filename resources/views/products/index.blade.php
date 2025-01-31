<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <livewire:products-table />
            </div>
        </div>
    </div>
</x-app-layout>

<script>
  window.addToCart = (productId, quantity = 1 /*, purchase_price = null */, price = null, type = 'box') => {
    fetch(`/cart/${productId}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        quantity: quantity,
        // purchase_price: purchase_price,
        price: price,
        type: type,
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Product added to cart successfully!');
      } else {
        alert('Failed to add product to cart.');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred. Please try again.');
    });
  }
</script>
