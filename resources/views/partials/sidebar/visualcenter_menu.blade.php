<div class="dropright">
    <div data-toggle="dropdown">
        <a href="{{url('/')}}/ru/visualcenter3" class="bg-dark-new list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="/img/gno/eye.png" class="companyLogo">
                <span class="menu-collapsed companyName d-none"></span>
            </div>
        </a>
    </div>
    <div class="dropdown-menu dropdown-menu__fourth">
        <div class="menu-header justify-content-between">
            <div class="d-flex align-items-center">
                <img src="/img/icons/sidebar_modules_blue.svg" class="companyLogo">
                {{ trans('app.modules') }}
            </div>
        </div>
        <div class="move-menu vc3_min-width">
            @if ((auth()->user()->can('visualcenter view main')) or (auth()->user()->can('visualcenter one_dzo main')))
            <li class="left-menu-li"><a href="{{ route('visualcenter3') }}">{{ trans("visualcenter.headOfPageModule") }}</a></li>
            <li class="left-menu-li"><a href="{{ route('excelform') }}">{{ trans("visualcenter.inputForm") }}</a></li>
            @endif
            @if (auth()->user()->can('visualcenter view main'))
            <li class="left-menu-li"><a href="{{ route('daily-report') }}">{{ trans("visualcenter.dailyReportsKMG") }}</a></li>
            <li class="left-menu-li"><a href="{{ route('daily-approve') }}">{{ trans("visualcenter.approvalsTable") }}</a></li>
            @endif
        </div>
    </div>
</div>
@if (auth()->user()->can('visualcenter view main'))
<div class="dropright">
    <div data-toggle="dropdown">
        <a href="{{url('/')}}/ru/visualcenter4" class="bg-dark-new list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="/img/gno/kpi.png" class="companyLogo">
                <span class="menu-collapsed companyName d-none"></span>
            </div>
        </a>
    </div>
    <div class="dropdown-menu dropdown-menu__fifth">
        <div class="menu-header justify-content-between">
            <div class="d-flex align-items-center">
                <img src="/img/icons/sidebar_modules_blue.svg" class="companyLogo">
                {{ trans('app.modules') }}
            </div>
        </div>
        <div class="move-menu vc3_min-width">
            <li class="left-menu-li menu-title no-route ">{{ trans("visualcenter.version") }} 2020</li>
            <li class="left-menu-li"><a href="{{url('/')}}/ru/visualcenter4">{{ trans("visualcenter.corpKPI") }}</a></li>
            <li class="left-menu-li"><a href="{{url('/')}}/ru/visualcenter7">{{ trans("visualcenter.prodKPI") }}</a></li>
            <li class="left-menu-li"><a href="{{url('/')}}/ru/visualcenter6">{{ trans("visualcenter.strategyKPI") }}</a></li>
            <li class="left-menu-li menu-title no-route font-weight-bold">{{ trans("visualcenter.version") }} 2021</li>
            <li class="left-menu-li"><a href="{{ route('kpd-tree') }}">{{ trans("visualcenter.upstreamKPI") }}</a></li>
        </div>
    </div>
</div>
@endif
@if (auth()->user()->can('visualcenter view main'))
<a href="{{url('/')}}/ru/visualcenter5" class="bg-dark-new list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/visualcenter3/tenge.png" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>
@endif
