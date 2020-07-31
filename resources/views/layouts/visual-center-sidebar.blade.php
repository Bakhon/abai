<!-- Sidebar -->
<div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
    <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
    <!-- Bootstrap List Group -->
    <ul class="list-group">
        <!-- Separator with title -->
        <!--<li class="">
            {{-- <small>MAIN MENU</small> --}}
            <span class="menu-collapsed companyName">
                <input id="password" type="text"  name="search" class="searchInput"    placeholder="Поиск">
            </span>
        </li>-->
        <!-- /END Separator -->
        <!-- Menu with submenu -->
			<a href="#submenu1" data-toggle="collapse" aria-expanded="false" ><div class="assets2" tabindex="-0"  >Операционные активы
</div></a>
 <div id='submenu1' class="collapse sidebar-submenu">
		<a href="#" data-toggle="collapse" aria-expanded="false" class="bg-dark list-group-item list-group-item-action circle-menu flex-column align-items-start circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center ">
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
        <a href="#" class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_karazhanbas.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">АО "Каражанбасмунай"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_kazger.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">ТОО "КазГерМунай"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_ozen.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">АО "ЭмбаМунайГаз"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_mangistau.png') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">АО "Мангистаумунайгаз"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_kazakhturkmunai.png') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">ТОО "Казахтуркмунай"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_koa.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">ТОО "Казахойл Актобе"</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_petrokaz.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">ПетроКазахстан Инк.</span>
            </div>
        </a>
        <a href="#" class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_amangeldy.png') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">Амангельды Газ</span>
            </div>
        </a></div>
	 
		
    </ul><!-- List Group END-->
	
	<a href="#submenu2" data-toggle="collapse" aria-expanded="false" ><div class="assets" tabindex="-0"  >Неоперационные активы
</div></a>
	 <div id='submenu2' class="collapse sidebar-submenu">
 <ul class="list-group">
<a href="#"  class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_tengiz.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">ТОО «Тенгизшевройл»</span>
            </div>
        </a>			
        <a href="#" class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_karachaganak.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">«Карачаганак <br>Петролеум
Оперейтинг б.в.»</span>
            </div>
        </a>
        <a href="#"  class="bg-dark list-group-item list-group-item-action circle-menu">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="{{ asset('img/level1/logo_ncoc.svg') }}" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName">«Норт Каспиан
Оперейтинг<br> Компани н.в.»</span>
            </div>
        </a>
		</div>
		
    </ul>	
	
	
	
	<div class="left-price-oil">
	
	<div class="left-price-oil2">Цена за нефть <div class="price-border ">43.1 $</div></div>
	
	<hr class="hr-visualcenter">
	<visual-center-chart-area-oil></visual-center-chart-area-oil>
	<hr class="hr-visualcenter">
	<ul class="oil-string-all">
	<li class="oil-string one">Нефть Brent</li>
	<li class="oil-string two">41,65</li>
	<li class="oil-string three">+0,60</li>
	<li class="oil-string three">+1,46%</li>
	</ul>
	<hr class="hr-visualcenter">
	<ul class="oil-string-all">
	<li class="oil-string one">Нефть WTI</li>
	<li class="oil-string two">41,65</li>
	<li class="oil-string three">+0,60</li>
	<li class="oil-string three">+1,46%</li>
	</ul>
	<hr class="hr-visualcenter">
	<ul class="oil-string-all">
	<li class="oil-string one">Нефть Urals</li>
	<li class="oil-string two">41,65</li>
	<li class="oil-string three">+0,60</li>
	<li class="oil-string three">+1,46%</li>
	</ul>
	<hr class="hr-visualcenter">
	
	
	</div>


	<div class="assets3"></div>

	<div class="left-price-oil">
	<div class="left-price-oil2">
	Курс доллара <div class="price-border ">412.1 &#8376;</div></div>
	
	
	<ul class="oil-string-all">
	<li class="oil-string one2 width-price">1 казахстанский тенге равно</li>
	<li class="oil-string two2">1</li>
	<li class="oil-string three2">Тенге</li>
	</ul>
	
	<ul class="oil-string-all">
	<li class="oil-string one2-2 width-price">Доллар США</li>
	<li class="oil-string two2">0,0025</li>
	<li class="oil-string three2">Доллар</li>
	</ul>
	<visual-center-chart-area-usd></visual-center-chart-area-usd>
	
		</div>
		
	</div><!-- sidebar-container END -->	
