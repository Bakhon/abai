<a href="{{route('mainpage')}}"
   class="bg-dark-new list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/home.png" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>
<a href="#" class="bg-dark-new list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/star.png" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>
<div class="dropright">
    <div data-toggle="dropdown">
        <a href="#" class="bg-dark-new list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="/img/gno/some-square.png" class="companyLogo">
                <span class="menu-collapsed companyName d-none"></span>
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
            <li class="left-menu-li">
                <a href="{{route('bigdata')}}">
                    <img src="/img/icons/bigdata_gray.svg" class="companyLogo">
                    {{ trans('bd.bigdata_module') }}
                </a>
            </li>
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
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
        </div>
    </div>
</div>
