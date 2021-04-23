@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Крепление</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Обсадные колонны: Режим спуска <i class="fas fa-chevron-down"></i>
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
                                <th rowspan="3">Название колонны</th>
                                <th rowspan="3">Номер части колонны в порядке спуска</th>
                                <th rowspan="3">Тип, шифр инструмента для спуска (элеватор, спайдер-элеватор)</th>
                                <th colspan="2">Средства смазки и уплотнения резьбовых соединений</th>
                                <th rowspan="3">Расход смазки, кг</th>
                                <th colspan="2" rowspan="2">Интервал глубины с одинаковой допустимой скоростью спуска труб, м</th>
                                <th rowspan="3">Допустимая скорость спуска труб, м/c</th>
                                <th rowspan="3">Допустимая глубина спуска труб, м/с спуска труб, м/c</th>
                                <th rowspan="3">Периодич-ность долива колонны, м</th>
                                <th colspan="3">Промежуточные промывки</th>
                            </tr>
                            <tr>
                                <th colspan="1" rowspan="2">шифр или название</th>
                                <th colspan="1" rowspan="2">ГОСТ, ОСТ, МРТУ, ТУ, МУ и т.п. на изготовление</th>
                                <th colspan="1" rowspan="2">глубина, м</th>
                                <th colspan="1" rowspan="2">продолжительность, мин.</th>
                                <th colspan="1" rowspan="2">расход, л/c</th>
                            </tr>
                            <tr>
                                <th colspan="1" rowspan="1">от (верх)</th>
                                <th colspan="1" rowspan="1">до (низ)</th>
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
                                <td>14</td>
                                <td>15</td>
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