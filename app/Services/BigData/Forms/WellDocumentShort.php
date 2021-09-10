<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

class WellDocumentShort extends WellDocument
{
    protected $configurationFileName = 'well_document_short';

    protected function prepareDataToSubmit()
    {
        $data = parent::prepareDataToSubmit();
        $data['name_ru'] = $data['doc_date'];
        return $data;
    }
}