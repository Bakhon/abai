<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use Illuminate\Support\Facades\DB;

class WellTechChangeDisconnect extends PlainForm
{
    protected $configurationFileName = 'well_tech_change_disconnect';

    public function submit(): array
    {
        DB::connection('tbd')->beginTransaction();

        try {
            $tableName = $this->params()['table'];

            $data = $this->request->all();

            $oldRow = DB::connection('tbd')
                ->table($tableName)
                ->where('well', $data['well'])
                ->orderBy('dend', 'desc')
                ->first();

            DB::connection('tbd')
                ->table($tableName)
                ->where('id', $oldRow->id)
                ->update(
                    [
                        'dend' => $data['dend']
                    ]
                );

            $id = DB::connection('tbd')
                ->table($tableName)
                ->insertGetId(
                    [
                        'tap' => $oldRow->tap,
                        'tech' => $data['tech'],
                        'dbeg' => $data['dend'],
                        'well' => $data['well']
                    ]
                );

            DB::connection('tbd')->commit();
            return (array)DB::connection('tbd')->table($tableName)->where('id', $id)->first();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }
}