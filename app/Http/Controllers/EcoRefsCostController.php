<?php

namespace App\Http\Controllers;

use App\Http\Requests\EcoRefs\Cost\EcoRefsCostRequest;
use App\Imports\EconomicIbrahimImport;
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsCost;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EcoRefsCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefscost = EcoRefsCost::latest()->with('scfa')->with('company')->paginate(5);
        return view('ecorefscost.index', compact('ecorefscost'));
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
            __('economic_reference.comment'),
            __('economic_reference.added_date_author'), __('economic_reference.changed_date_author'),
            __('economic_reference.edit'), __('economic_reference.id_of_add')];

        $response = [$columns];

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
                $item->comment,
                $item->author ? "{$item->created_at} {$item->author->name}" : "",
                $item->editor ? "{$item->updated_at} {$item->editor->name}" : "",
                route("ecorefscost.edit", $item->id),
                $item->log_id,
            ];
        }

        return [
            'economic_data' => $response
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sc_fa' => 'required',
            'company_id' => 'required',
            'date' => 'required',
            'variable' => 'nullable|numeric',
            'fix_noWRpayroll' => 'nullable|numeric',
            'fix_nopayroll' => 'nullable|numeric',
            'fix' => 'nullable|numeric',
            'gaoverheads' => 'nullable|numeric',
            'wr_nopayroll' => 'nullable|numeric',
            'wr_payroll' => 'nullable|numeric',
            'wo' => 'nullable|numeric',
            'net_back' => 'nullable|numeric',
        ]);

        EcoRefsCost::create($request->all());

        return redirect()->route('ecorefscost.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $eco_refs_cost = EcoRefsCost::find($id);
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();

        return view('ecorefscost.edit', compact('sc_fa', 'eco_refs_cost', 'company'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $EcoRefsCost = EcoRefsCost::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'company_id' => 'required',
            'date' => 'required',
            'variable' => 'nullable|numeric',
            'fix_noWRpayroll' => 'nullable|numeric',
            'fix_nopayroll' => 'nullable|numeric',
            'fix' => 'nullable|numeric',
            'gaoverheads' => 'nullable|numeric',
            'wr_nopayroll' => 'nullable|numeric',
            'wr_payroll' => 'nullable|numeric',
            'wo' => 'nullable|numeric',
            'net_back' => 'nullable|numeric',
        ]);

        $EcoRefsCost->update($request->all());

        return redirect()->route('ecorefscost.index')->with('success', __('app.updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsCost::find($id);
        $row->delete();

        return redirect()->route('ecorefscost.index')->with('success', __('app.deleted'));
    }

    public function uploadExcel()
    {
        return view('ecorefscost.import_excel');
    }

    public function importExcel(Request $request)
    {
        $user_id = auth()->id();
        $file_name = $request->select_file->getClientOriginalName();
        $file_name = pathinfo($file_name, PATHINFO_FILENAME);
        Excel::import(new EconomicIbrahimImport($user_id, $file_name), $request->select_file);
        return back()->with('success', 'Загрузка прошла успешно.');
    }
}
