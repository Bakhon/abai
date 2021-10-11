<a href="#" class="bg-dark-new list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/download.png" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>

<div class="dropright">
    <div data-toggle="dropdown">
        <a href="#" class="bg-dark-new list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M20.7052 7.09677H15.5294V0H20.7052C21.4191 0 21.9989 0.579078 21.9989 1.29341V5.80337C21.9989 6.51602 21.4197 7.09677 20.7052 7.09677ZM1.29471 7.09677C0.58012 7.09677 0 6.5177 0 5.80337V1.29341C0 0.580759 0.57966 0 1.29471 0H14.2353V7.09677H1.29471ZM1.61787 4.19355C1.43889 4.19355 1.29412 4.04777 1.29412 3.86795V3.22883C1.29412 3.04624 1.43907 2.90323 1.61787 2.90323H8.73507C8.91405 2.90323 9.05882 3.049 9.05882 3.22883V3.86795C9.05882 4.05053 8.91387 4.19355 8.73507 4.19355H1.61787ZM22 18.7078V8.04058C21.6192 8.26089 21.177 8.3871 20.7052 8.3871H1.29731C0.824342 8.3871 0.381326 8.26118 0 8.04115V18.7078C0 19.4215 0.57714 20 1.29407 20H20.7059C21.4206 20 22 19.4232 22 18.7078ZM1.61778 11.6129C1.44138 11.6129 1.29412 11.4671 1.29412 11.2873V10.6482C1.29412 10.4656 1.43903 10.3226 1.61778 10.3226H12.6175C12.7939 10.3226 12.9412 10.4684 12.9412 10.6482V11.2873C12.9412 11.4699 12.7963 11.6129 12.6175 11.6129H1.61778ZM1.61787 14.8387C1.43889 14.8387 1.29412 14.6929 1.29412 14.5131V13.874C1.29412 13.6914 1.43907 13.5484 1.61787 13.5484H8.73507C8.91405 13.5484 9.05882 13.6942 9.05882 13.874V14.5131C9.05882 14.6957 8.91387 14.8387 8.73507 14.8387H1.61787ZM1.61705 18.0645C1.43885 18.0645 1.29412 17.9187 1.29412 17.7389V17.0998C1.29412 16.9172 1.4387 16.7742 1.61705 16.7742H10.6771C10.8553 16.7742 11 16.92 11 17.0998V17.7389C11 17.9215 10.8554 18.0645 10.6771 18.0645H1.61705ZM20.5347 2.77923C20.7281 2.57535 20.7281 2.2448 20.5347 2.04093C20.3414 1.83705 20.028 1.83705 19.8347 2.04093L18.1429 3.82527L17.5647 3.21556C17.3714 3.01168 17.058 3.01168 16.8647 3.21556C16.6714 3.41944 16.6714 3.74999 16.8647 3.95386L17.6528 4.78506C17.9235 5.07049 18.3622 5.07049 18.6329 4.78506L20.5347 2.77923Z"
                          fill="#FEFEFE"/>
                </svg>
                <span class="menu-collapsed companyName d-none"></span>
            </div>
        </a>
    </div>
    <div class="dropdown-menu dropdown-menu__fifth">
       <div class="menu-header justify-content-between">
                <div class="d-flex align-items-center">
                    <img src="/img/icons/sidebar_modules_blue.svg" class="companyLogo">
                    {{ trans('bd.bigdata_module') }}
                </div>
            </div>
        <div class="move-menu">
            <li class="left-menu-li">
                <a href="{{route('bigdata.wells.index')}}">Формы ввода</a>
            </li>
            <li class="left-menu-li">
                <a href="{{route('bigdata.wells.create')}}">Регистрация скважины</a>
            </li>
            <li class="left-menu-li">
                <a href="{{route('bigdata.well_card')}}">Карточка скважины</a>
            </li>
        </div>
    </div>
</div>
