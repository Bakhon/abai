<?php

namespace App\Http\Controllers;

use App\Http\Requests\EcoRefs\Cost\EcoRefsCostRequest;
use App\Http\Requests\EcoRefs\Cost\ImportExcelEcoRefsCostRequest;
use App\Http\Requests\EcoRefs\Cost\StoreEcoRefsCostRequest;
use App\Imports\EconomicIbrahimImport;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsCost;
use App\Models\Refs\EcoRefsScFa;
use Maatwebsite\Excel\Facades\Excel;

class EcoRefsCostController extends Controller
{
    public function index()
    {
        return view('ecorefscost.index');
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
                route("ecorefscost.edit", $item->id),
                $item->log_id,
            ];
        }

        return [
            'data' => $response
        ];
    }

    public function store(StoreEcoRefsCostRequest $request)
    {
        EcoRefsCost::create($request->validated());

        return redirect()
            ->route('ecorefscost.index')
            ->with('success', __('app.created'));
    }

    public function edit(int $id)
    {
        $ecoRefsCost = EcoRefsCost::findOrFail($id);

        $scFas = EcoRefsScFa::get();

        $companies = EcoRefsCompaniesId::get();

        return view('ecorefscost.edit', compact('ecoRefsCost', 'scFas', 'companies'));
    }

    public function update(StoreEcoRefsCostRequest $request, int $id)
    {
        $EcoRefsCost = EcoRefsCost::findOrFail($id);

        $EcoRefsCost->update($request->validated());

        return redirect()
            ->route('ecorefscost.index')
            ->with('success', __('app.updated'));
    }

    public function destroy(int $id)
    {
        EcoRefsCost::query()->whereId($id)->delete();

        return redirect()
            ->route('ecorefscost.index')
            ->with('success', __('app.deleted'));
    }

    public function uploadExcel()
    {
        return view('ecorefscost.import_excel');
    }

    public function importExcel(ImportExcelEcoRefsCostRequest $request)
    {
        $fileName = pathinfo($request->file->getClientOriginalName(), PATHINFO_FILENAME);

        Excel::import(new EconomicIbrahimImport(auth()->id(), $fileName), $request->file);

        return back()->with('success', __('app.success'));
    }
}
