<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($product) ? __('Update Product') : __('Create Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
              <form action="{{ isset($product) ? route('products.edit', $product->id) : route('products.create') }}" method="POST">
                @csrf

                <div class="form-group">
                  <label for="reference">Product reference</label>
                  <input type="text" name="reference" id="reference" class="form-control" value="{{ isset($product) ? $product->reference : old('reference') }}" required>
                </div>

                <div class="form-group">
                  <label for="name">Product Name</label>
                  <input type="text" name="name" id="name" class="form-control" value="{{ isset($product) ? $product->name : old('name') }}" required>
                </div>

                <div class="form-group">
                  <label for="quantity-box">Quantity Carton</label>
                  <input type="number" name="quantity_box" id="quantity-box" class="form-control" value="{{ isset($product) ? $product->quantity_box : old('quantity_box') }}" required>
                </div>

                <div class="form-group">
                  <label for="quantity-pack">Quantity Pack</label>
                  <input type="number" name="quantity_pack" id="quantity-pack" class="form-control" value="{{ isset($product) ? $product->quantity_pack : old('quantity_pack') }}" required>
                </div>

                <div class="form-group">
                  <label for="purchase-price">Purchase Price</label>
                  <input type="number" name="purchase_price" id="purchase-price" class="form-control" value="{{ isset($product) ? $product->purchase_price : old('purchase_price') }}" required>
                </div>

                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="number" name="price" id="price" class="form-control" value="{{ isset($product) ? $product->price : old('price') }}" required>
                </div>

                <div class="form-group">
                  <label for="brand">Brand</label>
                  <select name="brand_id" id="brand" class="form-control" value="{{ isset($product) ? $product->brand_id : old('brand_id') }}" required>
                    @foreach (\App\Models\Brand::all() as $brand)
                      <option value="{{$brand->id}}">
                        {{ $brand->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Create' }} Product</button>
              </form>
            </div>
        </div>
    </div>
</x-app-layout>
