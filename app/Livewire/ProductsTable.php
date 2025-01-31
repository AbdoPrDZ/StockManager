<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ProductsTable extends DataTableComponent {
  protected $model = Product::class;

  public function configure(): void {
    $this->setPrimaryKey('id');
  }

  public function columns(): array {
    return [
      Column::make('ID', 'id')
            ->searchable()->sortable(),
      Column::make('Reference', 'reference')
            ->searchable()->sortable(),
      Column::make('Name', 'name')
            ->searchable()->sortable(),
      Column::make('Brand', 'brand')
            ->searchable()->sortable()
            ->label(fn(Product $row, Column $column) => '<a href="' . route('brands.show', $row->id) . '">' . $row->brand_id . '</a>')
            ->html(),
      Column::make('Quantity Carton', 'quantity_box')
            ->searchable()->sortable(),
      Column::make('Quantity Pack', 'quantity_pack')
            ->searchable()->sortable(),
      Column::make('Price', 'price')
            ->searchable()->sortable(),
      Column::make('Purchase Price', 'purchase_price')
            ->searchable()->sortable(),
      Column::make('Created At', 'created_at')
            ->searchable()->sortable(),
      Column::make('Updated At', 'updated_at')
            ->searchable()->sortable(),
      Column::make('Action')
            ->label(
              fn ($row, Column $column) => view('livewire.table_actions')->with(
                [
                  'viewLink'   => route('products.show', $row),
                  'editLink'   => route('products.edit.view', $row),
                  'deleteLink' => route('products.delete', $row),
                  'addToCart' => $row->id,
                ]
              )
            )->html(),
    ];
  }

}
