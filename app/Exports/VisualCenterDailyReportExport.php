<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;

class VisualCenterDailyReportExport implements FromView
{
    private $dailyParams = array();
    private $monthlyParams = array();
    private $yearlyParams = array();
    private $monthMapping = array(
        1 => 'Январь',
        2 => 'Февраль',
        3 => 'Март',
        4 => 'Апрель',
        5 => 'Май',
        6 => 'Июнь',
        7 => 'Июль',
        8 => 'Август',
        9 => 'Сентябрь',
        10 => 'Октябрь',
        11 => 'Ноябрь',
        12 => 'Декабрь'
    );

    function __construct($dailyParams,$monthlyParams,$yearlyParams)
    {
        $this->dailyParams = $this->getDecoded($dailyParams);
        $this->monthlyParams = $this->getDecoded($monthlyParams);
        $this->yearlyParams = $this->getDecoded($yearlyParams);
    }

    private function getDecoded($data)
    {
        $decoded = array();
        foreach($data as $string) {
            array_push($decoded,json_decode($string,true));
        }
        return $decoded;
    }

    public function view(): View
    {
        return view('visualcenter.daily_report_export', [
            'daily' => $this->dailyParams,
            'monthly' => $this->monthlyParams,
            'yearly' => $this->yearlyParams,
            'date' => Carbon::now()->format('d.m.Y'),
            'monthName' => $this->monthMapping[Carbon::now()->month],
            'monthId' => Carbon::now()->month-1,
            'yearId' => Carbon::now()->year
        ]);
    }
}
