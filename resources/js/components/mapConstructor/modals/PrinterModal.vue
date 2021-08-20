<template>
    <div class="modal fade modal-printer" id="printerModal" tabindex="-1"
         aria-labelledby="exampleModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-5 printer-left">
                                <img src="/img/map-constructor/a4.png" alt="" class="img-fluid">
                                <div class="d-flex align-items-center mt-2">
                                    <i class="fas fa-angle-left"></i>
                                    <span class="mx-3 printer-left-text">1 из 1</span>
                                    <i class="fas fa-angle-right"></i>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <label for="all-pages7">
                                            <input id="all-pages7" type="checkbox" class="mt-1"
                                                   aria-label="all pages">
                                            <span class="ml-1">{{ trans('map_constructor.add_frame') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-6">
                                        <span>{{ trans('map_constructor.location') }}</span>
                                    </div>
                                    <div class="col-6">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton15" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Книжное
                                            </button>
                                            <div class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton15">
                                                <a class="dropdown-item" href="#">Книжное</a>
                                                <a class="dropdown-item" href="#">Альбомное</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <span>{{ trans('map_constructor.format') }}</span>
                                    </div>
                                    <div class="col-6">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton16" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                а4
                                            </button>
                                            <div class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton16">
                                                <a class="dropdown-item" href="#">а4</a>
                                                <a class="dropdown-item" href="#">а3</a>
                                                <a class="dropdown-item" href="#">а2</a>
                                                <a class="dropdown-item" href="#">а1</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7 printer-right printer-right--bottom">
                                <div class="row">
                                    <div class="col-3">
                                        <p>{{ trans('map_constructor.printer') }}</p>
                                    </div>
                                    <div class="col-9">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-exclamation-triangle mr-2"></i> Принтер не
                                                найден
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Canon MF320</a>
                                                <a class="dropdown-item" href="#">Hp JVR415</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <p class="text-right">{{ trans('map_constructor.installations') }}</p>
                                    </div>
                                    <div class="col-9">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton2" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Последняя установка
                                            </button>
                                            <div class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton2">
                                                <a class="dropdown-item" href="#">last update</a>
                                                <a class="dropdown-item" href="#">previous update</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <p class="text-right"> {{ trans('map_constructor.copies') }}</p>
                                    </div>
                                    <div class="col-9">
                                        <input type="number" class="form-control number-xl"
                                               aria-label="Copies" value="1">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <p class="text-right"> {{ trans('map_constructor.copies') }}</p>
                                    </div>
                                    <div class="col-9">
                                        <label for="all-pages">
                                            <input id="all-pages" type="checkbox" class="mt-1"
                                                   aria-label="all pages">
                                            <span class="ml-1"> {{ trans('map_constructor.all_pages') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                    </div>
                                    <div class="col-9">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="mt-1" aria-label="all pages">
                                            <span class="mx-2"> {{ trans('map_constructor.from') }}</span>
                                            <input type="number" class="form-control number-s"
                                                   aria-label="Copies" value="1">
                                            <span class="mx-2"> {{ trans('map_constructor.till') }}</span>
                                            <input type="number" class="form-control number-s"
                                                   aria-label="Copies" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="gray-border"></div>
                                <div class="row">
                                    <div class="col-3">
                                        <p> {{ trans('map_constructor.windows') }}</p>
                                    </div>
                                    <div class="col-9">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton3" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                Последняя установка
                                            </button>
                                            <div class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton3">
                                                <a class="dropdown-item" href="#">Canon MF320</a>
                                                <a class="dropdown-item" href="#">Hp JVR415</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <p class="text-right"> {{ trans('map_constructor.two_sided') }}</p>
                                    </div>
                                    <div class="col-9">
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle disabled"
                                                    type="button" id="dropdownMenuButton4"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Выкл.
                                            </button>
                                            <div class="dropdown-menu"
                                                 aria-labelledby="dropdownMenuButton4">
                                                <a class="dropdown-item" href="#">last update</a>
                                                <a class="dropdown-item" href="#">previous update</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                    </div>
                                    <div class="col-9">
                                        <label for="all-pages1">
                                            <input id="all-pages1" type="checkbox" class="mt-1"
                                                   aria-label="all pages">
                                            <span class="ml-1"> {{ trans('map_constructor.reverse_page') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                    </div>
                                    <div class="col-9">
                                        <label for="all-pages2">
                                            <input id="all-pages2" type="checkbox" class="mt-1"
                                                   aria-label="all pages">
                                            <span class="ml-1"> {{ trans('map_constructor.flip_horizontal') }}</span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"> {{ trans('map_constructor.print') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{ trans('map_constructor.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
