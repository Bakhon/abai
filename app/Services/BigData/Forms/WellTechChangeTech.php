<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use App\Models\BigData\Well;
use App\Traits\BigData\Forms\DateMoreThanValidationTrait;
use Illuminate\Support\Facades\DB;

class WellTechChangeTech extends PlainForm
{
    protected $configurationFileName = 'well_tech_change_tech';

    use DateMoreThanValidationTrait;

    protected function getCustomValidationErrors(): array
    {
        $errors = [];

        if (!$this->isValidDate($this->request->get('well'), $this->request->get('dbeg'), 'prod.well_tech', 'dbeg')) {
            $errors['dbeg'][] = trans('bd.validation.dbeg');
        }

        return $errors;
    }

    public function submit(): array
    {
        DB::connection('tbd')->beginTransaction();

        try {
            $tableName = $this->params()['table'];

            $data = $this->request->all();

            $oldRow = DB::connection('tbd')
                ->table($tableName)
                ->where('well', $data['well'])
                ->orderBy('dbeg', 'desc')
                ->first();

            DB::connection('tbd')
                ->table($tableName)
                ->where('id', $oldRow->id)
                ->update(
                    [
                        'dend' => $data['dbeg']
                    ]
                );

            $data['tap'] = $oldRow->tap;
            $data['dend'] = Well::DEFAULT_END_DATE;
            $id = DB::connection('tbd')
                ->table($tableName)
                ->insertGetId($data);

            DB::connection('tbd')->commit();
            return (array)DB::connection('tbd')->table($tableName)->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }
}