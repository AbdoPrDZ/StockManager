<?php

namespace App\Livewire;

use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class OrderProductsTable extends DataTableComponent {

  public int $order_id;

  public function mount(int $order_id): void {
    $this->order_id = $order_id;
  }

  protected $model = OrderProduct::class;

  public function builder(): Builder {
    return OrderProduct::query()
                       ->where('order_products.order_id', $this->order_id)
                       ->with('product')
                       ->select('order_products.*');
  }

  public function configure(): void {
    $this->setPrimaryKey('id');
  }

  public function columns(): array {
    return [
      Column::make('ID', 'id')
            ->sortable(),
      LinkColumn::make('Product')
                ->title(fn($row) => $row->product->name)
                ->location(fn($row) => route('products.show', $row->product->id))
                ->searchable(fn(Builder $query, $search) => $query->orWhereHas('product', fn($query) => $query->where('name', 'like', "%$search%")))
                ->sortable(fn(Builder $query, $direction) => $query->leftJoin('products', 'order_products.product_id', '=', 'products.id')
                                                                                      ->orderBy('products.name', $direction)),
      Column::make('Type', 'type')
            ->format(fn($value) => ucfirst($value))
            ->sortable(),
      Column::make('Quantity', 'quantity')
            ->searchable()->sortable(),
      Column::make('Price', 'price')
            ->searchable()->sortable(),
      Column::make('Profit', 'profit')
            ->searchable()->sortable(),
      Column::make('Net Profit', 'net_profit')
            ->searchable()->sortable(),
      Column::make('Total', 'total')
            ->searchable()->sortable(),
      Column::make('Created At',  'created_at')
            ->sortable(),
    ];
  }

}
