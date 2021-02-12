<?php

namespace App\Http\Controllers\bd;

use App\Http\Controllers\Controller;
use App\Services\BigData\Forms\BaseForm;
use Illuminate\Http\Request;

class FormsController extends Controller
{

    public function getParams(string $formName): array
    {
        $form = $this->getForm($formName);
        return $form->getFormatedParams();
    }

    private function getForm(string $formName): BaseForm
    {
        if (empty(config("bigdata_forms.{$formName}"))) {
            abort(404);
        }
        return app()->make(config("bigdata_forms.{$formName}"));
    }

    public function submit(Request $request, string $formName)
    {
        $form = $this->getForm($formName);
        return $form->send($request);
    }

}
