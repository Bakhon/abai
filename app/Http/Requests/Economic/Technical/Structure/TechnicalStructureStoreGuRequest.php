<?php

namespace App\Http\Requests\Economic\Technical\Structure;

class TechnicalStructureStoreGuRequest extends TechnicalStructureStoreRequest
{
    public function rules()
    {
        return parent::rules() + [
                'cdng_id' => 'required|integer|min:1',
            ];
    }
}
