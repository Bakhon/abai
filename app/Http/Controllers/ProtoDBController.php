<?php

namespace App\Http\Controllers;

use App\Exports\ProtoDBExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Level23\Druid\DruidClient;
use Level23\Druid\Types\Granularity;
use Maatwebsite\Excel\Facades\Excel;

class ProtoDBController extends Controller
{
    public function getProtoOtchet1(Request $request)
    {
        $client = new DruidClient(['router_url' => 'http://cent7-bigdata.kmg.kz:8888']);

        $builder = $client->query('month_meter_prod_oil_v03', Granularity::MONTH);

        if ($request->has('org') && $request->has('start_date') && $request->has('end_date')) {
            $dateInterval = '' . $request->start_date . 'T00:00:00+00:00/' . $request->end_date . 'T00:00:00+00:00';

            $builder
                ->interval($dateInterval)
                ->select('month')
                ->select('year')
                ->select('field')
                ->select('ngdu')
                ->select('cndg')
                ->select('gu')
                ->select('tap')
                ->select('zu')
                ->select('uwi')
                ->select('drill_year')
                ->select('grzs')
                ->select('block2')
                ->select('perf_intr')
                ->select('tm_liquid')
                ->select('tm_bsw')
                ->select('tm_oil')
                ->sum('liq_avg')
                ->sum('oil_avg')
                ->sum('bsw_avg')
                ->select('gdis_date')
                ->select('gdis_conclusion')
                ->select('gdis_hdyn')
                ->select('gdis_pzatr')
                ->select('gdis_pzab')
                ->select('gdis_pbuf')
                ->select('gdis_pmaxload')
                ->select('work_day')
                ->sum("oil")
                ->sum("liquid_val")
                ->select('bsws')
                ->select('repairs_text')
                ->select('prs_count')
                ->sum('liq_cumm_avg')
                ->sum("oil_cumm_avg")
                ->sum("bsw_cumm_avg")
                ->select("work_day_cumm")
                ->sum("oil_cumm")
                ->sum("liq_cumm")
                ->select('dzo')
                ->where('dzo_short', '=', $request->org)
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc');
        } else {
            $builder
                ->interval('2014-01-01T00:00:00+00:00/2020-10-31T00:00:00+00:00')
                ->select('uwi')
                ->sum("oil");
        }

        $result = $builder->groupBy();
        $array = $result->data();
        $monthCount = Carbon::parse($request->start_date)->diffInMonths($request->end_date) + 1;
        $monthsList = [];
        $newData = [];

        foreach ($array as $item) {
            $date = Carbon::parse($request->start_date);
            $currentMonthKey = $item['year'] . '-' . $item['month'];

            if (empty($newData[$item['uwi']])) {
                $newData[$item['uwi']] = [];
            }

            if (!count($newData[$item['uwi']])) {
                for ($i = 0; $i < $monthCount; $i++) {
                    $currentDate = $date->format('Y') . '-' . (int) $date->format('m');
                    $monthsList[$currentDate] = $this->getMonth((int) $date->format('m')).' '.$date->format('Y');
                    $newData[$item['uwi']]['months'][$currentDate] = [];
                    $date = $date->addMonth();
                }
            }

            $newData[$item['uwi']]['field'] = $item['field'];
            $newData[$item['uwi']]['ngdu'] = $item['ngdu'];
            $newData[$item['uwi']]['cndg'] = $item['cndg'];
            $newData[$item['uwi']]['gu'] = $item['gu'];
            $newData[$item['uwi']]['tap'] = $item['tap'];
            $newData[$item['uwi']]['zu'] = $item['zu'];
            $newData[$item['uwi']]['uwi'] = $item['uwi'];
            $newData[$item['uwi']]['drill_year'] = date("m.Y", strtotime($item['drill_year']));
            $newData[$item['uwi']]['grzs'] = $item['grzs'];
            $newData[$item['uwi']]['block2'] = $item['block2'];
            $newData[$item['uwi']]['perf_intr'] = $item['perf_intr'];
            $newData[$item['uwi']]['months'][$currentMonthKey] = $item;
            $newData[$item['uwi']]['months'][$currentMonthKey]['drill_year'] = date("m.Y", strtotime($item['drill_year']));
            $newData[$item['uwi']]['months'][$currentMonthKey]['gdis_date'] = date("d.m.Y", strtotime($item['gdis_date']));

            $newData[$item['uwi']]['liq_cumm_avg'] = $monthCount === 1
                ? $newData[$item['uwi']]['months'][$currentMonthKey]['liq_cumm_avg'] : 0;

            $newData[$item['uwi']]['oil_cumm_avg'] = $monthCount === 1
                ? $newData[$item['uwi']]['months'][$currentMonthKey]['oil_cumm_avg'] : 0;

            $newData[$item['uwi']]['bsw_cumm_avg'] = $monthCount === 1
                ? $newData[$item['uwi']]['months'][$currentMonthKey]['bsw_cumm_avg'] : 0;

            $newData[$item['uwi']]['work_day_cumm'] = $monthCount === 1
                ? $newData[$item['uwi']]['months'][$currentMonthKey]['work_day_cumm'] : 0;

            $newData[$item['uwi']]['oil_cumm'] = $monthCount === 1
                ? $newData[$item['uwi']]['months'][$currentMonthKey]['oil_cumm'] : 0;

            $newData[$item['uwi']]['liq_cumm'] = $monthCount === 1
                ? $newData[$item['uwi']]['months'][$currentMonthKey]['liq_cumm'] : 0;

            if ($monthCount > 1) {
                foreach ($newData[$item['uwi']]['months'] as $monthKey => $month) {
                    if (!empty($month['month'])) {
                        $newData[$item['uwi']]['months'][$monthKey]['human_date'] =
                            $this->getMonth($month['month']) . ' ' . $month['year'];
                    }

                    if (!empty($month['liquid_val'])) {
                        $newData[$item['uwi']]['liq_cumm'] += (int) $month['liquid_val'];
                    }

                    if (!empty($month['oil'])) {
                        $newData[$item['uwi']]['oil_cumm'] += (int) $month['oil'];
                    }

                    if (!empty($month['work_day'])) {
                        $newData[$item['uwi']]['work_day_cumm'] += (int) $month['work_day'];
                    }

                    $newData[$item['uwi']]['bsw_cumm_avg'] = $newData[$item['uwi']]['liq_cumm'] ?
                        (int) ((1 - $newData[$item['uwi']]['oil_cumm'] / $newData[$item['uwi']]['liq_cumm']) * 100) : 100;

                    if (!empty($newData[$item['uwi']]['work_day_cumm'])) {
                        $newData[$item['uwi']]['oil_cumm_avg'] =
                            number_format((float) ($newData[$item['uwi']]['oil_cumm'] / $newData[$item['uwi']]['work_day_cumm']), 1);

                        $newData[$item['uwi']]['liq_cumm_avg'] =
                            number_format((float) ($newData[$item['uwi']]['liq_cumm'] / $newData[$item['uwi']]['work_day_cumm']), 1);
                    }
                }
            }
        }

        $data = [
            'list' => $newData,
            'months_count' => $monthCount,
            'months_list' => $monthsList
        ];

        return Excel::download(new ProtoDBExport($data), 'tableExport.xls');
    }

    public function getMonth($month)
    {
        $months = [
            '1' => 'Январь',
            '2' => 'Февраль',
            '3' => 'Март',
            '4' => 'Апрель',
            '5' => 'Май',
            '6' => 'Июнь',
            '7' => 'Июль',
            '8' => 'Август',
            '9' => 'Сентябрь',
            '10' => 'Октябрь',
            '11' => 'Ноябрь',
            '12' => 'Декабрь',
        ];

        return $months[$month];
    }
}