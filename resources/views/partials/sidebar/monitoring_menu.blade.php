<li class="left-menu-li">
    <a class="d-flex justify-content-between" href="{{route('tech-map.index')}}">
        <div>
            <img src="/img/icons/monitor_gray.svg" class="companyLogo">
            {{ trans('monitoring.monitoring_module') }}
        </div>
        <img src="/img/icons/arrow-right.svg">
     </a>
    <ul class="dropdown-child">
        <div class="menu-header">
            <img src="/img/icons/monitor.svg" class="companyLogo">
            {{ trans('monitoring.monitoring_module') }}
        </div>
        <div class="menu-title no-route">{{ trans('monitoring.monitoring_module') }}</div>
        <li class="left-menu-li">
            <ul>
                @if(auth()->user()->can('monitoring view main'))
                    <li class="left-menu-li">
                        <a href="{{route('monitor')}}">
                            {{ trans('monitoring.gu-scheme') }}
                        </a>
                    </li>
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
                        <a href="{{route('omgngdu-zu.index')}}">
                            {{ trans('monitoring.omgngdu_zu.menu') }}
                        </a>
                    </li>
                    <li class="left-menu-li">
                        <a href="{{route('omgngdu-well.index')}}">
                            {{ trans('monitoring.omgngdu_well.menu') }}
                        </a>
                    </li>
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
                <div class="menu-title no-route">
                    {{ trans('monitoring.kaznipi') }}
                </div>
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
                    @if(auth()->user()->can('monitoring list manual_hydro_calculation'))
                        <li class="left-menu-li">
                            <a href="{{route('manual_hydro_calculation.index')}}">
                                {{ trans('monitoring.manual_hydro_calculation.menu') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if(
            auth()->user()->can('monitoring list pipes')
            || auth()->user()->can('monitoring list inhibitors')
            || auth()->user()->can('monitoring list pipe-passport')
            || auth()->user()->can('monitoring list agzu')
            || auth()->user()->can('monitoring list buffer-tank')
            || auth()->user()->can('monitoring list metering-units')
            || auth()->user()->can('monitoring list ovens')
            || auth()->user()->can('monitoring list pumps')
            || auth()->user()->can('monitoring list sib')
        )
            <li class="left-menu-li">
                <div class="menu-title no-route">
                    {{ trans('monitoring.gu_equipment') }}
                </div>
                <ul>
                    @if(auth()->user()->can('monitoring list pipe-passport'))
                    <li class="left-menu-li">
                        <a href="{{route('pipe-passport.index')}}">
                            {{ trans('monitoring.pipe_passport.title') }}
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
                    @if(auth()->user()->can('monitoring list buffer-tank'))
                        <li class="left-menu-li">
                            <a href="{{route('buffer-tank.index')}}">
                                {{ trans('monitoring.buffer_tank.title') }}
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
                    @if(auth()->user()->can('monitoring list sib'))
                        <li class="left-menu-li">
                            <a href="{{route('sib.index')}}">
                                {{ trans('monitoring.sib.title') }}
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
                <div class="menu-title no-route">
                    {{ trans('monitoring.dictionaries') }}
                </div>
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

        @if(auth()->user()->can('monitoring view pipes map'))
            <li class="left-menu-li">
                <div class="menu-title">
                    <a href="{{route('tech-map.index')}}">
                        {{ trans('monitoring.tech_map') }}
                    </a>
                </div>
            </li>
        @endif

        @if(auth()->user()->can('monitoring view pipes map'))
            <li class="left-menu-li">
                <div class="menu-title">
                    <a href="{{route('map-history.index')}}">
                        {{ trans('monitoring.map-history.menu') }}
                    </a>
                </div>
            </li>
        @endif

        <li class="left-menu-li">
            <div class="menu-title">
                <a href="{{route('facilities')}}">
                    {{ trans('monitoring.tech_map_prototype') }}
                </a>
            </div>
        </li>
        @if(auth()->user()->can('monitoring list lost_profits'))
            <li class="left-menu-li">
                <div class="menu-title">
                    <a href="{{route('lost-profits.index')}}">
                        {{ trans('monitoring.lost_profits_title') }}
                    </a>
                </div>
            </li>
        @endif
        @if(auth()->user()->can('monitoring list economical_effect'))
            <li class="left-menu-li">
                <div class="menu-title">
                    <a href="{{route('economical-effect.index')}}">
                        {{ trans('monitoring.economical_effect_title') }}
                    </a>
                </div>
            </li>
        @endif
    </ul>
</li>
