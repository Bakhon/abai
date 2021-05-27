@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Цементирование: Компонентный состав <i class="fas fa-chevron-down"></i>
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
                                <th colspan="1">Номер колонны в порядке спуска</th>
                                <th colspan="1">Название колонны</th>
                                <th colspan="1">Номер колонны в порядке спуска</th>
                                <th colspan="1">Номер ступени (снизу-вверх)</th>
                                <th colspan="1">Тип или название жидкости для цементирования</th>
                                <th colspan="1">Название компонента</th>
                                <th colspan="1" class="verticalText"><span>Пластическая вязкость, сПз</span></th>
                                <th colspan="1" class="verticalText"><span>Пластическая вязкость, сПз</span></th>
                                <th colspan="1">Сорт</th>
                                <th colspan="1">ГОСТ, ОСТ, МРТУ, ТУ, МУ и т.п. на изготовление</th>
                                <th colspan="1">Норма расхода компонента кг/м3</th>
                            </tr>
                            <tr>
                                @for ($i = 1; $i <= 11; $i++)
                                    <td>{{$i}}</td>
                                @endfor
                            </tr>
                            @for ($i = 0; $i < 20; $i++)
                                <tr>
                                    @for ($a = 0; $a < 11; $a++)
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