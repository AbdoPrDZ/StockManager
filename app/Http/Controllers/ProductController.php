<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {

  /**
   * Display a listing of the resource.
   */
  public function index(ProductsDataTable $dataTable) {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $request->validate([
      'name'           => 'required|min:2|max:255',
      'reference'      => 'required|unique:products,reference',
      'quantity_box'   => 'required|integer|min:0',
      'quantity_pack'  => 'required|integer|min:0',
      'purchase_price' => 'required|numeric|min:0',
      'price'          => 'required|numeric|min:0',
      'brand_id'       => 'required|exists:brands,id',
    ]);

    $product = Product::create([
      'name'           => $request->name,
      'reference'      => $request->reference,
      'quantity_box'   => $request->quantity_box,
      'quantity_pack'  => $request->quantity_pack,
      'purchase_price' => $request->purchase_price,
      'price'          => $request->price,
      'brand_id'       => $request->brand_id,
    ]);

    return redirect()->route('products');
  }

  /**
   * Display the specified resource.
   */
  public function show(Product $product) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Product $product) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Product $product) {
    $request->validate([
      'name'           => 'required|min:2|max:255',
      'reference'      => "required|unique:products,reference,id,$product->id",
      'quantity_box'   => 'required|integer|min:0',
      'quantity_pack'  => 'required|integer|min:0',
      'purchase_price' => 'required|numeric|min:0',
      'price'          => 'required|numeric|min:0',
      'brand_id'       => 'required|exists:brands,id',
    ]);

    $product->update([
      'name'           => $request->name,
      'reference'      => $request->reference,
      'quantity_box'   => $request->quantity_box,
      'quantity_pack'  => $request->quantity_pack,
      'purchase_price' => $request->purchase_price,
      'price'          => $request->price,
      'brand_id'       => $request->brand_id,
    ]);

    return redirect()->route('products');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Product $product) {
    //
  }

}
