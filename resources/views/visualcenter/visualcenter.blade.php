@extends('layouts.app')
@section('content')
<div class="col p-4">
    <div class="level1-content row">
        <div class=" col-md-12 col-lg-12 row">
            <div class="main col-lg-7-2 row">
                <div class="col-sm-12 col-md-4 col-lg-4">
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="col-md-12 col-lg-12 row">
                        <div class="timer-visual-center">
                            <div class="left-arrow">
                            </div>
                            <div class="timer">
                                <div class="time">{{date("h:i")}}</div>
                                <div class="date">{{date("d F Y")}}</div>
                            </div>
                            <div class="right-arrow">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="visual-center-center">
               
                    <div class="level2-tab active" tabindex="-3">День</div>
                    <div class="level2-tab" tabindex="-3">Месяц</div>
                    <div class="level2-tab" tabindex="-3">Год</div>
            
              <div>
                        <visual-center-table></visual-center-table>
                    </div>
                    <div class="visual-center-center">
                        <div class="tables-name">График добычи за 16 июня 2020</div>
                        <visual-center-chart-area-center></visual-center-chart-area-center>
                    </div>
                </div>
                <div class="visual-center-center">
                    <div class="visual-center-bottom ">
                        <div class="visual-center-string1 ">Отключение РП:</div>
                        <div class="visual-center-string2 "></div>
                        <div class="visual-center-string1 ">Отключение скважин:</div>
                        <div class="visual-center-string2 "></div>
                        <div class="visual-center-string1 ">Выбросы и разливы:</div>
                        <div class="visual-center-string2 "></div>
                        <div class="visual-center-string1 ">Прочие:</div>
                        <div class="visual-center-string2 "></div>
                    </div>
                    <div class="visual-center-bottom ">
                        <div class="accidents-first accidents">
                            <div class="number-of-accidents ">
                                2
                            </div>Несчастные<br> случаи
                        </div>
                        <div class="accidents-second accidents">
                            <div class="number-of-accidents">
                                0
                            </div>Смертельные<br> случаи
                        </div>
                        <div class="accidents-third accidents">
                            <div class="number-of-accidents">
                                14
                            </div>COVID<br>19
                        </div>
                    </div>
                    <div class="visual-center-bottom ">
                        <div class="difference-of-24">Отклонение за сутки</div>
                        <div class="visual-center-chart-bar-bottom">
                            <visual-center-chart-bar-bottom></visual-center-chart-bar-bottom>
                        </div>
                    </div>
                </div>
            </div>
            <div class="visual-center-right-column">
                <div class="right-button-panel">
                    <div class="right-chart-button right-button" tabindex="-5">
                        График
                    </div>
                    <div class="right-table-button right-button" tabindex="-5">
                        Таблица
                    </div>
                </div>
                <div class="donut">
                    <div class="indent">
                        Фонд добывающих скважин за 16 июня 2020</div>
                    <div>
                        <visual-center-chart-donut-right1>
                            </visual-center-chart-doughut-right1>
                    </div>
                    <div class="donut-inner1 inner1">В работе<br>1 005</div>
                    <div class="donut-inner1 inner2">В простое<br>1 011</div>
                </div>
                <div class="donut donut2">
                    <div class="indent">Фонд нагнетательных скважин за 16 июня 2020</div>
                    <div>
                        <visual-center-chart-donut-right2>
                            </visual-center-chart-doughut-right2>
                    </div>
                    <div class="donut-inner1 inner1">В работе<br>1 005</div>
                    <div class="donut-inner1 inner2">В простое<br>1 011</div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    <style>
        .p-4 {
            background-color: #0F1430;
        }

        .level1-tab {
            width: 390px;
            height: 25px;
            background-color: #0F254A;
            color: #41638A;
            display: inline-block;
            text-align: center;
            margin-left: 0px !important;
            margin-right: -4px !important;
        }

        .level1-tab:focus {
            background-color: #15509D;
            color: #FFFFFF;
            border: none;
        }

        .main {
            height: 897px;
            background-color: #0F1430;
            background-image: url("{{ asset('img/level1/grid.svg')}}");
            border: 1px solid #0D2B4D;
            margin-left: 0px !important;
            padding-top: 20px;
        }

        .right-bar {
            height: 918px;
            margin-left: 10px !important;
        }

        .right-tab {
            height: 25px;
            display: inline-block;
            background: #0F254A;
            text-align: center;
            color: #41638A;
            margin-left: 0px !important;
            margin-right: -4px !important;
        }

        .right-tab:focus {
            background: #15509D;
            color: #FFFFFF;
            border: none;
        }

        .info-panel {
            height: 870px;
            background: #20274F;
        }

        .indicator {
            background-image: url("{{ asset('img/level1/oil_reserve.svg') }}");
            background-repeat: no-repeat;
            color: #FFFFFF;
            font-size: 11px;
            line-height: 13px;
            text-align: center;
            width: 135px;
            height: 135px;
        }

        .title {
            width: 225px;
            height: 40px;
            background-image: url("{{ asset('img/level1/title.svg') }}");
            background-repeat: no-repeat;
            color: #FFFFFF;
            text-align: center;
            vertical-align: middle;
            line-height: 40px;
            margin: auto;
        }

        .time {
            font-size: 18px;
            color: #FFFFFF;
            text-align: center;
            vertical-align: middle;
        }

        .date {
            font-size: 12px;
            color: #FFFFFF;
            text-align: center;
            vertical-align: middle;
        }

        .digitOil {
            width: 270px;
            height: 77px;
            background-image: url("{{ asset('img/level1/digitOil.svg') }}");
            background-repeat: no-repeat;
            margin-top: 10px;
            color: #FFFFFF;
        }

        .digitGaz {
            width: 270px;
            height: 77px;
            background-image: url("{{ asset('img/level1/digitGaz.svg') }}");
            background-repeat: no-repeat;
            margin-top: 10px;
            color: #FFFFFF;
        }

        .okei {
            font-size: 11px;
            line-height: 13px;
            color: #FFFFFF;
        }

        .okei-left {
            margin-left: 220px;
        }

        .okei-right {
            margin-left: 5px;
        }

        /* oil */
        .digit-oil-icon {
            width: 77.63px;
            height: 80px;
            position: absolute;
            margin-left: 12.73px;
        }

        .digit-oil-name {
            width: 48px;
            height: 19px;
            margin-left: 110px;
            font-size: 16px;
            margin-top: -5px;
        }

        .digit-oil-value {
            width: 51px;
            height: 35px;
            margin-left: 110px;
            font-size: 30px;
            margin-top: -5px;
        }

        .digit-oil-additional-icon {
            width: 13.55px;
            height: 10px;
            margin-left: 197.73px;
            margin-top: -25px;
        }

        .digit-oil-additional-value {
            width: 13.55px;
            height: 10px;
            margin-left: 217.73px;
            margin-top: -15px;
        }

        .digit-oil-icon-middle {
            width: 27.08px;
            height: 35px;
            position: absolute;
            margin-left: 38.73px;
            margin-top: 23px;
        }

        /* gaz */
        .digit-gaz-additional-value {
            width: 13.55px;
            height: 10px;
            margin-top: 40px;
            margin-left: -35px;
            position: absolute;
        }

        .digit-gaz-additional-icon {
            width: 13.55px;
            height: 10px;
            margin-top: 45px;
            margin-left: 4px;
            position: absolute;
        }

        .digit-gaz-name {
            width: 48px;
            height: 19px;
            font-size: 16px;
            margin-top: 20px;
            margin-left: 45px;
            position: absolute;
        }

        .digit-gaz-value {
            width: 51px;
            height: 35px;
            font-size: 30px;
            margin-left: 45px;
            margin-top: 30px;
            position: absolute;
        }

        .digit-gaz-icon {
            width: 77.63px;
            height: 80px;
            position: absolute;
            margin-left: 180px;
        }

        .digit-gaz-icon-middle {
            width: 27.08px;
            height: 35px;
            position: absolute;
            margin-left: 206px;
            margin-top: 23px;
        }

        .indicator-icon {
            width: 15.47px;
            height: 20px;
            margin-top: 20px;
            margin-left: 45.5px;
        }

        .indicator-name {
            width: 86px;
            height: 26px;
            font-size: 11px;
            text-align: center;
            margin-left: 11px;
            margin-top: 3px;
        }

        .indicator-value {
            width: 51px;
            height: 23px;
            font-size: 20px;
            text-align: center;
            margin-left: 28px;
            margin-top: 6px;
        }

        .indicator-okei {
            width: 47px;
            height: 17px;
            font-size: 11px;
            text-align: center;
            margin-left: 28px;
            margin-top: 4px;
        }
    </style>