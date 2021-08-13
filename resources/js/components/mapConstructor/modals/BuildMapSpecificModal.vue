<template>
    <div class="modal fade modal-printer modal-map" id="buildMapSpecificModal" tabindex="-1"
         aria-labelledby="exampleModalLabel6" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="text-white" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body printer-right py-5">
                    <div class="row">
                        <div class="col-4">
                            <p> {{ trans('map_constructor.select_data') }}</p>
                        </div>
                        <div class="col-8">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton13" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    данные
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton13">
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
                                        id="dropdownMenuButton14" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    фильтр
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton14">
                                    <a class="dropdown-item" href="#">фильтр</a>
                                    <a class="dropdown-item" href="#">фильтр</a>
                                    <a class="dropdown-item" href="#">фильтр</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p> {{ trans('map_constructor.date_picker') }}</p>
                        </div>
                        <div class="col-8">
                            <datetime
                                    v-model="date3"
                                    :disabled="isLoading"
                                    :flow="['year', 'month', 'date']"
                                    :phrases="{ok: '', cancel: ''}"
                                    auto
                                    format="dd LLLL yyyy"
                                    input-class="form-control"
                                    type="date"
                                    value-zone="Asia/Almaty"
                                    zone="Asia/Almaty"
                            >
                            </datetime>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"> {{ trans('map_constructor.build') }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> {{ trans('map_constructor.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
