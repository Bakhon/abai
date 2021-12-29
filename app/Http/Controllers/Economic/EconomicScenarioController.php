<?php


namespace App\Http\Controllers\Economic;


use App\Http\Controllers\Controller;
use App\Http\Requests\Economic\Scenario\EconomicScenarioDataRequest;
use App\Http\Requests\Economic\Scenario\EconomicScenarioStoreRequest;
use App\Jobs\Economic\Scenario\EconomicScenarioJob;
use App\Models\Refs\EcoRefsManufacturingProgram;
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

        if ($request->manufacturing_program_log_id) {
            EcoRefsManufacturingProgram::query()
                ->where([
                    'log_id' => $request->manufacturing_program_log_id
                ])
                ->firstOrFail();
        }

        $scenario = new EcoRefsScenario($request->validated());

        $scenario->user_id = auth()->id();

        $scenario->calculated_variants = 0;

        $scenario->total_variants = EconomicScenarioJob::NUMBER_OF_STOPS *
            count($scenario->params['oil_prices']) *
            count($scenario->params['dollar_rates']) *
            count($scenario->params['cost_wr_payrolls']) *
            count($scenario->params['fixed_nopayrolls']);

        $scenario->save();

        foreach ($scenario->params['oil_prices'] as $oilPrice) {
            foreach ($scenario->params['dollar_rates'] as $dollarRate) {
                dispatch(new EconomicScenarioJob(
                    $scenario->id,
                    $oilPrice['value'],
                    $dollarRate['value'],
                ));
            }
        }

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

        if ($request->is_processed) {
            $query->whereRaw(DB::raw("
                total_variants IS NOT NULL AND total_variants = calculated_variants
            "));
        }

        return $query
            ->with(['scFa', 'source', 'gtmKit', 'user', 'manufacturingLog'])
            ->latest('id')
            ->get()
            ->toArray();
    }
}