<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <!--<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>-->
    <a href="{{url('/')}}">
        <div class="logo"> </div>
        <a href="#top" data-toggle="sidebar-colapse">
            <i class="fas fa-bars fa-lg"></i>
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php
    $user = Auth::user()->username;
    if (strpos($user, 'Almukhan_test') === false || strpos($user, 'vcuser') === false || strpos($user, 'gnouser') === false || strpos($user, 'truser') === false) { ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <img src="{{ asset('img/level1/icon_geology.svg') }}" width="15" height="15" class="workTypeLogo">
                    <a href=""><span class="workTypeText">Геология</span></a>
                </li>
                <li class="nav-item active dropdown">
                    <img src="{{ asset('img/level1/icon_razrabotka.svg') }}" width="15" height="15" class="workTypeLogo">
                    <a href=""><span class="workTypeText">Разработка</span></a>
                </li>
            <li class="nav-item active dropdown">
                <img src="{{ asset('img/level1/icon_buren.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href=""><span class="workTypeText">Бурение</span></a>
            </li>
            <li class="nav-item active dropdown">
                <img src="{{ asset('img/level1/icon_dobycha.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href="{{url('/')}}/ru/visualcenter"><span class="workTypeText">Добыча</span></a>
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
                <img src="{{ asset('img/level1/icon_obustroystvo.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href="{{url('/')}}/ru/facilities"><span class="workTypeText">Обустройство</span></a>
                <ul class="dropdown-child">
                    <li class="nav-item child">
                        <a href="{{url('/')}}/ru/monitor">
                            <span class="workTypeText">Мониторинг коррозии ГУ - Кормасс</span>
                        </a>
                        <ul>
                            <li class="nav-item child">
                                <a href="{{url('/')}}/ru/omgca">
                                    <span class="workTypeText">ОМГ ДДНГ</span>
                                </a>
                            </li>
                            <li class="nav-item child">
                                <a href="{{url('/')}}/ru/omguhe">
                                    <span class="workTypeText">ОМГ УХЭ</span>
                                </a>
                            </li>
                            <li class="nav-item child">
                                <a href="{{url('/')}}/ru/omgngdu">
                                    <span class="workTypeText">ОМГ НГДУ</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item child">
                        <a>
                            <span class="workTypeText">КазНИПИ ЦНЛИ</span>
                        </a>
                        <ul>
                            <li class="nav-item child">
                                <a href="{{url('/')}}/ru/watermeasurement">
                                    <span class="workTypeText">Лабораторные данные по промысловой жидкости и газу</span>
                                </a>
                            </li>
                            <li class="nav-item child">
                                <a href="{{url('/')}}/ru/oilgas">
                                    <span class="workTypeText">Данных по нефти и газу</span>
                                </a>
                            </li>
                        </ul>
                    </li>
            </li>
            </ul>
            </li>
            <li class="nav-item active dropdown">
                <img src="{{ asset('img/level1/economic.svg') }}" width="15" height="15" class="workTypeLogo">
                <a href="{{url('/')}}/ru/economic"><span class="workTypeText">Экономика</span></a>
            </li>

            <li class="nav-item active">
                <button onclick="document.location='{{url('/')}}/ru/bigdata'" type="button" class="btn btn-primary-bigdata"></button>
            </li>
            </ul><?php  } ?>
            <div class="form-inline my-2 my-lg-0">
                <li class="nav-item2">
                    <i class="fas fa-bell fa-lg"></i>
                </li>
                {{--@if (Auth::guest())--}}
                <li class="nav-item2 active dropdown2">
                    <a href="{{ route('login') }}"><img src="{{ asset('img/level1/icon_user.svg') }}" width="30" height="30" alt=""></a>
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
    $('[data-toggle=sidebar-colapse]').click(function() {
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
<style>
    .bg-dark {
        background-color: #20274e !important;
       /* height: 80px;*/
        z-index: 99999;
    }

    .fas {
        color: white;
    }

    #body-row {
        margin-left: 0;
        margin-right: 0;
    }

    #sidebar-container {
        min-height: 100vh;
        background-color: #20274e;
        padding: 0;
    }

    /* Sidebar sizes when expanded and expanded */
    .sidebar-expanded {
        width: 280px;
    }

    .sidebar-collapsed {
        width: 60px;
    }

    /* Menu item*/
    #sidebar-container .list-group a {
        height: 50px;
        color: white;
    }

    /* Submenu item*/
    #sidebar-container .list-group .sidebar-submenu a {
        height: 45px;
        padding-left: 30px;
    }

    .sidebar-submenu {
        font-size: 0.9rem;
    }

    /* Separators */
    .sidebar-separator-title {
        background-color: #20274e;
        height: 35px;
    }

    .sidebar-separator {
        background-color: #20274e;
        height: 25px;
    }

    /*.logo-separator {
        background-color: #20274e;
        height: 60px;
    }*/

    /* Closed submenu icon */
    #sidebar-container .list-group .list-group-item[aria-expanded="false"] .submenu-icon::after {
        content: " \f0dd";
        font-family: Font Awesome 5 Free;
        display: inline;
        text-align: right;
        padding-left: 10px;
    }

    /* Opened submenu icon */
    #sidebar-container .list-group .list-group-item[aria-expanded="true"] .submenu-icon::after {
        content: " \f0dd";
        font-family: Font Awesome 5 Free;
        display: inline;
        text-align: right;
        padding-left: 10px;
    }

    .searchInput {
        width: 320px;
        border: none;
        height: 40px;
        font-size: 16px;
        background-color: #353d6a;
        /* font-family: "Font Awesome 5 Free"; */
        /* font-weight: 600; */
        background-image: url('img/level1/icon_search.svg');
    background-repeat: no-repeat;
    background-size: 25px 25px;
    background-position: 22px 10px;
    padding-left: 72px;
    color:white;
    }

    .companyLogo {
        margin-right: 15px;
    }

    .companyName {
        font-size: 16px;
    }

    .brand-name {
        margin-left: 15px;
        font-size: 16px;
    }

    .brand-name {
        margin-right: 82px;
    }

    .workTypeLogo {
        margin-left: 60px;
    }

    .workTypeText {
        color: white;
        font-size: 16px;
        margin-left: 2px;
    }


    /*.logo a:link, a:hover, a:visited {
     color: white;*/


    }

    .bigdatabtn {
        color: white;
        background-color: purple;
        border: none;
        border-radius: 20px;
        margin-left: 40px;
    }
</style>
