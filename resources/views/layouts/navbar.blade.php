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
            <div class="module-block mr-auto">
                @hasSection('module_title')
                    <div class="module-block__icon">
                        @yield('module_icon')
                    </div>
                    <div class="module-block__title">
                        Модуль "@yield('module_title')"
                    </div>
                @endif
            </div>

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
