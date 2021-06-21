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
    'select_ngdu' => 'Выберите НГДУ из списка',
    'nothing_found' => 'Ничего не найдено',
    'actions' => 'Действия',
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
            'Planned_events_tech_modes' => 'Намечаемые мероприятия',
            'event' => 'Мероприятие',
            'planned_month' => 'Планируемый месяц'
        ],
        'kpc' => [
            'request_date' => 'Дата подачи заявки',
            'planned_date' => 'Ожидаемая дата проведения',
            'work_type' => 'Вид работ',
            'gtm_type' => 'Вид ГТМ',
            'planing_work_list' => 'Список планируемых работ',
            'repair' => 'Ремонт',
            'request' => 'Заявка',
            'delivery_certificate_for_repair' => 'Акт сдачи в ремонт',
            'acceptance_certificate_from_repair' => 'Акт приема из ремонта',
            'rejection_reason' => 'Причина отказа',
            'work_start_date' => 'Дата начала работ',
            'repair_work_type' => 'Вид ремонтных работ',
            'planned_works_list' => 'Список планируемых работ',
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
            'actual_bottomhole_m' => 'Фактический забой, м',
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
            'stopping_reason' => 'Причина остановки'
        ],
        'injection_wells' => [
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
        'gtm_register' => [
            'Gtm_start' => 'Начало ГТМ',
            'date_gtm_start' => 'Дата начала ГТМ',
            'gtm_name' => 'Наименование ГТМ',
            'new_technologies' => 'Новые технологии',
            'own_forces' => 'Собственными силами',
            'contractor' => 'Подрядчик',
            'Gtm_end' => 'Окончание ГТМ',
            'date_gtm_end' => 'Дата окончания ГТМ',
            'gtm_parameters_results' => 'Параметры ГТМ/результаты',
            'well_previous_status' => 'Статус до выбранной даты',
            'well_previous_category' => 'Категория до выбранной даты',
            'well_current_status' => 'Новое состояние',
            'status' => 'Состояние'
        ],
        'well_design' => [
            "well_design_project" => "Проект конструкции скважины",
            "column_type" => "Вид колонны",
            "casing_running_depth" => "Глубина спуска колонны",
            "side_barrel" => "Боковой ствол",
            "casing_type" => "Вид обсадной трубы",
            "number_of_pipes" => "Количество труб",
            "poured_cement_volume" => "Объем залитого цемента",
            "cement_lifting_height" => "Высота подъема цемента",
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
            'new_condition' => 'Новое состояние',
            'dublicate_to_gtm' => 'Дублировать в ГТМ',
            'by_your_own' => 'Дублировать в ГТМ',
            'owt_of_plan' => 'Вне плана',
            'do_not_chenge_teckh_condition' => 'Не менять техническое состояние',
            'do_not_chenge_condition' => 'Не менять состояние'
        ],
        'gas_well' => [
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
        ],
        'well_constr' => [
            "well_constructor" => "Конструкция скважины",
            "column_type" => "Вид колонны",
            "casing_running_depth" => "Глубина спуска колонны",
            "side_barrel" => "Боковой ствол",
            "casing_type" => "Вид обсадной трубы",
            "number_of_pipes" => "Количество труб",
            "poured_cement_volume" => "Объем залитого цемента",
            "cement_lifting_height" => "Высота подъема цемента",
            "landing_date" => "Дата спуска"
        ],
        'tech_state' => [
            'main' => 'Основное',
            'date_start' => 'Дата начала',
            'old_state' => 'Сменяемое техническое состояние',
            'current_category' => 'Категория на дату',
            'state' => 'Техническое состояние скважины',
        ],
        'bottom_hole' => [
            'main' => 'Основное',
            'data' => 'Дата отбивки',
            'bottom_h' =>'Фактический забой',
            'comment' => 'Примечание',
            'bottom_h_m' => 'Фактический забой, м'
        ],
        'well_block' => [
            'w_block' => 'Блок скважины',
            'main' => 'Основное',
            'date' => 'Дата',
            'ch_block' => 'Сменяемый блок',
            'new_block' => 'Новый блок'
        ],
        'recording_method' => [
            'menu' => 'Наименование технологии записи',
            'title' => 'Справочник наименование технологии записи',
            'fields' => [
                'name' => 'Наименование технологии записи',
            ],
            'show_title' => 'Данные по наименовании технологии записи',
            'edit_title' => 'Редактирование наименования технологии записи',
            'create_title' => 'Ввод данных по наименованию технологии записи',
        ],
        'recording_state' => [
            'menu' => 'Справочник статус записи',
            'title' => 'Справочник статус записи',
            'fields' => [
                'name' => 'Статус записи',
            ],
            'show_title' => 'Данные по статусу записи',
            'edit_title' => 'Редактирование статуса записи',
            'create_title' => 'Ввод данных по статусу записи',
        ],
        'stem_section' => [
            'menu' => 'Справочник cекция ствола',
            'title' => 'Справочник cекция ствола',
            'fields' => [
                'name' => 'Секция ствола',
            ],
            'show_title' => 'Данные по секции ствола',
            'edit_title' => 'Редактирование cекции ствола',
            'create_title' => 'Ввод данных по секции ствола',
        ],
        'stem_type' => [
            'menu' => 'Справочник тип ствола',
            'title' => 'Справочник тип ствола',
            'fields' => [
                'name' => 'Тип ствола',
            ],
            'show_title' => 'Данные по типу ствола',
            'edit_title' => 'Редактирование типа ствола',
            'create_title' => 'Ввод данных по типу ствола',
        ],
        'file_type' => [
            'menu' => 'Справочник тип файла',
            'title' => 'Справочник тип файла',
            'fields' => [
                'name' => 'Тип Файла',
            ],
            'show_title' => 'Данные по типу файла',
            'edit_title' => 'Редактирование типа файла',
            'create_title' => 'Ввод данных по типу файла',
        ],
        'file_status' => [
            'menu' => 'Справочник cтатус обработки',
            'title' => 'Справочник cтатус обработки',
            'fields' => [
                'name' => 'Статус обработки',
            ],
            'show_title' => 'Данные по статусу обработки',
            'edit_title' => 'Редактирование статуса обработки',
            'create_title' => 'Ввод данных по статусу обработки'            
        ],
        'bottom_hole_artificial' => [
            'b_hole' => 'Искусственный забой',
            'main' => 'Основное',
            'data' => 'Дата',
            'b_hole_m' => 'Искусственный забой, м'
        ],
        'gis' => [
            'title' => 'Гис в открытом стволе',
            'main' => 'Основное',
            'data' => 'Дата и время проведения ГИС',
            'podr' => 'Подрядчик',
            'intr_ot' => 'Интервал замера, от',
            'intr_do' => 'Интервал замера, до',
            'intr_obr_ot' => 'Интервал обработки, от',
            'intr_obr_do' => 'Интервал обработки, до',
            'zakl'=> 'Заключение от подрядчика'
        ],
        'well_incl' => [
            'title' => 'Инклинометрия скважины',
            'device' => 'Прибор',
            'main' => 'Общие сведения',
            'date' => 'Дата',
            'identifier' => 'Географический идентификатор',
            'deep' => 'Истинная глубина по вертикали'
        ],
        'well_register' => [
            'main' => 'Основное',
            'title' => 'Скважина',
            'orgs' => 'Оргструктура',
            'geo_s' => 'Геоструктура',
            'numb' => 'Номер скважины',
            'data' => 'Дата создания проекта',
            'cat_well' => 'Категория скважины',
            'sv_well' => 'Свойства скважины',
            'alt' => 'Альтитуда',
            'alt_h' => 'Превышение стола ротора',
            'coord' => 'Координатная система',
            'coord_x' => 'Координаты устья X',
            'coord_y' => 'Координаты устья Y',
            'well_t' => 'Вид скважины',
            'coord_x_p' => 'Координаты забоя X',
            'coord_y_p' => 'Координаты забоя Y',
            'str_date' => 'Дата начала бурения',
            'end_date' => 'Дата окончания бурения',
            'podr' => 'Подрядчик',
            'nom_dog' => 'Номер договора',
            'data_dog' => 'Дата договора',
            'depth' => 'Проектная глубина, м',
            'gas_f' => 'Средний газовый фактор',
            'title2' => 'Проект бурения'
        ],
        'water_inj' => [
            'uwi_number' => 'Скважина',
            'worktime' => 'Отработанное время',
            'water_inj_v' => 'Приемистость, м3/сут',
            'volume' => 'Объем закачки, м3',
            'agent_type' => 'Вид агента',
            'agent_temp' => 'Температура агента',
            'pressure' => 'Давление закачки (атм)',
            'comment' => 'Примечание',
            'data' => 'Дата',
            'water_inj' => 'Закачка воды'
        ],
        'production_program' => [
            'oil_production' => 'Добыча нефти (т)',
            'water_injection' => 'Закачка воды (м3)',
            'water_production' => 'Добыча воды (м3)',
            'liquid_production' => 'Добыча жидкости (м3)',
            'oil_injection' => 'Сдача нефти (т)',
            'gas_production' => 'Добыча газа (м3)',
            'steam_injection' => 'Закачка пара (м3)',
            'absorption' => 'Поглощение',
            'date' => 'Дата с',
            'date_to' => 'Дата по',
            'select_ngdu' => 'Выберите НГДУ'
        ]
    ],
    'list' => 'Просмотр списка',
    'create' => 'Создание',
    'read' => 'Просмотр',
    'update' => 'Изменение',
    'delete' => 'Удаление',
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
