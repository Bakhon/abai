<nav class="navbar navbar-expand-lg navbar-dark bg-dark-new">
    <a href="{{url('/')}}">
        <div class="logo"></div>
    </a>
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
                <li class="nav-item2 active dropdown2">
                    <a href="{{ route('profile') }}" class="nav-avatar-wrap">
                        @if(auth()->user()->profile && auth()->user()->profile->thumb)
                            <img src="{{ auth()->user()->profile->thumb }}">
                        @else
                            <img src="{{ asset('img/level1/icon_user.svg') }}">
                        @endif
                    </a>
                    <ul class="dropdown-child2">
                        <li class="nav-item child2">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}
                                <a class="logout" onClick="document.forms['logout-form'].submit();" href="#"> Выйти</a>
                            </form>
                    </li>
                    <li class="nav-item child">
                    </li>
                </ul>
            </li>
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
    $(function(){
        $('.nav-lang__select').click(function(){
            $('.nav-lang').toggleClass('active')
        })
        $(document).click(function(event) {
            var $target = $(event.target);
            if(!$target.closest('.nav-lang').length) {
                $('.nav-lang').removeClass('active');
            }
        });
    })
</script>
