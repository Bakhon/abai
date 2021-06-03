@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Крепление: гидравлика <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-fastening-first') }}">Крепление: обсадные колонны</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-fastening-second') }}">Крепление: цементирование</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-analytics-fastening-third') }}">Крепление: гидравлика</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tr>
                               <th rowspan="3">Номер колонны в порядке спуска</th>
                               <th rowspan="3">Номер части колонны в порядке спуска, (см. таб. 1.5.2, гр.8)</th>
                               <th rowspan="3">Номер ступени цементирования (снизу - вверх)</th>
                               <th rowspan="3">Наименование технологической операции</th>
                               <th rowspan="3">Тип или название жидкости</th>
                               <th rowspan="3">Тип (шифр) агрегата или бурового насоса</th>
                               <th rowspan="3">Назначение агрегата или бурового насоса</th>
                               <th rowspan="3">Количество агрегатов (буровых насосов), работающих на одном режиме</th>
                               <th colspan="6">Режим работы агрегатов (буровых) насосов</th>
                               <th colspan="2" rowspan="2">Время выполнения технологической операции, мин</th>
                            </tr>
                            <tr>
                                <th rowspan="2">Диаметр цилиндровых втулок, мм.</th>
                                <th rowspan="2">Скорость агрегата или число двойных ходов бурового насоса</th>
                                <th rowspan="2">Суммарная производительность агрегатов (бурового насосов), л/с</th>
                                <th colspan="2">Давление, кгс/см2</th>
                                <th rowspan="2">Объем порции на данном режиме</th>
                            </tr>
                            <tr>
                                <th>Допустимое для агрегатов (буровых насосов)</th>
                                <th>На устье скважины в конце операции</th>
                                <th>В данном режиме</th>
                                <th>Нарастающее от начала затворения до момента "стоп"</th>
                            </tr>
                            <tr>
                                @for ($a = 1; $a <= 16; $a++)
                                    <td>{{ $a }}</td>
                                @endfor
                            </tr>
                            @for ($i = 0; $i < 15; $i++)
                                <tr>
                                    @for ($a = 0; $a < 16; $a++)
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