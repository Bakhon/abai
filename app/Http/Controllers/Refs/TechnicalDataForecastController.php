<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Technical\StoreTechnicalDataForecastRequest;
use App\Http\Requests\Technical\TechnicalDataForecastRequest;
use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class TechnicalDataForecastController extends Controller
{
    protected $index_route = "tech_data_forecast.index";

    public function index(): View
    {
        return view('technical_forecast.production_data.index');
    }

    public function techDataJson(TechnicalDataForecastRequest $request): array
    {
        $techData = TechnicalDataForecast::query()
            ->whereSourceId($request->source_id)
            ->with(['source', 'gu', 'author', 'editor'])
            ->get();

        $columns = [__('forecast.source_data'), __('forecast.gu'), __('forecast.well'),
            __('forecast.month-year'), __('forecast.oil-production'), __('forecast.extraction-liquid'),
            __('forecast.days-worked'), __('forecast.prs'), __('forecast.comment'),
            __('forecast.added_date_author'), __('forecast.changed_date_author'),
            __('forecast.edit'), __('forecast.id_of_add')];

        $response = [$columns];

        foreach ($techData as $item) {
            $response[] = [
                $item->source->name,
                $item->gu->name,
                $item->well_id,
                date('Y-m', strtotime($item->date)),
                $item->oil,
                $item->liquid,
                $item->days_worked,
                $item->prs,
                $item->comment,
                "{$item->created_at} {$item->author->name}",
                $item->editor ? "{$item->updated_at} {$item->editor->name}" : "",
                route("tech_data_forecast.edit", $item->id),
                $item->log_id,
            ];
        }

        return [
            'data' => $response
        ];
    }

    public function create(): View
    {
        $source = TechnicalStructureSource::get();
        $gu = TechnicalStructureGu::get();
        return view('technical_forecast.production_data.create', compact('source', 'gu'));
    }

    public function store(StoreTechnicalDataForecastRequest $request): RedirectResponse
    {
        $dataArray = $request->all();
        $dataArray['author_id'] = auth()->user()->id;
        TechnicalDataForecast::create($dataArray);

        return redirect()->route($this->index_route)->with('success', __('app.created'));
    }

    public function edit(int $id): View
    {
        $technicalDataForecast = TechnicalDataForecast::find($id);
        $gu = TechnicalStructureGu::get();
        $source = TechnicalStructureSource::get();
        return view('technical_forecast.production_data.edit',
            compact('source', 'technicalDataForecast', 'gu'));
    }

    public function update(StoreTechnicalDataForecastRequest $request, int $id): RedirectResponse
    {
        $technicalDataForecast = TechnicalDataForecast::find($id);
        $dataArray = $request->all();
        $dataArray['editor_id'] = auth()->user()->id;
        $technicalDataForecast->update($dataArray);

        return redirect()->route($this->index_route)->with('success', __('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $technicalDataForecast = TechnicalDataForecast::find($id);
        $technicalDataForecast->delete();

        return redirect()->route($this->index_route)->with('success', __('app.deleted'));
    }

}
