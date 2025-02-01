<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ProductsTable extends DataTableComponent {
  protected $model = Product::class;

  public function builder(): Builder {
    return Product::query()
                  ->with('brand')
                  ->select('products.*');
  }

  public function configure(): void {
    $this->setPrimaryKey('id');
    $this->setTableRowUrl(function($row) {
      return route('products.show', $row->id);
    });
    $this->setTableRowUrlTarget(fn($row) => '_blank');
    $this->setId('products-table');
  }

  public function columns(): array {
    return [
      Column::make('ID', 'id')
            ->searchable()->sortable(),
      Column::make('Reference', 'reference')
            ->searchable()->sortable(),
      Column::make('Name', 'name')
            ->searchable()->sortable(),
      Column::make('Add To Cart')
            ->unclickable()
            ->label(fn ($row, Column $column) => view('livewire.cart-button')->with(['id' => $row->id]))
            ->html(),
      LinkColumn::make('Brand')
                ->title(fn($row) => $row->brand->name)
                ->location(fn($row) => route('brands.show', $row->brand->id))
                ->searchable(fn(Builder $query, $search) => $query->orWhereHas('brand', fn($query) => $query->where('name', 'like', "%$search%")))
                ->sortable(fn(Builder $query, $direction) => $query->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
                                                                                      ->orderBy('brands.name', $direction)),
      Column::make('Stock', 'quantity')
            ->searchable()->sortable(),
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
    ];
  }

}
