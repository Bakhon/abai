<?php

return [
    'validation' => [
        'coords_mouth' => 'Значение координаты не попадает в границы земельного отвода',
        'coords_bottom' => 'Значение координаты не попадает в границы горного отвода'
    ],
    'date' => 'Дата',
    'select' => 'Выбрать',
    'exit' => 'Выход',
    'select_dzo' => 'Выберите ДЗО из списка',
    'nothing_found' => 'Ничего не найдено',
    'forms' => [
        'fluid_production' => [
            'uwi_number' => 'Номер скважины',
            'other_uwi' => 'Совместные скважины',
            'worktime' => 'Отработанное время',
            'exp_type' => 'Способ эксплуатации',
            'lease' => 'Отвод',
            'geostructure' => 'Геоструктура',
            'debit_fluid_tech' => 'Дебит жидк. по тех.режиму, м³/сут',
            'debit_oil_tech' => 'Дебит нефти по тех. режиму, тн.',
            'bsw_tech' => 'Обводн. по тех.режиму, %',
            'liquid_val' => 'Добыча жидкости, м3',
            'oil_val' => 'Добыча нефти, тн',
            'liquid_debit' => 'Дебит жидк., м³/сут',
            'mark' => 'Отметка',
            'liquid_telemetry' => 'Жидк. с телеметрии, м³/сут',
            'bsw' => 'Тек. обводненность, %',
            'oil_debit' => 'Дебит нефти',
            'contamination' => 'Мех. примеси, %',
            'pipe_diameter' => 'Диаметр штуцера, мм',
            'p_buf' => 'Рбуфф.',
            'p_zatr' => 'Рзатр',
            'p_buf_b' => 'Рбуфф. до штуцера',
            'p_buf_a' => 'Рбуфф. после штуцера',
            'cycle_per_minute' => 'Об./мин',
            'length_stroke' => 'Длина хода, м',
            'reciprotating_speed' => 'Число качаний',
            'downtime_reason' => 'Причина простоя',
            'gas_factor' => 'Газовый фактор, м³/т',
            'gas_output' => 'Добыча газа, м³',
            'note' => 'Примечание',
            'prod_decline_reason' => 'Причина снижения дебита',
            'measure_last_month' => 'Замеры по скважине за последний месяц',
            'telemetry_data' => 'Данные телеметрии по скважине'
        ],
        'production_well' => [
            'date_start' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'Intended_production_regime' => 'Намечаемый режим по добыче',
            'Tech_modes_indicators' => 'Показатели тех режимов',
            'liquid' => 'Жидкость (м3/сутки)',
            'oil' => 'Нефть (Т/сутки)',
            'water_cut' => 'Обводненность (%)',
            'calculated_fields' => 'Рассчитываемые поля',
            'oil_density' => 'Плотность нефти (Т/М3)',
            'water_cut' => 'Обводненность (%)'
        ],
        'injection_wells'=>[
            'Main' => 'Основное',
            'Planned_event' => 'Намечаемое мероприятие',
            'Mode_parameters' => 'Параметры режима',
            'date_start' => 'Дата начала',
            'date_end' => 'Дата конца',
            'Tech_modes_of_injection_wells' => 'Технологические режимы нагнетательных скважин',
            'agent_volume' => 'Объем агента, м³',
            'agent_type' => 'Вид агента',
            'agent_temperature' => 'Температура агента, С°',
            'injection_pressure' => 'Давление закачки, атм',
            'qmax_reception' => 'Qмакс.прием',
            'Planned_events_tech_modes' => 'Намечаемые мероприятия по технологическим режимам',
            'event' => 'Мероприятие',
            'planned_month' => 'Планируемый месяц'
        ],
        'gtm_register'=>[
            'Gtm_start'=>'Начало ГТМ',
            'date_gtm_start'=>'Дата начала ГТМ',
            'gtm_name'=>'Наименование ГТМ',
            'new_technologies'=>'Новые технологии',
            'own_forces'=>'Собственными силами',
            'contractor'=>'Подрядчик',
            'Gtm_end'=>'Окончание ГТМ',
            'date_gtm_end'=>'Дата окончания ГТМ',
            'gtm_parameters_results'=>'Параметры ГТМ/результаты',
            'status'=>'Состояние'
        ],
        'well_design'=>[
            "well_design_project" => "Проект конструкции скважины",
            "casing_type" => "Вид колонны",
            "casing_running_depth" => "Глубина спуска колонны",
            "side_barrel" => "Боковой ствол",
            "casing_type" => "Вид обсадной трубы",
            "number_of_pipes" => "Количество труб",
            "poured_cement_volume" => "Объем залитого цемента",
            "cement_lifting_height" => "Высота подъема цемента" 
        ]
    ],
    'close' => 'Закрыть',
    'value_outside' => 'Данное значение выходит за ограничения',
    'are_you_sure' => 'Вы уверены, что хотите сохранить изменения?',
    'week' => 'неделя',
    'month' => 'месяц',
    'month_1' => 'месяца',
    'month_2' => 'месяцев',
    'year' => 'год',
    'all' => 'все',
    'sure_you_want_to_copy' => 'Вы точно хотите скопировать данные из ячейки?'
];