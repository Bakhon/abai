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
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>6</td>
                                <td>7</td>
                                <td>8</td>
                                <td>9</td>
                                <td>10</td>
                                <td>11</td>
                                <td>12</td>
                            </tr>
                            @for ($i = 0; $i < 20; $i++)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endfor
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection