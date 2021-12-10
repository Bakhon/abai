<a href="{{route('mainpage')}}"
   class="bg-dark-new list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/home.png" class="companyLogo">
        <span class="menu-collapsed companyName d-none nav_item_text">Главная</span>
    </div>
</a>
<a href="#" class="bg-dark-new list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/star.png" class="companyLogo">
        <span class="menu-collapsed companyName d-none nav_item_text">Избранное</span>
    </div>
</a>
<div class="dropright">
    <div data-toggle="dropdown">
        <a href="#" class="bg-dark-new list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="/img/gno/some-square.png" class="companyLogo">
                <span class="menu-collapsed companyName d-none nav_item_text">Модули</span>
            </div>
        </a>
    </div>
    <div class="dropdown-menu dropdown-menu__third">
        <div class="menu-header justify-content-between">
            <div class="d-flex align-items-center">
                <img src="/img/icons/sidebar_modules_blue.svg" class="companyLogo">
                {{ trans('app.modules') }}
            </div>
        </div>
        <div class="move-menu">
            @if(auth()->user()->can('bigdata view main'))
            <li class="left-menu-li">
                <a class="d-flex justify-content-between" href="{{route('bigdata')}}">
                    <div>
                        <img src="/img/icons/bigdata_gray.svg" class="companyLogo">
                        {{ trans('bd.bigdata_module') }}
                    </div>
                    <img src="/img/icons/arrow-right.svg">
                </a>
                <ul class="dropdown-child">
                    <div class="menu-header">
                        <img src="/img/icons/bigdata_gray.svg" class="companyLogo">
                        {{ trans('bd.bigdata_module') }}
                    </div>
                    <div class="menu-title no-route">{{ trans('bd.bigdata_module') }}</div>
                    <li class="left-menu-li">
                        <ul>
                            <li class="left-menu-li">
                                <a href="{{route('bigdata.well_card')}}">
                                    {{ trans('bd.forms.well_card.menu') }}
                                </a>
                            </li>

                            <li class="left-menu-li">
                                <a href="{{route('bigdata.wells.index')}}">
                                    {{ trans('bd.forms.title') }}
                                </a>
                            </li>

                            <li class="left-menu-li">
                                <a href="{{route('bigdata.wells.create')}}">
                                    {{ trans('bd.forms.well_register.title') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->can('visualcenter view main'))
                <li class="left-menu-li">
                    <a href="{{route('visualcenter3')}}">
                    <img src="/img/icons/visual-center-left-menu-icon.svg" class="companyLogo">
                    {{ trans('visualcenter.visualcenter_module') }}
                    </a>
                </li>
            @endif
            @if(auth()->user()->can('tr view main'))
                <li class="left-menu-li">
                    <a href="{{route('tr')}}">
                        <img src="/img/icons/tr_gray.svg" class="companyLogo">
                        {{ trans('tr.tr_module') }}
                    </a>
                </li>
            @endif
            @if(auth()->user()->can('podborGno view main'))
                <li class="left-menu-li">
                    <a href="{{route('gno')}}">
                        <img src="/img/icons/podborgno_gray.svg" class="companyLogo">
                        {{ trans('pgno.pgno_module') }}
                    </a>
                </li>
            @endif

            @include('partials.sidebar.monitoring_menu')

            @if(auth()->user()->can('economic view main'))
                <li class="left-menu-li">
                    <a class="d-flex justify-content-between" href="{{route('economic.nrs')}}">
                        <div>
                            <img src="/img/icons/monitor_gray.svg" class="companyLogo">
                            {{ trans('economic_reference.economic_module') }}
                        </div>
                        <img src="/img/icons/arrow-right.svg">
                    </a>
                    <ul class="dropdown-child">
                        <div class="menu-header">
                            <img src="/img/icons/nrs.svg" class="companyLogo">
                            {{ trans('economic_reference.economic_module') }}
                        </div>
                        <div class="menu-title no-route">{{ trans('economic_reference.economic_module') }}</div>
                        <li class="left-menu-li">
                            <ul>
                                <li class="left-menu-li">
                                    <a href="{{route('economic.nrs')}}">
                                        {{ trans('economic_reference.nrs') }}
                                    </a>
                                </li>

                                <li class="left-menu-li">
                                    <a href="{{route('economic.optimization')}}">
                                        {{ trans('economic_reference.optimization_of_development') }}
                                    </a>
                                </li>

                                <li class="left-menu-li">
                                    <a href="{{route('economic.analysis')}}">
                                        {{ trans('economic_reference.analysis_of_actual_stops') }}
                                    </a>
                                </li>

                                <li class="left-menu-li">
                                    <a href="{{route('eco_refs_list')}}">
                                        {{ trans('economic_reference.input_params') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
        </div>
    </div>
</div>

@yield('sidebar_menu_additional')

<div class="nav_bottom">
<a href="{{route('faq')}}"
   class="bg-dark-new list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/nav_icon1.svg" class="companyLogo">
        <span class="menu-collapsed companyName d-none nav_item_text">{{ trans('app.help') }}</span>
    </div>
</a>
<div class="dropright">
    <div data-toggle="dropdown">
        <a href="#" class="bg-dark-new list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="/img/nav_icon2.svg" class="companyLogo">
                <span class="menu-collapsed companyName d-none nav_item_text">{{ trans('app.support') }}</span>
            </div>
        </a>
    </div>
    <div class="dropdown-menu dropdown-menu__support">
        <div class="menu-header justify-content-between">
            <div class="d-flex align-items-center">
                <img src="/img/nav_icon2.svg" class="companyLogo">
                {{ trans('app.support') }}
            </div>
        </div>
        <div class="move-menu">
            <li class="left-menu-li">
                <a href="#">
                <img src="/img/icons/default_phone.svg" class="companyLogo"> Для абонентов «Казахтелеком» 1444
                </a>
            </li>
            <li class="left-menu-li">
                <a href="#">
                <img src="/img/icons/mobile_phone.svg" class="companyLogo">  Для мобильных абонентов  +7 (800) 080 1444
                </a>
            </li>
        </div>
    </div>
</div>
<a href="mailto:sms.abai@niikmg.kz"
   class="bg-dark-new list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/nav_icon3.svg" class="companyLogo">
        <span class="menu-collapsed companyName d-none nav_item_text">{{ trans('app.mail') }}</span>
    </div>
</a>
<div
   class="bg-dark-new list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/nav_icon4.svg" class="companyLogo">
        <span class="menu-collapsed companyName d-none nav_item_text">{{ trans('app.chat') }}</span>
    </div>
</div>
</div>
