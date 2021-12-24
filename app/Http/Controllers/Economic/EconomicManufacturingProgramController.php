<?php

namespace App\Http\Controllers\Economic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Gtm\EconomicGtmImportExcelRequest;
use App\Http\Requests\Economic\ManufacturingProgram\EconomicManufacturingProgramDataRequest;
use App\Imports\Economic\EconomicManufacturingProgramImport;
use App\Models\Refs\EcoRefsManufacturingProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class EconomicManufacturingProgramController extends Controller
{
    public function index(): View
    {
        return view('economic.manufacturing_program.index');
    }

    public function getData(EconomicManufacturingProgramDataRequest $request): array
    {
        $query = EcoRefsManufacturingProgram::query();

        if ($request->company_id) {
            $query->whereCompanyId($request->company_id);
        }

        if ($request->user_id) {
            $query->whereUserId($request->user_id);
        }

        if ($request->log_id) {
            $query->whereLogId($request->log_id);
        }

        return $query
            ->with(['company', 'user'])
            ->latest('id')
            ->get()
            ->toArray();
    }

    public function uploadExcel(): View
    {
        $mimeTypes = EconomicGtmImportExcelRequest::MIME_TYPES;

        return view(
            'economic.manufacturing_program.import_excel',
            compact('mimeTypes')
        );
    }

    public function importExcel(EconomicGtmImportExcelRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new EconomicManufacturingProgramImport(auth()->id(), $fileName);

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}
