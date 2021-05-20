@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        КНБК <i class="fas fa-chevron-down"></i>
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
                                <th colspan="2">Индекс горной породы</th>
                                <th colspan="2">Плотность горной породы, кг/м3</th>
                                <th colspan="2">Угол падения пласта, град.</th>
                                <th colspan="2">Коэффицент кавернозности</th>
                                <th colspan="2">КНБК (каталог)</th>
                                <th colspan="2">Механическая скорость бурения, м/ч (факт.)</th>
                            </tr>
                            <tr class="blue">
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
                            @for ($i = 0; $i < 10; $i++)
                                <tr>
                                    @for ($a = 0; $a < 12; $a++)
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