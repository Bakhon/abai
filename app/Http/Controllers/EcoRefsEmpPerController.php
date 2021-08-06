<?php

namespace App\Http\Controllers;

use App\Http\Requests\EcoRefs\EmpPer\EcoRefsEmpPerRequest;             // here
use App\Http\Requests\EcoRefs\EmpPer\ImportExcelEcoRefsEmpPerRequest;  // here
use App\Http\Requests\EcoRefs\EmpPer\UpdateEcoRefsEmpPerRequest;       // here
use App\Imports\EcoRefsEmpPerImport;  
use App\Models\EcoRefsCompaniesId;                                    // here
use App\Models\EcoRefsDirectionId;                                    // here
use App\Models\EcoRefsRoutesId;                                       // here
use App\Models\EcoRefsEmpPer;              
use App\Models\Refs\EcoRefsScFa;              
use Illuminate\Http\Request;              
use Illuminate\Http\RedirectResponse;                                 // here
use Illuminate\Support\Facades\DB;                                    // here
use Illuminate\View\View;                                             // here
use Maatwebsite\Excel\Facades\Excel;                                  // here

class EcoRefsEmpPerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ecorefsempper = EcoRefsEmpPer::latest()->with('scfa')->paginate(5);

        return view('ecorefsempper.index',compact('ecorefsempper'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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
        return view('ecorefsempper.create',compact('sc_fa', 'company', 'direction', 'route'));
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

        return view('ecorefsempper.edit',compact('row', 'sc_fa', 'company', 'direction'. 'route'));
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

    public function getData(EcoRefsEmpPerRequest $request): array
    {
        $data = EcoRefsEmpPer::query()
            ->whereScFa($request->sc_fa)
            ->with(['scfa', 'company', 'direction', 'route'])
            ->get();

        $response = [];

        /** @var EcoRefsEmpPer $item */
        foreach ($data as $item) {
            $response[] = [
                $item->scfa->name,
                $item->company -> name,
                $item->direction->name,
                $item->route->name,
                date('Y-m-d', strtotime($item->date)),
                $item->emp_per
            ];
        }

        return [
            'data' => $response
        ];
    }

    public function uploadExcel(): View
    {
        return view('ecorefsempper.import_excel');
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
