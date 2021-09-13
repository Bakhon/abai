<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\HasPlannedEvents;
use Illuminate\Support\Facades\DB;

class ProductionWell extends PlainForm
{
    use HasPlannedEvents;

    protected $configurationFileName = 'production_well';

    public function getCalculatedFields(int $wellId, array $values): array
    {
        $requiredFields = ['liquid', 'wcut', 'oil_density'];
        foreach ($requiredFields as $field) {
            if (empty($values[$field])) {
                return [];
            }
        }

        $oil = round($values['liquid'] * (1 - $values['wcut'] / 100) * $values['oil_density'], 2);
        return [
            'oil' => $oil
        ];
    }

    private function isValidDate($wellId, $dbeg):bool
    {
        $dend = DB::connection('tbd')
            ->table('prod.tech_mode_prod_oil')
            ->where('well', $wellId)
            ->where('dend' ,'<' , '3333-12-31 00:00:00+06')
            ->orderBy('dend', 'desc')
            ->get('dend')
            ->first();
        if(!empty($dend)){
            return $dbeg >= $dend->dend;
        }
        return true;
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