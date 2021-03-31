<?php

namespace App\Http\Controllers\Refs;


use App\Http\Controllers\Controller;
use App\Models\EcoRefsCost;
use App\Models\Refs\EconomicDataLog;
use Illuminate\Http\RedirectResponse;

class EconomicDataLogController extends Controller
{
    protected $index_route = "economic_data_log.index";

    public function index()
    {
        $economicDataLog = EconomicDataLog::latest()->paginate(5);
        return view('ecorefscost.log.index',compact('economicDataLog'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $economicRefsCost = EcoRefsCost::where('log_id', '=', $id);
        $economicRefsCost->delete();

        $economicDataLog = EconomicDataLog::find($id);
        $economicDataLog->delete();

        return redirect()->route($this->index_route)->with('success',__('app.deleted'));
    }
}
