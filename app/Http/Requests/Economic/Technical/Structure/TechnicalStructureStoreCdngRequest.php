<?php

namespace App\Http\Requests\Economic\Technical\Structure;

class TechnicalStructureStoreCdngRequest extends TechnicalStructureStoreRequest
{
    public function rules()
    {
        return parent::rules() + [
                'ngdu_id' => 'required|integer|min:1',
            ];
    }
}
