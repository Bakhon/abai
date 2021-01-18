<a href="{{route('mainpage')}}" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/home.png" width="25" height="25" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>
<a href="#" class="bg-dark list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/star.png" width="25" height="25" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>

<a href="#" class="bg-dark list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/list.png" width="25" height="25" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>

<div class="dropright">
    <div data-toggle="dropdown">
        <a href="#" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="/img/gno/some-square.png" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName d-none"></span>
            </div>
        </a>
    </div>
    <div class="dropdown-menu">
        <div class="move-menu">
            <li class="left-menu-li"><a href="{{route('bigdata')}}">Модуль "Прототип БД ABAI"</a></li>
            <li class="left-menu-li"><a href="{{route('visualcenter3')}}">Модуль "Центр визуализации"</a></li>
            @if(auth()->user()->can('tr view main'))
            <li class="left-menu-li"><a href="{{route('tr')}}">Модуль "Технологический режим"</a></li>
            @endif
            <li class="left-menu-li"><a href="{{route('gno')}}">Модуль "Подбор ГНО"</a></li>
            <li class="left-menu-li"><a href="{{route('monitor')}}">Модуль "Мониторинг осложнений"</a>
                <ul class="dropdown-child">
                    <li class="left-menu-li">
                        <ul>
                            @if(auth()->user()->can('monitoring view main'))
                                <li class="left-menu-li">
                                    <a href="{{route('omgca.index')}}">
                                        {{ trans('monitoring.omgca.menu') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('monitoring view main'))
                                <li class="left-menu-li">
                                    <a href="{{route('omguhe.index')}}">
                                        {{ trans('monitoring.omguhe.menu') }}
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('monitoring view main'))
                                <li class="left-menu-li">
                                    <a href="{{route('omgngdu.index')}}">
                                        {{ trans('monitoring.omgngdu.menu') }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                    @if(
                        auth()->user()->can('monitoring list watermeasurement')
                        || auth()->user()->can('monitoring list oilgas')
                        || auth()->user()->can('monitoring list corrosion')
                    )
                        <li class="left-menu-li">
                            <a>
                                {{ trans('monitoring.kaznipi') }}
                            </a>
                            <ul>
                                @if(auth()->user()->can('monitoring list watermeasurement'))
                                    <li class="left-menu-li">
                                        <a href="{{route('watermeasurement.index')}}">
                                            {{ trans('monitoring.wm.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list oilgas'))
                                    <li class="left-menu-li">
                                        <a href="{{route('oilgas.index')}}">
                                            {{ trans('monitoring.oil.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list corrosion'))
                                    <li class="left-menu-li">
                                        <a href="{{route('corrosioncrud.index')}}">
                                            {{ trans('monitoring.corrosion.menu') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(
                        auth()->user()->can('monitoring list pipes')
                        || auth()->user()->can('monitoring list inhibitors')
                    )
                        <li class="left-menu-li">
                            <a>
                                {{ trans('monitoring.dictionaries') }}
                            </a>
                            <ul>
                                @if(auth()->user()->can('monitoring list pipes'))
                                    <li class="left-menu-li">
                                        <a href="{{route('pipes.index')}}">
                                            {{ trans('monitoring.pipe.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list inhibitors'))
                                    <li class="left-menu-li">
                                        <a href="{{route('inhibitors.index')}}">
                                            {{ trans('monitoring.inhibitors') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    <li class="left-menu-li">
                        @if(auth()->user()->can('monitoring view pipes map'))
                            <a href="{{route('maps.gu')}}">
                                {{ trans('monitoring.tech_map') }}
                            </a>
                        @endif
                    </li>
                    <li class="left-menu-li">
                        <a href="{{route('facilities')}}">
                            {{ trans('monitoring.tech_map_prototype') }}
                        </a>
                    </li>
                </ul>
            </li>
        </div>
    </div>
</div>
