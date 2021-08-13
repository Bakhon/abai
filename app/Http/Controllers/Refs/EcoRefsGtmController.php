<?php

namespace App\Http\Controllers\Refs;

use App\EcoRefsScenario;
use App\Http\Controllers\Controller;
use App\Http\Requests\EcoRefs\Gtm\EcoRefsGtmRequest;
use App\Http\Requests\EcoRefs\Gtm\ImportExcelEcoRefsGtmRequest;
use App\Http\Requests\EcoRefs\Scenario\StoreEcoRefsScenarioRequest;
use App\Http\Resources\EcoRefsGtmResource;
use App\Http\Resources\EcoRefsScenarioResource;
use App\Imports\EcoRefsGtmImport;
use App\Models\Refs\EcoRefsGtm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class EcoRefsGtmController extends Controller
{
    public function index(): View
    {
        return view('eco_refs_gtm.index');
    }

    public function store(StoreEcoRefsScenarioRequest $request): EcoRefsScenarioResource
    {
        $scenario = EcoRefsScenario::create($request->validated());

        $scenario->load('scFa');

        return EcoRefsScenarioResource::make($scenario);
    }

    public function destroy(int $id): RedirectResponse
    {
        EcoRefsGtm::query()->whereId($id)->delete();

        return redirect()
            ->route('eco_refs_gtm.index')
            ->with('success', __('app.deleted'));
    }

    public function getData(EcoRefsGtmRequest $request): array
    {
        $query = EcoRefsGtm::query();

        if ($request->company_id) {
            $query->whereCompanyId($request->company_id);
        }

        $data = $query
            ->with('company')
            ->latest('id')
            ->get();

        return [
            'data' => EcoRefsGtmResource::collection($data)
        ];
    }

    public function uploadExcel(): View
    {
        $mimeTypes = ImportExcelEcoRefsGtmRequest::MIME_TYPES;

        return view('eco_refs_gtm.import_excel', compact('mimeTypes'));
    }

    public function importExcel(ImportExcelEcoRefsGtmRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $import = new EcoRefsGtmImport(auth()->id());

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}
