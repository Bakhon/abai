<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Gtm\EconomicGtmImportExcelRequest;
use App\Http\Requests\Economic\Gtm\Value\EconomicGtmValueDataRequest;
use App\Http\Resources\EcoRefsGtmValueResource;
use App\Imports\Economic\EconomicGtmValueImport;
use App\Models\Refs\EcoRefsGtmValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EconomicGtmValueController extends Controller
{
    public function destroy(int $id): int
    {
        return EcoRefsGtmValue::query()->whereId($id)->delete();
    }

    public function getData(EconomicGtmValueDataRequest $request): array
    {
        $query = EcoRefsGtmValue::query();

        if ($request->company_id) {
            $query->whereCompanyId($request->company_id);
        }

        if ($request->gtm_id) {
            $query->whereGtmId($request->gtm_id);
        }

        $data = $query
            ->with(['company', 'gtm'])
            ->latest('id')
            ->get();

        return [
            'data' => EcoRefsGtmValueResource::collection($data)
        ];
    }

    public function importExcel(EconomicGtmImportExcelRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $import = new EconomicGtmValueImport(auth()->id());

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}