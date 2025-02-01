<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('reference');
      $table->string('name');
      $table->integer('quantity');
      $table->integer('quantity_box');
      $table->integer('quantity_pack');
      $table->double('purchase_price');
      $table->double('price');
      $table->foreignId('brand_id')->constrained()->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('products');
  }

};
