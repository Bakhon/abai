@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Цементирование: Характеристики жидкостей <i class="fas fa-chevron-down"></i>
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
                                <th rowspan="2">Номер части колонны в порядке спуска</th>
                                <th rowspan="2">Номер ступени (снизу-вверх)</th>
                                <th colspan="8">Характеристика жидкости (раствора)</th>
                            </tr>
                            <tr>
                                <th colspan="1">Тип или название</th>
                                <th colspan="1">Объем порции, м3</th>
                                <th colspan="1">Плотность, кг/м3</th>
                                <th class="verticalText"><span>Пластическая вязкость, сПз</span></th>
                                <th class="verticalText"><span>Динамическое напряжение сдвига, мгс/см2</span></th>
                                <th class="verticalText"><span>Время начала схватывания, мин.</span></th>
                                <th class="verticalText"><span>Время ОЗЦ, час</span></th>
                                <th class="verticalText"><span>Производительность при затворении, л/сек.</span></th>
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