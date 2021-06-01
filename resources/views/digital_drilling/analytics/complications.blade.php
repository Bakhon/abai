@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle">Осложнения (проект/факт)</p>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tr>
                                <th colspan="2">Интервал бурения</th>
                                <th>Индекс стратиграфического подразделения</th>
                                <th colspan="2">Проходка, м</th>
                                <th colspan="2">Размер долта, м</th>
                                <th colspan="2">Удельный вес, г/см3 Вязкость по СПВ-5 в сек, Фильтрация см3/30 мин</th>
                                <th colspan="2">Вид осложнения</th>
                                <th>Характеристика фактического осложнения</th>
                            </tr>
                            <tr>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th></th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th></th>
                            </tr>
                            @for ($i = 0; $i < 15; $i++)
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