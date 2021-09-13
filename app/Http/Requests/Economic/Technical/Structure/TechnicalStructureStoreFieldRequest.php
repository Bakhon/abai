<?php

namespace App\Http\Requests\Economic\Technical\Structure;

class TechnicalStructureStoreFieldRequest extends TechnicalStructureStoreRequest
{
    public function rules()
    {
        return parent::rules() + [
                'company_id' => 'required|integer|min:1',
            ];
    }
}
