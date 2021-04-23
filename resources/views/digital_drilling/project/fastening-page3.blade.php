@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Обсадные колонны: Опрессовка и натяжение ОК <i class="fas fa-chevron-down"></i>
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
                                <th rowspan="2">Номер колонны в порядке спуска</th>
                                <th rowspan="2">Название колонны</th>
                                <th rowspan="2">Номер раздельно спускаемой части колонны в порядке спуска</th>
                                <th rowspan="2">Натяжение эксплуатационной колонны, тс</th>
                                <th colspan="2">Плотность жидкости для опрессовки, кг/м3</th>
                                <th colspan="3">Давление на устье скважины при опресссовке, МПа</th>
                                <th rowspan="2">Глубина установки пакера, м</th>
                                <th rowspan="2">Давление на устье скважины при оперссовке труб ниже пакера, МПа</th>
                                <th rowspan="2">Номер равнопрочной секции труб в раздельно спускаемой части</th>
                                <th rowspan="2">Давление опрессовки труб равнопрочной секции на поверхности, МПа</th>
                            </tr>
                            <tr>
                                <th colspan="1">раздельно спускаемой части</th>
                                <th colspan="1">Цементного кольца</th>
                                <th colspan="1">Раздельно спускаемой части</th>
                                <th colspan="1">Цементного кольца</th>
                                <th colspan="1">Части колонны ниже муфты для 2х ступ. цементирования</th>
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
                                <td>13</td>
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