<div class="controlBlock">
    <div class="block">
        <div class="dropdown @if(Request::segment(3) == 'bd') active @endif">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <img src="/img/digital-drilling/menu1.svg" alt="">База данных<i class="fas fa-chevron-down"></i>
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
                <a class="dropdown-item"><img src="/img/digital-drilling/menu24.svg" alt="">Продолжительность строительства</a>
                <a class="dropdown-item"><img src="/img/digital-drilling/menu25.svg" alt="">Ресурсная смета</a>
                {{--<a class="dropdown-item"><img src="/img/digital-drilling/menu16.svg" alt="">Формирование отчета</a>--}}
            </div>
        </div>
    </div>
    <div class="block">
        <div class="dropdown @if(Request::segment(3) == 'online') active @endif">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <img src="/img/digital-drilling/menu9.svg" alt="">Онлайн-бурение <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('digital-drilling-alarm') }}"><img src="/img/digital-drilling/menu17.svg" alt="">ALARM-оповещения</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-geo-first') }}"><img src="/img/digital-drilling/menu18.svg" alt="">Геонавигация</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-sector') }}"><img src="/img/digital-drilling/menu19.svg" alt="">Секторная геологическая модель</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-visual') }}"><img src="/img/digital-drilling/menu16.svg" alt="">Визуализация данных</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-report1') }}"><img src="/img/digital-drilling/menu20.svg" alt="">Отчеты</a>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="dropdown @if(Request::segment(3) == 'supervising') active @endif">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <img src="/img/digital-drilling/menu10.svg" alt="">Супервайзинг <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('digital-drilling-reports') }}"><img src="/img/digital-drilling/menu21.svg" alt="">Суточные рапорты</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-balance') }}"><img src="/img/digital-drilling/menu22.svg" alt="">Баланс календарного времени</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-fact') }}"><img src="/img/digital-drilling/menu23.svg" alt="">Проект/факт</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-npv') }}"><img src="/img/digital-drilling/menu7.svg" alt="">Данные НПВ</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-akc') }}"><img src="/img/digital-drilling/menu5.svg" alt="">Данные АКЦ</a>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="dropdown @if(Request::segment(3) == 'analytics') active @endif">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <img src="/img/digital-drilling/menu11.svg" alt="">Аналитика <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-inclino') }}"><img src="/img/digital-drilling/menu23.svg" alt="">Углубление</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-analytics-fastening-first') }}"><img src="/img/digital-drilling/menu22.svg" alt="">Крепление</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-analytics-complications') }}"><img src="/img/digital-drilling/menu7.svg" alt="">Осложнения</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-analytics-akc') }}"><img src="/img/digital-drilling/menu5.svg" alt="">Анализ АКЦ</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-analytics-balance') }}"><img src="/img/digital-drilling/menu21.svg" alt="">Баланс времени</a>
            </div>
        </div>
    </div>
</div>