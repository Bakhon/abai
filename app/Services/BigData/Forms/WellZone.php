<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WellZone extends PlainForm
{
    protected $configurationFileName = 'well_zone';

    public function getCalculatedFields(int $wellId, array $values): array
    {
        if (empty($values['dbeg'])) {
            return [];
        }

        $result = DB::connection('tbd')
            ->table('prod.well_zone as wz')
            ->select('z.name_ru as zone')
            ->where('wz.dbeg', '<=', Carbon::parse($values['dbeg'])->timezone('Asia/Almaty')->endOfDay())
            ->where('wz.well', $wellId)
            ->leftJoin('dict.zone as z', 'z.id', 'wz.zone')
            ->orderBy('wz.dbeg', 'desc')
            ->first();

        if (empty($result)) {
            return [];
        }

        return [
            'old_zone' => $result->zone
        ];
    }

    private function isValidDate($wellId, $dbeg):bool
    {
           
        $dbeg_well_zone = DB::connection('tbd')
                    ->table('prod.well_zone')
                    ->where('well', $wellId)
                    ->orderBy('dbeg', 'desc')
                    ->get('dbeg')
                    ->first();
                   
        if(!empty($dbeg_well_zone)){
            return $dbeg >= $dbeg_well_zone->dbeg;
        }   
        return true;
    }


    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'),$this->request->get('dbeg'))){
            $errors[$this->request->get('dbeg')][] = trans('bd.validation.dbeg_well_zone');
        }

        return $errors;
    }

}