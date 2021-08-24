<template>
    <div class="modal fade modal-printer modal-map modal-report" id="reportModal" tabindex="-1"
         aria-labelledby="exampleModalLabel5" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body printer-right">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <div class="row">
                                <div class="col-4">
                                    <p> {{ trans('map_constructor.select_map') }}</p>
                                </div>
                                <div class="col-8">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton10" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            Карты текущих/накопленных отборов
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton10">
                                            <a class="dropdown-item" href="#">Карты текущих/накопленных
                                                отборов</a>
                                            <a class="dropdown-item" href="#">Карты изобар</a>
                                            <a class="dropdown-item" href="#">Карта kh</a>
                                            <a class="dropdown-item" href="#">Карта перфорированных
                                                толщин</a>
                                            <a class="dropdown-item" href="#">Карта по сетке Вороного</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <p> {{ trans('map_constructor.report_wells') }}</p>
                                </div>
                                <div class="col-8">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton11" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            Выбор скв
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton11">
                                            <a class="dropdown-item" href="#">Выбор скв</a>
                                            <a class="dropdown-item" href="#">МЭР</a>
                                            <a class="dropdown-item" href="#">ГДИС (Рпл)</a>
                                            <a class="dropdown-item" href="#">Данные РИГИС</a>
                                            <a class="dropdown-item" href="#">…</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <p> {{ trans('map_constructor.report_format') }}</p>
                                </div>
                                <div class="col-8">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton12" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                            pdf
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton12">
                                            <a class="dropdown-item" href="#">doc</a>
                                            <a class="dropdown-item" href="#">excel</a>
                                            <a class="dropdown-item" href="#">...</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="report-right">
                                <h4> {{ trans('map_constructor.map_preview') }}</h4>
                                <div class="report-right--map"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"> {{ trans('map_constructor.apply') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{ trans('map_constructor.close') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
