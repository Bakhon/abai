<?php

namespace App\Http\Controllers\GTM\EcoRefs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Paegtm\EcoRefs\GtmDeclineRateCreateRequest;
use App\Http\Requests\Paegtm\EcoRefs\GtmDeclineRateUpdateRequest;
use App\Models\BigData\Dictionaries\Org;
use App\Models\Paegtm\EcoRefs\GtmDeclineRates;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GtmDeclineRateController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $declineRates = GtmDeclineRates::simplePaginate(20);

        return view('gtm.EcoRefs.GtmDeclineRate.index', compact('declineRates'));
    }

    /**
     * @return View
     */
    public function create()
    {
        $orgs = Org::whereNull('parent')->orderBy('id')->get();
        $geos = $orgs;

        return view('gtm.EcoRefs.GtmDeclineRate.create', compact('orgs', 'geos'));
    }

    /**
     * @param GtmDeclineRateCreateRequest $request
     * @return RedirectResponse
     */
    public function store(GtmDeclineRateCreateRequest $request)
    {
        $validated = $request->validated();

        $org = Org::find($validated['org_id']);

        if ($org) {
            $validated['org_name'] = $org->name_ru;
            $validated['org_name_short'] = $org->name_short_ru;
        }

        $validated['date'] = Carbon::create($validated['date'], 1, 1);

        GtmDeclineRates::create($validated);

        return redirect()->route('gtm-decline-rates.index')->with('success',__('app.created'));
    }

    /**
     * @param GtmDeclineRates $declineRate
     * @return View
     */
    public function edit(GtmDeclineRates $gtmDeclineRate)
    {
        $orgs = Org::whereNull('parent')->orderBy('id')->get();
        $geos = $orgs;

        return view('gtm.EcoRefs.GtmDeclineRate.edit', compact('gtmDeclineRate', 'orgs', 'geos'));
    }

    /**
     * @param GtmDeclineRateUpdateRequest $request
     * @param GtmDeclineRates $declineRate
     * @return RedirectResponse
     */
    public function update(GtmDeclineRateUpdateRequest $request, GtmDeclineRates $gtmDeclineRate)

    {
        $validated = $request->validated();

        $validated['date'] = Carbon::create($validated['date'], 1, 1);

        $gtmDeclineRate->update($validated);

        return redirect()->route('gtm-decline-rates.index')->with('success',__('app.updated'));
    }

    /**
     * @param GtmDeclineRates $declineRate
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(GtmDeclineRates $gtmDeclineRate)
    {
        $gtmDeclineRate->delete();

        return redirect()->route('gtm-decline-rates.index')->with('success',__('app.deleted'));
    }
}
