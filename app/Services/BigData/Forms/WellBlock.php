<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WellBlock extends PlainForm
{
    protected $configurationFileName = 'well_block';

    public function getCalculatedFields(int $wellId, array $values): array
    {
        if (empty($values['dbeg'])) {
            return [];
        }

        $result = DB::connection('tbd')
            ->table('prod.well_block as wb')
            ->select('b.name_ru as block')
            ->where('wb.dbeg', '<=', Carbon::parse($values['dbeg'])->timezone('Asia/Almaty')->endOfDay())
            ->where('wb.well', $wellId)
            ->leftJoin('dict.block as b', 'b.id', 'wb.block')
            ->orderBy('wb.dbeg', 'desc')
            ->limit(1)
            ->first();

        if (empty($result)) {
            return [];
        }

        return [
            'current_block' => $result->block
        ];
    }

    
    private function isValidDate($wellId, $dbeg):bool
    {
           
        $dbegWellBlock = DB::connection('tbd')
                    ->table('prod.well_block')
                    ->where('well', $wellId)
                    ->orderBy('dbeg', 'desc')
                    ->get('dbeg')
                    ->first();
                    
        if(!empty($dbegWellBlock)){
           
            return $dbeg >= $dbegWellBlock->dbeg;
        }   
        return true;
    }


    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'),$this->request->get('dbeg'))){
            $errors[$this->request->get('dbeg')][] = trans('bd.validation.dbeg_well_block');
        }

        return $errors;
    }
}