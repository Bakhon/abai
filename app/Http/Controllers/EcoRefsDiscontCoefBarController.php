<?php

namespace App\Http\Controllers;

use App\Http\Requests\EcoRefs\DiscontCoefBar\EcoRefsDiscontCoefBarRequest;     
use App\Http\Requests\EcoRefs\DiscontCoefBar\ImportExcelEcoRefsDiscontCoefBarRequest;     
use App\Http\Requests\EcoRefs\DiscontCoefBar\UpdateEcoRefsDiscontCoefBarRequest;
use App\Imports\EcoRefsDiscontCoefBarImport;       
use App\Models\EcoRefsCompaniesId;
use App\Models\EcoRefsDirectionId;
use App\Models\EcoRefsRoutesId;
use App\Models\EcoRefsDiscontCoefBar;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Http\Request;
use App\Http\Resources\EcoRefsDiscontCoefBarListResource;  
use Illuminate\Http\RedirectResponse;                                 
use Illuminate\Support\Facades\DB;                                    
use Illuminate\View\View;                                             
use Maatwebsite\Excel\Facades\Excel;  

class EcoRefsDiscontCoefBarController extends Controller
{
    protected $modelName = 'ecorefsdiscontcoefbar';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = [
            'links' => [
                'list' => route('ecorefsdiscontcoefbar.list'),
            ]
        ];
        
        $ecorefsdiscontcoefbar = EcoRefsDiscontCoefBar::latest()->with('scfa')->with('company')->with('direction')->with('route')->paginate(5);

        $ecorefsdiscontcoefbarPages = view('economy_kenzhe/ecorefsdiscontcoefbar.index',compact('ecorefsdiscontcoefbar'))
            ->with('starting_row_number', (request()->input('page', 1) - 1) * 5);

        return $ecorefsdiscontcoefbarPages;
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
        return view('economy_kenzhe/ecorefsdiscontcoefbar.create',compact('sc_fa', 'company', 'direction', 'route'));
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
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'date' => 'required',
            'barr_coef' => 'required',
            'discont' => 'required',
            'macro' => 'required',
        ]);

        EcoRefsDiscontCoefBar::create($request->all());

        return redirect()->route('ecorefsdiscontcoefbar.index')->with('success',__('app.created'));
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
        $row = EcoRefsDiscontCoefBar::find($id);
        $sc_fa = EcoRefsScFa::get();
        $company = EcoRefsCompaniesId::get();
        $direction = EcoRefsDirectionId::get();
        $route = EcoRefsRoutesId::get();

        return view('economy_kenzhe/ecorefsdiscontcoefbar.edit',compact('sc_fa', 'row', 'company', 'direction', 'route'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEcoRefsDiscontCoefBarRequest $request, $id)
    {
        $EcoRefsDiscontCoefBar=EcoRefsDiscontCoefBar::find($id);
        $request->validate([
            'sc_fa' => 'required',
            'company_id' => 'required',
            'direction_id' => 'required',
            'route_id' => 'required',
            'date' => 'required',
            'barr_coef' => 'required',
            'discont' => 'required',
            'macro' => 'required',
        ]);

        $EcoRefsDiscontCoefBar->update($request->all());

        return redirect()->route('ecorefsdiscontcoefbar.index')->with('success',__('app.updated'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $row = EcoRefsDiscontCoefBar::find($id);
        $row->delete();

        return redirect()->route('ecorefsdiscontcoefbar.index')->with('success',__('app.deleted'));
    }

    public function list(EcoRefsDiscontCoefBarRequest $request)
    {
        parent::list($request);

        $query = EcoRefsDiscontCoefBar::query()
            ->whereScFa($request->sc_fa)
            ->with(['scfa', 'company', 'direction', 'route'])
            ->get();

        $ecorefsdiscontcoefbar = $this
            ->getFilteredQuery($request->validated(), $query)
            ->paginate(25);

        return response()->json(json_decode(EcoRefsDiscontCoefBarListResource::collection($ecorefsdiscontcoefbar)->toJson()));
    }

    public function uploadExcel(): View
    {
        return view('economy_kenzhe/ecorefsdiscontcoefbar.import_excel');
    }

    public function importExcel(ImportExcelEcoRefsDiscontCoefBarRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $fileName = pathinfo(
                $request->file->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $import = new EcoRefsDiscontCoefBarImport(
                $fileName,
            );

            Excel::import($import, $request->file);
        });

        return back()->with('success', __('app.success'));
    }
}


