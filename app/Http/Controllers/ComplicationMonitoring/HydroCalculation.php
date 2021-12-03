<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\HydroCalcFilter;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\WithFieldsValidation;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\HydroCalcPrepareListResource;
use App\Http\Resources\HydroCalculatedListResource;
use App\Jobs\CalculateHydroDynamics;
use App\Models\ComplicationMonitoring\HydroCalcResult;
use App\Models\ComplicationMonitoring\Ngdu;
use App\Models\ComplicationMonitoring\OilPipe;
use App\Models\ComplicationMonitoring\OmgNGDU;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;

class HydroCalculation extends Controller
{
    use WithFieldsValidation;

    protected $modelName = 'hydro_calculation';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('hydro_calculation.list'),
            ],
            'title' => trans('monitoring.hydro_calculation.table_title'),
            'fields' => [
                'id' => [
                    'title' => '№',
                    'type' => 'numeric',
                ],
                'date' => [
                    'title' => trans('app.date'),
                    'type' => 'date',
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
                    'title' => trans('monitoring.hydro_calculation.fields.length'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'qliq' => [
                    'title' => trans('monitoring.units.q_zh') . ', ' . trans('measurements.m3/day'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'wc' => [
                    'title' => trans('monitoring.gu.fields.bsw') . ', ' . trans('measurements.percent'),
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
                    'title' => trans('monitoring.hydro_calculation.fields.pressure_start'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'press_end' => [
                    'title' => trans('monitoring.hydro_calculation.fields.pressure_end'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'temp_start' => [
                    'title' => trans('monitoring.hydro_calculation.fields.temperature_start'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'temp_end' => [
                    'title' => trans('monitoring.hydro_calculation.fields.temperature_end'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'start_point' => [
                    'title' => trans('monitoring.hydro_calculation.fields.start_point'),
                    'type' => 'numeric',
                ],
                'end_point' => [
                    'title' => trans('monitoring.hydro_calculation.fields.end_point'),
                    'type' => 'numeric',
                ],
                'name' => [
                    'title' => trans('monitoring.hydro_calculation.fields.pipe_name'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'mix_speed_avg' => [
                    'title' => trans('monitoring.hydro_calculation.fields.mix_speed_avg'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'fluid_speed' => [
                    'title' => trans('monitoring.hydro_calculation.fields.fluid_speed'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'gaz_speed' => [
                    'title' => trans('monitoring.hydro_calculation.fields.gaz_speed'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'flow_type' => [
                    'title' => trans('monitoring.hydro_calculation.fields.flow_type'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'press_change' => [
                    'title' => trans('monitoring.hydro_calculation.fields.press_change'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'break_qty' => [
                    'title' => trans('monitoring.hydro_calculation.fields.break_qty'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'height_drop' => [
                    'title' => trans('monitoring.hydro_calculation.fields.height_drop'),
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
            ],
        ];

        $params['links']['calc']['export'] = false;
        $params['links']['calc']['link'] = route($this->modelName . '.calculate');
        $params['links']['date'] = true;
        $params['selected_date'] = session('hydro_calc_date');

        return view('hydro_calc.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $input = $request->validated();
        $pipes = null;

        if (isset($input['date'])) {
            $pipes = $this->getCalculatedData($input['date']);
            $list = json_decode(HydroCalculatedListResource::collection($pipes)->toJson());
        }

        if (!$pipes || !$pipes->total()) {
            $prepairedData = $this->getPrepairedData($input);
            $pipes = $prepairedData['pipes'];
            $alerts = $prepairedData['alerts'];
            $request->session()->put('from_hydro_calc', true);
            $list = json_decode(HydroCalcPrepareListResource::collection($pipes)->toJson());

            if (count($alerts)) {
                $list->alerts = $alerts;
            }
        }

        return response()->json($list);
    }

    public function getPrepairedData(array $input): array
    {
        $ngdu_id = Ngdu::where('name', 'НГДУ-4')->first()->id;
        $query = OilPipe::query()
            ->with(
                'pipeType',
                'firstCoords',
                'lastCoords',
                'gu'
            )
            ->where('ngdu_id', $ngdu_id)
            ->where('trunkline', true);

        $pipes = $this
            ->getFilteredQuery($input, $query)
            ->get();
        
        $alerts = [];

        foreach ($pipes as $key => $pipe) {

            if (!$pipe->gu) {
                continue;
            }

            $query = OmgNGDU::where('gu_id', $pipe->gu->id);

            if (isset($input['date'])) {
                $query = $query->where('date', $input['date']);
            }

            $pipes[$key]->omgngdu = $query->orderBy('date', 'desc')->first();

            if (!$pipe->omgngdu) {
                $message = $pipe->gu->name . ' ' . trans('monitoring.hydro_calculation.message.no-omgdu-data');

                if (isset($input['date'])) {
                    $message .= ' на ' . $input['date'];
                }

                $alerts[] = [
                    'message' => $message . ' !',
                    'variant' => 'danger'
                ];
                continue;
            }

            $temperature = $pipe->omgngdu->heater_output_temperature;
            $temperature = $temperature ? ($temperature < 40 ? 50 : $temperature) : 50;
            $pipes[$key]->omgngdu->heater_output_temperature = $temperature;

            if ($pipe->omgngdu->pump_discharge_pressure == 0) {
                $alerts[] = [
                    'message' => $pipe->gu->name . ' ' . trans('monitoring.hydro_calculation.message.pressure-0'),
                    'variant' => 'danger'
                ];
            }

            if (is_null($pipe->omgngdu->pump_discharge_pressure)) {
                $alerts[] = [
                    'message' => $pipe->gu->name . ' ' . trans('monitoring.hydro_calculation.message.no-pressure-data'),
                    'variant' => 'danger'
                ];
            }

            if (!$pipe->omgngdu->daily_fluid_production) {
                $alerts[] = [
                    'message' => $pipe->gu->name . ' ' . trans('monitoring.hydro_calculation.message.no-daily-fluid-data'),
                    'variant' => 'danger'
                ];
            }

            if (!$pipe->omgngdu->bsw) {
                $alerts[] = [
                    'message' => $pipe->gu->name . ' ' . trans('monitoring.hydro_calculation.message.no-bsw-data'),
                    'variant' => 'danger'
                ];
            }
        }

        $pipes = $this->paginate($pipes, 25, (int)$input['page']);
        return ['pipes' => $pipes, 'alerts' => $alerts];
    }

    public function getCalculatedData(string $date)
    {
        return HydroCalcResult::with('oilPipe.pipeType')
            ->where('date', $date)
            ->orderBy('id')
            ->paginate(25);
    }

    public function calculate(IndexTableRequest $request)
    {
        $job = new CalculateHydroDynamics($request->validated());
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

    /**
     * Generates the pagination of items in an array or collection.
     *
     * @param array|Collection $items
     */
    protected function paginate($items, int $perPage = 15, int $page = null, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}