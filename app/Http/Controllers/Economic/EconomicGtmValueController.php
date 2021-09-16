<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Gtm\EconomicGtmImportExcelRequest;
use App\Http\Requests\Economic\Gtm\Value\EconomicGtmValueDataRequest;
use App\Http\Resources\EcoRefsGtmValueResource;
use App\Imports\Economic\EconomicGtmValueImport;
use App\Models\Refs\EcoRefsGtmValue;
use App\User;
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

        if ($request->author_id) {
            $query->whereAuthorId($request->author_id);
        }

        if ($request->log_id) {
            $query->whereLogId($request->log_id);
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
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new EconomicGtmValueImport(auth()->id(), $fileName);

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }

    public function getAuthors(): array
    {
        $authorIds = EcoRefsGtmValue::query()->distinct()->pluck('author_id');

        return User::query()
            ->select(['id', 'name'])
            ->whereIn('id', $authorIds)
            ->get()
            ->toArray();
    }
}
