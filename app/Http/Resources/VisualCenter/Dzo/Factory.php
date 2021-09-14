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
        'КТМ' => 'Ktm'
    );

    public function make($dzoName)
    {
        $name = "\App\Http\Resources\VisualCenter\Dzo\\" . $this->dzoClassMapping[$dzoName];
        return new $name();
    }

}