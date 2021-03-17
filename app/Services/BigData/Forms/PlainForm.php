<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Facades\DB;

abstract class PlainForm extends BaseForm
{
    public function submit(): array
    {
        $fields = $this->request->all();
        $fields['created_at'] = \Carbon\Carbon::now();
        $fields['updated_at'] = \Carbon\Carbon::now();

        $id = DB::table($this->params()['table'])
            ->insertGetId($fields);

        return (array)DB::table($this->params()['table'])->where('id', $id)->first();
    }
}