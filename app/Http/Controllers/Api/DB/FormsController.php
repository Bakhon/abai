<?php

namespace App\Http\Controllers\Api\DB;

use App\Exceptions\BigData\SubmitFormException;
use App\Exceptions\ParseJsonException;
use App\Http\Controllers\Controller;
use App\Models\BigData\Dictionaries\Geo;
use App\Services\BigData\Forms\BaseForm;
use App\Services\BigData\Forms\RowHistory\RowHistory;
use App\Services\BigData\Forms\TableForm;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class FormsController extends Controller
{

    protected $file;

    public function __construct()
    {
        $this->file = storage_path() . '/mobile_form.json';
    }

    public function getMobileFormValues(): array
    {
        if (!File::exists($this->file)) {
            $values = [
                'casing_pressure' => 1.12,
                'wellhead_pressure' => 1,
                'casing_pressure1' => 1.12,
                'wellhead_pressure1' => 1.12,
                'casing_pressure2' => 1.12,
                'wellhead_pressure2' => 1.12,
            ];
            File::put($this->file, json_encode($values));
        }

        return json_decode(File::get($this->file), 1);
    }

    public function saveMobileForm(Request $request): void
    {
        $values = $this->getMobileFormValues();
        $values[$request->get('code')] = $request->get('value');
        File::put($this->file, json_encode($values));
    }

    public function getForms(): JsonResponse
    {
        $forms = json_decode(File::get(resource_path('js/json/bd/forms.json')));
        $forms = array_filter(
            $forms,
            function ($form) {
                return auth()->user()->can('bigdata list ' . $form->code);
            }
        );

        return response()->json(
            [
                'forms' => array_values($forms)
            ]
        );
    }

    public function getParams(string $formName): JsonResponse
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

    public function submit(string $formName)
    {
        $form = $this->getForm($formName);
        try {
            return $form->send();
        } catch (SubmitFormException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRows(string $formName): array
    {
        $form = $this->getForm($formName);
        return $form->getRows();
    }

    public function getRowHistory(string $formName, Request $request): array
    {
        /** @var TableForm $form */
        $form = $this->getForm($formName);
        $rowHistory = new RowHistory($form);
        return $rowHistory->getRowHistory(
            $request->get('well_id'),
            $request->get('column'),
            Carbon::parse($request->get('date'))
        );
    }

    public function getRowHistoryGraph(string $formName, Request $request): array
    {
        /** @var TableForm $form */
        $form = $this->getForm($formName);
        $rowHistory = new RowHistory($form);
        return $rowHistory->getRowHistoryGraph(
            $request->get('well_id'),
            $request->get('column'),
            Carbon::parse($request->get('date'))
        );
    }

    public function getHistory(string $formName, Request $request): array
    {
        $form = $this->getForm($formName);
        return $form->getHistory($request->get('id'), Carbon::parse($request->get('date')));
    }

    public function copyFieldValue(string $formName, Request $request): JsonResponse
    {
        $form = $this->getForm($formName);
        $form->copyFieldValue($request->get('well_id'), Carbon::parse($request->get('date')));
        return response()->json([], Response::HTTP_NO_CONTENT);
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

    public function getResults(Request $request, string $formName): JsonResponse
    {
        $form = $this->getForm($formName);
        return $form->getResults($request->get('well_id'));
    }

    public function calcFields(Request $request, string $form): JsonResponse
    {
        $form = $this->getForm($form);
        return response()->json($form->getCalculatedFields($request->get('well_id'), $request->get('values')));
    }

    public function updateFields(Request $request, string $form): JsonResponse
    {
        $form = $this->getForm($form);
        return response()->json($form->getUpdatedFields($request->get('well_id'), $request->get('values')));
    }

    public function getFormByRow(Request $request, string $form): JsonResponse
    {
        $form = $this->getForm($form);
        return response()->json($form->getFormByRow(json_decode($request->get('row'), 1)));
    }

    public function delete(Request $request, string $form, int $row): JsonResponse
    {
        $form = $this->getForm($form);
        return $form->delete($row);
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
