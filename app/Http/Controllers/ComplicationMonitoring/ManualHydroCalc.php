<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Filters\ManualHydroCalculationFilter;
use App\Filters\ManualReverseCalculationFilter;
use App\Http\Controllers\CrudController;
use App\Http\Requests\IndexTableRequest;
use App\Http\Resources\ManualHydroCalcListResource;
use App\Http\Resources\ManualHydroCalcPrepareListResource;
use App\Jobs\ManualCalculateHydroDynamics;
use App\Models\ComplicationMonitoring\ManualHydroCalcResult;
use App\Models\ComplicationMonitoring\ManualOilPipe;
use App\Models\ComplicationMonitoring\OmgNGDUWell;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;

class ManualHydroCalc extends CrudController
{
    protected $modelName = 'manual_hydro_calculation';

    public function index()
    {
        $params = [
            'success' => Session::get('success'),
            'links' => [
                'list' => route('manual_hydro_calculation.list'),
            ],
            'title' => trans('monitoring.manual_hydro_calculation.table_title'),
            'fields' => [
                'check_calc' => [
                    'title' => trans('monitoring.hydro_calculation.fields.check_calc'),
                    'type' => 'checkbox',
                ],
                'id' => [
                    'title' => '№',
                    'type' => 'numeric',
                ],
                'gu_name' => [
                    'title' => trans('monitoring.gu.gu'),
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
                ],
                'length' => [
                    'title' => trans('monitoring.hydro_calculation.fields.length'),
                    'type' => 'numeric',
                ],
                'daily_fluid_production' => [
                    'title' => trans('monitoring.units.q_zh') . ', ' . trans('measurements.m3/day'),
                    'type' => 'numeric',
                ],
                'wc' => [
                    'title' => trans('monitoring.gu.fields.bsw') . ', ' . trans('measurements.percent'),
                    'type' => 'numeric',
                ],
                'gas_factor' => [
                    'title' => trans('monitoring.omgngdu.fields.gas_factor'),
                    'type' => 'numeric',
                ],
                'pressure_start' => [
                    'title' => trans('monitoring.hydro_calculation.fields.pressure_start'),
                    'type' => 'numeric',
                ],
                'pressure_end' => [
                    'title' => trans('monitoring.hydro_calculation.fields.pressure_end'),
                    'type' => 'numeric',
                ],
                'temp_start' => [
                    'title' => trans('monitoring.hydro_calculation.fields.temperature_start'),
                    'type' => 'numeric',
                ],
                'temp_end' => [
                    'title' => trans('monitoring.hydro_calculation.fields.temperature_end'),
                    'type' => 'numeric',
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
                ],
                'mix_speed_avg' => [
                    'title' => trans('monitoring.hydro_calculation.fields.mix_speed_avg'),
                    'type' => 'numeric',
                ],
                'fluid_speed' => [
                    'title' => trans('monitoring.hydro_calculation.fields.fluid_speed'),
                    'type' => 'numeric',
                ],
                'gaz_speed' => [
                    'title' => trans('monitoring.hydro_calculation.fields.gaz_speed'),
                    'type' => 'numeric',
                ],
                'flow_type' => [
                    'title' => trans('monitoring.hydro_calculation.fields.flow_type'),
                    'type' => 'numeric',
                ],
                'press_change' => [
                    'title' => trans('monitoring.hydro_calculation.fields.press_change'),
                    'type' => 'numeric',
                ],
                'break_qty' => [
                    'title' => trans('monitoring.hydro_calculation.fields.break_qty'),
                    'type' => 'numeric',
                ],
                'height_drop' => [
                    'title' => trans('monitoring.hydro_calculation.fields.height_drop'),
                    'type' => 'numeric',
                ],
            ],
        ];

        $params['links']['calc']['link'] = route($this->modelName . '.calculate');
        $params['links']['date'] = true;
        $params['selected_date'] = session('manual_hydro_calc_date');

        return view('complicationMonitoring.manual_hydro_calc.index', compact('params'));
    }

    public function list(IndexTableRequest $request)
    {
        $input = $request->validated();
        $calculatedPipes = null;
        $calculatedPipesIds = [];

        if (isset($input['date'])) {
            $calculatedPipes = $this->getCalculatedData($input['date']);

            if ($calculatedPipes) {
                foreach ($calculatedPipes as $pipe) {
                    $calculatedPipesIds[] = $pipe->oil_pipe_id;
                }
            }
        }

        $prepairedData = $this->getPrepairedData($input, $calculatedPipesIds);
        $pipes = $prepairedData['pipes'];
        $alerts = $prepairedData['alerts'];

        if ($calculatedPipes) {
            $pipes = $calculatedPipes->merge($pipes);
        }

        $pipes = $this->paginate($pipes, 25, (int)$input['page']);
        $request->session()->put('from_manual_hydro_calc', true);
        $list = json_decode(ManualHydroCalcListResource::collection($pipes)->toJson());

        if (count($alerts)) {
            $list->alerts = $alerts;
        }

        return response()->json($list);
    }

    public function getPrepairedData(array $input = [], array $calculatedPipesIds): array
    {
        $query = ManualOilPipe::query()
            ->with('firstCoords', 'lastCoords');

        $pipes = $this
            ->getFilteredQuery($input, $query)
            ->whereNotNull('start_point')
            ->whereNotNull('end_point')
            ->whereNotIn('id', $calculatedPipesIds)
            ->orderBy('gu_id')
            ->get();

        $pipes->load('pipeType', 'gu');
        $alerts = [];

        foreach ($pipes as $key => $pipe) {
            if (!$pipe->lastCoords || !$pipe->firstCoords) {
                unset($pipes[$key]);
                continue;
            }

            if ($pipe->between_points == 'well-zu') {
                $query = OmgNGDUWell::where('well_id', $pipe->well_id);

                if (isset($input['date'])) {
                    $query = $query->where('date', $input['date']);
                }

                $pipe->omgngdu = $query->orderBy('date', 'desc')->first();

                if ($pipe->between_points == 'well-zu' && !$pipe->omgngdu) {
                    $message = $pipe->start_point . ' ' . trans('monitoring.hydro_calculation.message.no-omgdu-data');

                    if (isset($input['date'])) {
                        $message .= ' на ' . $input['date'];
                    }

                    $alerts[] = [
                        'message' => $message . ' !',
                        'variant' => 'danger'
                    ];
                    continue;
                }
            }
        }

        return ['pipes' => $pipes, 'alerts' => $alerts];
    }

    protected function getFilteredQuery($filter, $query = null)
    {
        return (new ManualHydroCalculationFilter($query, $filter))->filter();
    }

    public function calculate(IndexTableRequest $request)
    {
        $job = new ManualCalculateHydroDynamics($request->validated());
        $this->dispatch($job);

        return response()->json(
            [
                'id' => $job->getJobStatusId()
            ]
        );
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

    public function getCalculatedData(string $date)
    {
        return ManualHydroCalcResult::with('oilPipe.pipeType', 'oilPipe.gu')
            ->where('date', $date)
            ->orderBy('id')
            ->get();
    }
}
