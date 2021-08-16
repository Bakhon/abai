<div class="dropright">
    <div data-toggle="dropdown">
        <a href="{{url('/')}}/ru/visualcenter3" class="bg-dark-new list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="/img/gno/eye.png" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName d-none"></span>
            </div>
        </a>
    </div>
    <div class="dropdown-menu">
        <div class="move-menu vc3_min-width">
            <li><a href="{{ route('excelform') }}">Форма ввода</a></li>
            <li><a href="{{ route('daily-report') }}">Суточная отчетность КМГ</a></li>
            <li><a href="{{ route('daily-approve') }}">Таблица согласований</a></li>
        </div>
    </div>
</div>
<div class="dropright">
    <div data-toggle="dropdown">
        <a href="{{url('/')}}/ru/visualcenter4" class="bg-dark-new list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="/img/gno/kpi.png" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName d-none"></span>
            </div>
        </a>
    </div>
    <div class="dropdown-menu">
        <div class="move-menu vc3_min-width">
            <li class="font-weight-bold">Версия 2020</li>
            <li class="move-menu"><a href="{{url('/')}}/ru/visualcenter4">Корпоративные КПД</a></li>
            <li class="move-menu"><a href="{{url('/')}}/ru/visualcenter7">КПД Блока добычи</a></li>
            <li class="move-menu"><a href="{{url('/')}}/ru/visualcenter6">КПД Блока стратегии</a></li>
            <li class="font-weight-bold">Версия 2021</li>
            <li class="move-menu"><a href="{{ route('kpd-tree') }}">КПД Блока Upstream</a></li>
        </div>
    </div>
</div>
<a href="{{url('/')}}/ru/visualcenter5" class="bg-dark-new list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/arm.png" width="25" height="25" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>