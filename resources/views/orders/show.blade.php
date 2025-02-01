@php
  $order = \App\Models\Order::find($order);
@endphp

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Order', ['id' => $order]) }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <x-label for="reference" value="{{ __('Order reference') }}" />
        <p id="reference" class="p-4">{{ $order->reference }}</p>

        <hr>

        <x-label for="cart" value="{{ __('Items Count') }}" />
        <p id="cart" class="p-4">{{ $order->products->count() }}</p>

        <hr>

        <x-label for="total" value="{{ __('Total') }}" />
        <p id="total" class="p-4">{{ $order->total }}</p>

        <hr>

        <x-label for="profit" value="{{ __('Profit') }}" />
        <p id="profit" class="p-4">{{ $order->profit }}</p>

        <hr>

        <x-label for="net-profit" value="{{ __('Net Profit') }}" />
        <p id="net-profit" class="p-4">{{ $order->net_profit }}</p>

        <hr>

        <a href="{{ route('orders.edit', $order->id) }}" class="ms-4">
          {{ __('Edit') }}
        </a>
        {{-- delete --}}
        <form action="{{ route('orders.delete', $order->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <x-button type="submit" class="ms-4">
            {{ __('Delete') }}
          </x-button>
        </form>
      </div>
    </div>
  </div>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <h1 class="text-center text-2xl font-bold p-4">
          {{ __('Order Products') }}
        </h1>
        <livewire:order-products-table order_id="{{ $order->id }}" />
      </div>
    </div>
  </div>
</x-app-layout>
