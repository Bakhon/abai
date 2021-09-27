<template>
    <div class="map-constructor">
        <RightClickMenu
            v-if="viewMenu || viewMenuLayers"
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
        <TopMenu @importFile="importFile"></TopMenu>
        <div class="col-lg-12 px-0 pt-1">
            <div class="dashboard">
                <div class="tools">
                    <div class="left-tools" >
                        <div class="tool" v-for="tool in leftTools">
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
                        <div class="tool">
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
                        <div class="layers-info">
                          <i class="fas fa-caret-down ml-2"></i>
                          <i class="fas fa-vector-square ml-2"></i>
                          <span class="ml-2">Группа</span>
                          <ul class="text-white list-style-none ml-4">
                            <li v-for="(layerGroup, index) in layersList">
                              <input type="checkbox" checked="1" @change="toggleOpacity(layerGroup)">
                              layer_{{ index }}
                            </li>
                          </ul>
                        </div>
                    </div>
                    <div class="main-map" @contextmenu="openMenu">
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
        <ExportModal></ExportModal>
    </div>
</template>
<script src="./main.js"></script>

