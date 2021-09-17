<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Cost\EconomicCostDataRequest;
use App\Http\Requests\Economic\Cost\EconomicCostImportExcelRequest;
use App\Http\Requests\Economic\Cost\EconomicCostUpdateRequest;
use App\Imports\Economic\EconomicCostImport;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsCost;
use App\Models\Refs\EcoRefsScFa;
use App\Models\Refs\TechnicalStructurePes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class EconomicCostController extends Controller
{
    public function index(): View
    {
        $isForecast = request()->query('is_forecast');

        return view('economic.cost.index', compact('isForecast'));
    }

    public function edit(int $id): View
    {
        $model = EcoRefsCost::findOrFail($id);

        $fillableFloatKeys = EcoRefsCost::FILLABLE_FLOAT_KEYS;

        $scFas = EcoRefsScFa::get();

        $companies = EcoRefsCompaniesId::get();

        $pes = TechnicalStructurePes::get();

        return view(
            'economic.cost.edit',
            compact('model', 'fillableFloatKeys', 'scFas', 'companies', 'pes')
        );
    }

    public function update(EconomicCostUpdateRequest $request, int $id): RedirectResponse
    {
        /** @var EcoRefsCost $ecoRefsCost */
        $ecoRefsCost = EcoRefsCost::findOrFail($id);

        $ecoRefsCost->update($request->validated());

        return redirect()
            ->route('economic.cost.index')
            ->with('success', __('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        EcoRefsCost::query()->whereId($id)->delete();

        return redirect()
            ->route('economic.cost.index')
            ->with('success', __('app.deleted'));
    }

    public function getData(EconomicCostDataRequest $request): array
    {
        $query = EcoRefsCost::query();

        if($request->sc_fa){
            $query->whereScFa($request->sc_fa);
        }

        if($request->company_id){
            $query->whereCompanyId($request->company_id);
        }

        return $query
            ->with(['scfa', 'company', 'author', 'editor', 'pes'])
            ->get()
            ->toArray();
    }

    public function uploadExcel(): View
    {
        $mimeTypes = EconomicCostImportExcelRequest::MIME_TYPES;

        $isForecast = request()->query('is_forecast');

        return view(
            'economic.cost.import_excel',
            compact('mimeTypes', 'isForecast')
        );
    }

    public function importExcel(EconomicCostImportExcelRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new EconomicCostImport(
                auth()->id(),
                $fileName,
                $request->is_forecast
            );

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}
