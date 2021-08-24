<a href="{{route('mainpage')}}"
   class="bg-dark-new list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/home.png" width="25" height="25" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>
<a href="#" class="bg-dark-new list-group-item list-group-item-action">
    <div class="d-flex w-100 justify-content-start align-items-center">
        <img src="/img/gno/star.png" width="25" height="25" class="companyLogo">
        <span class="menu-collapsed companyName d-none"></span>
    </div>
</a>
<div class="dropright">
    <div data-toggle="dropdown">
        <a href="#" class="bg-dark-new list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-start align-items-center">
                <img src="/img/gno/some-square.png" width="25" height="25" class="companyLogo">
                <span class="menu-collapsed companyName d-none"></span>
            </div>
        </a>
    </div>
    <div class="dropdown-menu">
        <div class="move-menu">
            <li class="left-menu-li"><a href="{{route('bigdata')}}">{{ trans('bd.bigdata_module') }}</a>
            </li>
            @if(auth()->user()->can('visualcenter view main'))
                <li class="left-menu-li"><a href="{{route('visualcenter3')}}">{{ trans('visualcenter.visualcenter_module') }}</a></li>
            @endif
            @if(auth()->user()->can('tr view main'))
                <li class="left-menu-li"><a href="{{route('tr')}}">{{ trans('tr.tr_module') }}</a></li>
            @endif
            @if(auth()->user()->can('podborGno view main'))
                <li class="left-menu-li"><a href="{{route('gno')}}">{{ trans('pgno.pgno_module') }}</a></li>
            @endif
            <li class="left-menu-li"><a href="{{route('monitor')}}">{{ trans('monitoring.monitoring_module') }}</a>
                <ul class="dropdown-child">
                    <li class="left-menu-li">
                        <ul>
                            @if(auth()->user()->can('monitoring view main'))
                                <li class="left-menu-li">
                                    <a href="{{route('omgca.index')}}">
                                        {{ trans('monitoring.omgca.menu') }}
                                    </a>
                                </li>
                                <li class="left-menu-li">
                                    <a href="{{route('omguhe.index')}}">
                                        {{ trans('monitoring.omguhe.menu') }}
                                    </a>
                                </li>
                                <li class="left-menu-li">
                                    <a href="{{route('omgngdu.index')}}">
                                        {{ trans('monitoring.omgngdu.menu') }}
                                    </a>
                                </li>
                                <li class="left-menu-li">
                                    <a href="{{route('omgngdu-well.index')}}">
                                        {{ trans('monitoring.omgngdu_well.menu') }}
                                    </a>
                                </li>
                                @if(auth()->user()->can('monitoring list pipe-passport'))
                                    <li class="left-menu-li">
                                        <a href="{{route('pipe-passport.index')}}">
                                            {{ trans('monitoring.pipe_passport.title') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list zu-cleanings'))
                                    <li class="left-menu-li">
                                        <a href="{{route('zu-cleanings.index')}}">
                                            {{ trans('monitoring.zu_cleanings.title') }}
                                        </a>
                                    </li>
                                @endif
                            @endif

                        </ul>
                    </li>
                    @if(
                        auth()->user()->can('monitoring list watermeasurement')
                        || auth()->user()->can('monitoring list oilgas')
                        || auth()->user()->can('monitoring list corrosion')
                        || auth()->user()->can('monitoring list hydro_calculation')
                        || auth()->user()->can('monitoring list reverse_calculation')
                    )
                        <li class="left-menu-li">
                            <a>
                                {{ trans('monitoring.kaznipi') }}
                            </a>
                            <ul>
                                @if(auth()->user()->can('monitoring list watermeasurement'))
                                    <li class="left-menu-li">
                                        <a href="{{route('watermeasurement.index')}}">
                                            {{ trans('monitoring.wm.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list oilgas'))
                                    <li class="left-menu-li">
                                        <a href="{{route('oilgas.index')}}">
                                            {{ trans('monitoring.oil.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list corrosion'))
                                    <li class="left-menu-li">
                                        <a href="{{route('corrosioncrud.index')}}">
                                            {{ trans('monitoring.corrosion.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list hydro_calculation'))
                                    <li class="left-menu-li">
                                        <a href="{{route('hydro_calculation.index')}}">
                                            {{ trans('monitoring.hydro_calculation.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list reverse_calculation'))
                                    <li class="left-menu-li">
                                        <a href="{{route('reverse_calculation.index')}}">
                                            {{ trans('monitoring.reverse_calculation.menu') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(
                        auth()->user()->can('monitoring list pipes')
                        || auth()->user()->can('monitoring list inhibitors')
                    )
                        <li class="left-menu-li">
                            <a>
                                {{ trans('monitoring.gu_equipment') }}
                            </a>
                            <ul>
                                @if(auth()->user()->can('monitoring list buffer-tank'))
                                    <li class="left-menu-li">
                                        <a href="{{route('buffer-tank.index')}}">
                                            {{ trans('monitoring.buffer_tank.title') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list pumps'))
                                    <li class="left-menu-li">
                                        <a href="{{route('pumps.index')}}">
                                            {{ trans('monitoring.pumps.title') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list ovens'))
                                    <li class="left-menu-li">
                                        <a href="{{route('ovens.index')}}">
                                            {{ trans('monitoring.ovens.title') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list agzu'))
                                    <li class="left-menu-li">
                                        <a href="{{route('agzu.index')}}">
                                            {{ trans('monitoring.agzu.title') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list sib'))
                                    <li class="left-menu-li">
                                        <a href="{{route('sib.index')}}">
                                            {{ trans('monitoring.sib.title') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list metering_units'))
                                    <li class="left-menu-li">
                                        <a href="{{route('metering-units.index')}}">
                                            {{ trans('monitoring.metering_units.title') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    @if(
                        auth()->user()->can('monitoring list pipes')
                        || auth()->user()->can('monitoring list inhibitors')
                    )
                        <li class="left-menu-li">
                            <a>
                                {{ trans('monitoring.dictionaries') }}
                            </a>
                            <ul>
                                @if(auth()->user()->can('monitoring list pipes'))
                                    <li class="left-menu-li">
                                        <a href="{{route('pipes.index')}}">
                                            {{ trans('monitoring.pipe.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list pipe_types'))
                                    <li class="left-menu-li">
                                        <a href="{{route('pipe_types.index')}}">
                                            {{ trans('monitoring.pipe_types.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring list inhibitors'))
                                    <li class="left-menu-li">
                                        <a href="{{route('inhibitors.index')}}">
                                            {{ trans('monitoring.inhibitors') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif

            @include('partials.sidebar.monitoring_menu')

            @if(auth()->user()->can('economic view main'))
                <li class="left-menu-li">
                    <div>{{ trans('economic_reference.economic_module') }}</div>
                    <ul class="dropdown-child">
                        <li class="left-menu-li">
                            <ul>
                                <li class="left-menu-li">
                                    <a href="{{route('economic_nrs')}}">
                                        {{ trans('economic_reference.nrs') }}
                                    </a>
                                </li>

                                <li class="left-menu-li">
                                    <a href="{{route('economic_optimization')}}">
                                        {{ trans('economic_reference.optimization_of_development') }}
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            @endif
        </div>
    </div>
</div>

@if(auth()->user()->can('digitalDrilling view main'))
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
                    <a href="{{route('digital-drilling-daily-report')}}">Суточный рапорт</a>
                </li>
            </div>
        </div>
    </div>
@endif
