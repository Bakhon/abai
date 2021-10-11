@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle">ГИС в открытом стволе</p>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable gisTable">
                            <tr>
                                <th></th>
                                <th>Радиоактивный каротаж</th>
                                <th>Интервальные времена</th>
                                <th>Сжимаемость</th>
                                <th>Кн (Сопр.)</th>
                                <th>Кн (Акуст.)</th>
                            </tr>
                            <tr>
                                <td><p>Глубина</p></td>
                                <td>
                                    <p class="inter red"><span class="first">U</span>ГК <i>гамма</i><span class="second">12</span></p>
                                    <p class="inter blue"><span class="first">1</span>НК <i>усп.ед.</i><span class="second">5</span></p>
                                </td>
                                <td>
                                    <p class="inter red"><span class="first">180</span>dtp <i>мкс/м</i><span class="second">280</span></p>
                                    <p class="inter blue"><span class="first">300</span>dts <i>мкс/м</i><span class="second">500</span></p>
                                </td>
                                <td>
                                    <p class="inter orange"><span class="first">2</span>Rn <i class="bold"></i><span class="second">0</span></p>
                                </td>
                                <td>
                                    <p>
                                        Заключение по ИК<br>
                                        21.09.94</p>
                                    <p class="inter red"><span class="first">0</span>Кн <i class="bold"></i><span class="second">1</span></p>
                                </td>
                                <td>
                                    <p>
                                        Заключение по RAK<br>
                                        05.12.96
                                    </p>
                                    <p class="inter red"><span class="first">0</span>Кн <i class="bold"></i><span class="second">1</span></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="graphText">1 800</p>
                                    <p class="graphText">1 802</p>
                                    <p class="graphText">1 004</p>
                                    <p class="graphText">1 806</p>
                                    <p class="graphText">1 808</p>
                                    <p class="graphText">1 010</p>
                                    <p class="graphText">1 812</p>
                                    <p class="graphText">1 014</p>
                                    <p class="graphText">1 816</p>
                                    <p class="graphText">1 818</p>
                                    <p class="graphText">1 020</p>
                                    <p class="graphText">1 822</p>
                                    <p class="graphText">1 824</p>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection