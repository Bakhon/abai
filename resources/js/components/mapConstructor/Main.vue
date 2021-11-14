<template>
    <div class="map-constructor">
        <TopMenu @importFile="importFile" :addProjectModal="addProjectModal"></TopMenu>
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
                        <div class="tool" @click="showBubbles">
                            <div class="box">
                                <i class="fas fa-map"></i>
                            </div>
                            <span>{{ trans('map_constructor.show') }}</span>
                        </div>
                    </div>
                </div>
                <div class="main">
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
                                @contextmenu.prevent="openCtxMenu(index)">
                                <i class="fas fa-caret-down ml-2"></i>
                                <i class="fas fa-vector-square ml-2"></i>
                                <span class="ml-2 h4"
                                >{{ project.name }}</span>
                            </div>
                          <draggable class="ml-3 text-white" v-model="project.layerGroups" @change="layerGroupsChangeOrder(project.layerGroups)"
                                     group="layers" @start="drag=true" @end="drag=false" >
                              <div v-for="(layerGroup, index) in project.layerGroups" :key="index">
                                  <input type="checkbox" checked="1" @change="toggleOpacity(layerGroup.getLayers())">
                                  {{ layerGroup.name }}
                              </div>
                          </draggable>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap" style="width: 80%;">
                        <Project v-for="(project, index) in projects"
                                 :ref="'mkProject_' + index"
                                 :key="'mkProject_' + index"
                                 :projectIndex="index"
                                 :data="project"
                                 class="projectBlock"
                        ></Project>
                    </div>
                </div>
            </div>
        </div>
        <PrinterModal></PrinterModal>
        <BuildMapModal></BuildMapModal>
        <BuildMapSpecificModal></BuildMapSpecificModal>
        <ReportModal></ReportModal>
        <ExportModal></ExportModal>

        <context-menu class="right-click-menu" ref="ctxMenu" id="context-menu">
            <li v-for="projectCtxMenuItem in projectCtxMenuItems" @click="ctxMenuAction(projectCtxMenuItem.action)">
                {{ projectCtxMenuItem.name }}
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
</style>