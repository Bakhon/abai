<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Illuminate\Pagination\LengthAwarePaginator;

class FluidProduction extends TableForm
{
    protected $configurationFileName = 'fluid_production';

    public function submit(): array
    {
        dd($this->request);
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
        /** @var LengthAwarePaginator $wells */
        $wells = Well::query()
            ->select('id', 'uwi')
            ->orderBy('uwi')
            ->paginate($this->rowsPerPage);

        $fluidProduction = collect();

        $wells->getCollection()->transform(
            function ($item) use ($fluidProduction) {
                $result = [
                    'uwi' => [
                        'name' => $item->uwi,
                        'href' => '#'
                    ],
                    'liquid_val' => [
                        'id' => null,
                        'value' => null
                    ]
                ];

                if (!is_null($fluidProduction->get($item->id))) {
                    $fluidProductionRow = $fluidProduction->get($item->id)->first();
                    $result['liquid_val']['id'] = $fluidProductionRow->id;
                    $result['liquid_val']['value'] = floatval($fluidProductionRow->liquid_val);
                }

                return $result;
            }
        );

        return $wells;
    }
}