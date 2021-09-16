<?php

namespace App\Http\Requests\Economic\Technical\Structure;

class TechnicalStructureStoreCompanyRequest extends TechnicalStructureStoreRequest
{
    public function rules()
    {
        return parent::rules() + [
                'short_name' => 'nullable|string',
                'tbd_id' => 'nullable|numeric',
            ];
    }
}
