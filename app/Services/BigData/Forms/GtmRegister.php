<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use Illuminate\Support\Facades\DB;

class GtmRegister extends PlainForm
{
    protected $configurationFileName = 'gtm_register';

    public function submit(): array
    {
        DB::beginTransaction();

        try {
            $formFields = $this->request->except('well_status_type');

            $dbQuery = DB::connection('tbd')->table($this->params()['table']);

            if (!empty($formFields['id'])) {
                $id = $dbQuery->where('id', $formFields['id'])->update($formFields);
            } else {
                $id = $dbQuery->insertGetId($formFields);
            }

            $this->updateWellStatus();

            DB::commit();

            return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new SubmitFormException();
        }
    }

    private function updateWellStatus()
    {
        DB::connection('tbd')
            ->table('prod.well_status')
            ->where('well', $this->request->get('well'))
            ->where('dbeg', '<', $this->request->get('dend'))
            ->orderBy('dbeg', 'desc')
            ->limit(1)
            ->update(['dend' => $this->request->get('dend')]);

        DB::connection('tbd')
            ->table('prod.well_status')
            ->insert(
                [
                    'well' => $this->request->get('well'),
                    'status' => $this->request->get('well_status_type'),
                    'dbeg' => $this->request->get('dend'),
                    'dend' => '3333-12-31 00:00:00+06',
                ]
            );
    }

}