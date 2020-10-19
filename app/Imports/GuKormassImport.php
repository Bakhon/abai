<?php

namespace App\Imports;

use App\Models\Cdng;
use App\Models\GuKormass;
use App\Models\Gu;
use App\Models\Kormass;
use Maatwebsite\Excel\Concerns\ToModel;

class GuKormassImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $kormass = Kormass::where('name', '=', $row[0])->first();
        $gu = Gu::where('name', '=', $row[1])->first();
        $cdng = Cdng::where('name', '=', $row[2])->first();
        return new GuKormass([
            'kormass_id' => $kormass->id,
            'gu_id' => $gu->id,
            'cdng_id' => $cdng->id,
        ]);
    }
}
