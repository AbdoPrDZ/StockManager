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
    $this->setTableRowUrl(function($row) {
      return route('orders.show', $row->id);
    });
    $this->setTableRowUrlTarget(fn($row) => '_blank');
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
    ];
  }

}
