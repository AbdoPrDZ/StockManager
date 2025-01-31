<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class OrdersTable extends DataTableComponent {
  protected $model = Order::class;

  public function configure(): void {
    $this->setPrimaryKey('id');
  }

  public function columns(): array {
    return [
      Column::make('ID',         'id')
            ->sortable(),
      Column::make('Reference',  'reference')
            ->sortable(),
      Column::make('Total',      'total')
            ->sortable(),
      Column::make('Net Profit', 'net_profit')
            ->sortable(),
      Column::make('Created At', 'created_at')
            ->sortable(),
      Column::make('Updated At', 'updated_at')
            ->sortable(),
      Column::make('Action')
            ->label(
              fn ($row, Column $column) => view('livewire.table_actions')->with(
                [
                  'viewLink'   => route('orders.show', $row),
                  'editLink'   => route('orders.edit.view', $row),
                  'deleteLink' => route('orders.delete', $row),
                ]
              )
            )->html(),
    ];
  }

}
