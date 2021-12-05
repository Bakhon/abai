<?php


namespace App\Http\Controllers\Economic;


use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Scenario\EconomicScenarioDataRequest;
use App\Http\Requests\Economic\Scenario\EconomicScenarioStoreRequest;
use App\Models\Refs\EcoRefsScenario;
use App\Models\Refs\EcoRefsScFa;
use Illuminate\Support\Facades\DB;

class EconomicScenarioController extends Controller
{
    public function store(EconomicScenarioStoreRequest $request): EcoRefsScenario
    {
        EcoRefsScFa::query()
            ->where([
                'id' => $request->sc_fa_id,
                'is_forecast' => true
            ])
            ->firstOrFail();

        $scenario = new EcoRefsScenario($request->validated());

        $scenario->user_id = auth()->id();

        $scenario->save();

        return $scenario;
    }

    public function destroy(int $id): int
    {
        return DB::transaction(function () use ($id) {
            $scenario = EcoRefsScenario::query()
                ->whereId($id)
                ->lockForUpdate()
                ->firstOrFail();

            $scenario->results()->delete();

            return (int)$scenario->delete();
        });
    }

    public function getData(EconomicScenarioDataRequest $request): array
    {
        $query = EcoRefsScenario::query();

        if ($request->sc_fa_id) {
            $query->whereScFaId($request->sc_fa_id);
        }

        if ($request->source_id) {
            $query->whereSourceId($request->source_id);
        }

        if ($request->gtm_kit_id) {
            $query->whereGtmKitId($request->gtm_kit_id);
        }

        return EcoRefsScenario::query()
            ->with(['scFa', 'source', 'gtmKit', 'user'])
            ->latest('id')
            ->get()
            ->toArray();
    }
}