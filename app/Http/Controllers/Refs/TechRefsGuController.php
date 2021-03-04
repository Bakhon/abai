<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\TechRefsCdng;
use App\Models\Refs\TechRefsGu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TechRefsGuController extends Controller
{

    public function index(): View
    {
        $techRefsGu = TechRefsGu::latest()->paginate(5);

        return view('tech_refs.gu.index',compact('techRefsGu'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        $cdng = TechRefsCdng::get();
        return view('tech_refs.gu.create',compact('cdng'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'cdng_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        TechRefsGu::create($dataArray);

        return redirect()->route('techrefsgu.index')->with('success',__('app.created'));
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
        $techRefsGu = TechRefsGu::find($id);
        $cdng = TechRefsCdng::get();
        return view('tech_refs.gu.edit',compact('techRefsGu', 'cdng'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $techRefsGu=TechRefsGu::find($id);
        $request->validate([
            'name' => 'required',
            'cdng_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $techRefsGu->update($dataArray);

        return redirect()->route('techrefsgu.index')->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $techRefsGu = TechRefsGu::find($id);
        $techRefsGu->delete();

        return redirect()->route('techrefsgu.index')->with('success',__('app.deleted'));
        //
    }

}
