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
            'title' => 'Таблица расчета гидравлики',
            'fields' => [
                'id' => [
                    'title' => '№',
                    'type' => 'numeric',
                ],
                'out_dia' => [
                    'title' => 'Внешний диаметр, мм',
                    'type' => 'numeric',

                ],
                'wall_thick' => [
                    'title' => 'Толщина стенки, мм',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'length' => [
                    'title' => 'Протяженность, м',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'qliq' => [
                    'title' => 'Qж, м3/сут',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'wc' => [
                    'title' => 'Обводненность, %',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'gazf' => [
                    'title' => 'ГФ, м3/м3',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'press_start' => [
                    'title' => 'Давление начальное, ата',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'press_end' => [
                    'title' => 'Давление конечное, ата',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'temp_start' => [
                    'title' => 'Температура начальная, °С',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'temp_end' => [
                    'title' => 'Температура конечная, °С',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'start_point' => [
                    'title' => 'Начальная точка',
                    'type' => 'numeric',
                ],
                'end_point' => [
                    'title' => 'Конечная точка',
                    'type' => 'numeric',
                ],
                'name' => [
                    'title' => 'Трубопровод',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'mix_speed_avg' => [
                    'title' => 'Средняя скорость смеси, м/с',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'fluid_speed' => [
                    'title' => 'Скорость жидкости, м/с',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'gaz_speed' => [
                    'title' => 'Скорость газа, м/с',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'flow_type' => [
                    'title' => 'Режим течения',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'press_change' => [
                    'title' => 'Перепад давления, атм/км',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'break_qty' => [
                    'title' => 'Количество порывов',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
                'height_drop' => [
                    'title' => 'Перепад высот, м',
                    'type' => 'numeric',
                    'sortable' => false,
                    'filterable' => false,
                ],
            ],
        ];

        $params['links']['export'] = route($this->modelName.'.export');

        return view('hydro_calc.index', compact('params'));
    }

    public function list (IndexTableRequest $request)
    {
        $query = TrunklinePoint::query()
            ->with('map_pipe.pipeType', 'map_pipe.firstCoords', 'map_pipe.lastCoords', 'gu', 'trunkline_end_point');

        $points = $this
            ->getFilteredQuery($request->validated(), $query)
            ->whereNotNull('gu_id')
            ->orWhereNotNull('point_end_id')
            ->paginate(25);

        foreach ($points as $key => $point) {
            if ($points[$key]->gu) {
                $points[$key]->lastOmgngdu = OmgNGDU::where('gu_id', $points[$key]->gu->id)
                    ->orderBy('date', 'desc')
                    ->first();

                if ($points[$key]->lastOmgngdu) {
                    $temperature = $points[$key]->lastOmgngdu->heater_output_temperature;
                    $temperature = $temperature ? ($temperature < 40 ? 50 : $temperature) : 50;
                    $points[$key]->lastOmgngdu->heater_output_temperature = $temperature;
                }
            }
        }

        return response()->json(json_decode(HydroCalcListResource::collection($points)->toJson()));
    }

    public function exportExcel()
    {
        $job = new ExportHydroCalcTableToExcel();
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