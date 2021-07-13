<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\DepthValidationTrait;

class BottomHoleArtificial extends PlainForm
{
    protected $configurationFileName = 'bottom_hole_artificial';

    use DepthValidationTrait;

    protected function isValidDate($wellId, $date): bool
    {
        $endDate =  DB::connection('tbd')
            ->table('dict.well')
            ->where('id', $wellId)
            ->get('drill_end_date')
            ->first();            
            
        if(empty($endDate) || $endDate->drill_end_date == null){
            return true;
        }
        return $date >= $endDate->drill_end_date;    
    }   

        
    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDepth($this->request->get('well'),$this->request->get('depth'))) {
            $errors['depth'][] = trans('bd.validation.depth');
        }

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('data'))) {
            $errors[$this->request->get('data')][] = trans('bd.validation.end_date');
        }

        return $errors;
    }

}


