import TopMenu from './shared/TopMenu'
import PrinterModal from './modals/PrinterModal'
import BuildMapModal from './modals/BuildMapModal'
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
import contextMenu from 'vue-context-menu'

export default {
    data() {
        return {
            selectedMonth: null,
            leftTools: [
                {
                    icon: 'fas fa-plus',
                    langCode: 'map_constructor.add'
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
        showBubbles() {

        },
        addProjectModal(e, projectIndex) {
            const $self = this;
            const oldProjectName = typeof $self.projects[projectIndex] === "undefined" ? '' : $self.projects[projectIndex].name;
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
                    this.projects.splice(this.rightClickTargetIndex, 1);
                    break;
            }
        },
    },
}
