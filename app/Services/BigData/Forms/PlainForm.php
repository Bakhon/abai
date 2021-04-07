<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use Illuminate\Support\Facades\DB;

abstract class PlainForm extends BaseForm
{
    protected $jsonValidationSchemeFileName = 'plain_form.json';

    public function submit(): array
    {
        $tableFields = $this->getFields()
            ->filter(
                function ($item) {
                    return $item['type'] === 'table';
                }
            );

        $tableFieldCodes = $tableFields
            ->pluck('code')
            ->toArray();

        $data = $this->request->except($tableFieldCodes);
        //$data['created_at'] = \Carbon\Carbon::now();
        //$data['updated_at'] = \Carbon\Carbon::now();

        $id = DB::connection('tbd')->table($this->params()['table'])
            ->insertGetId($data);

        if (!empty($tableFields)) {
            foreach ($tableFields as $field) {
                foreach ($this->request->get($field['code']) as $data) {
                    $data[$field['parent_column']] = $id;
                    DB::connection('tbd')->table($field['table'])->insert($data);
                }
            }
        }

        return (array)DB::connection('tbd')->table($this->params()['table'])->where('id', $id)->first();
    }
}