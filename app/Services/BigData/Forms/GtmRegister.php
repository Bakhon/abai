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
            $data = $this->request->except('well_status_type');

            $dbQuery = DB::connection('tbd')->table($this->params()['table']);

            if (!empty($data['id'])) {
                $id = $dbQuery->where('id', $data['id'])->update($data);
            } else {
                $id = $dbQuery->insertGetId($data);
            }


            return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new SubmitFormException();
        }
    }

}