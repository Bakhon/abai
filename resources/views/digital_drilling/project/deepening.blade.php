@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление скважины</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Подбор КНБК <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-deepening-graph') }}">Визуализация</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-deepening-params') }}">Параметры и режимы бурения</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tr>
                                <th rowspan="3" class="verticalText"><span>Условный номер КНБК</span></th>
                                <th colspan="11">ЭЛЕМЕНТЫ КНБК (до бурильных труб)</th>
                            </tr>
                            <tr>
                                <th rowspan="2" class="verticalText"><span>№ по порядку</span></th>
                                <th rowspan="2">Типоразмер, шифр или краткое название элемента КНБК (код по IADC)</th>
                                <th rowspan="2">Расстояние от забоя до места установки</th>
                                <th colspan="5">Техническая характеристика</th>
                                <th rowspan="2">Суммарная длина КНБК, м</th>
                                <th rowspan="2">Суммарная масса КНБК, т</th>
                                <th rowspan="2">Примечание</th>
                            </tr>
                            <tr>
                                <th colspan="1">Наружный диаметр, мм</th>
                                <th colspan="1">Диаметр проходного сечения, мм</th>
                                <th colspan="1">Длина, м</th>
                                <th colspan="1">Масса, кг</th>
                                <th colspan="1">Угол перекоса осей отклонителя, град.</th>
                            </tr>
                            <tr>
                                @for ($a = 1; $a <= 12; $a++)
                                    <td>{{$a}}</td>
                                @endfor
                            </tr>
                            @for ($i = 0; $i < 20; $i++)
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