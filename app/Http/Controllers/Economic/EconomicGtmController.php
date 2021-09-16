<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Gtm\EconomicGtmDataRequest;
use App\Http\Requests\Economic\Gtm\EconomicGtmImportExcelRequest;
use App\Http\Resources\EcoRefsGtmResource;
use App\Imports\Economic\EconomicGtmImport;
use App\Models\Refs\EcoRefsGtm;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class EconomicGtmController extends Controller
{
    public function index(): View
    {
        return view('economic.gtm.index');
    }

    public function destroy(int $id): int
    {
        return EcoRefsGtm::query()->whereId($id)->delete();
    }

    public function getData(EconomicGtmDataRequest $request): array
    {
        $query = EcoRefsGtm::query();

        if ($request->company_id) {
            $query->whereCompanyId($request->company_id);
        }

        if ($request->author_id) {
            $query->whereAuthorId($request->author_id);
        }

        if ($request->log_id) {
            $query->whereLogId($request->log_id);
        }

        $data = $query
            ->with('company')
            ->latest('id')
            ->get();

        return [
            'data' => EcoRefsGtmResource::collection($data)
        ];
    }

    public function uploadExcel(Request $request): View
    {
        $mimeTypes = EconomicGtmImportExcelRequest::MIME_TYPES;

        $isTechnical = $request->is_technical;

        return view(
            'economic.gtm.import_excel',
            compact('mimeTypes', 'isTechnical')
        );
    }

    public function importExcel(EconomicGtmImportExcelRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new EconomicGtmImport(auth()->id(), $fileName);

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }

    public function getAuthors(): array
    {
        $authorIds = EcoRefsGtm::query()->distinct()->pluck('author_id');

        return User::query()
            ->select(['id', 'name'])
            ->whereIn('id', $authorIds)
            ->get()
            ->toArray();
    }
}
