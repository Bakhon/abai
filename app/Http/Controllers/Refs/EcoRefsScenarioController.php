<?php


namespace App\Http\Controllers\Refs;


use App\EcoRefsScenario;
use App\Http\Controllers\Controller;
use App\Http\Requests\EcoRefs\Scenario\StoreEcoRefsScenarioRequest;
use App\Http\Resources\EcoRefsScenarioResource;
use Illuminate\View\View;

class EcoRefsScenarioController extends Controller
{
    public function index(): View
    {
        return view('eco_refs_scenario.index');
    }

    public function store(StoreEcoRefsScenarioRequest $request): EcoRefsScenarioResource
    {
        $scenario = EcoRefsScenario::create($request->validated());

        $scenario->load('scFa');

        return EcoRefsScenarioResource::make($scenario);
    }

    public function destroy(int $id): int
    {
        return (int)EcoRefsScenario::query()
            ->whereId($id)
            ->delete();
    }

    public function getData(): array
    {
        $data = EcoRefsScenario::query()
            ->with('scFa')
            ->oldest('id')
            ->get();

        return [
            'data' => EcoRefsScenarioResource::collection($data)
        ];
    }
}