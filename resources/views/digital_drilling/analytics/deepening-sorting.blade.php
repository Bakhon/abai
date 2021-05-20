@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Буровые растворы: распределение потерь давления на долоте <i class="fas fa-chevron-down"></i>
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
                                <th rowspan="2" colspan="2">Интервал, м.</th>
                                <th rowspan="3">Вид Технологической операции</th>
                                <th rowspan="2" colspan="2">Наименьшая скорость восходящего потока в открытом стволе, м/</th>
                                <th colspan="2">Потери давлений (кгс/см2) в интервалах:</th>
                                <th rowspan="2" colspan="2">Схема промывки долота (центральная, периферийная, комбинированная)</th>
                                <th colspan="4">Гидро-мониторные насадки</th>
                                <th rowspan="2" colspan="2">Скорость истечения, м/с</th>
                                <th rowspan="2" colspan="2">Мощность срабатываемая на долоте, квт.</th>
                            </tr>
                            <tr>
                                <th colspan="2">Удельный расход, л/c.см2</th>
                                <th colspan="2">Количество, шт</th>
                                <th colspan="2">Диаметр, мм</th>
                            </tr>
                            <tr>
                                <th>От (верх)</th>
                                <th>До (низ)</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                            </tr>
                            @for ($i = 0; $i < 5; $i++)
                                <tr>
                                    @for ($a = 0; $a < 17; $a++)
                                        <td></td>
                                    @endfor
                                </tr>
                            @endfor
                            <tr>
                                <th colspan="17">Резервный вариант</th>
                            </tr>
                            @for ($i = 0; $i < 10; $i++)
                                <tr>
                                    @for ($a = 0; $a < 17; $a++)
                                        <td></td>
                                    @endfor
                                </tr>
                            @endfor
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection