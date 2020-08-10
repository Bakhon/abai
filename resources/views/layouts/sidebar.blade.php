<!-- Sidebar -->
<div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
    <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
    <!-- Bootstrap List Group -->
    <ul class="list-group">
        <!-- Separator with title -->
        <li class="">
            {{-- <small>MAIN MENU</small> --}}
            <span class="menu-collapsed companyName">
                <input id="password" type="text"  name="search" class="searchInput"    placeholder="Поиск">
            </span>
        </li>
        <!-- /END Separator -->
        <!-- Menu with submenu -->
        <a href="#" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_ozen.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">АО "ОзенМунайГаз"</span>
            </div>
        </a>
        {{-- <!-- Submenu content -->
        <div id='submenu2' class="collapse sidebar-submenu">
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                <span class="menu-collapsed">Settings</span>
            </a>
            <a href="#" class="list-group-item list-group-item-action bg-dark text-white">
                <span class="menu-collapsed">Password</span>
            </a>
        </div> --}}
        <a href="#" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_karazhanbas.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">АО "Каражанбасмунай"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_kazger.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">ТОО "КазГерМунай"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_ozen.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">АО "ЭмбаМунайГаз"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_mangistau.png') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">АО "Мангистаумунайгаз"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_kazakhturkmunai.png') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">ТОО "Казахтуркмунай"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_koa.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">ТОО "Казахойл Актобе"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_petrokaz.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">ПетроКазахстан Инк.</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_amangeldy.png') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">Амангельды Газ</span>
            </div>
        </a>
	   </ul>	
		
	 <a href="#submenu2"  data-toggle="collapse" aria-expanded="false"><div class="assets" tabindex="-0"  >Неоперационные активы
<div tabindex="-0" class="button-menu button-menu-position"></div></div></a>
	 <div id='submenu2' class="collapse sidebar-submenu">
 <ul class="list-group">
<a href="#"  class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_tengiz.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">ТОО «Тенгизшевройл»</span>
            </div>
        </a>			
        <a href="#" class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_karachaganak.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">«Карачаганак Петролеум
Оперейтинг б.в.»</span>
            </div>
        </a>
        <a href="#"  class="bg-dark list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_ncoc.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">«Норт Каспиан
Оперейтинг Компани н.в.»</span>
            </div>
        </a>
		</div>
    </ul><!-- List Group END-->
</div><!-- sidebar-container END -->