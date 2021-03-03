<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Dictionaries\Geo;
use App\Models\BigData\FluidProduction as FluidProductionModel;
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
            ->select('id', 'uwi')
            ->orderBy('uwi')
            ->whereHas(
                'geo',
                function ($query) use ($geo) {
                    return $query
                        ->whereIn('tbdi.geo.id', array_merge([$geo->id], $geo->getParentIds()))
                        ->whereDate('tbdi.geo.dbeg', '<=', $this->request->get('date'))
                        ->whereDate('tbdi.geo.dend', '>=', $this->request->get('date'));
                }
            )
            ->get();

        $fluidProduction = FluidProductionModel::query()
            ->select('id', 'well_id', 'liquid_val', 'dbeg')
            ->whereIn('well_id', $wells->pluck('id')->toArray())
            ->whereDate('dbeg', '<=', $this->request->get('date'))
            ->whereDate('dend', '>=', $this->request->get('date'))
            ->orderBy('dbeg', 'desc')
            ->get()
            ->groupBy('well_id');

        $bsw = DB::connection('tbd')
            ->table('tbdi.bsw_prod')
            ->whereIn('well_id', $wells->pluck('id')->toArray())
            ->whereDate('dbeg', '<=', $this->request->get('date'))
            ->whereDate('dend', '>=', $this->request->get('date'))
            ->orderBy('dbeg', 'desc')
            ->get()
            ->groupBy('well_id');

        $measurements = DB::connection('tbd')
            ->table('tbdic.meas_log_cut')
            ->whereIn('well_id', $wells->pluck('id')->toArray())
            ->whereDate('meas_date', '<=', $this->request->get('date'))
            ->orderBy('meas_date', 'desc')
            ->get()
            ->groupBy('well_id');

        $wells->transform(
            function ($item) use ($fluidProduction, $bsw, $measurements) {
                $result = [
                    'uwi' => [
                        'id' => $item->id,
                        'name' => $item->uwi,
                        'href' => '#'
                    ]
                ];

                $measurementFields = $this->mapMeasurementFields($measurements, $item);
                $result = array_merge($result, $measurementFields);

                $result['liquid_debit'] = $this->mapLiquidDebit($fluidProduction, $item);
                $result['bsw'] = $this->mapBsw($bsw, $item);


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

    private function mapMeasurementFields(Collection $measurements, Model $item): array
    {
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
        if (!empty($measurements->get($item->id))) {
            foreach ($measurements->get($item->id) as $measurement) {
                foreach ($measurementFields as $field) {
                    if (isset($result[$field])) {
                        continue;
                    }
                    if (empty($measurement->{$field})) {
                        continue;
                    }
                    $result[$field] = [
                        'id' => $measurement->id,
                        'value' => $measurement->{$field},
                        'date' => !$this->isCurrentDay($measurement->meas_date) ? $measurement->meas_date : null
                    ];
                }
            }
        }
        return $result;
    }

    private function mapLiquidDebit(Collection $fluidProduction, Model $item)
    {
        if (!is_null($fluidProduction->get($item->id))) {
            $fluidProductionRow = $fluidProduction->get($item->id)->first();
            return [
                'id' => $fluidProductionRow->id,
                'value' => floatval($fluidProductionRow->liquid_val),
                'date' => !$this->isCurrentDay($fluidProductionRow->dbeg) ? $fluidProductionRow->dbeg : null
            ];
        }
        return [];
    }

    private function mapBsw(Collection $bsw, Model $item)
    {
        if (!is_null($bsw->get($item->id))) {
            $bswRow = $bsw->get($item->id)->first();
            return [
                'id' => $bswRow->id,
                'value' => floatval($bswRow->bsw_val),
                'date' => !$this->isCurrentDay($bswRow->dbeg) ? $bswRow->dbeg : null
            ];
        }
        return [];
    }

    private function isCurrentDay(string $date)
    {
        return Carbon::parse($date)->diffInDays(Carbon::now()) === 0;
    }

    private function saveSingleFieldInDB(string $field)
    {
        $column = $this->getFieldByCode($field);

        $item = $this->getFieldRow($column, $this->request->get('well_id'), $this->request->get('date'));

        if (empty($item)) {
            $fieldsToInsert = [
                'well_id' => $this->request->get('well_id'),
                $column['column'] => $this->request->get($field),
            ];
            switch ($column['table']) {
                case 'tbdi.liquid_prod':
                case 'tbdi.bsw_prod':
                    $fieldsToInsert['dbeg'] = Carbon::parse($this->request->get('date'))->toDateTimeString();
                    $fieldsToInsert['dend'] = Carbon::parse($this->request->get('date'))->addDay()->toDateTimeString();
                    break;
                default:
                    $fieldsToInsert['meas_date'] = Carbon::parse($this->request->get('date'))->toDateTimeString();
            }

            DB::connection('tbd')
                ->table($column['table'])
                ->insert($fieldsToInsert);
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
        $query = DB::connection('tbd')
            ->table($column['table'])
            ->where('well_id', $wellId);

        switch ($column['table']) {
            case 'tbdi.liquid_prod':
            case 'tbdi.bsw_prod':
                $query->whereDate(
                    'dbeg',
                    '=',
                    Carbon::parse($date)->toDateTimeString()
                );
                break;
            default:
                $query->whereDate(
                    'meas_date',
                    '=',
                    Carbon::parse($date)->toDateTimeString()
                );
        }
        return $query->first();
    }
}