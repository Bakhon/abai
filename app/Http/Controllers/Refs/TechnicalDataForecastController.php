<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Technical\StoreTechnicalDataForecastRequest;
use App\Http\Requests\Technical\TechnicalDataForecastRequest;
use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalStructureCdng;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureNgdu;
use App\Models\Refs\TechnicalStructureSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class TechnicalDataForecastController extends Controller
{
    const INDEX_ROUTE = "tech-data-forecast.index";

    public function index(): View
    {
        return view('technical_forecast.production_data.index');
    }

    public function store(StoreTechnicalDataForecastRequest $request): RedirectResponse
    {
        $params = $request->validated();

        $params['author_id'] = auth()->user()->id;

        TechnicalDataForecast::create($params);

        return redirect()
            ->route(self::INDEX_ROUTE)
            ->with('success', __('app.created'));
    }

    public function edit(int $id): View
    {
        $technicalDataForecast = TechnicalDataForecast::find($id);

        $gu = TechnicalStructureGu::get();

        $source = TechnicalStructureSource::get();

        return view(
            'technical_forecast.production_data.edit',
            compact('source', 'technicalDataForecast', 'gu')
        );
    }

    public function update(StoreTechnicalDataForecastRequest $request, int $id): RedirectResponse
    {
        $technicalDataForecast = TechnicalDataForecast::findOrFail($id);

        $params = $request->validated();

        $params['editor_id'] = auth()->user()->id;

        $technicalDataForecast->update($params);

        return redirect()
            ->route(self::INDEX_ROUTE)
            ->with('success', __('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        TechnicalDataForecast::query()
            ->whereId($id)
            ->delete();

        return redirect()
            ->route(self::INDEX_ROUTE)
            ->with('success', __('app.deleted'));
    }

    public function getData(TechnicalDataForecastRequest $request): array
    {
        $query = TechnicalDataForecast::query();

        if ($request->source_id) {
            $query->whereSourceId($request->source_id);
        }

        if ($request->ngdu_id) {
            $ngdu = TechnicalStructureNgdu::findOrFail($request->ngdu_id);

            $guIds = TechnicalStructureGu::query()
                ->distinct()
                ->whereIn('cdng_id', $ngdu->cdngs()->pluck('id'))
                ->pluck('id');

            $query->whereIn('gu_id', $guIds);
        }

        if ($request->cdng_id) {
            /** @var TechnicalStructureCdng $cdng */
            $cdng = TechnicalStructureCdng::findOrFail($request->cdng_id);

            $query->whereIn('gu_id', $cdng->gus()->distinct()->pluck('id'));
        }

        if ($request->gu_id) {
            $query->whereGuId($request->gu_id);
        }

        if ($request->only_well_id) {
            return $query
                ->distinct()
                ->pluck('well_id')
                ->toArray();
        }

        return $query
            ->with(['source', 'gu', 'author', 'editor'])
            ->get()
            ->toArray();
    }
}
