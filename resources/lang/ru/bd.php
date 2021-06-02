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
        'kpc' => [
            'request_date'=>'Дата подачи заявки',
            'planned_date'=>'Ожидаемая дата проведения',
            'work_type'=>'Вид работ',
            'gtm_type'=>'Вид ГТМ',
            'planing_work_list'=>'Список планируемых работ',
            'repair' => 'Ремонт',
            'request' => 'Заявка',
            'delivery_certificate_for_repair' => 'Акт сдачи в ремонт',
            'acceptance_certificate_from_repair' => 'Акт приема из ремонта',
            'rejection_reason' => 'Причина отказа',
            'work_start_date' => 'Дата начала работ',
            'repair_work_type' => 'Вид ремонтных работ',
            'planned_works_list'=> 'Список планируемых работ',
            'on_our_own' => 'Собственными силами',
            'contractor' => 'Подрядчик',
            'brigade' => 'Бригада',
            'brigade_master' => 'Мастер бригады',
            'duplicate_in_gts' => 'Дублировать в ГТС',
            'opi' => 'ОПИ',
            'work_end_date' => 'Дата окончания работ', 
            'done_work_description' => 'Описание проделанных работ',
            'out_of_plan' => 'Вне плана',
            'new_run_down_nkt' => 'Кол-во спущенных НКТ, новые',
            'used_run_down_nkt' => 'Кол-во спущенных НКТ, б/у',
            'actual_bottomhole_m' =>  'Фактический забой, м',
            'no_slaughter' => 'Забой отсутствует',
            'no_slaughter_reason' => 'Причина отсутсивия забоя',
            'artificial_slaughter_m' => 'Искусственный забой, м',
            'machine_technical_condition' => 'Техническое состояние скважин',
            'not_change_technical_condition' => 'Не менять техническое состояние',
            'status_before_selected_date' => 'Статус до выбранной даты', 
            'date_not_selected' => 'Дата не выбрана',
            'new_state' => 'Новое состояние',
            'condition' => 'Состояние',
            'not_change_state' => 'Не менять состояние',
            'hardware_failure_cause' => 'Основная причина отказа оборудования',
            'equipment_failure_type' => 'Вид причины отказа оборудования',
            'stopping_reason' => 'Причина остановки'],
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
            "column_type" => "Вид колонны",
            "casing_running_depth" => "Глубина спуска колонны",
            "side_barrel" => "Боковой ствол",
            "casing_type" => "Вид обсадной трубы",
            "number_of_pipes" => "Количество труб",
            "poured_cement_volume" => "Объем залитого цемента",
            "cement_lifting_height" => "Высота подъема цемента" 
        ],
        'prs' => [
            'repair' => 'Ремонт',
            'delivery_cert' => 'Акт сдачи в ремонт',
            'rej_reason' => 'Причина отказа',
            'acceptance_cert' => 'Акт приема из ремонта',
            'start_date' => 'Дата начала работы',
            'type_rep_work' => 'Вид ремонтных работ',
            'planned_works_list' => 'Список планируемых работ',
            'contractor' => 'Подрядчик',
            'brigade' => 'Бригада',
            'brigade_master' => 'Мастер бригады',
            'cause_h_failure' => 'Основная причина отказа оборудования',
            'reason_type' => 'Вид причины отказа оборудования',
            'reason_stopping' => 'Причина остановки',
            'completion_date' => 'Дата и время окончания работ',
            'desc_done' => 'Описание проделанной работы',
            'rep_type' => 'Вид ремонта',
            'nkt_new' => 'Кол-во спущенных НКТ, новые',
            'nkt_used' => 'Кол-во спущенных НКТ, б/у',
            'actual_bh' => 'Фактический забой, м',
            'tech_condition' => 'Техническое состояние скважин',
            'new_condition' => 'Новое состояние'
        ],
        'gas_well'=>[
            'main' => 'Основное',
            'mode_parameters' => 'Параметры режима',
            'date_start' => 'Дата начала',
            'date_end' => 'Дата конца',
            'tech_modes_gas_well' => 'Технологические режимы газовых скважин',
            'gas_flow_rate' => 'Дебит газа (М³/сут.)',
            'planned_events' => 'Намечаемые мероприятия',
            'event' => 'Мероприятие',
            'planned_month' => 'Планируемый месяц'
        ],
        'daily_drill'=>[
            'main_information'=>'Основные сведения',
            'drilling'=>'Бурение',
            'date_drill'=>'Дата бурения:',
            'well_status_type'=>'Статус ведения работ:',
            'reason_downtime'=>'Причина простоя:',
            'drill_beg'=>'Начало бурения:',
            'drill_end'=>'Окончание бурения:',
            'works'=>'Работы:',
            'daily_drill_progress'=>'Суточная проходка:',
            'work_name'=>'Проводимые работы:',
            'other_parameters'=>'Прочие параметры',
            'washing_liquid_parameters'=>'Параметры промывочной жидкости',
            'liquid_density'=>'Плотность:',
            'liquid_crust'=>'Корка:',
            'liquid_viscosity'=>'Вязкость:',
            'liquid_ph'=>'pH:',
            'liquid_water_yield'=>'Водоотдача:',
            'drilling_mode'=>'Режим бурения',
            'drill_rate'=>'Скорость проходки:',
            'drill_load'=>'Нагрузка:',
            'pump_type'=>'Тип насоса:',
            'revs_per_minute'=>'Оборотов в минуту:',
            'drill_pump_p'=>'P насоса:',
            'rotating_moment'=>'Вращающий момент:',
            'drill_piston_d'=>'Д поршня:',
            'kern'=>'Керн',
            'kern_roofing'=>'Кровля(керн):',
            'kern_sole'=>'Подошва(керн):',
            'chisel_knbk'=>'Долото, КНБК',
            'chisel'=>'Долото:',
            'diameter'=>'Диаметр:',
            'knbk'=>'КНБК',
            'knbk_full'=>'Компонент низа бурильной колонны',
            'drill_column_type'=>'Виды компонентов низа бурильной колонны:',
            'value'=>'Значение:'
        ],
        'well_zone'=>[
            'w_zone' => 'Зона скважины',
            'main' => 'Основное',
            'date_start'=>'Дата',
            'ch_zone' =>'Сменяемая зона',
            'new_zone' => 'Новая зона'
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