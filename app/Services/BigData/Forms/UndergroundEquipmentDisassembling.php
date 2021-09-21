<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Facades\DB;

class UndergroundEquipmentDisassembling extends PlainForm
{
    protected $configurationFileName = 'underground_equipment_disassembling';

    protected function submitForm(): array
    {
        if (!$this->request->get('id') || !$this->request->get('date')) {
            throw new \Exception('Нет даты или id');
        }

        DB::connection('tbd')
            ->table($this->params()['table'])
            ->where('id', $this->request->get('id'))
            ->update(
                [
                    'dend' => $this->request->get('date')
                ]
            );

        return [];
    }
}