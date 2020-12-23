<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <!--<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>-->
    <a href="{{url('/')}}">
        <div class="logo"></div>
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
                    <a href="{{url('/')}}/ru/facilities"><span class="workTypeText">Обустройство</span></a>
                    <ul class="dropdown-child">
                        <li class="nav-item child">
                            @if(auth()->user()->can('monitoring view main'))
                                <a href="{{url('/')}}/ru/monitor">
                                    <span class="workTypeText">Мониторинг коррозии ГУ - Кормасс</span>
                                </a>
                            @endif
                            <ul>
                                @if(auth()->user()->can('monitoring view main'))
                                    <li class="nav-item child">
                                        <a href="{{url('/')}}/ru/omgca">
                                            <span class="workTypeText">ОМГ ДДНГ</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring view main'))
                                    <li class="nav-item child">
                                        <a href="{{url('/')}}/ru/omguhe">
                                            <span class="workTypeText">ОМГ УХЭ</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring view main'))
                                    <li class="nav-item child">
                                        <a href="{{url('/')}}/ru/omgngdu">
                                            <span class="workTypeText">ОМГ НГДУ</span>
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
                                <span class="workTypeText">КазНИПИ ЦНЛИ</span>
                            </a>
                            <ul>
                                @if(auth()->user()->can('monitoring list watermeasurement'))
                                    <li class="nav-item child">
                                        <a href="{{url('/')}}/ru/watermeasurement">
                                            <span class="workTypeText">База данных по промысловой жидкости и газу</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list oilgas'))
                                    <li class="nav-item child">
                                        <a href="{{url('/')}}/ru/oilgas">
                                            <span class="workTypeText">База данных по нефти и газу</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list corrosion'))
                                    <li class="nav-item child">
                                        <a href="{{url('/')}}/ru/corrosioncrud">
                                            <span class="workTypeText">База данных по скорости коррозии</span>
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
                                    <span class="workTypeText">Справочники</span>
                                </a>
                                <ul>
                                    @if(auth()->user()->can('monitoring list pipes'))
                                        <li class="nav-item child">
                                            <a href="{{url('/ru/pipes')}}">
                                                <span class="workTypeText">Трубопроводы</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if(auth()->user()->can('monitoring list inhibitors'))
                                        <li class="nav-item child">
                                            <a href="{{url('/ru/inhibitors')}}">
                                                <span class="workTypeText">Ингибиторы</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        <li class="nav-item child">
                            @if(auth()->user()->can('monitoring view pipes map'))
                                <a href="{{url('/ru/gu-map')}}">
                                    <span class="workTypeText">Техкарта</span>
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
    // Hide submenus
    // $('#body-row .collapse').collapse('hide');

    // Collapse click
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
