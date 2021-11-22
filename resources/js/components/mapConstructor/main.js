import TopMenu from './shared/TopMenu'
import PrinterModal from './modals/PrinterModal'
import BuildMapSpecificModal from './modals/BuildMapSpecificModal'
import ReportModal from './modals/ReportModal'
import ExportModal from './modals/ExportModal'
import './MyFilter'
import 'ol/ol.css';
import {globalloadingMutations} from '@store/helpers';
import Project from './components/Project';
import VModal from 'vue-js-modal/dist/index.nocss.js'
import 'vue-js-modal/dist/styles.css'
import ProjectModal from './modals/ProjectModal';
import BuildMapModal from './modals/BuildMapModal';
import contextMenu from 'vue-context-menu';
import moment from 'moment';

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
            projectCtxMenuItems: [
                {
                    name: this.trans('map_constructor.rename'),
                    action: 'rename',
                },
                {
                    name: this.trans('map_constructor.delete'),
                    action: 'delete',
                },
            ],
            maps: [],
            gridMapsValues: [],
            projects: [],
            activeProjectIndex: 0,
            rightClickTargetIndex: null,
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
        ProjectModal,
        contextMenu,
        VModal,
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        toggleOpacity(layerGroup) {
            layerGroup.forEach(layer => {
                if (layer.values_.type !== 'empty') {
                    layer.setOpacity(layer.getOpacity() ? 0 : 1);
                }
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
                    const projectRef = 'mkProject_' + this.activeProjectIndex;
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
        addProjectModal(e, projectIndex) {
            const $self = this;
            const oldProjectName = typeof this.projects[projectIndex] === "undefined" ? '' : this.projects[projectIndex].name;
            this.$modal.show(ProjectModal, {
                oldProjectName: oldProjectName,
                saveProject(projectName) {
                    if (projectName !== "") {
                        $self.saveProject(projectName, projectIndex);
                    }
                }
            }, {
                height: "20%",
                styles: "background-color: rgb(51, 57, 117);",
            });
        },
        buildMapModal() {
            if (this.projects.length === 0) {
                this.$notifyError(this.trans('map_constructor.import_add_project'));
                return false;
            }
            const projectRef = 'mkProject_' + this.activeProjectIndex;
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
                                const projectRef = 'mkProject_' + $self.activeProjectIndex;
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
        saveProject(projectName, projectIndex) {
            this.$modal.hideAll();
            if (typeof projectIndex !== "undefined") {
                this.projects[projectIndex].name = projectName;
                return;
            }
            if (this.projects.length < 4) {
                this.activeProjectIndex = this.projects.length;
                this.projects.push({
                    name: projectName,
                    layerGroups: [],
                });
                this.projectsMapResize();
            } else {
                this.$notifyError(this.trans('map_constructor.max_projects'));
            }
        },
        openCtxMenu(index) {
            this.$refs.ctxMenu.open();
            this.rightClickTargetIndex = index;
        },
        ctxMenuAction(action) {
            switch (action) {
                case 'rename':
                    this.addProjectModal({}, this.rightClickTargetIndex)
                    break;
                case 'delete':
                    this.$refs['mkProject_' + this.rightClickTargetIndex][0].removeAllLayers().then(() => {
                        this.projects.splice(this.rightClickTargetIndex, 1);
                        this.projectsMapResize();
                        this.activeProjectIndex = 0;
                    }, () => {});
                    break;
            }
        },
        projectsMapResize() {
            this.projects.forEach((project, index) => {
                let $self = this;
                setTimeout( function() {
                    $self.$refs['mkProject_' + index][0].updateMapSize();
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
            const projectRef = 'mkProject_' + this.activeProjectIndex;
            this.$refs[projectRef][0].addGeographicalMap();
        },
        showBubblesByDate() {
            const projectRef = 'mkProject_' + this.activeProjectIndex;
            let data = null;
            this.bubblesData.forEach(item => {
                if (!this.selectedMonth) {
                    const newDate = new Date();
                    this.selectedMonth = `${newDate.getFullYear()}-${newDate.getMonth()}-${newDate.getDay()}`;
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
    },
    mounted() {
        this.getGeoList('dzo');
    }
}
