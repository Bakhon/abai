<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Traits\BigData\Forms\WithDocumentsUpload;
use Illuminate\Support\Collection;

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

    protected function getRows(): Collection
    {
        $rows = parent::getRows();

        if (!empty($rows)) {
            $rows = $this->attachDocuments($rows);
        }

        return $rows;
    }

    protected function prepareDataToSubmit()
    {
        $data = parent::prepareDataToSubmit();
        return array_filter(
            $data,
            function ($key) {
                return !in_array($key, ['gis_method', 'gis_type', 'documents']);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}