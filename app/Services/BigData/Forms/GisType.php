<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\WithDocumentsUpload;

class GisType extends PlainForm
{
    protected $configurationFileName = 'gis_type';

    use WithDocumentsUpload;

    protected function submitForm(): array
    {
        $result = parent::submitForm();

        $gis = \App\Models\BigData\Gis::find($result['id']);
        $gis->methods()->sync($this->request->get('gis_method'));

        return $result;
    }
}