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
        $ecoRefsCost = EcoRefsCost::findOrFail($id);

        $scFas = EcoRefsScFa::get();

        $companies = EcoRefsCompaniesId::get();

        return view(
            'economic.cost.edit',
            compact('ecoRefsCost', 'scFas', 'companies')
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
        $data = EcoRefsCost::query()
            ->whereScFa($request->sc_fa)
            ->with(['scfa', 'company', 'author', 'editor'])
            ->get();

        $response = [];

        /** @var EcoRefsCost $item */
        foreach ($data as $item) {
            $response[] = [
                $item->scfa->name,
                $item->company->name,
                date('Y-m', strtotime($item->date)),
                $item->variable,
                $item->variable_processing,
                $item->fix_noWRpayroll,
                $item->fix_payroll,
                $item->fix_nopayroll,
                $item->fix,
                $item->gaoverheads,
                $item->wr_nopayroll,
                $item->wr_payroll,
                $item->wo,
                $item->net_back,
                $item->amort,
                $item->comment,
                $item->author ? "{$item->created_at} {$item->author->name}" : "",
                $item->editor ? "{$item->updated_at} {$item->editor->name}" : "",
                route("economic.cost.edit", $item->id),
                $item->log_id,
            ];
        }

        return [
            'data' => $response
        ];
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
