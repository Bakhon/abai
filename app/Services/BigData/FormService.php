<?php


namespace App\Services\BigData;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class FormService
{
    public function getFormsStructure()
    {
        $forms = $this->getForms();
        $formsStructure = json_decode(File::get(resource_path('js/json/bd/forms_structure.json')), 1);

        foreach ($formsStructure as &$item) {
            $this->fillFormsStructure($item, $forms);
        }

        return $formsStructure;
    }

    public function getWellFormsStructure()
    {
        $forms = $this->getForms();
        $formsStructure = json_decode(File::get(resource_path('js/json/bd/well_forms_structure.json')), 1);

        foreach ($formsStructure as &$item) {
            $this->fillFormsStructure($item, $forms);
        }

        return $formsStructure;
    }

    public function getForms()
    {
        $forms = collect(json_decode(File::get(resource_path('js/json/bd/forms.json'))));
        $forms = $forms->filter(
            function ($form) {
                return auth()->user()->can('bigdata list ' . $form->code);
            }
        );

        return $forms;
    }

    public function fillFormsStructure(array &$formsStructure, Collection $activeForms)
    {
        $forms = [];

        foreach ($formsStructure['forms'] as $formCode) {
            $form = $activeForms->where('code', $formCode)->first();
            if (empty($form)) {
                continue;
            }
            $forms[] = $form;
        }

        $formsStructure['forms'] = $forms;
    }
}