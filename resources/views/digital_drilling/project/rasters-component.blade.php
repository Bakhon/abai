@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Буровые растворы</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Компонентный состав БР<i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-rasters') }}">Геологические данные</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-rasters-params') }}">Параметры БР</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tr>
                                <th rowspan="2">Номер интервала с одинаковым долевым составом бурового раствора</th>
                                <th colspan="2">Интервал (по стволу), м</th>
                                <th rowspan="2">Название (тип) раствора</th>
                                <th rowspan="2">Плотность раствора, кг/м3</th>
                                <th rowspan="2">Смена раствора для бурения интервала (да, нет)</th>
                                <th rowspan="2">Название компонента</th>
                                <th rowspan="2">Плотность кг/м3</th>
                                <th rowspan="2">Содержание вещества в товарном продукте (жидкости), %</th>
                                <th rowspan="2" class="verticalText"><span>Влажность, %</span></th>
                                <th rowspan="2">Сорт</th>
                                <th rowspan="2">Содержание компонента в буровом растворе, кг/м3</th>
                            </tr>
                            <tr>
                                <th colspan="1">От (верх)</th>
                                <th colspan="1">До (низ)</th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= 12; $i++)
                                    <td>{{$i}}</td>
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