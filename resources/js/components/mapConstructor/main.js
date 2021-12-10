import TopMenu from './shared/TopMenu'
import PrinterModal from './modals/PrinterModal'
import BuildMapSpecificModal from './modals/BuildMapSpecificModal'
import ReportModal from './modals/ReportModal'
import ExportModal from './modals/ExportModal'
import './MyFilter'
import 'ol/ol.css';
import 'ol-ext/dist/ol-ext.css'
import {globalloadingMutations} from '@store/helpers';
import Project from './components/Project';
import VModal from 'vue-js-modal/dist/index.nocss.js'
import 'vue-js-modal/dist/styles.css'
import NameModal from './modals/NameModal';
import BuildMapModal from './modals/BuildMapModal';
import ContextMenu from 'vue-context-menu';
import moment from 'moment';
import IsolinesMenu from "./modals/IsolinesMenu";

export default {
    data() {
        return {
            selectedMonth: '',
            leftTools: [
                {
                    icon: 'fas fa-plus',
                    langCode: 'map_constructor.add',
                    action: 'addGeographicalMap'
                },
                {
                    icon: 'fas fa-location-arrow',
                    langCode: 'map_constructor.cursor'
                },
                {
                    icon: 'far fa-hand-paper',
                    langCode: 'map_constructor.hand'
                },
                {
                    icon: 'far fa-copy',
                    langCode: 'map_constructor.copy'
                },
                {
                    icon: 'fas fa-ruler',
                    langCode: 'map_constructor.ruler'
                },
                {
                    icon: 'fas fa-info-circle',
                    langCode: 'map_constructor.reference'
                },
                {
                    icon: 'fas fa-cut',
                    langCode: 'map_constructor.scissors'
                },
                {
                    icon: 'fas fa-draw-polygon',
                    langCode: 'map_constructor.edit_polygon'
                },
                {
                    icon: 'far fa-circle',
                    langCode: 'map_constructor.fictitious_point'
                },
            ],
            ctxMenuItems: [
                {
                    name: this.trans('map_constructor.isolines'),
                    action: 'isolines',
                    visible: false,
                    forTypes: 'polygon',
                    icon: 'fas fa-bars text-black-50',
                },
                {
                    name: this.trans('map_constructor.rename'),
                    action: 'rename',
                    visible: false,
                    forTypes: 'all',
                    childMenu: null,
                },
                {
                    name: this.trans('map_constructor.delete'),
                    action: 'delete',
                    visible: false,
                    forTypes: 'project',
                    childMenu: null,
                },
            ],
            maps: [],
            gridMapsValues: [],
            projects: [],
            activeProjectIndex: 0,
            rightClickTargetIndex: null,
            rightClickTargetProjectIndex: null,
            rightClickTargetType: 'project',
            geoList: {
                dzoList: [],
                fieldList: [],
                horizonList: [],
            },
            bubblesData: [],
        }
    },
    components: {
        PrinterModal,
        BuildMapModal,
        BuildMapSpecificModal,
        ReportModal,
        ExportModal,
        TopMenu,
        Project,
        NameModal,
        ContextMenu,
        IsolinesMenu,
        VModal,
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        toggleOpacity(e, layerGroup) {
            layerGroup.forEach(layer => {
                layer.setOpacity(e.target.checked ? 1 : 0);
            })
        },
        layerGroupsChangeOrder(layerGroups) {
            layerGroups.forEach((layerGroup, index) => {
                layerGroup.getLayers().forEach(layer => {
                    layer.setZIndex(index);
                })
            })
        },
        importFile(file) {
            this.SET_LOADING(true);
            const extensions = ['irap', 'zmap', 'shp', 'txt'];
            let fileType = '';
            extensions.forEach(extension => {
                  if (fileType === '' && file.name.indexOf(extension) !== -1) {
                      fileType = extension;
                  }
              }
            )
            if (fileType === '') {
                this.$notifyError(this.trans('map_constructor.file_extension_error'));
                this.SET_LOADING(false);
                return false;
            }
            if (this.projects.length === 0) {
                this.$notifyError(this.trans('map_constructor.import_add_project'));
                this.SET_LOADING(false);
                return false;
            }
            this.sendFileToAPI(file, fileType);
        },
        sendFileToAPI(file, type) {
            let formData = new FormData();
            let $self = this;
            formData.append('file', file);
            formData.append('number_of_levels', '10');
            formData.append('type', type);
            axios.post(this.localeUrl('map-constructor/import'),
              formData,
              {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
              }
            ).then((response) => {
                if (response.data) {
                    const projectRef = this.projects[this.activeProjectIndex].key;
                    this.$refs[projectRef][0].importData(response.data, type);
                }
                this.SET_LOADING(false);
            })
            .catch(function(e){
              $self.$notifyError($self.trans('map_constructor.import_error'));
              $self.SET_LOADING(false);
            });
        },
        sendExcelToAPI(file) {
            this.SET_LOADING(true);
            let formData = new FormData();
            let $self = this;
            formData.append('file', file);
            axios.post(this.localeUrl('map-constructor/get_data_from_excel'),
              formData,
              {
                  headers: {
                      'Content-Type': 'multipart/form-data'
                  }
              }
            ).then((response) => {
                if (response.data) {
                    $self.bubblesData = response.data;
                    $self.showBubblesByDate();
                }
                this.SET_LOADING(false);
            })
            .catch(function(e){
                $self.$notifyError($self.trans('map_constructor.import_error'));
                $self.SET_LOADING(false);
            });
        },
        buildNameModal() {
            const $self = this;
            let oldName = '';
            if (this.rightClickTargetIndex !== null) {
                if (this.rightClickTargetType === 'project') {
                    oldName = this.projects[this.rightClickTargetIndex].name;
                } else {
                    oldName = this.projects[this.rightClickTargetProjectIndex].layerGroups[this.rightClickTargetIndex].name;
                }
            }
            this.$modal.show(NameModal, {
                oldName: oldName,
                save(name) {
                    if (name !== "") {
                        $self.saveName(name);
                        $self.resetToDefaultRightClickValues();
                    }
                }
            }, {
                height: "20%",
                styles: "background-color: rgb(51, 57, 117);",
            });
        },
        buildIsolinesModal() {
            const $self = this;
            this.$modal.show(IsolinesMenu, {
                isolinesData: {
                    selectedFilterType: $self.projects[$self.rightClickTargetProjectIndex]
                      .layerGroups[$self.rightClickTargetIndex].selectedFilterType,
                    selectedFilterValue: $self.projects[$self.rightClickTargetProjectIndex]
                      .layerGroups[$self.rightClickTargetIndex].selectedFilterValue,
                    bounds: $self.projects[$self.rightClickTargetProjectIndex]
                      .layerGroups[$self.rightClickTargetIndex].bounds,
                    show: $self.projects[$self.rightClickTargetProjectIndex]
                      .layerGroups[$self.rightClickTargetIndex].show,
                },
                save(isolinesData) {
                    const projectRef = $self.projects[$self.rightClickTargetProjectIndex].key;
                    $self.$refs[projectRef][0].map.removeLayer($self.projects[$self.rightClickTargetProjectIndex]
                      .layerGroups[$self.rightClickTargetIndex]);
                    $self.projects[$self.rightClickTargetProjectIndex].layerGroups
                      .splice($self.rightClickTargetIndex, 1);
                    const base64Data = $self.$refs[projectRef][0].base64Data;
                    $self.SET_LOADING(true);
                    axios.post($self.localeUrl('map-constructor/get_grid_by_base64'),
                      {
                          selectedFilterType: isolinesData.selectedFilterType,
                          selectedFilterValue: isolinesData.selectedFilterValue,
                          base64Data: base64Data,
                      },
                    ).then((response) => {
                        if (response.data) {
                            response.data.selectedFilterType = isolinesData.selectedFilterType;
                            response.data.selectedFilterValue = isolinesData.selectedFilterValue;
                            response.data.bounds = isolinesData.bounds;
                            response.data.show = isolinesData.show;
                            $self.$refs[projectRef][0].importData(response.data, 'grid');
                        }
                        $self.SET_LOADING(false);
                        $self.resetToDefaultRightClickValues();
                    }).catch(function(e){
                          $self.$notifyError($self.trans('map_constructor.import_error'));
                          $self.SET_LOADING(false);
                    });
                    this.$modal.hideAll();
                }
            }, {
                height: "35%",
                styles: "background-color: rgb(51, 57, 117);",
            });
        },
        buildMapModal() {
            if (this.projects.length === 0) {
                this.$notifyError(this.trans('map_constructor.import_add_project'));
                return false;
            }
            const projectRef = this.projects[this.activeProjectIndex].key;
            if (this.$refs[projectRef][0].map === null) {
                this.$notifyError(this.trans('map_constructor.geo_map_empty'));
                return false;
            }
            const $self = this;
            this.$modal.show(BuildMapModal, {
                buildMap() {
                    if (!this.lineFileDisabled && this.lineFileData !== null) {
                        $self.importFile(this.lineFileData);
                    }
                    if (this.bubblesFileData !== null) {
                        $self.sendExcelToAPI(this.bubblesFileData);
                    }
                    this.$modal.hideAll();
                }
            }, {
                styles: "background-color: rgb(51, 57, 117);",
            });
        },
        buildMapSpecificModal() {
            if (this.projects.length === 0) {
                this.$notifyError(this.trans('map_constructor.import_add_project'));
                return false;
            }
            const $self = this;
            if (this.geoList.dzoList.length > 0) {
                this.$modal.show(BuildMapSpecificModal, {
                    geoList: this.geoList,
                    getGeoList(type, id) {
                        if (id !== 0) {
                            if (type === 'field') {
                                $self.geoList.fieldList = [];
                                $self.geoList.horizonList = [];
                            } else if (type === 'horizon') {
                                $self.geoList.horizonList = [];
                            }
                            $self.getGeoList(type, id);
                        }
                    },
                    buildMapSpecific(selectedData) {
                        let geo = selectedData.selectedHorizon ? selectedData.selectedHorizon
                          : selectedData.selectedField ? selectedData.selectedField
                            : null;
                        if (!geo) {
                            this.$notifyError(this.trans('map_constructor.select_field_or_horizon'));
                            return;
                        }
                        $self.SET_LOADING(true);
                        axios.post(this.localeUrl('map-constructor/wells'), {
                            geo: geo,
                            selectedDzo: selectedData.selectedDzo,
                        }).then((response) => {
                            if (response.data) {
                                if (response.data.length === 0) {
                                    this.$notifyError(this.trans('map_constructor.empty_data'));
                                    return;
                                }
                                const projectRef = $self.projects[$self.activeProjectIndex].key;
                                $self.$refs[projectRef][0].showBubbles(response.data, 'oil_with_water');
                            }
                            this.$modal.hideAll();
                            this.geoList.fieldList = [];
                            this.geoList.horizonList = [];
                            $self.SET_LOADING(false);
                        });
                    }
                }, {
                    styles: "background-color: rgb(51, 57, 117);",
                });
            } else {
                this.$notifyError(this.trans('map_constructor.get_dzo_error'));
            }
        },
        saveName(name) {
            this.$modal.hideAll();
            if (this.rightClickTargetType === 'project') {
                if (this.rightClickTargetIndex !== null) {
                    this.projects[this.rightClickTargetIndex].name = name;
                    return;
                }
                if (this.projects.length < 4) {
                    this.activeProjectIndex = this.projects.length;
                    this.projects.push({
                        key: 'mcProject_' + this.projects.length,
                        name: name,
                        layerGroups: [],
                    });
                    this.projectsMapResize();
                } else {
                    this.$notifyError(this.trans('map_constructor.max_projects'));
                }
            } else {
                if (this.rightClickTargetProjectIndex !== null && this.rightClickTargetIndex !== null) {
                    this.projects[this.rightClickTargetProjectIndex].layerGroups[this.rightClickTargetIndex].name = name;
                }
            }
        },
        openCtxMenu(projectIndex, targetType, layerGroupIndex) {
            let showCTXMenu = false;
            this.ctxMenuItems.forEach(item => {
                item.visible = item.forTypes.indexOf(targetType) !== -1 || item.forTypes.indexOf('all') !== -1;
                if (item.visible) {
                    showCTXMenu = true;
                }
            })
            if (showCTXMenu) {
                this.$refs.ctxMenu.open();
                this.rightClickTargetProjectIndex = projectIndex;
                this.rightClickTargetIndex = layerGroupIndex;
                this.rightClickTargetType = targetType;
            }
        },
        ctxMenuAction(action) {
            switch (action) {
                case 'isolines':
                    this.buildIsolinesModal();
                    break;
                case 'rename':
                    this.buildNameModal();
                    break;
                case 'delete':
                    if (this.rightClickTargetType === 'project') {
                        if (this.rightClickTargetProjectIndex !== null) {
                            this.projects.splice(this.rightClickTargetProjectIndex, 1);
                            this.activeProjectIndex = 0;
                        }
                    } else {
                        if (this.rightClickTargetProjectIndex !== null && this.rightClickTargetIndex !== null) {
                            const projectRef = this.projects[this.activeProjectIndex].key;
                            this.projects[this.rightClickTargetProjectIndex]
                              .layerGroups.splice(this.rightClickTargetIndex, 1);
                            let layerToDelete = null;
                            this.$refs[projectRef][0].map.getLayers().forEach((layer, index) => {
                                if (index === this.rightClickTargetIndex) {
                                    layerToDelete = layer;
                                }
                            })
                            if (layerToDelete) {
                                this.$refs[projectRef][0].map.removeLayer(layerToDelete);
                            }
                            if (mapLayers.length === 0) {
                                this.$refs[projectRef][0].map = null;
                            }
                        }
                    }
                    this.projectsMapResize();
                    this.resetToDefaultRightClickValues();
                    break;
            }
        },
        projectsMapResize() {
            this.projects.forEach((project, index) => {
                let $self = this;
                setTimeout( function() {
                    $self.$refs[project.key][0].updateMapSize();
                }, 200);
            });
        },
        getGeoList(type, id) {
            this.SET_LOADING(true);
            axios.post(this.localeUrl('map-constructor/structure'), {
                type: type,
                id: id,
            }).then((response) => {
                if (response.data) {
                    this.geoList[type + 'List'] = response.data;
                } else {
                    this.$notifyError(this.trans('map_constructor.get_dzo_error'));
                }
                this.SET_LOADING(false);
            });
        },
        toolAction(action) {
            if (typeof action !== "undefined") {
                this[action]();
            }
        },
        addGeographicalMap() {
            if (this.projects.length === 0) {
                this.$notifyError(this.trans('map_constructor.import_add_project'));
                return false;
            }
            const projectRef = this.projects[this.activeProjectIndex].key;
            this.$refs[projectRef][0].addGeographicalMap();
        },
        showBubblesByDate() {
            const projectRef = this.projects[this.activeProjectIndex].key;
            let data = null;
            this.bubblesData.forEach(item => {
                if (!this.selectedMonth) {
                    this.selectedMonth = moment(new Date()).format('YYYY-MM-DD');
                }
                const selectedDate = new Date(this.selectedMonth);
                const excelDate = new Date(item.date);
                if (excelDate.getFullYear() === selectedDate.getFullYear()
                  && excelDate.getMonth() === selectedDate.getMonth()) {
                      data = item;
                }
            });
            if (data !== null) {
                this.$refs[projectRef][0].showBubbles(data, 'ppm');
            }
        },
        changeDate() {
            if (this.bubblesData.length > 0) {
                this.showBubblesByDate();
            }
        },
        monthUp() {
            let selectedDate = moment(this.selectedMonth, 'YYYY-MM-DD');
            let newDate = moment(selectedDate.add(1, 'M'));
            this.selectedMonth = newDate.format('YYYY-MM-DD');
            this.changeDate();
        },
        monthDown() {
            let selectedDate = moment(this.selectedMonth, 'YYYY-MM-DD');
            let newDate = moment(selectedDate.add(-1, 'M'));
            this.selectedMonth = newDate.format('YYYY-MM-DD');
            this.changeDate();
        },
        resetToDefaultRightClickValues() {
            this.rightClickTargetProjectIndex = null;
            this.rightClickTargetIndex = null;
            this.rightClickTargetType = 'project';
        }
    },
    mounted() {
        this.getGeoList('dzo');
    }
}
