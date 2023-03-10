<?php

namespace App\Http\Controllers;

use App\Http\Requests\EcoRefs\TarifyTn\EcoRefsTarifyTnRequest;   
use App\Http\Requests\EcoRefs\TarifyTn\ImportExcelEcoRefsTarifyTnRequest;   
use App\Http\Requests\EcoRefs\TarifyTn\UpdateEcoRefsTarifyTnRequest;   
use App\Imports\EcoRefsTarifyTnImport; 
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsRoutesId;
use App\Models\EcoRefsBranchId;
use App\Models\EcoRefsRouteTnId;
use App\Models\EcoRefsExc;
use App\Models\EcoRefsTarifyTn;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;
use App\Http\Resources\EcoRefsTarifyTnListResource;   
use Illuminate\Http\RedirectResponse;                                 
use Illuminate\Support\Facades\DB;                                    
use Illuminate\View\View;                                             
use Maatwebsite\Excel\Facades\Excel;  

class EcoRefsTarifyTnController extends Controller
{
    protected $modelName = 'ecorefstarifytn';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $params = [
                'links' => [
                    'list' => route('ecorefstarifytn.list'),
                ]
            ];

            $ecorefstarifytn = EcoRefsTarifyTn::orderBy('id','desc')->with('scfa')->with('branch')->with('company')->with('direction')->with('route')->with('routetn')->with('exc')->paginate(10);

            $ecorefstarifytnPages = view('economy_kenzhe/ecorefstarifytn.index',compact('ecorefstarifytn'))
                ->with('starting_row_number', (request()->input('page', 1) - 1) * 5);

            return $ecorefstarifytnPages;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sc_fa = EcoRefsScFa::get();
        $branch = EcoRefsBranchId::get();
        $company = EcoRefsCompaniesId::get();
        $direction = EcoRefsDirectionId::get();
        $route = EcoRefsRoutesId::get();
        $routetn = EcoRefsRouteTnId::get();
        $exc = EcoRefsExc::get();
        return view('economy_kenzhe/ecorefstarifytn.create',compact('sc_fa', 'branch', 'company', 'direction', 'route', 'routetn', 'exc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sc_fa' => 'required',
            'branch_id' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'route_tn_id' => 'required',
            'exc_id' => 'required',
            'date' => 'required',
            'tn_rate' => 'required',
        ]);

        EcoRefsTarifyTn::create($request->all());

        return redirect()->route('ecorefstarifytn.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            $row = EcoRefsTarifyTn::find($id);
            $sc_fa = EcoRefsScFa::get();
            $branch = EcoRefsBranchId::get();
            $company = EcoRefsCompaniesId::get();
            $direction = EcoRefsDirectionId::get();
            $route = EcoRefsRoutesId::get();
            $routetn = EcoRefsRouteTnId::get();
            $exc = EcoRefsExc::get();

            return view('economy_kenzhe/ecorefstarifytn.edit',compact('row', 'sc_fa', 'branch', 'company', 'direction', 'route', 'routetn', 'exc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEcoRefsTarifyTnRequest $request, $id)

    {
        $EcoRefsTarifyTn=EcoRefsTarifyTn::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'branch_id' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'route_tn_id' => 'required',
            'exc_id' => 'required',
            'date' => 'required',
            'tn_rate' => 'required',
        ]);

        $EcoRefsTarifyTn->update($request->all());

        return redirect()->route('ecorefstarifytn.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsTarifyTn::find($id);
        $row->delete();

        return redirect()->route('ecorefstarifytn.index')->with('success',__('app.deleted'));
    }

    public function list(EcoRefsTarifyTnRequest $request)
    {
        parent::list($request);

        $query = EcoRefsTarifyTn::query()
            ->whereScFa($request->sc_fa)
            ->with(['scfa', 'company', 'direction', 'route', 'branch', 'routetn', 'exc'])
            ->get();

        $ecorefstarifytn = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(EcoRefsTarifyTnListResource::collection($ecorefstarifytn)->toJson()));
    }

    public function uploadExcel(): View
    {
        return view('economy_kenzhe/ecorefstarifytn.import_excel');
    }

    public function importExcel(ImportExcelEcoRefsTarifyTnRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new EcoRefsTarifyTnImport(
                $fileName,
            );

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}
