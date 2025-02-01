@php
  $cart = session()->get('cart', []);
@endphp
@if (array_search($id, array_column($cart, 'id')) !== false)
  <button class="btn btn-link btn-cart" onclick="CartManager.remove({{ $id }})">
    <i class="fa-solid fa-check"></i>
  </button>
  @else
  <button class="btn btn-link btn-cart" onclick="CartManager.add(this)">
    <i class="fa-solid fa-cart-plus"></i>
  </button>
@endif
