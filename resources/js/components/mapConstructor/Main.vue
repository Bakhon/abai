<template>
    <div class="map-constructor">
        <RightClickMenu
                @openRightMap="openRightMap"
                @closeMenu="closeMenu"
                @openRightLayers="openRightLayers"
                @closeMenuLayers="closeMenuLayers"
                ref="rightClickMenu"
                :right-map="rightMap"
                :right-layers="rightLayers"
                :top="top"
                :left="left"
                :viewMenu="viewMenu"
                :viewMenuLayers="viewMenuLayers">
        </RightClickMenu>
        <TopMenu @addFile="addFile"></TopMenu>
        <div class="col-lg-12 px-1 py-3">
            <div class="dashboard">
                <div class="tools">
                    <div class="left-tools" v-for="tool in leftTools">
                        <div class="tool">
                            <div class="box">
                                <i :class="tool.icon"></i>
                            </div>
                            <span>{{ trans(tool.langCode) }}</span>
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
                    <div v-if="mapInitialized" class="main-map" @contextmenu="openMenu">
                        <div id="olmap" style="width: 100%; height: 100vh"></div>
                        <div style="display: none;">
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
        <ExportModal></ExportModal>    </div>
</template>
<script src="./main.js"></script>

