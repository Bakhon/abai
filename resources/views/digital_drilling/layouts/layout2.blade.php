@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="/css/digital_drilling.css">
    <div class="row digital_drilling">
        <div class="col-sm-12 centerBlock">
            <div class="controlBlock">
                <div class="block">
                    <div class="dropdown @if(Request::segment(3) == 'bd') active @endif">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <img src="/img/digital-drilling/menu1.svg" alt="">База данных <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('digital-drilling-home') }}"><img src="/img/digital-drilling/menu2.svg" alt="">Общая информация</a>
                            <a class="dropdown-item" href="{{ route('digital-drilling-passport') }}"><img src="/img/digital-drilling/menu3.svg" alt="">Паспорт скважины</a>
                            <a class="dropdown-item" href="{{ route('digital-drilling-gis') }}"><img src="/img/digital-drilling/menu4.svg" alt="">ГИС в открытом стволе</a>
                            <a class="dropdown-item" href="{{ route('digital-drilling-inclino') }}"><img src="/img/digital-drilling/menu5.svg" alt="">Инклинометрия</a>
                            <a class="dropdown-item" href="{{ route('digital-drilling-structure') }}"><img src="/img/digital-drilling/menu6.svg" alt="">Конструкция скважины</a>
                            <a class="dropdown-item" href="{{ route('digital-drilling-project-data') }}"><img src="/img/digital-drilling/menu7.svg" alt="">Проекты/фактические данные</a>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="dropdown @if(Request::segment(3) == 'project') active @endif">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <img src="/img/digital-drilling/menu8.svg" alt="">Проектирование <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('digital-drilling-well-profile') }}"><img src="/img/digital-drilling/menu12.svg" alt="">Профиль скважины</a>
                            <a class="dropdown-item" href="{{ route('digital-drilling-calculation') }}"><img src="/img/digital-drilling/menu13.svg" alt="">Расчет конструкции</a>
                            <a class="dropdown-item" href="{{ route('digital-drilling-rasters') }}"><img src="/img/digital-drilling/menu14.svg" alt="">Буровые растворы</a>
                            <a class="dropdown-item" href="{{ route('digital-drilling-deepening') }}"><img src="/img/digital-drilling/menu15.svg" alt="">Углубление скважины</a>
                            <a class="dropdown-item" href="{{ route('digital-drilling-fastening') }}"><img src="/img/digital-drilling/menu12.svg" alt="">Крепление</a>
                            <a class="dropdown-item"><img src="/img/digital-drilling/menu16.svg" alt="">Продолжительность</a>
                            <a class="dropdown-item"><img src="/img/digital-drilling/menu16.svg" alt="">Ресурсная смета</a>
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <img src="/img/digital-drilling/menu9.svg" alt="">Онлайн-бурение <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
                <div class="block">
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <img src="/img/digital-drilling/menu10.svg" alt="">Супервайзинг <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
                <div class="block">
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <img src="/img/digital-drilling/menu11.svg" alt="">Аналитика <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-10 leftBlock">
            <div class="resultsBlock">
                <ul>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">54</span>
                                <span>скважин</span>
                            </p>
                            <p class="title green">В бурении</p>
                            <p class="percent"><span>5,2%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">1726</span>
                                <span>скважин</span>
                            </p>
                            <p class="title yellow">Пробурено</p>
                            <p class="percent"><span>1,4%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">0</span>
                                <span>скважин</span>
                            </p>
                            <p class="title red">Ликвидированные</p>
                            <p class="percent"><span>0,0%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">5520</span>
                                <span>скважин</span>
                            </p>
                            <p class="title">Итого</p>
                            <p class="percent"><span>1,4%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="contentBlock">@yield('in-content')</div>
        </div>
        <div class="col-sm-2 rightBlock">
            <div class="analyticsBlock">
                <div class="mspBlock bigBlock">
                    <p class="numm">6054</p>
                    <canvas id="foo" height="140"></canvas>
                    <p>Средняя <br>коммерческая скорость</p>
                </div>
            </div>
            <div class="analyticsBlock">
                <div class="mspBlock bigBlock">
                    <p class="numm"><img src="/img/digital-drilling/drilling.svg" alt=""></p>
                    <p class="bigNum">142 524 <span>Пробурено (метров)</span></p>
                    <p class="percent"><span>1,4%</span> vs 23.03.2021</p>
                </div>
            </div>
        </div>
    </div>


@endsection
<script src="/js/digital-drilling/gauge.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        var options = {
            angle: 0,
            lineWidth: 0.25,
            radiusScale: 1,
            pointer: {
                length: 0.36,
                strokeWidth: 0.042,
                color: '#FFFFFF'
            },
            limitMax: false,
            limitMin: false,
            strokeColor: '#E0E0E0',
            generateGradient: true,
            highDpiSupport: true,
            staticZones: [
                {strokeStyle: "#E3000F", min: 0, max: 2490},
                {strokeStyle: "#FBA409", min: 2510, max: 4990},
                {strokeStyle: "#FFEC08", min: 5010, max: 7490},
                {strokeStyle: "#00963F", min: 7510, max: 10000},
            ],
        };
        initGauge('foo', 6054, options);
    });

    function initGauge(id, value, options){
        var target = document.getElementById(id);
        var gauge = new Gauge(target).setOptions(options);
        gauge.maxValue = 10000;
        gauge.setMinValue(0);
        gauge.animationSpeed = 58;
        gauge.set(value);
    }
</script>