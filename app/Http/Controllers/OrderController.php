<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
    $request->merge(['cart', session()->get('cart', [])]);

    $request->validate([
      'reference'         => 'required|min:2|max:255',
      'cart'              => 'required|array|min:1',
      'cart.*.product_id' => 'required|exists:products,id',
      'cart.*.quantity'   => 'required|numeric|min:1',
      'cart.*.type'       => 'required|in:unit,pack,box',
      'cart.*.price'      => 'required|numeric|min:0',
    ]);


    $order = Order::create([
      'reference'  => $request->reference,
    ]);

    $total = 0;
    $profit = 0;
    $net_profit = 0;

    foreach ($request->cart as $productId => $item) {
      $order->products()->create([
        'product_id'     => $productId,
        'quantity'       => $item['quantity'],
        'type'           => $item['type'],
        'price'          => $item['price'],
        'purchase_price' => $item['purchase_price'],
        'total'          => $item['total'],
        'profit'         => $item['profit'],
        'net_profit'     => $item['net_profit'],
      ]);

      $total      = $item['quantity'] * $item['price'];
      $profit     = $total - ($item['purchase_price'] * $item['quantity']);
      $net_profit = $profit - ($total * 0.03);

      $total += $item['total'];
      $profit += $item['profit'];
      $net_profit += $item['net_profit'];
    }

    $order->update([
      'total'      => $total,
      'profit'     => $profit,
      'net_profit' => $net_profit,
    ]);

    session()->forget('cart');

    return redirect()->route('orders.index')->with('messages', [
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
