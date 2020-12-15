<?php

namespace App\Http\Controllers\ComplicationMonitoring;

use App\Http\Controllers\Controller;
use App\Http\Requests\CorrosionCreateRequest;
use App\Http\Requests\CorrosionUpdateRequest;
use App\Models\ComplicationMonitoring\Corrosion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CorrosionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $corrosion = Corrosion::orderByDesc('final_date_of_background_corrosion')
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->paginate(10);

        return view('сomplicationMonitoring.corrosion.index', compact('corrosion'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function export()
    {
        $corrosion = Corrosion::orderByDesc('final_date_of_background_corrosion')
            ->with('other_objects')
            ->with('ngdu')
            ->with('cdng')
            ->with('gu')
            ->get();

        return Excel::download(new \App\Exports\CorrosionExport($corrosion), 'corrosion.xls');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('сomplicationMonitoring.corrosion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CorrosionCreateRequest $request)
    {
        $corrosion = Corrosion::create($request->validated());
        return redirect()->route('corrosioncrud.index')->with('success', __('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Corrosion $corrosioncrud)
    {
        return view('сomplicationMonitoring.corrosion.show', ['corrosion' => $corrosioncrud]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history(Corrosion $corrosion)
    {
        $corrosion->load('history');
        return view('сomplicationMonitoring.corrosion.history', compact('corrosion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Corrosion $corrosioncrud)
    {
        return view('сomplicationMonitoring.corrosion.edit', ['corrosion' => $corrosioncrud]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CorrosionUpdateRequest $request, Corrosion $corrosioncrud)
    {
        $corrosioncrud->update($request->validated());
        return redirect()->route('corrosioncrud.index')->with('success', __('app.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Corrosion $corrosioncrud)
    {
        $corrosioncrud->delete();
        return redirect()->route('corrosioncrud.index')->with('success', __('app.deleted'));
    }
}
