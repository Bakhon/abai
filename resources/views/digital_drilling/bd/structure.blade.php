@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Конструкция скважины</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Табличные данные <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-structure-graph') }}">Визуализация</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable">
                            <tr>
                                <th>Вид обсадной трубы</th>
                                <th>Вид колонны</th>
                                <th>Интервал спуска колонны от</th>
                                <th>Интервал спуска колонны до</th>
                                <th>Боковой ствол</th>
                                <th>Количество труб</th>
                                <th>Объем залитого цемента</th>
                                <th>Высота подъема цемента</th>
                                <th>Пакер от</th>
                                <th>Пакер до</th>
                                <th>Глубина спуска колонны</th>
                                <th>Пакер</th>
                            </tr>
                            <tr>
                                <td>Условный диаметр трубы (мм): 245.0, Условный диаметр: 245.0, Группа прочности: </td>
                                <td>Кондуктор</td>
                                <td></td>
                                <td></td>
                                <td>0</td>
                                <td>42</td>
                                <td></td>
                                <td>0</td>
                                <td></td>
                                <td></td>
                                <td>437</td>
                                <td></td>
                            </tr>
                            @for ($i = 0; $i < 10; $i++)
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