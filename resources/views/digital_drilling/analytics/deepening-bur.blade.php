@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Буровые растворы: параметры и комп.состав <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-inclino') }}">Профиль скважины: инклинометрия</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-visual') }}">Профиль скважины: визуализация</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-knbk') }}">КНБК</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-params') }}">Параметры режимов</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-bur') }}">Буровые растворы: параметры и комп.состав</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-gidro') }}">Буровые растворы: Гидравлика - распределение потерь давления в цирк.системе</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-sorting') }}">Буровые растворы: распределение потерь давления на долоте</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-selection') }}">Отбор керна</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tr>
                                <th rowspan="3">Наименование секции ОК (диаметр, мм.)</th>
                                <th colspan="4">Интервал бурения, м.</th>
                                <th colspan="2">Название (тип) раствора</th>
                                <th colspan="4">Параметры бурового растрова</th>
                            </tr>
                            <tr>
                                <th colspan="2">Проект</th>
                                <th colspan="2">Факт</th>
                                <th rowspan="2">Проект</th>
                                <th rowspan="2">Факт</th>
                                <th rowspan="2"></th>
                                <th rowspan="2"></th>
                                <th rowspan="2"></th>
                                <th rowspan="2"></th>
                            </tr>
                            <tr>
                                <th>От (верх)</th>
                                <th>До (низ)</th>
                                <th>От (верх)</th>
                                <th>До (низ)</th>
                            </tr>
                                <tr>
                                    <td class="blueTd">Направления</td>
                                    @for ($a = 0; $a < 10; $a++)
                                        <td></td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td class="blueTd">Кондуктор</td>
                                    @for ($a = 0; $a < 10; $a++)
                                        <td></td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td class="blueTd">Промежуточная колонна</td>
                                    @for ($a = 0; $a < 10; $a++)
                                        <td></td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td class="blueTd">Эксплуатационная колонна</td>
                                    @for ($a = 0; $a < 10; $a++)
                                        <td></td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td class="blueTd">Потойная колонна/хвостовик</td>
                                    @for ($a = 0; $a < 10; $a++)
                                        <td></td>
                                    @endfor
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection