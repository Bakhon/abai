<ul class="menu-collapsed padding" aria-expanded="false" data-toggle="collapse show">
    <a href="{{route('mainpage')}}" class="bg-dark list-group-item list-group-item-action flex-column align-items-start">
        <div class="d-flex w-100 justify-content-start align-items-center"><img src="/img/gno/home.png"
                                                                                width="25" height="25"
                                                                                class="companyLogo"> <span
                    class="menu-collapsed companyName d-none"></span></div>
    </a>

    <a href="#" class="bg-dark list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-start align-items-center"><img src="/img/gno/star.png"
                                                                                width="25" height="25"
                                                                                class="companyLogo"> <span
                    class="menu-collapsed companyName d-none"></span></div>
    </a>
    <div class="dropright">
        <div data-toggle="dropdown">
            <a href="#" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center"><img src="/img/gno/list.png"
                                                                                        width="25" height="25"
                                                                                        class="companyLogo">
                    <span class="menu-collapsed companyName d-none"></span></div>
            </a>
        </div>
        <div class="dropdown-menu">
            <div class="move-menu">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label class="form-check-label" for="inlineRadio1">Казгермунай</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                    <label class="form-check-label" for="inlineRadio2">КаражанбасМунай</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                    <label class="form-check-label" for="inlineRadio3">Казахойл</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                    <label class="form-check-label" for="inlineRadio3">МангистауМунайГаз</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                    <label class="form-check-label" for="inlineRadio3">ЭмбаМунайГаз</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                    <label class="form-check-label" for="inlineRadio3">УзенМунайГаз</label>
                </div>
                <button type="button" class="btn btn-secondary btn-sm companylist" style="margin-left: 30px;">
                    Выбрать
                </button>

            </div>
        </div>
    </div>


    <div class="dropright">
        <div data-toggle="dropdown">
            <a href="#" class="bg-dark list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center"><img
                            src="/img/gno/some-square.png" width="25" height="25" class="companyLogo"> <span
                            class="menu-collapsed companyName d-none"></span></div>
            </a>
        </div>
        <div class="dropdown-menu">
            <div class="move-menu">
                <li class="left-menu-li"> <a href="{{route('bigdata')}}">Модуль "Прототип БД ABAI"</a></li>
                <li class="left-menu-li"> <a href="{{route('visualcenter3')}}">Модуль "Центр визуализации"</a></li>
                <li class="left-menu-li"> <a href="{{route('tr')}}">Модуль "Технологический режим"</a></li>
                <li class="left-menu-li"> <a href="{{route('gno')}}">Модуль "Подбор ГНО"</a></li>
                <li class="left-menu-li"> <a href="{{route('monitor')}}">Модуль "Мониторинг осложнений"</a>
                    <ul class="dropdown-child">
                        <li class="left-menu-li">
                            <ul>
                                @if(auth()->user()->can('monitoring view main'))
                                    <li class="left-menu-li">
                                        <a href="{{route('omgca.index')}}">
                                            {{ trans('monitoring.omgca.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring view main'))
                                    <li class="left-menu-li">
                                        <a href="{{route('omguhe.index')}}">
                                            {{ trans('monitoring.omguhe.menu') }}
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->can('monitoring view main'))
                                    <li class="left-menu-li">
                                        <a href="{{route('omgngdu.index')}}">
                                            {{ trans('monitoring.omgngdu.menu') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        @if(
                            auth()->user()->can('monitoring list watermeasurement')
                            || auth()->user()->can('monitoring list oilgas')
                            || auth()->user()->can('monitoring list corrosion')
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
                        <li class="left-menu-li">
                            @if(auth()->user()->can('monitoring view pipes map'))
                                <a href="{{route('maps.gu')}}">
                                    {{ trans('monitoring.tech_map') }}
                                </a>
                            @endif
                        </li>
                        <li class="left-menu-li">
                            <a href="{{route('facilities')}}">
                                {{ trans('monitoring.tech_map_prototype') }}
                            </a>
                        </li>
                    </ul>

                </li>
            </div>
        </div>
    </div>


    <a href="{{route('monitor.reports')}}" class="bg-dark list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-start align-items-center"><img src="/img/gno/download.png"
                                                                                width="25" height="25"
                                                                                class="companyLogo"> <span
                    class="menu-collapsed companyName d-none"></span></div>
    </a>


    <a href="#" class="bg-dark list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-start align-items-center">
            <svg width="27" height="23" viewBox="0 0 27 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M5.14269 8.93182H7.71417V17.8761H5.14269V8.93182ZM15.4286 12.7647H17.9998V17.8761H15.4286V12.7647ZM10.2854 5.09812H12.8571V17.8761H10.2854V5.09812ZM23.143 5.11115V1.27771H20.5713V5.11115H16.7143V7.66659H20.5713V11.5H23.143V7.66659H27V5.11115H23.143ZM20.5713 20.4446H2.57095V2.55544H17.9998V0H2.57095C1.15709 0 0 1.15022 0 2.55544V20.4446C0 21.8498 1.15709 23 2.57095 23H20.5713C21.986 23 23.143 21.8498 23.143 20.4446V14.0557H20.5713V20.4446Z"
                      fill="#FEFEFE"/>
            </svg>
            <span class="menu-collapsed companyName d-none"></span></div>
    </a>

</ul>