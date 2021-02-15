<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use App\Services\BigData\Forms\BaseForm;

class FormsController extends Controller
{

    public function getParams(string $formName): array
    {
        $form = $this->getForm($formName);
        return $form->getFormatedParams();
    }

    public function validateField(string $formName, string $field)
    {
        $form = $this->getForm($formName);
        $form->validateSingleField($field);
    }

    public function submit(string $formName)
    {
        $form = $this->getForm($formName);
        return $form->send();
    }

    private function getForm(string $formName): BaseForm
    {
        if (empty(config("bigdata_forms.{$formName}"))) {
            abort(404);
        }
        return app()->make(config("bigdata_forms.{$formName}"));
    }

}
