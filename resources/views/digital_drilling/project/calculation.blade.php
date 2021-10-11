@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Расчет Конструкции</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Подбор ОК(каталог) <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-calculation-graph') }}">График совмещенных давлений</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable ">
                            <tr>
                                <th rowspan="2">Наружный диаметр обсадной трубы</th>
                                <th colspan="2">Толщина стенки</th>
                                <th colspan="2">Диапазон варьирования внутреннего диаметра</th>
                                <th colspan="2">Наружный диаметр соединительной муфты</th>
                                <th rowspan="2">Толщина стенок обсадной трубы</th>
                            </tr>
                            <tr>
                                <th>минимальная</th>
                                <th>максимальная</th>
                                <th>минимальная</th>
                                <th>максимальная</th>
                                <th>минимальная</th>
                                <th>максимальная</th>
                            </tr>
                            @for ($i = 0; $i < 20; $i++)
                                <tr>
                                    <td>114,3</td>
                                    <td>5,2</td>
                                    <td>10,2</td>
                                    <td>103,9</td>
                                    <td>93,9</td>
                                    <td>127,0 (133,0)</td>
                                    <td>123,8</td>
                                    <td>5,2; 5,7; 6,4; 7,4; 8,6; 10,2</td>
                                </tr>
                            @endfor
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection