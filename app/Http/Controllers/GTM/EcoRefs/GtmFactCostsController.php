<?php

namespace App\Http\Controllers\GTM\EcoRefs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Paegtm\EcoRefs\ImportExcelGtmFactCostsRequest;
use App\Imports\PaegtmRefsGtmFactCostsImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class GtmFactCostsController extends Controller
{
    public function uploadExcel(): View
    {
        $mimeTypes = ImportExcelGtmFactCostsRequest::MIME_TYPES;

        return view('gtm.EcoRefs.GtmFactCosts.import_excel', compact('mimeTypes'));
    }

    public function importExcel(ImportExcelGtmFactCostsRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $import = new PaegtmRefsGtmFactCostsImport();

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}
