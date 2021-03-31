<?php

namespace App\Http\Controllers\bd;

use App\Exceptions\ParseJsonException;
use App\Http\Controllers\Controller;
use App\Models\BigData\Dictionaries\Geo;
use App\Services\BigData\Forms\BaseForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class FormsController extends Controller
{

    protected $file;

    public function __construct()
    {
        $this->file = storage_path() . '/mobile_form.json';
    }

    public function getMobileFormValues(): array
    {
        if (!\Illuminate\Support\Facades\File::exists($this->file)) {
            $values = [
                'casing_pressure' => 1.12,
                'wellhead_pressure' => 1,
                'casing_pressure1' => 1.12,
                'wellhead_pressure1' => 1.12,
                'casing_pressure2' => 1.12,
                'wellhead_pressure2' => 1.12,
            ];
            \Illuminate\Support\Facades\File::put($this->file, json_encode($values));
        }

        return json_decode(\Illuminate\Support\Facades\File::get($this->file), 1);
    }

    public function saveMobileForm(Request $request): void
    {
        $values = $this->getMobileFormValues();
        $values[$request->get('code')] = $request->get('value');
        \Illuminate\Support\Facades\File::put($this->file, json_encode($values));
    }

    public function getParams(string $formName): \Illuminate\Http\JsonResponse
    {
        $form = $this->getForm($formName);
        try {
            $result = $form->getFormatedParams();
        } catch (ParseJsonException $e) {
            return response()->json(
                [
                    'errors' => $e->getMessage(),
                    'text' => 'Ошибка файла конфигурации'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return response()->json($result);
    }

    public function validateField(string $formName, string $field): void
    {
        $form = $this->getForm($formName);
        $form->validateSingleField($field);
    }

    public function saveField(string $formName, string $field): void
    {
        $form = $this->getForm($formName);
        $form->saveSingleField($field);
    }

    public function submit(string $formName): array
    {
        $form = $this->getForm($formName);
        return $form->send();
    }

    public function getRows(string $formName): array
    {
        $form = $this->getForm($formName);
        return $form->getRows();
    }

    public function getRowHistory(string $formName, Request $request): array
    {
        $form = $this->getForm($formName);
        return $form->getRowHistory(Carbon::parse($request->get('date')));
    }

    public function getRowHistoryGraph(string $formName, Request $request): array
    {
        $form = $this->getForm($formName);
        return $form->getRowHistoryGraph(Carbon::parse($request->get('date')));
    }

    public function getHistory(string $formName, Request $request): JsonResource
    {
        $form = $this->getForm($formName);
        return $form->getHistory($request->get('id'), Carbon::parse($request->get('date')));
    }

    public function getWellPrefix(Request $request): array
    {
        $prefix = '';
        $geo = Geo::find($request->get('geo'));
        while (true) {
            if (empty($geo)) {
                break;
            }

            if (!empty($geo->field_code)) {
                $prefix = $geo->field_code . '_';
                break;
            }
            $geo = $geo->parent();
        }

        return ['prefix' => $prefix];
    }

    private function getForm(string $formName): BaseForm
    {
        $formName = strtolower($formName);
        if (empty(config("bigdata_forms.{$formName}"))) {
            abort(404);
        }
        return app()->make(config("bigdata_forms.{$formName}"));
    }
}
