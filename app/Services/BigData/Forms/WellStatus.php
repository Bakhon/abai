<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use App\Models\BigData\Well;
use Illuminate\Support\Facades\DB;

class WellStatus extends PlainForm
{
    protected $configurationFileName = 'well_status';


    private function isValidDate($wellId, $dbeg):bool
    {
        $dend = DB::connection('tbd')
            ->table('prod.well_status')
            ->where('well', $wellId)
            ->where('dend', '<', Well::DEFAULT_END_DATE)
            ->orderBy('dend', 'desc')
            ->get('dend')
            ->first();

        return $dbeg >= $dend->dend;
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'),$this->request->get('dbeg'))){
            $errors[$this->request->get('dbeg')][] = trans('bd.validation.dbeg');
        }

        return $errors;
    }


}