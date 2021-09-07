<?php

namespace App\Http\Controllers;

use App\Http\Requests\EcoRefs\Macro\EcoRefsMacroRequest;             
use App\Http\Requests\EcoRefs\Macro\ImportExcelEcoRefsMacroRequest;  
use App\Http\Requests\EcoRefs\Macro\UpdateEcoRefsMacroRequest;       
use App\Imports\EcoRefsMacroImport;                                  
use App\Models\EcoRefsMacro;              
use App\Models\Refs\EcoRefsScFa;              
use Illuminate\Http\Request;       
use App\Http\Resources\EcoRefsMacroListResource;       
use Illuminate\Http\RedirectResponse;                                
use Illuminate\Support\Facades\DB;                                   
use Illuminate\View\View;                                            
use Maatwebsite\Excel\Facades\Excel;                                 

class EcoRefsMacroController extends Controller
{

    protected $modelName = 'ecorefsmacro';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = [
            'links' => [
                'list' => route('ecorefsmacro.list'),
            ]
        ];

        $ecorefsmacro = EcoRefsMacro::orderBy('id','desc')->latest()->with('scfa')->paginate(5);

        $ecorefsmacroPages = view('economy_kenzhe/ecorefsmacro.index',compact('ecorefsmacro'))
            ->with('starting_row_number', (request()->input('page', 1) - 1) * 8);

        return $ecorefsmacroPages;
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
        return view('economy_kenzhe/ecorefsmacro.create',compact('sc_fa'));
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
            'ex_rate_dol' => 'nullable|numeric',
            'ex_rate_rub' => 'nullable|numeric',
            'inf_end' => 'nullable|numeric',
            'barrel_world_price' => 'nullable|numeric'
            ]);

        EcoRefsMacro::create($request->all());

        return redirect()->route('ecorefsmacro.index')->with('success',__('app.created'));
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
        $scFas = EcoRefsScFa::get();
        $ecoRefsMacro = EcoRefsMacro::find($id);
        return view('economy_kenzhe/ecorefsmacro.edit',compact('ecoRefsMacro', 'scFas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEcoRefsMacroRequest $request, $id)
    {
        $EcoRefsMacro=EcoRefsMacro::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'date' => 'required',
            'ex_rate_dol' => 'nullable|numeric',
            'ex_rate_rub' => 'nullable|numeric',
            'inf_end' => 'nullable|numeric',
            'barrel_world_price' => 'nullable|numeric'
        ]);

        $EcoRefsMacro->update($request->all());

        return redirect()->route('ecorefsmacro.index')->with('success',__('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $EcoRefsMacro = EcoRefsMacro::find($id);
        $EcoRefsMacro->delete();

        return redirect()->route('ecorefsmacro.index')->with('success',__('app.deleted'));
    }

    public function list(EcoRefsMacroRequest $request)
    {
        parent::list($request);

        $query = EcoRefsMacro::query()
            ->whereScFa($request->sc_fa)
            ->with(['scfa'])
            ->get();

        $ecorefsmacro = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);
        
        return response()->json(json_decode(EcoRefsMacroListResource::collection($ecorefsmacro)->toJson()));
    }

    public function uploadExcel(): View
    {
        return view('economy_kenzhe/ecorefsmacro.import_excel');
    }

    public function importExcel(ImportExcelEcoRefsMacroRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new EcoRefsMacroImport(
                $fileName,
            );

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}
