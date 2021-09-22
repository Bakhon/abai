<?php

namespace App\Http\Controllers\Api\DB;

use App\Exceptions\BigData\SubmitFormException;
use App\Exceptions\ParseJsonException;
use App\Http\Controllers\Controller;
use App\Models\BigData\Dictionaries\Geo;
use App\Services\BigData\Forms\BaseForm;
use App\Services\BigData\Forms\History\RowHistory;
use App\Services\BigData\Forms\TableForm;
use App\Services\BigData\FormService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormsController extends Controller
{

    public function getForms(FormService $formService): JsonResponse
    {
        return response()->json(
            [
                'forms' => $formService->getForms()->values()
            ]
        );
    }


    public function getFormsStructure(FormService $formService): JsonResponse
    {
        return response()->json(
            [
                'tree' => $formService->getFormsStructure()
            ]
        );
    }

    public function getParams(string $formName): JsonResponse
    {
        $form = $this->getForm($formName);
        try {
            $result = $form->getFormInfo();
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

    public function validateTableField(string $formName, string $parent, string $field): void
    {
        $form = $this->getForm($formName);
        $form->validateSingleTableField($parent, $field);
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
        try {
            return response()->json(
                $form->getResults()
            );
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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

    public function updateFieldList(Request $request, string $form): JsonResponse
    {
        $form = $this->getForm($form);
        return response()->json($form->getUpdatedFieldList($request->get('well_id'), $request->get('values')));
    }

    public function getFormByRow(Request $request, string $form): JsonResponse
    {
        $form = $this->getForm($form);
        return response()->json($form->getFormByRow(json_decode($request->get('row'), 1)));
    }

    public function getFormParamsToEdit(Request $request, string $form): JsonResponse
    {
        $form = $this->getForm($form);
        return response()->json($form->getFormParamsToEdit($request->all()));
    }

    public function delete(string $form, int $row): JsonResponse
    {
        if (auth()->user()->cannot("bigdata delete {$form}")) {
            abort(403);
        }

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
