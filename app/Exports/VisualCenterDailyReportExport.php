<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisualCenterDailyReportExport implements FromView
{
    private $productionCategory;
    private $formattedCategory = array();
    private $skippingDzo = array ('ПККР','КГМКМГ','ТП');
    private $dzoMapping = array (
        'ТШО' => array (
            'id' => 1,
            'sortId' => 1,
            'name' => 'ТОО "Тенгизшевройл"',
            'part' => '20%'
        ),
        'ОМГ' => array (
            'id' => 2,
            'sortId' => 2,
            'name' => 'АО "Озенмунайгаз" (нефть)',
            'part' => '100%'
        ),
        'ОМГК' => array (
            'id' => '',
            'sortId' => 3,
            'name' => '(конденсат)',
            'part' => null
        ),
        'ММГ' => array (
            'id' => 3,
            'sortId' => 4,
            'name' => 'АО "Мангистаумунайгаз"',
            'part' => '50%'
        ),
        'ЭМГ' => array (
            'id' => 4,
            'sortId' => 5,
            'name' => 'АО "Эмбамунайгаз"',
            'part' => '100%'
        ),
        'НКО' => array (
            'id' => 5,
            'sortId' => 6,
            'name' => '"Норт Каспиан Оперейтинг Компани н.в."',
            'part' => '8,44%'
        ),
        'КПО' => array (
            'id' => 6,
            'sortId' => 7,
            'name' => '"Карачаганак Петролеум Оперейтинг б.в."',
            'part' => '10%'
        ),
        'КБМ' => array (
            'id' => 7,
            'sortId' => 8,
            'name' => 'АО "Каражанбасмунай"',
            'part' => '50%'
        ),
        'КГМ' => array (
            'id' => 8,
            'sortId' => 9,
            'name' => 'ТОО "СП "Казгермунай"',
            'part' => '50%'
        ),
        'ПКИ' => array (
            'id' => 9,
            'sortId' => 10,
            'name' => 'АО "ПетроКазахстан Инк"',
            'part' => '33%'
        ),
        'КТМ' => array (
            'id' => 10,
            'sortId' => 11,
            'name' => 'ТОО "Казахтуркмунай"',
            'part' => '100%'
        ),
        'КОА' => array (
            'id' => 11,
            'sortId' => 12,
            'name' => 'ТОО "Казахойл Актобе"',
            'part' => '50%'
        ),
        'УО' => array (
            'id' => 12,
            'sortId' => 13,
            'name' => 'ТОО "Урихтау Оперейтинг"',
            'part' => '100%'
        ),
        'АГ' => array (
            'id' => 13,
            'sortId' => 14,
            'name' => 'ТОО "Амангельды Газ" (конденсат)',
            'part' => '100%'
        ),
    );

    function __construct($params)
    {
        $allCategories = app()->call('App\Http\Controllers\VisCenter\ProductionParams\VisualCenterController@getProductionParamsByCategory',$params);
        $this->productionCategory = $allCategories['tableData']['current']['oilCondensateProduction'];

        foreach($this->productionCategory as  $dzo) {
            if (!in_array($dzo['name'],$this->skippingDzo)) {
                $dzoDetails = array (
                    'id' => $this->dzoMapping[$dzo['name']]['id'],
                    'orderId' => $this->dzoMapping[$dzo['name']]['sortId'],
                    'name' => $this->dzoMapping[$dzo['name']]['name'],
                    'part' => $this->dzoMapping[$dzo['name']]['part'],
                    'plan' => $dzo['plan'],
                    'fact' => $dzo['fact'],
                    'reasons' => array()
                );
                if ($dzo['name'] !== 'ОМГК') {
                    $dzoDetails['reasons'] = $dzo['decreaseReasonExplanations'];
                }
                array_push($this->formattedCategory,$dzoDetails);
            }
        }

        $sortOrder = array_column($this->formattedCategory, 'orderId');
        array_multisort($sortOrder, SORT_ASC, $this->formattedCategory);
    }

    public function view(): View
    {
        return view('visualcenter.daily_report_export', [
            'daily' => $this->formattedCategory,
            'date' => Carbon::now()->format('d.m.Y')
        ]);
    }
}
