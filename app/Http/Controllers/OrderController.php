<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller {

  /**
   * Display a listing of the resource.
   */
  public function index() {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    //
  }

  /**`
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    if ($request->has('products')) try {
      $products = json_decode($request->products, true);
      $request->merge(['products' => $products]);
    } catch (\Throwable $th) {
      //throw $th;
    }

    $request->validate([
      'reference'           => 'required|min:2|max:255',
      'products'            => 'required|array|min:1',
      'products.*.id'       => 'required|exists:products,id',
      'products.*.quantity' => 'required|numeric|min:1',
      'products.*.price'    => 'required|numeric|min:0',
      'products.*.type'     => 'required|in:box,pack,unit',
    ]);

    $order = Order::create(['reference' => $request->reference]);

    $total = 0;
    $profit = 0;
    $net_profit = 0;

    foreach ($request->products as $item) {
      $product = Product::find($item['id']);

      $purchase_price  = array_key_exists('purchase_price', $item) ? $item['purchase_price'] : $product->purchase_price;

      // TODO:: Check those calculates
      // ----------------------------------------------------------------
      $item_total      = $item['quantity'] * $item['price'];
      $item_profit     = $total - ($purchase_price * $item['quantity']);
      $item_net_profit = $profit - ($total * 0.03);

      $total      += $item_total;
      $profit     += $item_profit;
      $net_profit += $item_net_profit;
      // ----------------------------------------------------------------
      
      $order->products()->create([
        'product_id'     => $item['id'],
        'quantity'       => $item['quantity'],
        'type'           => $item['type'],
        'price'          => $item['price'],
        'purchase_price' => $purchase_price,
        'total'          => $item_total,
        'profit'         => $item_profit,
        'net_profit'     => $item_net_profit,
      ]);
    }

    $order->update([
      'total'      => $total,
      'profit'     => $profit,
      'net_profit' => $net_profit,
    ]);

    session()->forget('cart');

    return redirect()->route('orders')->with('messages', [
      [
        'type' => 'success',
        'message' => 'Order created successfully',
      ]
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(Order $order) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Order $order) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Order $order) {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Order $order) {
    //
  }

}
