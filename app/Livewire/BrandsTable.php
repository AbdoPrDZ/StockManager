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
      Column::make('Updated At',  'updated_at')
            ->sortable(),
      Column::make('Action')
            ->label(
              fn ($row, Column $column) => view('livewire.table_actions')->with(
                [
                  'viewLink'   => route('brands.show', $row),
                  'editLink'   => route('brands.edit.view', $row),
                  'deleteLink' => route('brands.delete', $row),
                ]
              )
            )->html(),
    ];
  }

}
