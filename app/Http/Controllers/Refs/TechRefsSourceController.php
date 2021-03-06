<?php

namespace App\Http\Controllers\Refs;

use App\Http\Controllers\Controller;
use App\Models\Refs\TechRefsSource;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class TechRefsSourceController extends Controller
{

    public function index(): View
    {
        $techRefsSource = TechRefsSource::latest()->paginate(5);

        return view('tech_refs.source.index',compact('techRefsSource'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        return view('tech_refs.source.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        TechRefsSource::create($dataArray);

        return redirect()->route('techrefssource.index')->with('success',__('app.created'));
    }

    public function edit(int $id): View
    {
        $techRefsSource = TechRefsSource::find($id);
        return view('tech_refs.source.edit',compact('techRefsSource'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $techRefsSource=TechRefsSource::find($id);
        $request->validate([
            'name' => 'required'
        ]);

        $dataArray = $request->all();
        $dataArray['user_id'] = auth()->user()->id;
        $techRefsSource->update($dataArray);

        return redirect()->route('techrefssource.index')->with('success',__('app.updated'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $techRefsSource = TechRefsSource::find($id);
        $techRefsSource->delete();

        return redirect()->route('techrefssource.index')->with('success',__('app.deleted'));
        //
    }

}
