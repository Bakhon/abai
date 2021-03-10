<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\TechRefsCompany;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TechRefsCompanyController extends Controller
{

    public function index(): View
    {
        $techRefsCompany = TechRefsCompany::latest()->paginate(12);

        return view('tech_refs.company.index',compact('techRefsCompany'));
    }

    public function create(): View
    {
        return view('tech_refs.company.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'short_name' => 'nullable|string',
            'tbd_id' => 'nullable|numeric',
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        TechRefsCompany::create($dataArray);

        return redirect()->route('techrefscompany.index')->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $techRefsCompany = TechRefsCompany::find($id);
        return view('tech_refs.company.edit',compact('techRefsCompany'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $techRefsCompany=TechRefsCompany::find($id);
        $request->validate([
            'name' => 'required',
            'short_name' => 'nullable|string',
            'tbd_id' => 'nullable|numeric',
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $techRefsCompany->update($dataArray);

        return redirect()->route('techrefscompany.index')->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $techRefsCompany = TechRefsCompany::find($id);
        $techRefsCompany->delete();

        return redirect()->route('techrefscompany.index')->with('success',__('app.deleted'));
    }

}
