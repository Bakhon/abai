@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Крепление: цементирование <i class="fas fa-chevron-down"></i>
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
                                <th rowspan="2">Название колонны</th>
                                <th colspan="2">Глубина установки муфты для ступенчатого цементирования, м</th>
                                <th rowspan="2">Название порции тампонажного раствора</th>
                                <th colspan="2">Объем порции, м3</th>
                                <th colspan="2">ПВ, сПз</th>
                                <th colspan="2">Водоотдача, см3/30мин</th>
                                <th colspan="2">ДНС</th>
                                <th colspan="2">Время начала схватывания, мин.</th>
                                <th colspan="2">Время ОЗЦ</th>
                            </tr>
                            <tr>
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
                            <tr>
                                <td rowspan="5"></td>
                                <td rowspan="5"></td>
                                <td rowspan="5"></td>
                            </tr>
                            <tr>
                                <td class="blueTd">Буферный</td>
                                @for ($a = 0; $a < 12; $a++)
                                    <td></td>
                                @endfor
                            </tr>
                            <tr>
                                <td class="blueTd">Тампонажный 1</td>
                                @for ($a = 0; $a < 12; $a++)
                                    <td></td>
                                @endfor
                            </tr>
                            <tr>
                                <td class="blueTd">Тампонажный 2</td>
                                @for ($a = 0; $a < 12; $a++)
                                    <td></td>
                                @endfor
                            </tr>
                            <tr>
                                <td class="blueTd">Продавочный</td>
                                @for ($a = 0; $a < 12; $a++)
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