<?php


namespace App\Http\Controllers\Refs;


use App\EcoRefsScenario;
use App\Http\Controllers\Controller;
use App\Http\Requests\EcoRefs\Scenario\StoreEcoRefsScenarioRequest;
use Illuminate\View\View;

class EcoRefsScenarioController extends Controller
{
    public function index(): View
    {
        return view('eco_refs_scenario.index');
    }

    public function store(StoreEcoRefsScenarioRequest $request): EcoRefsScenario
    {
        $scenario = EcoRefsScenario::create($request->validated());

        $scenario->load('scFa');

        return $scenario;
    }

    public function destroy(int $id): int
    {
        return (int)EcoRefsScenario::query()->whereId($id)->delete();
    }

    public function getData(): array
    {
        $data = EcoRefsScenario::query()
            ->with('scFa')
            ->latest('id')
            ->get();

        $response = [];

        /** @var EcoRefsScenario $item */
        foreach ($data as $item) {
            $response[] = [
                $item->id,
                $item->name,
                $item->scFa->name ?? '',
                $item->params['oil_prices'],
                $item->params['course_prices'],
                $item->params['optimizations'],
                $item->created_at
            ];
        }

        return [
            'data' => $response
        ];
    }
}