<?php

namespace App\Tables;

use App\Models\WaterMeasurement;
use Okipa\LaravelTable\Abstracts\AbstractTable;
use Okipa\LaravelTable\Table;

class WaterMeasurementTable extends AbstractTable
{
    /**
     * Configure the table itself.
     *
     * @return \Okipa\LaravelTable\Table
     * @throws \ErrorException
     */
    protected function table(): Table
    {
        return (new Table)->model(WaterMeasurement::class)->routes([
            'index'   => ['name' => 'watermeasurement.index'],
            'create'  => ['name' => 'watermeasurement.create'],
            'edit'    => ['name' => 'watermeasurement.edit'],
            'destroy' => ['name' => 'watermeasurement.destroy'],
        ])->destroyConfirmationHtmlAttributes(function (WaterMeasurement $waterMeasurement) {
            return [
                'data-confirm' => __('Are you sure you want to delete the line ' . $waterMeasurement->id . ' ?'),
            ];
        });
    }

    /**
     * Configure the table columns.
     *
     * @param \Okipa\LaravelTable\Table $table
     *
     * @throws \ErrorException
     */
    protected function columns(Table $table): void
    {
        $table->column('date')->dateTimeFormat('d/m/Y H:i')->sortable()->searchable();
        $table->column('magnesium_ion')->sortable()->searchable();
    }

    /**
     * Configure the table result lines.
     *
     * @param \Okipa\LaravelTable\Table $table
     */
    protected function resultLines(Table $table): void
    {
        //
    }
}
