<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\Well;
use App\Services\BigData\DictionaryService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FluidProduction extends TableForm
{
    protected $configurationFileName = 'fluid_production';

    public function submit(): array
    {
    }

    public function saveSingleField(string $field)
    {
        $this->validateSingleField($field);
        $this->saveSingleFieldInDB($field);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function getRows()
    {
        $geo = Geo::find($this->request->get('geo'));

        $wells = Well::query()
            ->with('geo')
            ->select('id', 'uwi')
            ->orderBy('uwi')
            ->whereHas(
                'geo',
                function ($query) use ($geo) {
                    return $query
                        ->whereIn('tbdi.geo.id', array_merge([$geo->id], $geo->descendants()->pluck('id')->toArray()))
                        ->whereDate('tbdi.geo.dbeg', '<=', $this->request->get('date'))
                        ->whereDate('tbdi.geo.dend', '>=', $this->request->get('date'));
                }
            )
            ->get();

        $rowData = [];

        $tables = $this->getFields()->pluck('table')->filter()->unique();
        foreach ($tables as $table) {
            switch ($table) {
                case 'tbdi.well_expl':

                    $rowData[$table] = DB::connection('tbd')
                        ->table('tbdi.well_expl as we')
                        ->whereIn('we.well_id', $wells->pluck('id')->toArray())
                        ->whereDate('dbeg', '<=', $this->request->get('date'))
                        ->leftJoin('tbdi.well_expl_type as wet', 'we.well_expl_type_id', '=', 'wet.id')
                        ->orderBy('dbeg', 'desc')
                        ->get()
                        ->groupBy('well_id');

                    break;
                case 'tbdi.tech_mode_well':

                    $rowData[$table] = DB::connection('tbd')
                        ->table('tbdi.tech_mode as tm')
                        ->whereIn('tm.well_id', $wells->pluck('id')->toArray())
                        ->whereDate('dbeg', '<=', $this->request->get('date'))
                        ->leftJoin('tbdi.tech_mode_well as tmw', 'tmw.tech_mode_id', '=', 'tm.id')
                        ->orderBy('dbeg', 'desc')
                        ->get()
                        ->groupBy('well_id');

                    break;
                default:
                    $rowData[$table] = DB::connection('tbd')
                        ->table($table)
                        ->whereIn('well_id', $wells->pluck('id')->toArray())
                        ->whereDate('dbeg', '<=', $this->request->get('date'))
                        ->orderBy('dbeg', 'desc')
                        ->get()
                        ->groupBy('well_id');
            }
        }

        $wells->transform(
            function ($item) use ($rowData) {
                $result = [
                    'uwi' => [
                        'id' => $item->id,
                        'name' => $item->uwi,
                        'href' => '#'
                    ]
                ];

                $measurementFields = $this->getMeasurementsByDates($rowData['tbdic.meas_log_cut'], $item);
                $result = array_merge($result, $measurementFields);

                foreach ($this->getFields() as $field) {
                    if (!empty($field['table'])) {
                        switch ($field['table']) {
                            case 'tbdic.meas_log_cut':
                                continue;
                            default:
                                $result[$field['code']] = $this->getFieldByDates(
                                    $field,
                                    $rowData[$field['table']],
                                    $item
                                );
                        }
                    } else {
                        switch ($field['code']) {
                            case 'geo':

                                $ancestors = $item->geo->first()->ancestors()
                                    ->reverse()
                                    ->pluck('name')
                                    ->toArray();

                                $ancestors[] = $item->geo->first()->name;

                                $result[$field['code']] = [
                                    'id' => null,
                                    'value' => implode(' / ', $ancestors),
                                    'date' => null
                                ];
                                break;
                        }
                    }
                }

                return $result;
            }
        );

        return $wells->toArray();
    }

    protected function getFilterTree(): array
    {
        $dictionaryService = app()->make(DictionaryService::class);
        return $dictionaryService->get('geos');
    }

    private function getMeasurementsByDates(Collection $measurements, Model $item): array
    {
        if (empty($measurements->get($item->id))) {
            return [];
        }

        $result = [];
        $measurementFields = [
            'p_buf',
            'p_zatr',
            'p_buf_b',
            'p_buf_a',
            'gas_factor',
            'note',
            'prod_decline_reason',
        ];


        foreach ($measurements->get($item->id) as $measurement) {
            foreach ($measurementFields as $field) {
                if (isset($result[$field])) {
                    break;
                }
                if (empty($measurement->{$field})) {
                    continue;
                }
                $result[$field] = [
                    'id' => $measurement->id,
                    'value' => $measurement->{$field},
                    'date' => !$this->isCurrentDay($measurement->dbeg) ? $measurement->dbeg : null
                ];
            }
        }

        foreach ($measurementFields as $field) {
            if (!isset($result[$field])) {
                $result[$field] = [
                    'id' => null,
                    'value' => null,
                    'date' => null
                ];
            }
        }

        return $result;
    }

    private function getFieldByDates(array $fieldParams, Collection $collection, Model $item)
    {
        if (is_null($collection->get($item->id))) {
            return [];
        }
        $row = $collection->get($item->id)->first();
        $value = $row->{$fieldParams['column']};

        switch ($fieldParams['type']) {
            case 'float':
                $value = floatval($value);
                break;
            case 'integer':
                $value = intval($value);
                break;
        }

        return [
            'id' => $row->id,
            'value' => $value,
            'date' => !$this->isCurrentDay($row->dbeg) ? $row->dbeg : null
        ];
    }

    private function isCurrentDay(string $date)
    {
        return Carbon::parse($date)->diffInDays(Carbon::parse($this->request->get('date'))) === 0;
    }

    private function saveSingleFieldInDB(string $field)
    {
        $column = $this->getFieldByCode($field);

        $item = $this->getFieldRow($column, $this->request->get('well_id'), $this->request->get('date'));

        if (empty($item)) {
            DB::connection('tbd')
                ->table($column['table'])
                ->insert(
                    [
                        'well_id' => $this->request->get('well_id'),
                        $column['column'] => $this->request->get($field),
                        'dbeg' => Carbon::parse($this->request->get('date'))->toDateTimeString(),
                        'dend' => Carbon::parse($this->request->get('date'))->addDay()->toDateTimeString()
                    ]
                );
        } else {
            DB::connection('tbd')
                ->table($column['table'])
                ->where('id', $item->id)
                ->update(
                    [
                        $column['column'] => $this->request->get($field)
                    ]
                );
        }
    }

    private function getFieldRow(array $column, int $wellId, string $date)
    {
        return DB::connection('tbd')
            ->table($column['table'])
            ->where('well_id', $wellId)
            ->whereDate(
                'dbeg',
                '=',
                Carbon::parse($date)->toDateTimeString()
            )
            ->first();
    }
}