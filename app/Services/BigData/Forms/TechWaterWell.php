<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TechWaterWell extends TechModeForm
{
    protected $configurationFileName = 'tech_water_well';
    protected $waterMeasurements;

    public function getResults(): array
    {
        $filter = json_decode($this->request->get('filter'));
        $params['filter']['well_category'] = ['WTR'];
        $wells = $this->getWells((int)$this->request->get('id'), $this->request->get('type'), $filter, $params);

        $tables = $this->getFields()->pluck('table')->filter()->unique();
        $rowData = $this->fetchRowData(
            $tables,
            $wells->pluck('id')->toArray(),
            Carbon::parse($filter->date, 'Asia/Almaty')
        );

        $this->waterMeasurements = DB::connection('tbd')
            ->table('prod.meas_water_prod')
            ->whereIn('well', $wells->pluck('id')->toArray())
            ->where('dbeg', '>=', Carbon::parse($filter->date, 'Asia/Almaty')->subMonthNoOverflow()->startOfMonth())
            ->where('dbeg', '<=', Carbon::parse($filter->date, 'Asia/Almaty')->subMonthNoOverflow()->endOfMonth())
            ->get()
            ->groupBy('well')
            ->map(function ($measurements) {
                return [
                    'avg' => round($measurements->avg('water_prod_val'), 2),
                    'sum' => round($measurements->sum('water_prod_val'), 2)
                ];
            });

        $wells->transform(
            function ($item) use ($rowData) {
                $result = [];

                foreach ($this->getFields() as $field) {
                    $value = $this->getFieldValue($field, $rowData, $item);
                    if (!empty($value)) {
                        $result[$field['code']] = $value;
                    }
                }

                $result['id'] = $result['uwi']['id'];
                return $result;
            }
        );

        $this->addLimits($wells);

        return [
            'rows' => $wells->toArray()
        ];
    }

    protected function getCustomFieldValue(array $field, array $rowData, Model $item): ?array
    {
        switch ($field['code']) {
            case 'avg_water_prev_month':
                $measurement = $this->waterMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['avg']] : null;
            case 'sum_water_prev_month':
                $measurement = $this->waterMeasurements->get($item->id);
                return !empty($measurement) ? ['value' => $measurement['sum']] : null;
            case 'events':
                return DB::connection('tbd')
                    ->table('prod.tech_mode_event')
                    ->select('id', 'event_type', 'plan_month')
                    ->where('well', $item->id)
                    ->get()
                    ->toArray();
            default:
                return null;
        }
    }

}