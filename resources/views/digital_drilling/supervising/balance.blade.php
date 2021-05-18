@extends('digital_drilling.layouts.layout')
@section('in-content')
    <div class="digitalDrillingWindow">
        @include('digital_drilling.layouts.window-head')
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Баланс календарного времени</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Баланс календарного времени <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('digital-drilling-balance-second') }}">Баланс календарного времени: Фактический график бурения</a>
                        <a class="dropdown-item" href="{{ route('digital-drilling-balance-third') }}">Визуализация баланса календарного времени</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tr>
                                <th rowspan="3" class="verticalText">Дата</th>
                                <th rowspan="3"><span>Забой, м</span></th>
                                <th colspan="24">расшифровка времени на бурение</th>
                            </tr>
                            <tr>
                                <th rowspan="2" class="verticalText"><span>Календарное время, всего</span></th>
                                <th colspan="5">работа по проходке</th>
                                <th colspan="8">вспомогательные работы</th>
                                <th colspan="5">крепление</th>
                                <th colspan="5">аварийные работы</th>
                            </tr>
                            <tr>
                                <th colspan="1" class="verticalText"><span>мехбурение</span></th>
                                <th colspan="1" class="verticalText"><span>отбор керна</span></th>
                                <th colspan="1" class="verticalText"><span>расширка</span></th>
                                <th colspan="1" class="verticalText"><span>СПО</span></th>
                                <th colspan="1" class="verticalText"><span>наращивание</span></th>
                                <th colspan="1" class="verticalText"><span>ПЗР</span></th>
                                <th colspan="1" class="verticalText"><span>проработка</span></th>
                                <th colspan="1" class="verticalText"><span>промывка</span></th>
                                <th colspan="1" class="verticalText"><span>спо при проработке</span></th>
                                <th colspan="1" class="verticalText"><span>обработка/ приготовление раствора</span></th>
                                <th colspan="1" class="verticalText"><span>сборка/ разборка компоновки</span></th>
                                <th colspan="1" class="verticalText"><span>смена тальканата</span></th>
                                <th colspan="1" class="verticalText"><span>прочие вспом</span></th>
                                <th colspan="1" class="verticalText"><span>спуск колон</span></th>
                                <th colspan="1" class="verticalText"><span>цементаж</span></th>
                                <th colspan="1" class="verticalText"><span>ОЗЦ</span></th>
                                <th colspan="1" class="verticalText"><span>оборудов. устья и оппресовка</span></th>
                                <th colspan="1" class="verticalText"><span>разбурив ц/ст</span></th>
                                <th colspan="1" class="verticalText"><span>расхаживание и промывка</span></th>
                                <th colspan="1" class="verticalText"><span>правильные и разбурочные работы</span></th>
                                <th colspan="1" class="verticalText"><span>компоновка и СПО ловильного инст-та</span></th>
                                <th colspan="1" class="verticalText"><span>прочие</span></th>
                                <th colspan="1" class="verticalText"><span>устан-ка нефтян. ванны и техстоянка</span></th>
                            </tr>
                            @for ($i = 0; $i < 16; $i++)
                                <tr>
                                    @for ($a = 0; $a < 26; $a++)
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