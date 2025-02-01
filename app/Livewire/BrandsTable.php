<?php

namespace App\Livewire;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class BrandsTable extends DataTableComponent {
  protected $model = Brand::class;

  public function configure(): void {
    $this->setPrimaryKey('id');
    $this->setTableRowUrl(function($row) {
      return route('brands.show', $row->id);
    });
    $this->setTableRowUrlTarget(fn($row) => '_blank');
  }

  public function columns(): array {
    return [
      Column::make('ID',          'id')
            ->sortable(),
      Column::make('Name',        'name')
            ->sortable(),
      Column::make('Description', 'description')
            ->sortable(),
      Column::make('Created At',  'created_at')
            ->sortable(),
    ];
  }

}
