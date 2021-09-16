<?php


namespace App\Http\Controllers\Economic;


use App\EcoRefsScenario;
use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Scenario\EconomicScenarioStoreRequest;
use App\Http\Resources\EcoRefsScenarioResource;
use Illuminate\View\View;

class EconomicScenarioController extends Controller
{
    public function index(): View
    {
        return view('economic.scenario.index');
    }

    public function store(EconomicScenarioStoreRequest $request): EcoRefsScenarioResource
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