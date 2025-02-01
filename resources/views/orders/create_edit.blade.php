@php
  if (isset($order)) $order = \App\Models\Order::find($order);
@endphp

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ isset($order) ? __('Update Order') : __('Create Order') }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-12">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <form id="order-form" action="{{ isset($order) ? route('orders.edit', $order->id) : route('orders.create') }}" method="POST">
          @csrf

          <input type="hidden" name="products" value="{{ json_encode(old('products', isset($order) ? $order->products->toArray() : [])) }}">

          <div class="mt-4">
            <x-label for="reference" value="{{ __('Order reference') }}" />
            <x-input id="reference" class="block mt-1 w-full" type="text" name="reference" value="{{ old('reference', isset($order) ? $order->reference : '') }}" required />
          </div>

          <div class="mt-4">
            <x-label for="cart" value="{{ __('Cart Items') }}" />
            @include('cart')
          </div>

          <x-button class="ms-4" onclick="CartManager.loadInput()">
            {{ __(isset($order) ? 'Update Order' : 'Create Order') }}
          </x-button>
        </form>
      </div>
    </div>
  </div>

  <div class="py-2">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <h1 class="text-center text-2xl font-bold p-4">Select More Products</h1>
        <livewire:products-table />
      </div>
    </div>
  </div>
</x-app-layout>
