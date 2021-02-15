<?php

declare(strict_types=1);

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;

class WellRegister extends BaseForm
{
    public function submit(\Illuminate\Http\Request $request): \Illuminate\Database\Eloquent\Model
    {
        $well = Well::create($request->all());
        return $well->toArray();
    }

    protected function params(): array
    {
        return [
            'tabs' => [
                [
                    'title' => 'Основное',
                    'blocks' => [
                        [
                            'title' => 'Скважина',
                            'items' => [
                                [
                                    'code' => 'org',
                                    'type' => 'dict_tree',
                                    'title' => 'Оргструктура',
                                    'validation' => 'required|exists:tbd.dict.org,id',
                                    'dict' => 'orgs'
                                ],
                                [
                                    'code' => 'geo',
                                    'type' => 'dict_tree',
                                    'title' => 'Геоструктура',
                                    'validation' => 'required|exists:tbd.dict.geo,id',
                                    'dict' => 'geos'
                                ],
                                [
                                    'code' => 'name',
                                    'type' => 'text',
                                    'title' => 'Номер скважины',
                                    'validation' => 'required|max:255'
                                ],
                                [
                                    'code' => 'date_create',
                                    'type' => 'date',
                                    'title' => 'Дата создания проекта',
                                    'validation' => 'required|date'
                                ],
                                [
                                    'code' => 'category',
                                    'type' => 'dict',
                                    'title' => 'Категория скважины',
                                    'validation' => 'required|exists:tbd.dict.well_category,id',
                                    'dict' => 'well_categories'
                                ],
                            ]
                        ],
                        [
                            'title' => 'Свойства скважины',
                            'items' => [
                                [
                                    'code' => 'altitude',
                                    'type' => 'numeric',
                                    'title' => 'Альтитуда',
                                    'validation' => 'nullable|numeric|min:10|max:100',
                                ],
                                [
                                    'code' => 'rotor_table',
                                    'type' => 'numeric',
                                    'title' => 'Превышение стола ротора',
                                    'validation' => 'numeric|min:10|max:100',
                                ],
                                [
                                    'code' => 'coord_type',
                                    'type' => 'radio',
                                    'title' => 'Координатная система',
                                    'values' => ['WGS-84', 'Пулково-42'],
                                    'validation' => 'required|date'
                                ],
                                [
                                    'code' => 'coord_mouth_x',
                                    'type' => 'numeric',
                                    'title' => 'Координаты устья X',
                                    'validation' => 'nullable|numeric|min:41|max:43'
                                ],
                                [
                                    'code' => 'coord_mouth_y',
                                    'type' => 'numeric',
                                    'title' => 'Координаты устья Y',
                                    'validation' => 'nullable|numeric|min:50|max:55'
                                ],
                                [
                                    'code' => 'type',
                                    'type' => 'dict',
                                    'title' => 'Вид скважины',
                                    'dict' => 'well_types',
                                    'validation' => 'required|exists:tbd.dict.well_type,id',
                                ],
                                [
                                    'code' => 'coord_bottom_x',
                                    'type' => 'numeric',
                                    'title' => 'Координаты забоя X',
                                    'validation' => 'nullable|numeric|min:41|max:43'
                                ],
                                [
                                    'code' => 'coord_bottom_y',
                                    'type' => 'numeric',
                                    'title' => 'Координаты забоя Y',
                                    'validation' => 'nullable|numeric|min:50|max:55'
                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Проект бурения',
                    'blocks' => [
                        [
                            'title' => 'Скважина',
                            'items' => [
                                [
                                    'code' => 'date_start_drilling',
                                    'type' => 'date',
                                    'title' => 'Дата начала бурения',
                                    'validation' => 'nullable|date'
                                ],
                                [
                                    'code' => 'date_end_drilling',
                                    'type' => 'date',
                                    'title' => 'Дата окончания бурения',
                                    'validation' => 'nullable|date'
                                ],
                                [
                                    'code' => 'company',
                                    'type' => 'dict',
                                    'title' => 'Подрядчик',
                                    'dict' => 'companies',
                                    'validation' => 'nullable|exists:tbd.dict.company'
                                ],
                                [
                                    'code' => 'agreement_num',
                                    'type' => 'numeric',
                                    'title' => 'Номер договора',
                                    'validation' => 'required|numeric'
                                ],
                                [
                                    'code' => 'agreement_date',
                                    'type' => 'date',
                                    'title' => 'Дата договора',
                                    'validation' => 'required|date'
                                ],
                                [
                                    'code' => 'planned_depth',
                                    'type' => 'numeric',
                                    'title' => 'Проектная глубина, м',
                                    'validation' => 'nullable|numeric'
                                ],
                                [
                                    'code' => 'avg_gasoil_ratio',
                                    'type' => 'numeric',
                                    'title' => 'Средний газовый фактор',
                                    'validation' => 'nullable|numeric'
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    protected function getCustomValidationErrors(\Illuminate\Http\Request $request): array
    {
        $errors = [];

        $errors = array_merge_recursive(
            $errors,
            $this->validateCoords($request, 'coord_mouth_x', 'coord_mouth_y', trans('bd.validation.coords_mouth'))
        );
        $errors = array_merge_recursive(
            $errors,
            $this->validateCoords($request, 'coord_bottom_x', 'coord_bottom_y', trans('bd.validation.coords_bottom'))
        );

        return $errors;
    }

    protected function validateCoords($request, $coordXField, $coordYField, $msg)
    {
        $errors = [];

        if (empty($request->get('geo')) || empty($request->get($coordXField)) || empty($request->get($coordYField))) {
            return $errors;
        }

        $coord = "({$request->get($coordXField)},{$request->get($coordYField)})";
        if (!$this->validator->validateCoords($coord, $request->get('geo'))) {
            $errors[$coordXField][] = $msg;
            $errors[$coordYField][] = $msg;
        }

        return $errors;
    }
}