<?php

namespace App\Http\Resources\VisualCenter\Dzo;

class Factory {
    protected $dzoClassMapping = array (
        'АГ' => 'Ag',
        'КБМ' => 'Kbm',
        'КГМ' => 'Kgm',
        'КОА' => 'Koa',
        'КПО' => 'Kpo',
        'ММГ' => 'Mmg',
        'НКО' => 'Nko',
        'ОМГ' => 'Omg',
        'ПКИ' => 'Pki',
        'ПККР' => 'Pkkr',
        'ТП' => 'Tp',
        'ТШО' => 'Tsho',
        'УО' => 'Yo',
        'ЭМГ' => 'Emg',
        'КТМ' => 'Ktm',
        'ПКК' => 'Pkk',
        'ОМГК' => 'Omgk',
        'КГМКМГ' => 'Kgmkmg'
    );
    protected $categoryMapping = array (
        'oilCondensateProduction' => 'OilCondensateConsolidated',
        'oilCondensateDelivery' => 'OilCondensateConsolidated',
        'oilCondensateProductionWithoutKMG' => 'OilCondensateConsolidatedWithoutKmg',
        'oilCondensateDeliveryWithoutKMG' => 'OilCondensateConsolidatedWithoutKmg',
        'oilCondensateDeliveryOilResidue' => 'OilCondensateConsolidatedOilResidue',
        'gasProduction' => 'GasProduction',
        'naturalGasProduction' => 'GasProduction',
        'associatedGasProduction' => 'GasProduction',
        'associatedGasFlaring' => 'GasProduction',
        'naturalGasDelivery' => 'GasProduction',
        'expensesForOwnNaturalGas' => 'GasProduction',
        'associatedGasDelivery' => 'GasProduction',
        'expensesForOwnAssociatedGas' => 'GasProduction',
        'waterInjection' => 'WaterInjection',
        'seaWaterInjection' => 'WaterInjection',
        'wasteWaterInjection' => 'WaterInjection',
        'artezianWaterInjection' => 'WaterInjection',
        'streamWaterInjection' => 'WaterInjection'
    );

    public function make($dzoName)
    {
        $name = "\App\Http\Resources\VisualCenter\Dzo\\" . $this->dzoClassMapping[$dzoName];
        return new $name();
    }

    public function makeCategory($categoryName)
    {
        $name = "\App\Http\Resources\VisualCenter\\" . $this->categoryMapping[$categoryName];
        return new $name();
    }

}