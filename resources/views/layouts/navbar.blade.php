<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="{{url('/')}}">
        <div class="logo"></div>
    </a>
    <a href="#top" data-toggle="sidebar-colapse">
        <i class="fas fa-bars fa-lg"></i>
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php
        $user = Auth::user()->username;
        if (strpos($user, 'Almukhan_test') === false || strpos($user, 'vcuser') === false || strpos(
            $user,
            'gnouser'
        ) === false || strpos($user, 'truser') === false) { ?>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <img src="{{ asset('img/level1/icon_geology.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href=""><span class="workTypeText">Геология</span></a>
            </li>
            <li class="nav-item active dropdown">
                <img src="{{ asset('img/level1/icon_razrabotka.svg') }}" width="15" height="15"
                     class="workTypeLogo">
                <a href=""><span class="workTypeText">Разработка</span></a>
            </li>
            <li class="nav-item active dropdown">
                <img src="{{ asset('img/level1/icon_buren.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href=""><span class="workTypeText">Бурение</span></a>
            </li>
            <li class="nav-item active dropdown">
                <img src="{{ asset('img/level1/icon_dobycha.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href=""><span class="workTypeText">Добыча</span></a>
                <ul class="dropdown-child">
                    <li class="nav-item child">
                        <a href="{{url('/')}}/ru/podborgno">
                            <span class="workTypeText">Подбор ГНО</span>
                        </a>
                    </li>
                    <li class="nav-item child">
                        <a href="{{url('/')}}/ru/tr">
                            <span class="workTypeText">Тех режим</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item active  dropdown">
                <img src="{{ asset('img/level1/icon_obustroystvo.svg') }}" width="15" height="15"
                     class="workTypeLogo">
                <a href="{{route('facilities')}}"><span class="workTypeText">Обустройство</span></a>
                <ul class="dropdown-child">
                    <li class="nav-item child">
                        @if(auth()->user()->can('monitoring view main'))
                            <a href="{{route('monitor')}}">
                                <span class="workTypeText">{{ trans('monitoring.corrosion_monitoring') }}</span>
                            </a>
                        @endif
                        <ul>
                            @if(auth()->user()->can('monitoring view main'))
                                <li class="nav-item child">
                                    <a href="{{route('omgca.index')}}">
                                        <span class="workTypeText">{{ trans('monitoring.omgca.menu') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('monitoring view main'))
                                <li class="nav-item child">
                                    <a href="{{route('omguhe.index')}}">
                                        <span class="workTypeText">{{ trans('monitoring.omguhe.menu') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if(auth()->user()->can('monitoring view main'))
                                <li class="nav-item child">
                                    <a href="{{route('omgngdu.index')}}">
                                        <span class="workTypeText">{{ trans('monitoring.omgngdu.menu') }}</span>
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
                        <li class="nav-item child">
                            <a>
                                <span class="workTypeText">{{ trans('monitoring.kaznipi') }}</span>
                            </a>
                            <ul>
                                @if(auth()->user()->can('monitoring list watermeasurement'))
                                    <li class="nav-item child">
                                        <a href="{{route('watermeasurement.index')}}">
                                            <span class="workTypeText">{{ trans('monitoring.wm.menu') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list oilgas'))
                                    <li class="nav-item child">
                                        <a href="{{route('oilgas.index')}}">
                                            <span class="workTypeText">{{ trans('monitoring.oil.menu') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list corrosion'))
                                    <li class="nav-item child">
                                        <a href="{{route('corrosioncrud.index')}}">
                                            <span class="workTypeText">{{ trans('monitoring.corrosion.menu') }}</span>
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
                        <li class="nav-item child">
                            <a>
                                <span class="workTypeText">{{ trans('monitoring.dictionaries') }}</span>
                            </a>
                            <ul>
                                @if(auth()->user()->can('monitoring list pipes'))
                                    <li class="nav-item child">
                                        <a href="{{route('pipes.index')}}">
                                            <span class="workTypeText">{{ trans('monitoring.pipe.menu') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list inhibitors'))
                                    <li class="nav-item child">
                                        <a href="{{route('inhibitors.index')}}">
                                            <span class="workTypeText">{{ trans('monitoring.inhibitors') }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item child">
                        @if(auth()->user()->can('monitoring view pipes map'))
                            <a href="{{route('maps.gu')}}">
                                <span class="workTypeText">{{ trans('monitoring.tech_map') }}</span>
                            </a>
                        @endif
                    </li>
                </ul>
            </li>
            @if(auth()->user()->can('economic view main'))
                <li class="nav-item active dropdown">
                    <img src="{{ asset('img/level1/economic.svg') }}" width="15" height="15" class="workTypeLogo">
                    <a href="{{url('/')}}/ru/economic"><span class="workTypeText">Экономика</span></a>
                </li>
            @endif

            <li class="nav-item active">
                <button onclick="document.location='{{url('/')}}/ru/bigdata'" type="button"
                        class="btn btn-primary-bigdata"></button>
            </li>
        </ul><?php  } ?>
        <div class="form-inline my-2 my-lg-0">
            <li class="nav-item2 mr-5">
                <div class="nav-lang">
                    <a href="#" class="nav-lang__select">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11" cy="11" r="10.2" stroke="white" stroke-width="1.6"/>
                            <path d="M5.5 11C5.5 2 11 1 11 1C11 1 16.5 2 16.5 11C16.5 20 11 21 11 21C11 21 5.5 20 5.5 11Z"
                                  stroke="white" stroke-width="1.6"/>
                            <path d="M11 1V21" stroke="white" stroke-width="1.6"/>
                            <path d="M1 11H21" stroke="white" stroke-width="1.6"/>
                        </svg>
                        <span>{{$languages['current']['name']}}</span>
                    </a>
                    <div class="nav-lang__dropdown">
                        @foreach($languages['list'] as $lang)
                            <a href="{{$lang['url']}}" class="nav-lang__dropdown-item">{{$lang['name']}}</a>
                        @endforeach
                    </div>
                </div>
            </li>
            <li class="nav-item2">
                <i class="fas fa-bell fa-lg"></i>
            </li>
            {{--@if (Auth::guest())--}}
            <li class="nav-item2 active dropdown2">
                <a href="{{ route('login') }}"><img src="{{ asset('img/level1/icon_user.svg') }}" width="30"
                                                    height="30" alt=""></a>
                <ul class="dropdown-child2">
                    <li class="nav-item child2">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: one;">
                            {{ csrf_field() }}

                            <a class="logout" onClick="document.forms['logout-form'].submit();" href="#"> Выйти</a>
                        </form>
                    </li>
                    <li class="nav-item child">
                    </li>
                </ul>
            </li>
            {{-- @else--}}

            {{--@endif--}}
            <li class="nav-item2">
                <i class="fas fa-ellipsis-v"></i>
            </li>

        </div>
    </div>
</nav>

<script>
    $(function () {

    });

    $('[data-toggle=sidebar-colapse]').click(function () {
        SidebarCollapse();
    });

    function SidebarCollapse() {
        $('.menu-collapsed').toggleClass('d-none');
        $('.sidebar-submenu').toggleClass('d-none');
        $('.submenu-icon').toggleClass('d-none');
        $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');

        // Treating d-flex/d-none on separators with title
        var SeparatorTitle = $('.sidebar-separator-title');
        //var SeparatorTitle = document.getElementsByClassName('sidebar-separator-title');
        if (SeparatorTitle.hasClass('d-flex')) {
            SeparatorTitle.removeClass('d-flex');
        } else {
            SeparatorTitle.addClass('d-flex');
        }
    }
</script>
