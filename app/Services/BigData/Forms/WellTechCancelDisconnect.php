<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Exceptions\BigData\SubmitFormException;
use App\Models\BigData\Well;
use Illuminate\Support\Facades\DB;

class WellTechCancelDisconnect extends PlainForm
{
    protected $configurationFileName = 'well_tech_cancel_disconnect';

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
                        'dend' => Well::DEFAULT_END_DATE
                    ]
                );

            DB::connection('tbd')->commit();
            return (array)DB::connection('tbd')->table($tableName)->where('id', $oldRow->id)->first();
        } catch (\Exception $e) {
            DB::connection('tbd')->rollBack();
            throw new SubmitFormException($e->getMessage());
        }
    }
}