<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\TechRefsField;
use App\Models\Refs\TechRefsNgdu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TechRefsNgduController extends Controller
{

    public function index(): View
    {
        $techRefsNgdu = TechRefsNgdu::latest()->paginate(12);

        return view('tech_refs.ngdu.index',compact('techRefsNgdu'));
    }

    public function create(): View
    {
        $field = TechRefsField::get();
        return view('tech_refs.ngdu.create',compact('field'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'field_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        TechRefsNgdu::create($dataArray);

        return redirect()->route('techrefsngdu.index')->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $techRefsNgdu = TechRefsNgdu::find($id);
        $field = TechRefsField::get();
        return view('tech_refs.ngdu.edit',compact('techRefsNgdu', 'field'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $techRefsNgdu=TechRefsNgdu::find($id);
        $request->validate([
            'name' => 'required',
            'field_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $techRefsNgdu->update($dataArray);

        return redirect()->route('techrefsngdu.index')->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $techRefsNgdu = TechRefsNgdu::find($id);
        $techRefsNgdu->delete();

        return redirect()->route('techrefsngdu.index')->with('success',__('app.deleted'));
    }

}
