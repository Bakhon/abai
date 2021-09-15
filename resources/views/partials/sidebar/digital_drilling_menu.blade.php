{{--@if(auth()->user()->can('digitalDrilling view main'))--}}
    <div class="dropright">
        <div data-toggle="dropdown">
            <a href="#" class="bg-dark-new list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <img src="/img/digital-drilling/daily-raport.png" width="25" height="25" class="companyLogo">
                    <span class="menu-collapsed companyName d-none"></span>
                </div>
            </a>
        </div>
        <div class="dropdown-menu">
            <div class="move-menu">
                <li class="left-menu-li">
                    <a href="{{route('digital-drilling-daily-report')}}">{{trans('digital_drilling.daily_raport.DAILY_DRILLING_REPORT')}}</a>
                </li>
            </div>
        </div>
    </div>
{{--@endif--}}