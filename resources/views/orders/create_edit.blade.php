<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($order) ? __('Update Order') : __('Create Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <form action="{{ isset($order) ? route('orders.edit', $order->id) : route('orders.create') }}" method="POST">
                @csrf

                <div class="form-group">
                  <label for="reference">Order reference</label>
                  <input type="text" name="reference" id="reference" class="form-control" value="{{ isset($order) ? $order->reference : old('reference') }}" required>
                </div>

                <div class="form-group">
                  <label for="total">Price</label>
                  <input type="number" name="total" id="total" class="form-control" value="{{ isset($order) ? $order->total : old('total') }}" required>
                </div>

                <div class="form-group">
                  <label for="net_profit">Net Profit</label>
                  <input type="number" name="net_profit" id="net_profit" class="form-control" value="{{ isset($order) ? $order->net_profit : old('net_profit') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($order) ? 'Update' : 'Create' }} Order</button>
              </form>
            </div>
        </div>
    </div>
</x-app-layout>
