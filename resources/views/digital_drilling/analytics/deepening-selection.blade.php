@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Отбор керна <i class="fas fa-chevron-down"></i>
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
                                <th colspan="4">Индекс стратиграфического разреза</th>
                                <th colspan="2">Отбор керна, м.</th>
                                <th colspan="4">Интервал залегания</th>
                            </tr>
                            <tr>
                                <th colspan="2">Проект</th>
                                <th colspan="2">Факт</th>
                                <th rowspan="2">Проект</th>
                                <th rowspan="2">Факт</th>
                                <th colspan="2">Проект</th>
                                <th colspan="2">Факт</th>
                            </tr>
                            <tr>
                                <th>От (верх)</th>
                                <th>До (низ)</th>
                                <th>От (верх)</th>
                                <th>До (низ)</th>
                                <th>От (верх)</th>
                                <th>До (низ)</th>
                                <th>От (верх)</th>
                                <th>До (низ)</th>
                            </tr>
                            @for ($i = 0; $i < 15; $i++)
                                <tr>
                                    @for ($a = 0; $a < 10; $a++)
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