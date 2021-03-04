<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\TechRefsBkns;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TechRefsBknsController extends Controller
{

    public function index(): View
    {
        $techRefsBkns = TechRefsBkns::latest()->paginate(5);

        return view('tech_refs.bkns.index',compact('techRefsBkns'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
//        $user = auth()->user()->name;
        return view('tech_refs.bkns.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        TechRefsBkns::create($dataArray);

        return redirect()->route('techrefsbkns.index')->with('success',__('app.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(int $id): Response
    {
    }

    public function edit(int $id): View
    {
        $techRefsBkns = TechRefsBkns::find($id);
        return view('tech_refs.bkns.edit',compact('techRefsBkns'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $techRefsBkns=TechRefsBkns::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $techRefsBkns->update($dataArray);

        return redirect()->route('techrefsbkns.index')->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $techRefsBkns = TechRefsBkns::find($id);
        $techRefsBkns->delete();

        return redirect()->route('techrefsbkns.index')->with('success',__('app.deleted'));
        //
    }

}
