<template>
    <div class="map-constructor">
        <TopMenu
            @importFile="importFile"
            :buildNameModal="buildNameModal"
            :buildMapModal="buildMapModal"
            :buildMapSpecificModal="buildMapSpecificModal"
            :interpolationModal="interpolationModal"
        ></TopMenu>
        <div class="col-lg-12 px-0 pt-1">
            <div class="dashboard">
                <div class="tools">
                    <div class="left-tools" >
                        <div class="tool" v-for="tool in leftTools" @click="toolAction(tool.action)">
                            <div class="box" :class="{activeTool: tool.isActive}">
                                <i :class="tool.icon"></i>
                            </div>
                            <span>{{ trans(tool.langCode) }}</span>
                        </div>
                    </div>
                    <div class="right-tools">
                        <div class="tool d-flex">
                            <div v-if="selectedMonth" class="text-white" @click="monthDown"><</div>
                            <div>
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
                                        @input="changeDate"
                                    >
                                    </datetime>
                                </div>
                                <span>{{ trans('map_constructor.date_picker') }}</span>
                            </div>
                            <div v-if="selectedMonth" class="text-white" @click="monthUp">></div>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <span>{{ trans('map_constructor.select_kno') }}</span>
                        </div>
                        <div class="tool">
                            <div class="box">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <span>{{ trans('map_constructor.select_kto') }}</span>
                        </div>
                    </div>
                </div>
                <div class="map-constructor-main">
                    <div class="layers">
                        <div class="form-group has-search m-0">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control" placeholder="Поиск">
                        </div>
                        <div class="layers-info" v-for="(project, index) in projects"
                             :key="'project_' + index"
                             :class="{activeProject: index === activeProjectIndex}"
                        >
                            <div
                                @click="activeProjectIndex = index"
                                @contextmenu.prevent="openCtxMenu(index, 'project', index)">
                                <i class="fas fa-caret-down ml-2"></i>
                                <i class="fas fa-vector-square ml-2"></i>
                                <span class="ml-2 h4"
                                >{{ project.name }}</span>
                            </div>
                          <draggable class="ml-3 text-white" v-model="project.layerGroups" @change="layerGroupsChangeOrder(project.layerGroups)"
                                     group="layers" @start="drag=true" @end="drag=false" >
                              <div class="d-flex align-items-center"
                                   v-for="(layerGroup, layerGroupIndex) in project.layerGroups"
                                   :key="'layerGroup_' + layerGroupIndex">
                                  <input class="mr-1" type="checkbox" checked="1"
                                         @change="toggleOpacity($event, layerGroup.getLayers())">
                                  <div @contextmenu.prevent="openCtxMenu(index, layerGroup.type, layerGroupIndex)">
                                      {{ layerGroup.name }}
                                  </div>
                              </div>
                          </draggable>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap" style="width: 80%;">
                        <Project v-for="(project, index) in projects"
                                 :ref="project.key"
                                 :key="project.key"
                                 :projectKey="project.key"
                                 :data="project"
                                 :class="{'active-project-block': index === activeProjectIndex}"
                                 :activeToolType="activeToolType"
                                 class="projectBlock"
                        ></Project>
                    </div>
                </div>
            </div>
        </div>
        <PrinterModal></PrinterModal>
        <ReportModal></ReportModal>
        <ExportModal></ExportModal>

        <context-menu class="right-click-menu" ref="ctxMenu" id="context-menu">
            <li v-for="ctxMenuItem in ctxMenuItems"
                @click="ctxMenuAction(ctxMenuItem.action)"
                v-if="ctxMenuItem.visible"
                class="d-flex justify-content-between"
            >
                <div>{{ ctxMenuItem.name }}</div>
                <div v-if="ctxMenuItem.icon">
                    <i :class="ctxMenuItem.icon"></i>
                </div>
            </li>
        </context-menu>
    </div>
</template>
<script src="./main.js"></script>
<style scoped>
.activeProject {
    background-color: rgba(100, 100, 100, 0.4);
}
.projectBlock {
    border: 1px groove;
}
.active-project-block {
    border: 2px groove #20e200;
}
.tool .fas, .tool .far {
    margin: 0.45rem 0 0 0;
}
.activeTool {
    background-color: #fff !important;
}
.activeTool i {
    color: black !important;
}
</style>