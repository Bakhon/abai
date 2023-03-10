<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;
use Illuminate\Support\Facades\DB;

class GasWell extends PlainForm
{
    protected $configurationFileName = 'gas_well';

    private function isValidDate($wellId, $dbeg):bool
    {
        $dend = DB::connection('tbd')
            ->table('prod.well_expl')
            ->where('well', $wellId)
            ->where('dend' ,'<' , '3333-12-31 00:00:00+06')
            ->orderBy('dend', 'desc')
            ->get('dend')
            ->first();

        if(!isset($dend->dend)) return true;
        return $dbeg >= $dend->dend;
    }

    protected function getCustomValidationErrors(string $field = null): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('dbeg'))) {
            $errors['dbeg'] = trans('bd.validation.dbeg');
        }

        return $errors;
    }

    protected function submitInnerTable(int $parentId)
    {
        $this->innerTableService->submitTables($this->request->get('well'), $this->tableFields);
    }

}