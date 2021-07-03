<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class WellStatus extends PlainForm
{
    protected $configurationFileName = 'well_status';

    public function submit(): array
    {
        DB::connection('tbd')->beginTransaction();

        try {
            $data = $this->request->except(
                [
                    'well',
                    'dbeg'
                ]
            );
            if (!empty($this->params()['default_values'])) {
                $data = array_merge($this->params()['default_values'], $data);
            }

            $dbQuery = DB::connection('tbd')->table($this->params()['table']);
            $wellId = $dbQuery->insertGetId($data);


            DB::connection('tbd')->commit();
            return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $wellId)->first();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }

    private function isValidDate($wellId, $dbeg):bool
    {
            $dend = DB::connection('tbd')
                        ->table('prod.well_status')
                        ->where('well', $wellId)
                        ->orderBy('dend', 'desc')
                        ->get('dend');
                        

            ($dbeg > $dend) ? true: false;
    }

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate($wellId, 'dbeg')) {
            $errors['dbeg'][] = trans('bd.validation.dbeg');
        }

        return $errors;
    }
    
   

}