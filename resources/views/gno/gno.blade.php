@extends('layouts.app')
@section('content')
{{-- content --}}
<!--<div class="p-4" id="app">
   <h2 class="subtitle">ГНО</h2>
    <div class="level1-content row">-->
<div class="main col-md-12 col-lg-12 row">
    <div class="tables-one col-xs-12 col-sm-5  col-md-5 col-lg-3 col-xl-2">
        <div class="tables-string-gno col-12">
            <div class="select-well col-12">Выбор скважины</div>
            <div class="cell4-gno col-7">Месторождение</div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">Узень</div>

            <div class="cell4-gno table-border-gno-top col-7">Скважина №</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">6550</div>

            <div class="cell4-gno table-border-gno-top col-7">Пласт</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">14Осн</div>

            <div class="cell4-gno table-border-gno-top col-7">Новая скважина</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">с ГРП</div>

            <div class="cell4-gno table-border-gno-top col-7">ЦДНГ-13</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">ГУ-101</div>

            <div class="cell4-gno table-border-gno-top col-7">НГДУ-1</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">АО «ОМГ»</div>
        </div>
        <div class="tables-string-gno">
            <div class="select-well col-12">Конструкция</div>
            <div class="cell4-gno col-7">Наружн. ØЭК</div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">168 мм</div>

            <div class="cell4-gno table-border-gno-top col-7">Внутрен. ØЭК</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">150 мм</div>

            <div class="cell4-gno table-border-gno-top col-7">Нперф.(ВДП MD)</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">1352 м</div>

            <div class="cell4-gno table-border-gno-top col-7">Удл. на Нперф.</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">4 м</div>

            <div class="cell4-gno table-border-gno-top col-7">Текущий забой</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">1369 м</div>
            <div class="select-well col-12">Инклинометрия</div>
        </div>

        <div class="tables-string-gno1">
            <select class="select-gno">
                <option value="" hidden>Оборудование</option>
                <option>Арбуз</option>
                <option>Длинный-предлинный пункт</option>
                <option>Дыня</option>
                <option>Тыква</option>
            </select></div>
        <div class="tables-string-gno1"><select class="select-gno">
                <option value="" hidden>PVT</option>
                <option>Арбуз</option>
                <option>Длинный-предлинный пункт</option>
                <option>Дыня</option>
                <option>Тыква</option>
            </select></div>

        <div class="tables-string-gno2">
            <div class="select-well col-12">Технологический режим</div>
            <div class="cell4-gno col-7">Qж</div>
            <div class="cell4-gno table-border-gno cell4-gno-second col-5">55 м3/сут</div>

            <div class="cell4-gno table-border-gno-top col-7">Qж</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">10 т/сут</div>

            <div class="cell4-gno table-border-gno-top col-7">Обв.</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">82 %</div>

            <div class="cell4-gno table-border-gno-top col-7">Рзаб</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">68 ат</div>

            <div class="cell4-gno table-border-gno-top col-7">Рпл</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">124 ат</div>


            <div class="cell4-gno table-border-gno-top col-7">Ндин</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">658</div>
            <div class="cell4-gno table-border-gno-top col-7">Рзат</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">4 ат</div>
            <div class="cell4-gno table-border-gno-top col-7">Рбуф</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">4 ат</div>
            <div class="cell4-gno table-border-gno-top col-7">Рлин</div>
            <div class="cell4-gno table-border-gno table-border-gno-top cell4-gno-second col-5">4 ат</div>
        </div>
    </div>
    <div class="tables-two col-xs-12 col-sm-7  col-md-7 col-lg-8 col-xl-10">
        <div class="tables-string-gno3"></div>

        <div class="tables-string-gno4 col-6">
            <div class="select-well">Настройка кривой притока</div>
        </div>
        <div class="tables-string-gno44 col-6">
            <div class="select-well">Параметры подбора</div>
        </div>

        <div class="tables-string-gno5 col-xs-12 col-sm-12  col-md-12 col-lg-12 col-xl-6">
            Анализ потенциала скважины
        </div>

        <div class="tables-string-gno55 col-xs-12 col-sm-12  col-md-12 col-lg-12 col-xl-6">
            Анализ эффективности способа эксплуатации
        </div>


        <div class="tables-string-gno6 col-12">
            Подбор ГНО
        </div>

    </div>

    <!--<div class="tables-string-gno13">Анализ эффективности способа эксплуатации</div>
        </div>
    </div>-->
</div>
@endsection
<link href="{{ asset('/css/gno.css')}}" rel="stylesheet">
