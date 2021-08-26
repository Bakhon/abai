<template>
    <div class="modal fade modal-printer modal-map" id="buildMapModal" tabindex="-1"
         aria-labelledby="exampleModalLabel4" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body printer-right">
                    <b-card no-body>
                        <b-tabs card>
                            <b-tab title="Данные" active>
                                <div class="row">
                                    <div class="col-4">
                                        <p> {{ trans('map_constructor.select_data') }}</p>
                                    </div>
                                    <div class="col-8">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton5" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                данные
                                            </button>
                                            <div class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton5">
                                                <a class="dropdown-item" href="#">данные</a>
                                                <a class="dropdown-item" href="#">данные</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p> {{ trans('map_constructor.filter') }}</p>
                                    </div>
                                    <div class="col-8">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton6" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                фильтр
                                            </button>
                                            <div class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton6">
                                                <a class="dropdown-item" href="#">фильтр</a>
                                                <a class="dropdown-item" href="#">фильтр</a>
                                                <a class="dropdown-item" href="#">фильтр</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </b-tab>
                            <b-tab title="Метод">
                                <div class="row">
                                    <div class="col-4">
                                        <p> {{ trans('map_constructor.method') }}</p>
                                    </div>
                                    <div class="col-8">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton7" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Кригинг, Метод Шепарда, Метод
                                            </button>
                                            <div class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton7">
                                                <a class="dropdown-item" href="#">Кригинг</a>
                                                <a class="dropdown-item" href="#">Метод Шепарда</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p> {{ trans('map_constructor.cell_size') }}</p>
                                    </div>
                                    <div class="col-8">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="mt-1" aria-label="all pages">
                                            <span class="mx-2">X</span>
                                            <input type="number" class="form-control number-s"
                                                   aria-label="Copies" placeholder="0000">
                                            <span class="mx-2">Y</span>
                                            <input type="number" class="form-control number-s"
                                                   aria-label="Copies" placeholder="0000">
                                        </div>
                                    </div>
                                </div>
                            </b-tab>
                            <b-tab title="Тренд">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="all-pages3">
                                            <input id="all-pages3" type="checkbox" class="mt-1"
                                                   aria-label="all pages">
                                            <span class="ml-1"> {{ trans('map_constructor.trend_use') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton8" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                .....
                                            </button>
                                            <div class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton8">
                                                <a class="dropdown-item" href="#">.....</a>
                                                <a class="dropdown-item" href="#">.....</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="all-pages4">
                                            <input id="all-pages4" type="checkbox" class="mt-1"
                                                   aria-label="all pages">
                                            <span class="ml-1"> {{ trans('map_constructor.border_load') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton9" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                .....
                                            </button>
                                            <div class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton9">
                                                <a class="dropdown-item" href="#">.....</a>
                                                <a class="dropdown-item" href="#">.....</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="all-pages5">
                                            <input id="all-pages5" type="checkbox" class="mt-1"
                                                   aria-label="all pages">
                                            <span class="ml-1"> {{ trans('map_constructor.break_consider') }}</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                    </div>
                                </div>
                            </b-tab>
                        </b-tabs>
                    </b-card>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"> {{ trans('map_constructor.apply') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{ trans('map_constructor.close') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
