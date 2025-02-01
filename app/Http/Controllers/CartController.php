<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller {

  public function all() {
    $items = session()->get('cart', []);

    for ($i=0; $i < count($items); $i++)
      $items[$i]['product_name'] = Product::find($items[$i]['id'])->name;

    return response()->json([
      'success' => true,
      'message' => 'Cart retrieved successfully',
      'items'   => $items,
    ]);
  }

  public function count() {
    $cart = session()->get('cart', []);

    return response()->json([
      'success' => true,
      'message' => 'Cart count retrieved successfully',
      'count' => count($cart),
    ]);
  }

  public function add(Request $request, Product $product) {
    $cart = session()->get('cart', []);

    if (array_search($product->id, array_column($cart, 'id')) !== false)
      return response()->json([
        'success' => false,
        'message' => 'Product already exists in cart',
      ], 200);

    $request->validate([
      'quantity'       => 'required|numeric|min:0',
      'type'           => 'required|in:unit,pack,box',
      'purchase_price' => 'nullable|numeric|min:0',
      'price'          => 'nullable|numeric|min:0',
    ]);


    $price = $request->price ?? $product->price;

    $item = [
      'id'             => $product->id,
      'quantity'       => $request->quantity,
      'type'           => $request->type,
      'purchase_price' => $request->purchase_price ?? $product->purchase_price,
      'price'          => $price,
    ];
    $cart[] = $item;

    session()->put('cart', $cart);

    $item['product_name'] = $product->name;

    return response()->json([
      'success' => true,
      'message' => 'Product added to cart successfully',
      'item'    => $item,
    ]);
  }

  public function remove(Request $request, Product $product) {
    $cart = session()->get('cart', []);

    if (($index = array_search($product->id, array_column($cart, 'id'))) === false)
      return response()->json([
        'success' => false,
        'message' => 'Product does not exist in cart',
      ], 200);

    unset($cart[$index]);

    session()->put('cart', $cart);

    return response()->json([
      'success' => true,
      'message' => 'Product removed from cart successfully',
    ]);
  }

  public function clear(Request $request) {
    session()->forget('cart');

    return response()->json([
      'success' => true,
      'message' => 'Cart cleared successfully',
    ]);
  }

}
