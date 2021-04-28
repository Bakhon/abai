<?php

namespace App\Http\Controllers;

use App\Http\Requests\EcoRefs\Cost\EcoRefsCostRequest;
use App\Http\Requests\EcoRefs\Cost\ImportExcelEcoRefsCostRequest;
use App\Http\Requests\EcoRefs\Cost\UpdateEcoRefsCostRequest;
use App\Imports\EconomicIbrahimImport;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsCost;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class EcoRefsCostController extends Controller
{
    public function index()
    {
        return view('eco_refs_cost.index');
    }

    public function indexScenario()
    {
        return view('eco_refs_cost_scenario.index');
    }

    public function edit(int $id)
    {
        $ecoRefsCost = EcoRefsCost::findOrFail($id);

        $scFas = EcoRefsScFa::get();

        $companies = EcoRefsCompaniesId::get();

        return view('eco_refs_cost.edit', compact('ecoRefsCost', 'scFas', 'companies'));
    }

    public function update(UpdateEcoRefsCostRequest $request, int $id)
    {
        /** @var EcoRefsCost $ecoRefsCost */
        $ecoRefsCost = EcoRefsCost::findOrFail($id);

        $ecoRefsCost->update($request->validated());

        return redirect()
            ->route('eco_refs_cost.index')
            ->with('success', __('app.updated'));
    }

    public function destroy(int $id)
    {
        EcoRefsCost::query()->whereId($id)->delete();

        return redirect()
            ->route('eco_refs_cost.index')
            ->with('success', __('app.deleted'));
    }

    public function getData(EcoRefsCostRequest $request): array
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
                route("eco_refs_cost.edit", $item->id),
                $item->log_id,
            ];
        }

        return [
            'data' => $response
        ];
    }

    public function uploadExcel()
    {
        return view('eco_refs_cost.import_excel');
    }

    public function importExcel(ImportExcelEcoRefsCostRequest $request)
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new EconomicIbrahimImport(
                auth()->id(),
                $fileName,
                (bool)$request->is_fact
            );

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}
