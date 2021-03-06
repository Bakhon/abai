<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\TechRefsNgdu;
use App\Models\Refs\TechRefsCdng;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TechRefsCdngController extends Controller
{

    public function index(): View
    {
        $techRefsCdng = TechRefsCdng::latest()->paginate(5);

        return view('tech_refs.cdng.index',compact('techRefsCdng'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        $ngdu = TechRefsNgdu::get();
        return view('tech_refs.cdng.create',compact('ngdu'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'ngdu_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        TechRefsCdng::create($dataArray);

        return redirect()->route('techrefscdng.index')->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $techRefsCdng = TechRefsCdng::find($id);
        $ngdu = TechRefsNgdu::get();
        return view('tech_refs.cdng.edit',compact('techRefsCdng', 'ngdu'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $techRefsCdng=TechRefsCdng::find($id);
        $request->validate([
            'name' => 'required',
            'ngdu_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $techRefsCdng->update($dataArray);

        return redirect()->route('techrefscdng.index')->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $techRefsCdng = TechRefsCdng::find($id);
        $techRefsCdng->delete();

        return redirect()->route('techrefscdng.index')->with('success',__('app.deleted'));
    }

}
