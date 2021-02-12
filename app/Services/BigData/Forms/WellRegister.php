<?php

namespace App\Services\BigData\Forms;

use App\Models\BigData\Well;

class WellRegister extends BaseForm
{
    public function submit(\Illuminate\Http\Request $request)
    {
        $well = Well::create($request->all());
        return $well;
    }

    protected function params()
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
                                    'validation' => 'required|exists:tbd.dict.well_category',
                                    'dict' => 'well_categories'
                                ],
                                [
                                    'code' => 'org',
                                    'type' => 'dict_tree',
                                    'title' => 'Оргструктура',
                                    'validation' => 'required|exists:tbd.dict.org',
                                    'dict' => 'orgs'
                                ],
                                [
                                    'code' => 'geo',
                                    'type' => 'dict_tree',
                                    'title' => 'Геоструктура',
                                    'validation' => 'required|exists:tbd.dict.geo',
                                    'dict' => 'geos'
                                ]
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
                                    'validation' => 'required|exists:tbd.dict.well_type',
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
}