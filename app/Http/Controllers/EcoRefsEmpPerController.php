<?php

namespace App\Http\Controllers;

use App\Http\Requests\EcoRefs\EmpPer\EcoRefsEmpPerRequest;             
use App\Http\Requests\EcoRefs\EmpPer\ImportExcelEcoRefsEmpPerRequest;  
use App\Http\Requests\EcoRefs\EmpPer\UpdateEcoRefsEmpPerRequest;       
use App\Imports\EcoRefsEmpPerImport;  
use App\Models\EcoRefsCompaniesId;                                    
use App\Models\EcoRefsDirectionId;                                    
use App\Models\EcoRefsRoutesId;                                       
use App\Models\EcoRefsEmpPer;              
use App\Models\Refs\EcoRefsScFa;              
use Illuminate\Http\Request;    
use App\Http\Resources\EcoRefsEmpPerListResource;            
use Illuminate\Http\RedirectResponse;                                
use Illuminate\Support\Facades\DB;                                   
use Illuminate\View\View;                                            
use Maatwebsite\Excel\Facades\Excel;                                 

class EcoRefsEmpPerController extends Controller
{
    protected $modelName = 'ecorefsempper';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = [
            'links' => [
                'list' => route('ecorefsempper.list'),
            ]
        ];
        $ecorefsempper = EcoRefsEmpPer::latest()->with('scfa')->paginate(5);

        $ecorefsempperPages = view('economy_kenzhe/ecorefsempper.index',compact('ecorefsempper'))
            ->with('starting_row_number', (request()->input('page', 1) - 1) * 5);

        return $ecorefsempperPages;
       //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();
        $direction = EcoRefsDirectionId::get();
        $route = EcoRefsRoutesId::get();
        return view('economy_kenzhe/ecorefsempper.create',compact('sc_fa', 'company', 'direction', 'route'));
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
            'date' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'emp_per' => 'nullable|numeric',
            ]);

        EcoRefsEmpPer::create($request->all());

        return redirect()->route('ecorefsempper.index')->with('success',__('app.created'));
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
    public function edit( int $id): View
    {
        $sc_fa = EcoRefsScFa::get();
        $row = EcoRefsEmpPer::find($id);
        $company = EcoRefsCompaniesId::get();
        $direction = EcoRefsDirectionId::get();
        $route = EcoRefsRoutesId::get();

        return view('economy_kenzhe/ecorefsempper.edit',compact('row', 'sc_fa', 'company', 'direction', 'route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEcoRefsEmpPerRequest $request, $id)
    {
        $EcoRefsEmpPer=EcoRefsEmpPer::find($id);
        $request->validate([
            'sc_fa' =>        'required',
            'company_id' =>   'required',
            'direction_id' => 'required',
            'route_id' =>     'required',
            'date' =>         'required',
            'emp_per' => 'nullable|numeric'
        ]);

        $EcoRefsEmpPer->update($request->all());

        return redirect()->route('ecorefsempper.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsEmpPer = EcoRefsEmpPer::find($id);
        $EcoRefsEmpPer->delete();

        return redirect()->route('ecorefsempper.index')->with('success',__('app.deleted'));
    }

    public function list(EcoRefsEmpPerRequest $request)
    {
        parent::list($request);

        $query = EcoRefsEmpPer::query()
            ->whereScFa($request->sc_fa)
            ->with(['scfa', 'company', 'direction', 'route'])
            ->get();

        $ecorefsempper = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(EcoRefsEmpPerListResource::collection($ecorefsempper)->toJson()));
    }

    public function uploadExcel(): View
    {
        return view('economy_kenzhe/ecorefsempper.import_excel');
    }

    public function importExcel(ImportExcelEcoRefsEmpPerRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new EcoRefsEmpPerImport(
                $fileName,
            );

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}
