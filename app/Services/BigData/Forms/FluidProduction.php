<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Facades\DB;

class FluidProduction extends TableForm
{
    protected $configurationFileName = 'fluid_production';

    public function submit(): \Illuminate\Database\Eloquent\Model
    {
    }

    protected function getColumns(): array
    {
        return [
            [
                'name' => 'Скважина',
                'code' => 'uwi',
                'type' => 'link',
                'editable' => false
            ],
            [
                'name' => 'Добыча жидкости',
                'code' => 'liquid_val',
                'type' => 'text',
                'editable' => true
            ]
        ];
    }

    protected function getRows()
    {
        $rows = DB::connection('tbd')->table('dict.well as well')
            ->join('tbdi.liquid_prod as liquid_prod', 'well.id', '=', 'liquid_prod.well_id')
            ->whereDate('liquid_prod.dbeg', '<=', $this->request->get('date'))
            ->whereDate('liquid_prod.dend', '>=', $this->request->get('date'))
            ->select('well.id', 'well.uwi', 'liquid_prod.liquid_val')
            ->orderBy('well.uwi', 'asc')
            ->paginate($this->rowsPerPage);

        $rows->getCollection()->transform(
            function ($item) {
                $item->liquid_val = floatval($item->liquid_val);
                return $item;
            }
        );

        return $rows;
    }
}