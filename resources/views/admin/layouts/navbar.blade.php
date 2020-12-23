<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a href="{{url('/admin')}}">
        <div class="logo"></div>
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item mr-5">
                <a href="{{route('admin.users.index')}}"><span class="workTypeText">Пользователи</span></a>
            </li>
            <li class="nav-item mr-5">
                <a href="{{route('admin.roles.index')}}"><span class="workTypeText">Роли</span></a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <ul class="navbar-nav flex align-items-center">
                <li class="nav-item2 active dropdown2">
                    <a href="{{ route('login') }}"><img src="{{ asset('img/level1/icon_user.svg') }}" width="30"
                                                        height="30" alt=""></a>
                    <ul class="dropdown-child2">
                        <li class="nav-item child2 mt-3">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}

                                <a class="logout" onClick="document.forms['logout-form'].submit();" href="#"> Выйти</a>
                            </form>
                        </li>
                        <li class="nav-item child">
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>