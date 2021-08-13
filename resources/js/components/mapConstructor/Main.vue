<template>
    <div class="map-constructor">
        <ul class="right-click-menu" ref="right" id="right-click-menu" tabindex="-1" v-if="viewMenu" @blur="closeMenu"
            :style="{ top:top, left:left }">
            <li>{{ trans('map_constructor.add_shape') }}</li>
            <li>{{ trans('map_constructor.text') }}</li>
            <li>{{ trans('map_constructor.copy') }}</li>
            <li>{{ trans('map_constructor.delete') }}</li>
            <li>{{ trans('map_constructor.legnd') }}</li>
            <li class="d-flex justify-content-between align-items-center" @click="openRightMap">{{ trans('map_constructor.settings') }} <i
                    class="fas fa-caret-right text-dark"></i></li>
            <div v-if="rightMap">
                <ul class="right-click-menu right-click-menu--dropdown">
                    <li>{{ trans('map_constructor.icon') }}</li>
                    <li>{{ trans('map_constructor.line') }}</li>
                    <li>{{ trans('map_constructor.color') }}</li>
                    <li>{{ trans('map_constructor.palette') }}</li>
                    <li>{{ trans('map_constructor.text') }}</li>
                    <li>{{ trans('map_constructor.size') }}</li>
                </ul>
            </div>

        </ul>
        <ul class="right-click-menu" ref="rightLayers" id="right-click-menu-layers" tabindex="-1" v-if="viewMenuLayers"
            @blur="closeMenuLayers" :style="{ top:top, left:left }">
            <li>{{ trans('map_constructor.rename') }}</li>
            <li>{{ trans('map_constructor.copy') }}</li>
            <li>{{ trans('map_constructor.delete') }}</li>
            <li>{{ trans('map_constructor.legend') }}</li>
            <li class="d-flex justify-content-between align-items-center" @click="openRightLayers">{{ trans('map_constructor.settings') }} <i
                    class="fas fa-caret-right text-dark"></i></li>
            <div v-if="rightLayers">
                <ul class="right-click-menu right-click-menu--dropdown">
                    <li>{{ trans('map_constructor.icon') }}</li>
                    <li>{{ trans('map_constructor.line') }}</li>
                    <li>{{ trans('map_constructor.color') }}</li>
                    <li>{{ trans('map_constructor.palette') }}</li>
                    <li>{{ trans('map_constructor.tex') }}</li>
                    <li>{{ trans('map_constructor.size') }}</li>
                    <li>{{ trans('map_constructor.map_name') }}</li>
                    <li>{{ trans('map_constructor.outline_labels') }}</li>
                    <li>{{ trans('map_constructor.legend_labels') }}</li>
                </ul>
            </div>
            <li>{{ trans('map_constructor.info') }}</li>
        </ul>
        <div class="top-menu">
            <div class="col-lg-3 px-1">
                <b-dropdown
                        block
                        class="w-100 map-dropdown"
                >
                    <template slot="button-content">
                        <i class="far fa-file mr-2"></i>
                        <span>{{ trans('map_constructor.file') }}</span>
                    </template>
                    <b-dropdown-item href="#" @click="addFile">{{ trans('map_constructor.new') }}</b-dropdown-item>
                    <label for="file-upload" class="dropdown-item">{{ trans('map_constructor.open') }}
                        <input type="file" name="myfile" id="file-upload"/>
                    </label>

                    <b-dropdown-item href="#">{{ trans('map_constructor.save') }}</b-dropdown-item>
                    <label for="import" class="dropdown-item">{{ trans('map_constructor.import') }}
                        <input type="file" name="import" id="import"/>
                    </label>
                    <b-dropdown-item data-toggle="modal" data-target="#exportModal">{{ trans('map_constructor.export') }}</b-dropdown-item>
                    <b-dropdown-item data-toggle="modal" data-target="#printerModal">{{ trans('map_constructor.print') }}</b-dropdown-item>
                </b-dropdown>
            </div>
            <div class="col-lg-3 px-1">
                <b-dropdown
                        block
                        class=" w-100 map-dropdown"
                >
                    <template slot="button-content">
                        <i class="far fa-map mr-2"></i>
                        <span>{{ trans('map_constructor.map') }}</span>
                    </template>
                    <b-dropdown-item data-toggle="modal" data-target="#buildMapSpecificModal">{{ trans('map_constructor.build_current') }}</b-dropdown-item>
                    <b-dropdown-item data-toggle="modal" data-target="#buildMapSpecificModal">{{ trans('map_constructor.build_accumulated') }}</b-dropdown-item>
                    <b-dropdown-item data-toggle="modal" data-target="#buildMapModal">{{ trans('map_constructor.build_map') }}</b-dropdown-item>
                    <b-dropdown-item href="#">{{ trans('map_constructor.calculator') }}</b-dropdown-item>
                </b-dropdown>
            </div>
            <div class="col-lg-3 px-1">
                <b-dropdown
                        block
                        class=" w-100 map-dropdown"
                >
                    <template slot="button-content">
                        <i class="fas fa-bars mr-2"></i>
                        <span>{{ trans('map_constructor.additionally') }}</span>
                    </template>
                    <b-dropdown-item href="#">{{ trans('map_constructor.voronov_diagram') }}</b-dropdown-item>
                    <b-dropdown-item href="#">{{ trans('map_constructor.streamlines') }}</b-dropdown-item>
                    <b-dropdown-item href="#">{{ trans('map_constructor.inventory_calculation') }}</b-dropdown-item>
                    <b-dropdown-item href="#">{{ trans('map_constructor.waterflooding_elements') }}</b-dropdown-item>
                </b-dropdown>
            </div>
            <div class="col-lg-3 px-1">
                <div class="map-dropdown" data-toggle="modal" data-target="#reportModal">
                    <div class="dropdown-toggle">
                        <i class="fas fa-file-invoice mr-2"></i>
                        <span class="text-white">{{ trans('map_constructor.report') }}</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-12 px-1 py-3">
            <div class="dashboard">
                <div class="tools">
                    <div class="left-tools">
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-plus"></i>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <span>{{ trans('map_constructor.add') }}</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-location-arrow"></i>
                            </div>
                            <span>{{ trans('map_constructor.cursor') }}</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="far fa-hand-paper"></i>
                            </div>
                            <span>{{ trans('map_constructor.hand') }}</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="far fa-copy"></i>
                            </div>
                            <span>{{ trans('map_constructor.copy') }}</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-ruler"></i>
                            </div>
                            <span>{{ trans('map_constructor.ruler') }}</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <span>{{ trans('map_constructor.reference') }}</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-cut"></i>
                            </div>
                            <span>{{ trans('map_constructor.scissors') }}</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-draw-polygon"></i>
                            </div>
                            <span>{{ trans('map_constructor.edit_polygon') }}</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="far fa-circle"></i>
                            </div>
                            <span>{{ trans('map_constructor.fictitious_point') }}</span>
                        </div>
                    </div>
                    <div class="right-tools">
                        <div class="tool">
                            <div class="box">
                                <i v-if="!selectedMonth" class="far fa-calendar"></i>
                                <span v-else>{{selectedMonth | dateFormat()}}</span>
                                <datetime
                                        type="date"
                                        v-model="selectedMonth"
                                        input-class="form-control filter-input calendar"
                                        format="MM/yy"
                                        :phrases="{ok: '', cancel: ''}"
                                        :disabled="isLoading"
                                        auto
                                        :flow="['year', 'month']"
                                >
                                </datetime>
                            </div>
                            <span>{{ trans('map_constructor.date_picker') }}</span>
                        </div>
                        <div class="tool" @click="accumulatedSelected = !accumulatedSelected">
                            <div class="box" :class="{'is-active': accumulatedSelected === true}">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <span>{{ trans('map_constructor.select_kno') }}</span>
                        </div>
                        <div class="tool" @click="currentSelected = !currentSelected">
                            <div class="box" :class="{'is-active': currentSelected === true}">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <span>{{ trans('map_constructor.select_kto') }}</span>
                        </div>
                        <div class="tool" @click="mapInit">
                            <div class="box">
                                <i class="fas fa-map"></i>
                            </div>
                            <span>{{ trans('map_constructor.show') }}</span>
                        </div>
                    </div>
                </div>
                <div class="main">
                    <div class="layers" @contextmenu="openMenuLayers">
                        <div class="form-group has-search m-0">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="Поиск">
                        </div>
                        <div class="layers-info" @click="showFiles">
                            <i id="arrow" class="fas fa-caret-right ml-2"></i>
                            <i class="fas fa-vector-square ml-2"></i>
                            <span class="ml-2">Info</span>
                        </div>
                        <div id="files" class="files">
                            <template v-for="file in files">
                                <div class="single-file">
                                    <i class="fas fa-file"></i>
                                    <span class="ml-2 text-white">File</span>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div v-if="isSelected" class="main-map" @contextmenu="openMenu">
                        <div id="olmap" style="width: 100%; height: 100vh"></div>
                        <div style="display: none;">
                            <a class="overlay" id="vienna" target="_blank" href="https://en.wikipedia.org/wiki/Vienna">Vienna</a>
                            <div id="marker" title="Marker"></div>
                            <div id="popup" class="text-dark"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <PrinterModal></PrinterModal>
        <BuildMapModal></BuildMapModal>
        <BuildMapSpecificModal></BuildMapSpecificModal>
        <ReportModal></ReportModal>
        <ExportModal></ExportModal>
    </div>
</template>
<script src="./main.js"></script>

