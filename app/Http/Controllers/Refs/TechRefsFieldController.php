<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\TechRefsCompany;
use App\Models\Refs\TechRefsField;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TechRefsFieldController extends Controller
{

    public function index(): View
    {
        $techRefsField = TechRefsField::latest()->paginate(5);

        return view('tech_refs.field.index',compact('techRefsField'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        $company = TechRefsCompany::get();
        return view('tech_refs.field.create',compact('company'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'company_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        TechRefsField::create($dataArray);

        return redirect()->route('techrefsfield.index')->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $techRefsField = TechRefsField::find($id);
        $company = TechRefsCompany::get();
        return view('tech_refs.field.edit',compact('techRefsField', 'company'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $techRefsField=TechRefsField::find($id);
        $request->validate([
            'name' => 'required',
            'company_id' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $techRefsField->update($dataArray);

        return redirect()->route('techrefsfield.index')->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $techRefsField = TechRefsField::find($id);
        $techRefsField->delete();

        return redirect()->route('techrefsfield.index')->with('success',__('app.deleted'));
    }

}
