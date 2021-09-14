<a href="{{route('mainpage')}}"
   class="bg-dark-new list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/home.png" width="25" height="25" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>
<a href="#" class="bg-dark-new list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/star.png" width="25" height="25" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>
<div class="dropright">
    <div data-toggle="dropdown">
        <a href="#" class="bg-dark-new list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="/img/gno/some-square.png" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName d-none"></span>
            </div>
        </a>
    </div>
    <div class="dropdown-menu">
        <div class="move-menu">
            <li class="left-menu-li"><a href="{{route('bigdata')}}">{{ trans('bd.bigdata_module') }}</a>
            </li>
            @if(auth()->user()->can('visualcenter view main'))
                <li class="left-menu-li"><a href="{{route('visualcenter3')}}">{{ trans('visualcenter.visualcenter_module') }}</a></li>
            @endif
            @if(auth()->user()->can('tr view main'))
                <li class="left-menu-li"><a href="{{route('tr')}}">{{ trans('tr.tr_module') }}</a></li>
            @endif
            @if(auth()->user()->can('podborGno view main'))
                <li class="left-menu-li"><a href="{{route('gno')}}">{{ trans('pgno.pgno_module') }}</a></li>
            @endif

            @include('partials.sidebar.monitoring_menu')

            @if(auth()->user()->can('economic view main'))
                <li class="left-menu-li">
                    <div>{{ trans('economic_reference.economic_module') }}</div>
                    <ul class="dropdown-child">
                        <li class="left-menu-li">
                            <ul>
                                <li class="left-menu-li">
                                    <a href="{{route('economic_nrs')}}">
                                        {{ trans('economic_reference.nrs') }}
                                    </a>
                                </li>

                                <li class="left-menu-li">
                                    <a href="{{route('economic_optimization')}}">
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