<?php

namespace App\Http\Controllers;

use App\Models\DZO\DZOcalc;
use App\Models\UsdRate;
use Illuminate\Http\Request;

class VisualCenterController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getDZOcalcs(Request $request)
    {
        $dateStart = $request->get('dateStart');
        $dateEnd = $request->get('dateEnd');
        $dzo = $request->get('dzo');
        if (!$dateEnd) {
            $dateEnd = new \DateTime($dateStart);
            $dateStart = clone $dateEnd;
            $dateStart->sub(new \DateInterval('P3M'));
            $dateStart = $dateStart->format('Y-m-d H:i:s');
            $dateEnd = $dateEnd->format('Y-m-d H:i:s');
        }
        $dateTimeStart = new \DateTime($dateStart);
        $dateTimeEnd = new \DateTime($dateEnd);
        $dzoDataActual = DZOcalc::query()
            ->where('date', '>=', $dateTimeStart->format('Y-m-d H:i:s'))
            ->where('date', '<', $dateTimeEnd->format('Y-m-d H:i:s'));
        if ($dzo) {
            $dzoDataActual->where('dzo', '=', $dzo);
        }
        $dzoDataActual = $dzoDataActual->get();

        $dateTimeStart->sub(new \DateInterval('P1Y'));
        $dateTimeEnd->sub(new \DateInterval('P1Y'));
        $dzoDataPrevYear = DZOcalc::query()
            ->where('date', '>=', $dateTimeStart->format('Y-m-d H:i:s'))
            ->where('date', '<', $dateTimeEnd->format('Y-m-d H:i:s'));
        if ($dzo) {
            $dzoDataPrevYear->where('dzo', '=', $dzo);
        }
        $dzoDataPrevYear = $dzoDataPrevYear->get();

        return response()->json(['dzoDataActual' => $dzoDataActual, 'dzoDataPrevYear' => $dzoDataPrevYear]);
    }

    public function getDZOCalcsActualMonth()
    {
        $maxDate = DZOcalc::query()->max('date');
        $tmpDate = \DateTime::createFromFormat('Y-m-d H:i:s', $maxDate);
        return $tmpDate->format('m');
    }

//INSERT INTO dashboard.usd_rate (id, value, date, `change`, `index`, created_at, updated_at) VALUES

    public function getUsdRates()
    {
        $data = UsdRate::query()
            ->get()
            ->toArray();

        return response()->json($data);
    }

    public function getCurrency(Request $request)
    {
        $url = "https://www.nationalbank.kz/rss/get_rates.cfm?fdate=" . $request->fdate;
        $dataObj = simplexml_load_file($url);
        if ($dataObj) {
            foreach ($dataObj as $item) {
                if ($item->title == 'USD') {
                    return response()->json($item);
                }
            }
        }
    }

    function getCurrencyPeriod(Request $request)
    {
        $datesNow = $request->dates;
        $period = $request->period;
        $datesNowString = strtotime($datesNow);
        $last = strtotime($datesNow . '-' . $period . 'day');
        //$last = strtotime($datesNow . '- 1 month');
        $countDay = ($datesNowString - $last) / 86400;

        for (
            $i = 1;
            $i <= $countDay;
            $i++
        ) {
            $last = $last + 86400;
            $dates = date('d.m.Y', $last);
            $url = "https://www.nationalbank.kz/rss/get_rates.cfm?fdate=" . $dates;
            $dataObj = simplexml_load_file($url);
            if ($dataObj) {
                foreach ($dataObj as $item) {
                    if ($item->title == 'USD') {
                        $description = $item->description;
                        $array[$i] =  array(
                            "dates" => $dates,
                            "description" => $description,
                            "change" => $item->change,
                            "index" => $item->index,
                        );
                    }
                }
            }
        }

        return response()->json($array);
    }

}