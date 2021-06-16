@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle">ALARM оповещения</p>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable">
                            <tr>
                                <th>Глубина по стволу, м</th>
                                <th>Значение</th>
                                <th>План</th>
                                <th>Факт</th>
                                <th>Отклонение</th>
                            </tr>
                            <tr>
                                <td>543</td>
                                <td>Давлеzние на стояке</td>
                                <td>64 атм</td>
                                <td>79 атм</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td>623</td>
                                <td>Зенитный угол</td>
                                <td>6 гр.</td>
                                <td>9 гр.</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>746</td>
                                <td>Плотность бурового раствора</td>
                                <td>1,29 гр/см3</td>
                                <td>1,35 гр/см3</td>
                                <td>0,06</td>
                            </tr>
                            <tr>
                                <td>800</td>
                                <td>Нагрузка на долото</td>
                                <td>4-6 т.</td>
                                <td>10 т.</td>
                                <td>5</td>
                            </tr>
                            <tr>
                                <td>830</td>
                                <td>Поглощение</td>
                                <td>840 м.</td>
                                <td>830 м.</td>
                                <td>-10 м.</td>
                            </tr>
                            <tr>
                                <td>846</td>
                                <td>ГНВП</td>
                                <td>880 м.</td>
                                <td>846 м.</td>
                                <td>-34 м.</td>
                            </tr>
                            <tr>
                                <td>915</td>
                                <td>МСП</td>
                                <td>4 м/час</td>
                                <td>10 м/час</td>
                                <td>6</td>
                            </tr>
                            <tr>
                                <td>950</td>
                                <td>Все на крюке</td>
                                <td>14 т.</td>
                                <td>20 т.</td>
                                <td>6</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection