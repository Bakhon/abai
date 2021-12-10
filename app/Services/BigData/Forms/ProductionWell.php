<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
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
            ->where('dend', '<', Well::DEFAULT_END_DATE)
            ->orderBy('dend', 'desc')
            ->get('dend')
            ->first();
        if(!empty($dend)){
            return $dbeg >= $dend->dend;
        }
        return true;
    }

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->request->get('id') && !$this->isValidDate(
                $this->request->get('well'),
                $this->request->get('dbeg')
            )) {
            $errors['dbeg'][] = trans('bd.validation.dbeg');
        }

        return $errors;
    }

    protected function afterSubmit(int $id)
    {
        $row = DB::connection('tbd')
            ->table($this->params()['table'])
            ->where('id', $id)
            ->first();

        $prevRow = DB::connection('tbd')
            ->table($this->params()['table'])
            ->where('well', $row->well)
            ->where('id', '!=', $row->id)
            ->where('dend', '<=', $row->dend)
            ->where('dend', '>', $row->dbeg)
            ->orderBy('dbeg', 'desc')
            ->first();

        if ($prevRow) {
            DB::connection('tbd')
                ->table($this->params()['table'])
                ->where('id', $prevRow->id)
                ->update(
                    [
                        'dend' => $row->dbeg
                    ]
                );
        }

        $nextRow = DB::connection('tbd')
            ->table($this->params()['table'])
            ->where('well', $row->well)
            ->where('id', '!=', $row->id)
            ->where('dbeg', '>', $row->dbeg)
            ->where('dbeg', '<=', $row->dend)
            ->orderBy('dbeg', 'asc')
            ->first();

        if ($nextRow) {
            DB::connection('tbd')
                ->table($this->params()['table'])
                ->where('id', $nextRow->id)
                ->update(
                    [
                        'dbeg' => $row->dend
                    ]
                );
        }
    }
}