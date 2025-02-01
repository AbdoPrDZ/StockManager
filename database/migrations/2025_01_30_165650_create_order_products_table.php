<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('order_products', function (Blueprint $table) {
      $table->id();
      $table->foreignId('order_id')->constrained()->onDelete('cascade');
      $table->foreignId('product_id')->constrained()->onDelete('cascade');
      $table->enum('type', ['box', 'pack', 'unit'])->default('box');
      $table->integer('quantity');
      $table->double('purchase_price')->default(0);
      $table->double('price')->default(0);
      $table->double('total')->default(0);
      $table->double('profit')->default(0);
      $table->double('net_profit')->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('order_products');
  }

};
