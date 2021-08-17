<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Http\Requests\EcoRefs\Gtm\ImportExcelEcoRefsGtmRequest;
use App\Http\Requests\EcoRefs\GtmValue\EcoRefsGtmValueRequest;
use App\Http\Resources\EcoRefsGtmValueResource;
use App\Imports\EcoRefsGtmValueImport;
use App\Models\Refs\EcoRefsGtmValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EcoRefsGtmValueController extends Controller
{
    public function destroy(int $id): int
    {
        return EcoRefsGtmValue::query()->whereId($id)->delete();
    }

    public function getData(EcoRefsGtmValueRequest $request): array
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

    public function importExcel(ImportExcelEcoRefsGtmRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $import = new EcoRefsGtmValueImport(auth()->id());

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}
