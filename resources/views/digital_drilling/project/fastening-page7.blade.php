@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Цементирование: Компонентный состав <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening') }}">Обсадные колонны: Данные по ОК</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page2') }}">Обсадные колонны: Режим спуска</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page3') }}">Обсадные колонны: Опрессовка и натяжение ОК</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page4') }}">Обсадные колонны: Эпюры избыточных давлений</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page5') }}">Цементирование: Характеристики жидкостей</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page6') }}">Цементирование: Компонентный состав</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-fastening-page7') }}">Цементирование: Технологические операции</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tr>
                                <th rowspan="3" class="verticalText"><span>Номер колонны в порядке спуска</span></th>
                                <th rowspan="3" class="verticalText"><span>Номер  части колонны в порядке спуска</span></th>
                                <th rowspan="3" class="verticalText"><span>Номер ступени цементирования (снизу-вверх)</span></th>
                                <th rowspan="3">Наименование технологической операции</th>
                                <th rowspan="3">Тип или название жидкости</th>
                                <th rowspan="3">Тип (шифр) агрегата или бурового насоса</th>
                                <th rowspan="3">Назначение агрегата или бурового насоса</th>
                                <th rowspan="3" class="verticalText"><span>Количество агрегатов (буровых насосов),работающих на одном режиме</span></th>
                                <th colspan="6">Режим работы агрегатов (буровых) насосов</th>
                                <th colspan="2" rowspan="2">Время выполнения технологической операции, мин</th>
                            </tr>
                            <tr>
                                <th class="verticalText" rowspan="2"><span>диаметр цилиндровых втулок, мм</span></th>
                                <th class="verticalText" rowspan="2"><span>скорость агрегата или число двойных ходов бурового насоса</span></th>
                                <th class="verticalText" rowspan="2"><span>суммарная производительность агрегатов (бурового насосов), л/с</span></th>
                                <th colspan="2">давление, кгс/см2</th>
                                <th class="verticalText" rowspan="2">объем порции на данном режиме<span></span></th>
                            </tr>
                            <tr>
                                <th class="verticalText"><span>допустимое для агрегатов (буровых  насосов)</span></th>
                                <th class="verticalText"><span>на устье скважины в конце операции</span></th>
                                <th class="verticalText"><span>в данном режиме</span></th>
                                <th class="verticalText"><span>нарастающее от начала затворения до момента «стоп»</span></th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= 16; $i++)
                                    <td>{{$i}}</td>
                                @endfor
                            </tr>
                            @for ($i = 0; $i < 20; $i++)
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
<style>
    th.verticalText {
        max-width: 100px;
    }

    th.verticalText span {
        width: 140px;
        margin-left: -40px;
    }
</style>