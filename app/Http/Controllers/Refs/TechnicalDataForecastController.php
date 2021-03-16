<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Refs\TechnicalForecastDataRequest;
use App\Http\Resources\TechnicalForecastResource;
use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;


class TechnicalDataForecastController extends Controller
{
    protected $index_route = "tech_data_forecast.index";

    public function index(): View
    {
        $technicalDataForecast = TechnicalDataForecast::latest()->paginate(12);
        return view('technical_forecast.production_data.index',compact('technicalDataForecast'));
    }

    public function tech_data_json(): JsonResponse
    {
        $tech_data = TechnicalForecastResource::collection(TechnicalDataForecast::all());

        $tech_data_array = [];
        $column_names = ['Источник данных', 'ГУ', 'Скважина', 'Месяц-Год', 'Добыча нефти тыс.т',
            'Добыча жидкости тыс.т', 'Отработанные дни', 'ПРС', 'Комментарий', 'Добавлено: дата / автор',
            'Изменение: дата / автор', 'Редактировать', 'ID добавления'];
        array_push($tech_data_array, $column_names);

        foreach ($tech_data as $item) {
            $well = [];

            $edit_url = route("tech_data_forecast.edit", $item->id);

            array_push($well, $item->source->name);
            array_push($well, $item->gu->name);

            array_push($well, $item['well_id']);
            array_push($well, date('m-Y', strtotime($item['date'])));
            array_push($well, $item['oil']);
            array_push($well, $item['liquid']);
            array_push($well, $item['days_worked']);
            array_push($well, $item['prs']);
            array_push($well, $item['comment']);
            array_push($well, "{$item['created_at']} {$item->author->name}");
            if ($item->editor) {
                array_push($well, "{$item['updated_at']} {$item->editor->name}");
            } else {
                array_push($well, "");
            }
            array_push($well, $edit_url);
            array_push($well, $item['log_id']);
            array_push($tech_data_array, $well);
        }

        return response()->json([
            'tech_data' => $tech_data_array
        ]);
    }

    public function create(): View
    {
        $source = TechnicalStructureSource::get();
        $gu = TechnicalStructureGu::get();
        return view('technical_forecast.production_data.create', compact('source', 'gu'));
    }

    public function store(TechnicalForecastDataRequest $request): RedirectResponse
    {
        $dataArray = $request->all();
        $dataArray['author_id'] = auth()->user()->id;
        TechnicalDataForecast::create($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $technicalDataForecast = TechnicalDataForecast::find($id);
        $gu = TechnicalStructureGu::get();
        $source = TechnicalStructureSource::get();
        return view('technical_forecast.production_data.edit',
            compact('source', 'technicalDataForecast', 'gu'));
    }

    public function update(TechnicalForecastDataRequest $request, int $id): RedirectResponse
    {
        $technicalDataForecast=TechnicalDataForecast::find($id);
        $dataArray = $request->all();
        $dataArray['editor_id'] = auth()->user()->id;
        $technicalDataForecast->update($dataArray);

        return redirect()->route($this->index_route)->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $technicalDataForecast = TechnicalDataForecast::find($id);
        $technicalDataForecast->delete();

        return redirect()->route($this->index_route)->with('success',__('app.deleted'));
    }

}
