<?php

namespace App\Http\Controllers\Economic\Technical;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Technical\TechnicalDataForecastImportExcelRequest;
use App\Http\Requests\Economic\Technical\TechnicalDataForecastRequest;
use App\Http\Requests\Economic\Technical\TechnicalDataForecastUpdateRequest;
use App\Imports\Economic\Technical\TechnicalDataForecastImport;
use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalStructureCdng;
use App\Models\Refs\TechnicalStructureGu;
use App\Models\Refs\TechnicalStructureNgdu;
use App\Models\Refs\TechnicalStructurePes;
use App\Models\Refs\TechnicalStructureSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class TechnicalDataForecastController extends Controller
{
    const INDEX_ROUTE = "economic.technical.forecast.index";

    public function index(): View
    {
        return view('economic.technical.forecast.index');
    }

    public function edit(int $id): View
    {
        $model = TechnicalDataForecast::find($id);

        $gu = TechnicalStructureGu::get();

        $source = TechnicalStructureSource::get();

        $pes = TechnicalStructurePes::get();

        return view(
            'economic.technical.forecast.edit',
            compact('model', 'gu', 'source', 'pes')
        );
    }

    public function update(TechnicalDataForecastUpdateRequest $request, int $id): RedirectResponse
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
            ->with(['source', 'gu', 'author', 'editor', 'pes'])
            ->get()
            ->toArray();
    }

    public function uploadExcel(): View
    {
        $mimeTypes = TechnicalDataForecastImportExcelRequest::MIME_TYPES;

        return view('economic.technical.forecast.import_excel', compact('mimeTypes'));
    }

    public function importExcel(TechnicalDataForecastImportExcelRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new TechnicalDataForecastImport(auth()->id(), $fileName);

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}
