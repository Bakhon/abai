<?php


namespace App\Http\Controllers\Refs;


use App\EcoRefsScenario;
use App\Http\Controllers\Controller;
use App\Http\Requests\EcoRefs\Scenario\StoreEcoRefsScenarioRequest;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class EcoRefsScenarioController extends Controller
{
    public function index(): View
    {
        return view('eco_refs_scenario.index');
    }

    public function store(StoreEcoRefsScenarioRequest $request): EcoRefsScenario
    {
        return EcoRefsScenario::create($request->validated());
    }

    public function destroy(int $id): int
    {
        return (int)EcoRefsScenario::query()->whereId($id)->delete();
    }

    public function getData(): Collection
    {
        return EcoRefsScenario::query()->with('sc_fa')->get();
    }
}