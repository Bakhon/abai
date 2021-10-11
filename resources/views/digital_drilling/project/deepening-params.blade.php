@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление скважины</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Параметры и режимы бурения <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-deepening-graph') }}">Визуализация</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-deepening') }}">Подбор КНБК</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tr>
                                <th colspan="2">Интервал, м</th>
                                <th rowspan="2">Вид технологической операции (бурение, отбор керна, расширка, проработка)</th>
                                <th rowspan="2">Способ бурения</th>
                                <th rowspan="2">Условный номер КНБК</th>
                                <th colspan="3">Режим бурения</th>
                                <th rowspan="2">Скорость выполнения технологической операции, м/час</th>
                            </tr>
                            <tr>
                                <th colspan="1">от (верх)</th>
                                <th colspan="1">до (низ)</th>
                                <th colspan="1">осевая нагрузка, тс</th>
                                <th colspan="1">скорость вращения, об/мин</th>
                                <th colspan="1">расход бурового раствора, л/с</th>
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
                                </tr>
                            @endfor
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection