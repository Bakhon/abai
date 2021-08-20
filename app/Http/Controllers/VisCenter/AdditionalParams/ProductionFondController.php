<?php

namespace App\Http\Controllers\VisCenter\AdditionalParams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisCenter\ExcelForm\DzoImportData;
use App\Models\VisCenter\ExcelForm\DzoImportDowntimeReason;
use Carbon\Carbon;

class ProductionFondController extends Controller
{
    protected $formatted = array(
        'all' => array(),
        'ОМГ' => array(),
        'ММГ' => array(),
        'КГМ' => array(),
        'КОА' => array(),
        'КТМ' => array(),
        'КБМ' => array(),
        'ЭМГ' => array(),
    );
    public function getFactForChartByDay(Request $request)
    {
        $importData = DzoImportData::query()
             ->whereDate('date', '>=', Carbon::parse($request->startPeriod))
             ->whereDate('date', '<=', Carbon::parse($request->endPeriod))
             ->whereNull('is_corrected')
             ->orderBy('date', 'desc')
             ->with('importDowntimeReason')
             ->get()
             ->toArray();
        $result = $this->getMergedWithDowntimeReasons($importData);
        $formatted = $this->getSplittedByDzo($result,$request->workFields,$request->idleFields);

        return $formatted;
    }

    private function getMergedWithDowntimeReasons($input)
    {
        $result = array();
        foreach($input as $item) {
            if (!is_null($item['import_downtime_reason'])) {
                $merged = array_merge($item, $item['import_downtime_reason']);
                unset($merged['import_downtime_reason']);
                array_push($result,$merged);
            } else {
                array_push($result,$item);
            }
        }
        return $result;
    }

    private function getSplittedByDzo($input,$workFields,$idleFields)
    {
        $result = array();
        foreach($this->formatted as $dzoName => $dzo) {
            if ($dzoName === 'all') {
                $result[$dzoName] = array();
                $result[$dzoName]['work'] = $this->getDailySumByType($input,$workFields);
                $result[$dzoName]['idle'] = $this->getDailySumByType($input,$idleFields);
            } else {
                $result[$dzoName] = array();
                $filtered = array_filter($input, function ($var) use ($dzoName) {
                   return ($var['dzo_name'] === $dzoName);
                });
                $result[$dzoName]['work'] = $this->getDailySumByType($filtered,$workFields);
                $result[$dzoName]['idle'] = $this->getDailySumByType($filtered,$idleFields);
            }
        }
        return $result;
    }

    private function getDailySumByType($input,$fieldsType)
    {
        $result = array();
        foreach($fieldsType as $fieldName) {
            $result[$fieldName] = array_sum(array_column($input,$fieldName));
        }
        return $result;
    }
}
