<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\PerfType;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use App\Traits\BigData\Forms\DepthValidationTrait;
use Illuminate\Support\Facades\DB;

class WellPerfBridgePlug extends PlainForm
{
    protected $configurationFileName = 'well_perf_bridge_plug';
    use DepthValidationTrait;
    use DateMoreThanValidationTrait;


    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];


        if (!$this->isValidDepth($this->request->get('well'), $this->request->get('depth'))) {
            $errors['depth'] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate(
            $this->request->get('well'),
            $this->request->get('perf_date'),
            'dict.well',
            'drill_end_date'
        )) {
            $errors['perf_date'] = trans('bd.validation.perf_date');
        }
        return $errors;
    }

    public function getCalculatedFields(int $wellId, array $values): array
    {
        $result = [
            'new_intervals' => ''
        ];

        if ($values['depth'] && $values['perf_date']) {
            $intervals = DB::connection('tbd')
                ->table('prod.well_perf_interval as wpi')
                ->join('prod.well_perf as wp', 'wpi.well_perf', 'wp.id')
                ->select('wpi.top', 'wpi.base')
                ->where('wpi.dbeg', '<=', $values['perf_date'])
                ->where('wpi.top', '>', $values['depth'])
                ->where('wp.perf_type', '!=', PerfType::ISOLATION_ID)
                ->where('wp.well', $wellId)
                ->orderBy('wpi.top')
                ->get()
                ->map(function ($interval) {
                    return (float)$interval->top . ' - ' . (float)$interval->base . ';';
                })
                ->join('<br>');

            $result['new_intervals'] = $intervals;
        }

        return $result;
    }

}