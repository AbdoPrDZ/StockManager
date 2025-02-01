<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return redirect()->route('dashboard');
});

Route::middleware([
  'auth:sanctum',
  config('jetstream.auth_session'),
  'verified',
])->group(function () {
  Route::view('/dashboard', 'dashboard')
        ->name('dashboard');

  Route::prefix('brands')->group(function () {
    Route::view('/',  'brands.index')
          ->name('brands');
    Route::view('/create', 'brands.create_edit')
          ->name('brands.create.view');
    Route::post('/', [BrandController::class, 'store'])
          ->name('brands.create');

    Route::prefix('/{brand}')->group(function() {
      Route::view('/', 'brands.show')
            ->name('brands.show');
      Route::view('/edit', 'brands.create_edit')
            ->name('brands.edit.view');
      Route::post('/', [BrandController::class, 'update'])
            ->name('brands.edit');
      Route::delete('/', [BrandController::class, 'destroy'])
          ->name('brands.delete');
    });
  });

  Route::prefix('products')->group(function () {
    Route::view('/',  'products.index')
          ->name('products');
    Route::view('/create', 'products.create_edit')
          ->name('products.create.view');
    Route::post('/', [ProductController::class, 'store'])
          ->name('products.create');

    Route::prefix('/{product}')->group(function() {
      Route::get('/', [ProductController::class, 'show'])
            ->name('products.show');
      Route::view('/edit', 'products.create_edit')
            ->name('products.edit.view');
      Route::post('/', [ProductController::class, 'update'])
            ->name('products.edit');
      Route::delete('/', [ProductController::class, 'destroy'])
          ->name('products.delete');
      Route::get('/image', [ProductController::class, 'image'])
          ->name('products.image');
    });
  });

  Route::prefix('cart')->group(function() {
    Route::get('/', [CartController::class, 'all'])
          ->name('cart');
    Route::get('/count', [CartController::class, 'count'])
          ->name('cart.count');
    Route::delete('/', [CartController::class, 'clear'])
          ->name('cart.clear');

    Route::prefix('/{product}')->group(function() {
      Route::post('/', [CartController::class, 'add'])
            ->name('cart.add');
      Route::delete('/', [CartController::class, 'remove'])
            ->name('cart.remove');
    });
  });

  Route::prefix('orders')->group(function () {
    Route::view('/',  'orders.index')
          ->name('orders');
    Route::view('/create', 'orders.create_edit')
          ->name('orders.create.view');
    Route::post('/', [OrderController::class, 'store'])
          ->name('orders.create');

    Route::prefix('/{order}')->group(function() {
      Route::view('/', 'orders.show')
            ->name('orders.show');
      Route::view('/edit', 'orders.create_edit')
            ->name('orders.edit.view');
      Route::post('/', [OrderController::class, 'update'])
            ->name('orders.edit');
      Route::delete('/', [OrderController::class, 'destroy'])
          ->name('orders.delete');
    });
  });
});
