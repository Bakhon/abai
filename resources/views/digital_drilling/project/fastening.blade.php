@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Обсадные колонны: данные по ОК <i class="fas fa-chevron-down"></i>
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
                                <th rowspan="3">Номер колонны в порядке спуска</th>
                                <th rowspan="3">Номер раздельно спускаемой части колонны в порядке спуска</th>
                                <th rowspan="3">Номер равнопроч-ной секции труб в раздельно спускаемой части колонны (снизу-вверх)</th>
                                <th rowspan="2" colspan="2">Интервал установки расвнопрочной секции по стволу, м</th>
                                <th rowspan="3">Длина секции по стволу, м</th>
                                <th rowspan="3">Масса секции (в воздухе), т</th>
                                <th rowspan="3">Масса секции (в воздухе), т</th>
                                <th colspan="4" rowspan="1">Характеристика обсадной трубы</th>
                                <th colspan="3" rowspan="1">Коэффициенты запаса прочности при</th>
                            </tr>
                            <tr>
                                <th colspan="1" rowspan="2">Номинальный наружный диаметр, мм</th>
                                <th colspan="1" rowspan="2">Код типа соединения труб</th>
                                <th colspan="1" rowspan="2">Марка (группа прочности материала)</th>
                                <th colspan="1" rowspan="2">толщина стенки мм</th>
                                <th colspan="2" rowspan="1">избыточном давлении</th>
                                <th colspan="1" rowspan="2">Растяжении</th>
                            </tr>
                            <tr>
                                <th colspan="1" rowspan="1">от(верх)</th>
                                <th colspan="1" rowspan="1">до(низ)</th>
                                <th colspan="1">наружном</th>
                                <th colspan="1">внутреннем</th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= 15; $i++)
                                    <td>{{$i}}</td>
                                @endfor
                            </tr>
                            @for ($i = 0; $i < 20; $i++)
                                <tr>
                                    @for ($a = 0; $a < 15; $a++)
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