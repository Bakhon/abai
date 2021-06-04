<div class="controlBlock">
    <div class="block">
        <div class="dropdown @if(Request::segment(3) == 'bd') active @endif">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <img src="/img/digital-drilling/menu1.svg" alt="">{{ trans('digital_drilling.category1') }}<i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('digital-drilling-home') }}"><img src="/img/digital-drilling/menu2.svg" alt="">{{ trans('digital_drilling.menu1') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-passport') }}"><img src="/img/digital-drilling/menu3.svg" alt="">{{ trans('digital_drilling.menu2') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-gis') }}"><img src="/img/digital-drilling/menu4.svg" alt="">{{ trans('digital_drilling.menu3') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-inclino') }}"><img src="/img/digital-drilling/menu5.svg" alt="">{{ trans('digital_drilling.menu4') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-structure') }}"><img src="/img/digital-drilling/menu6.svg" alt="">{{ trans('digital_drilling.menu5') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-project-data') }}"><img src="/img/digital-drilling/menu7.svg" alt="">{{ trans('digital_drilling.menu6') }}</a>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="dropdown @if(Request::segment(3) == 'project') active @endif">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <img src="/img/digital-drilling/menu8.svg" alt="">{{ trans('digital_drilling.category2') }} <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('digital-drilling-well-profile') }}"><img src="/img/digital-drilling/menu12.svg" alt="">{{ trans('digital_drilling.menu7') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-calculation') }}"><img src="/img/digital-drilling/menu13.svg" alt="">{{ trans('digital_drilling.menu8') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-rasters') }}"><img src="/img/digital-drilling/menu14.svg" alt="">{{ trans('digital_drilling.menu9') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-deepening') }}"><img src="/img/digital-drilling/menu15.svg" alt="">{{ trans('digital_drilling.menu10') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-fastening') }}"><img src="/img/digital-drilling/menu12.svg" alt="">{{ trans('digital_drilling.menu11') }}</a>
                <a class="dropdown-item"><img src="/img/digital-drilling/menu24.svg" alt="">{{ trans('digital_drilling.menu12') }}</a>
                <a class="dropdown-item"><img src="/img/digital-drilling/menu25.svg" alt="">{{ trans('digital_drilling.menu13') }}</a>
                <a class="dropdown-item"><img src="/img/digital-drilling/menu16.svg" alt="">{{ trans('digital_drilling.menu14') }}</a>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="dropdown @if(Request::segment(3) == 'online') active @endif">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <img src="/img/digital-drilling/menu9.svg" alt="">{{ trans('digital_drilling.category3') }} <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('digital-drilling-alarm') }}"><img src="/img/digital-drilling/menu17.svg" alt="">{{ trans('digital_drilling.menu15') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-geo-first') }}"><img src="/img/digital-drilling/menu18.svg" alt="">{{ trans('digital_drilling.menu16') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-sector') }}"><img src="/img/digital-drilling/menu19.svg" alt="">{{ trans('digital_drilling.menu17') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-visual') }}"><img src="/img/digital-drilling/menu16.svg" alt="">{{ trans('digital_drilling.menu18') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-report1') }}"><img src="/img/digital-drilling/menu20.svg" alt="">{{ trans('digital_drilling.menu19') }}</a>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="dropdown @if(Request::segment(3) == 'supervising') active @endif">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <img src="/img/digital-drilling/menu10.svg" alt="">{{ trans('digital_drilling.category4') }} <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('digital-drilling-reports') }}"><img src="/img/digital-drilling/menu21.svg" alt="">{{ trans('digital_drilling.menu20') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-balance') }}"><img src="/img/digital-drilling/menu22.svg" alt="">{{ trans('digital_drilling.menu21') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-fact') }}"><img src="/img/digital-drilling/menu23.svg" alt="">{{ trans('digital_drilling.menu22') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-npv') }}"><img src="/img/digital-drilling/menu7.svg" alt="">{{ trans('digital_drilling.menu23') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-akc') }}"><img src="/img/digital-drilling/menu5.svg" alt="">{{ trans('digital_drilling.menu24') }}</a>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="dropdown @if(Request::segment(3) == 'analytics') active @endif">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <img src="/img/digital-drilling/menu11.svg" alt="">{{ trans('digital_drilling.category5') }} <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('digital-drilling-analytics-deepening-inclino') }}"><img src="/img/digital-drilling/menu23.svg" alt="">{{ trans('digital_drilling.menu25') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-analytics-fastening-first') }}"><img src="/img/digital-drilling/menu22.svg" alt="">{{ trans('digital_drilling.menu26') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-analytics-complications') }}"><img src="/img/digital-drilling/menu7.svg" alt="">{{ trans('digital_drilling.menu27') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-analytics-akc') }}"><img src="/img/digital-drilling/menu5.svg" alt="">{{ trans('digital_drilling.menu28') }}</a>
                <a class="dropdown-item" href="{{ route('digital-drilling-analytics-balance') }}"><img src="/img/digital-drilling/menu21.svg" alt="">{{ trans('digital_drilling.menu29') }}</a>
            </div>
        </div>
    </div>
</div>