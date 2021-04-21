<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Exports\PipeLineCalcExport;
use App\Filters\HydroCalcFilter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\HydroCalcListResource;
use App\Jobs\ExportHydroCalcTableToExcel;
use App\Models\ComplicationMonitoring\OmgNGDU;
use App\Models\ComplicationMonitoring\TrunklinePoint;

use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class HydroCalculcation extends Controller
{
    use WithFieldsValidation;

    protected $modelName = 'hydro_calculcation';

    public function index () {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('hydro_calculcation.list'),
            ],
            'title' => trans('monitoring.hydro_calculcation.table_title'),
            'fields' => [
                'id' => [
                    'title' => '№',
                    'type' => 'numeric',
                ],
                'out_dia' => [
                    'title' => trans('monitoring.pipe_types.fields.outside_diameter'),
                    'type' => 'numeric',

                ],
                'wall_thick' => [
                    'title' => trans('monitoring.pipe_types.fields.thickness'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'length' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.length'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'qliq' => [
                    'title' => trans('monitoring.units.q_zh').', '.trans('measurements.m3/day'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'wc' => [
                    'title' => trans('monitoring.gu.fields.bsw').', '.trans('measurements.percent'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'gazf' => [
                    'title' => trans('monitoring.omgngdu.fields.gas_factor'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'press_start' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.pressure_start'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'press_end' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.pressure_end'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'temp_start' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.temperature_start'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'temp_end' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.temperature_end'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'start_point' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.start_point'),
                    'type' => 'numeric',
                ],
                'end_point' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.end_point'),
                    'type' => 'numeric',
                ],
                'name' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.pipe_name'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'mix_speed_avg' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.mix_speed_avg'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'fluid_speed' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.fluid_speed'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'gaz_speed' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.gaz_speed'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'flow_type' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.flow_type'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'press_change' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.press_change'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'break_qty' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.break_qty'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'height_drop' => [
                    'title' => trans('monitoring.hydro_calculcation.fields.height_drop'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
            ],
        ];

        $params['links']['export'] = route($this->modelName.'.export');
        $params['links']['date'] = route($this->modelName.'.export');

        return view('hydro_calc.index', compact('params'));
    }

    public function list (IndexTableRequest $request)
    {
        $input = $request->validated();

        $query = TrunklinePoint::query()
            ->with('map_pipe.pipeType', 'map_pipe.firstCoords', 'map_pipe.lastCoords', 'gu', 'trunkline_end_point');

        $points = $this
            ->getFilteredQuery($input, $query)
            ->whereNotNull('gu_id')
            ->orWhereNotNull('point_end_id')
            ->paginate(25);

        $alerts = [];

        foreach ($points as $key => $point) {

            if (!$points[$key]->gu) {
                continue;
            }

            $query = OmgNGDU::where('gu_id', $points[$key]->gu->id);

            if (isset($input['date'])) {
                $query = $query->where('date', $input['date']);
            }

            $points[$key]->omgngdu = $query->orderBy('date', 'desc')->first();

            if (!$points[$key]->omgngdu) {
                $alert = $points[$key]->gu->name.' нет данных ОМГДУ';

                if (isset($input['date'])) {
                    $alert .= ' на '.$input['date'];
                }
                $alerts[] = $alert .= ' !';
                continue;
            }

            $temperature = $points[$key]->omgngdu->heater_output_temperature;
            $temperature = $temperature ? ($temperature < 40 ? 50 : $temperature) : 50;
            $points[$key]->omgngdu->heater_output_temperature = $temperature;

            if ($points[$key]->omgngdu->pump_discharge_pressure == 0) {
                $alerts[] = $points[$key]->gu->name.' давление 0 !';
            }

            if (is_null($points[$key]->omgngdu->pump_discharge_pressure)) {
                $alerts[] = $points[$key]->gu->name.' нет данных по давлению !';
            }

            if (!$points[$key]->omgngdu->daily_fluid_production) {
                $alerts[] = $points[$key]->gu->name.' нет данных по cуточной добычи жидкости !';
            }

            if (!$points[$key]->omgngdu->bsw) {
                $alerts[] = $points[$key]->gu->name.' нет данных по обводненности !';
            }
        }

        $list = json_decode(HydroCalcListResource::collection($points)->toJson());
        if (count($alerts)) {
            $list->alerts = $alerts;
        }

        return response()->json($list);
    }

    public function exportExcel(IndexTableRequest $request)
    {
        $job = new ExportHydroCalcTableToExcel($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new HydroCalcFilter($query, $filter))->filter();
    }
}