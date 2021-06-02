@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Крепление: обсадные колонны <i class="fas fa-chevron-down"></i>
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
                                <th colspan="2">Номинальный наружный диаметр, мм</th>
                                <th colspan="2">Глубина установки, м</th>
                                <th colspan="2">Длина секции, м</th>
                                <th colspan="2">Нарастающая масса, тн.</th>
                                <th colspan="2">Марка (группа прочности) материала труб</th>
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