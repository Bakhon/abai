<?php

namespace App\Http\Controllers\Refs;


use App\Models\Refs\TechnicalDataForecast;
use App\Models\Refs\TechnicalDataLog;
use Illuminate\Http\RedirectResponse;

class TechnicalDataLogController extends TechnicalStructureController
{
    protected $model = TechnicalDataLog::class;

    protected $controller_name = 'log';
    protected $index_route = "tech_data_log.index";

    public function destroy(int $id): RedirectResponse
    {
        $technicalDataForecast = TechnicalDataForecast::where('log_id', '=', $id);
        $technicalDataForecast->delete();

        $technicalDataLog = TechnicalDataLog::find($id);
        $technicalDataLog->delete();

        return redirect()->route($this->index_route)->with('success',__('app.deleted'));
    }
}
