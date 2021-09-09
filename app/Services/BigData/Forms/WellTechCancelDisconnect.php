<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;
use Illuminate\Support\Facades\DB;

class WellTechCancelDisconnect extends PlainForm
{
    protected $configurationFileName = 'well_tech_cancel_disconnect';

    protected function submitForm(): array
    {
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

        return (array)DB::connection('tbd')->table($tableName)->where('id', $oldRow->id)->first();
    }
}