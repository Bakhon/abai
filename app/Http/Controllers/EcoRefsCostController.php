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

    public function economicDataJson(EcoRefsCostRequest $request): array
    {
        $economicData = EcoRefsCost::query()
            ->whereScFa($request->sc_fa)
            ->with(['scfa', 'company', 'author', 'editor'])
            ->get();

        $columns = [__('economic_reference.source_data'),
            __('economic_reference.company'), __('economic_reference.month-year'),
            __('economic_reference.variable'), __('economic_reference.fix_noWRpayroll'),
            __('economic_reference.fix_payroll'), __('economic_reference.fix_nopayroll'),
            __('economic_reference.fix'), __('economic_reference.gaoverheads'),
            __('economic_reference.wr_nopayroll'), __('economic_reference.wr_payroll'),
            __('economic_reference.wo'), __('economic_reference.net_back'),
            __('economic_reference.amort'), __('economic_reference.comment'),
            __('economic_reference.added_date_author'), __('economic_reference.changed_date_author'),
            __('economic_reference.edit'), __('economic_reference.id_of_add')];

        $response = [$columns];

        /** @var EcoRefsCost $item */
        foreach ($economicData as $item) {
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
