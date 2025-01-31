<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller {

  public function add(Request $request, Product $product) {
    $request->validate([
      'quantity'       => 'required|numeric|min:0',
      'type'           => 'required|in:unit,pack,box',
      'purchase_price' => 'nullable|numeric|min:0',
      'price'          => 'nullable|numeric|min:0',
    ]);

    $cart = session()->get('cart', []);

    $price = $request->price ?? $product->price;

    $cart[$product->id] = [
      'quantity'       => $request->quantity,
      'type'           => $request->type,
      'purchase_price' => $request->purchase_price ?? $product->purchase_price,
      'price'          => $price,
    ];

    session()->put('cart', $cart);

    return response()->json(['message' => 'Product added to cart successfully']);
  }

  public function remove(Request $request, Product $product) {
    $cart = session()->get('cart', []);

    if (isset($cart[$product->id]))
      unset($cart[$product->id]);

    session()->put('cart', $cart);

    return response()->json(['message' => 'Product removed from cart successfully']);
  }

  public function clear(Request $request) {
    session()->forget('cart');

    return response()->json(['message' => 'Cart cleared successfully']);
  }

}
