<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller {

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

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $request->validate([
      'name' => 'required|min:2:max:255|unique:brands,name',
      'description' => 'required|min:4|max:255',
    ]);

    $brand = Brand::create([
      'name'        => $request->name,
      'description' => $request->description,
    ]);

    return redirect()->route('brands');
  }

  /**
   * Display the specified resource.
   */
  public function show(Brand $brand) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Brand $brand) {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Brand $brand) {
    $request->validate([
      'name'        => "required|min:2:max:255|unique:brands,name,id,$brand->id",
      'description' => 'required|min:4|max:255',
    ]);

    $brand->update([
      'name' => $request->name,
      'description' => $request->description,
    ]);

    return redirect()->route('brands');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Brand $brand) {
    $brand->delete();

    return redirect()->route('brands');
  }

}
