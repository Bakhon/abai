<?php

namespace App\Http\Requests\Economic\Technical\Structure;

class TechnicalStructureStoreNgduRequest extends TechnicalStructureStoreRequest
{
    public function rules()
    {
        return parent::rules() + [
                'field_id' => 'required|integer|min:1',
            ];
    }
}
