import RightClickMenu from './shared/RightClickMenu'
import TopMenu from './shared/TopMenu'
import PrinterModal from './modals/PrinterModal'
import BuildMapModal from './modals/BuildMapModal'
import BuildMapSpecificModal from './modals/BuildMapSpecificModal'
import ReportModal from './modals/ReportModal'
import ExportModal from './modals/ExportModal'
import './MyFilter'
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import 'ol/ol.css';
import {Vector as VectorLayer} from 'ol/layer';
import {Vector as VectorSource} from 'ol/source';
import {Fill, Stroke, Style, Text} from 'ol/style';
import Feature from 'ol/Feature';
import Map from 'ol/Map';
import Projection from 'ol/proj/Projection';
import View from 'ol/View';
import monthlyOilValue from './data.json'
import {LineString, Polygon} from "ol/geom";
import LayerGroup from "ol/layer/Group";
import {globalloadingMutations} from '@store/helpers';
export default {
    data() {
        return {
            monthlyOilValue: monthlyOilValue.data,
            accumulatedSelected: false,
            currentSelected: false,
            selectedMonth: null,
            viewMenu: false,
            viewMenuLayers: false,
            rightLayers: false,
            rightMap: false,
            top: '0px',
            left: '0px',
            windHeight: window.innerHeight,
            windWidth: window.innerWidth,
            date: null,
            mapInitialized: false,
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
            map: {},
            layerGroups: [],
            layersList: [],
        }
    },
    components: {
        Datetime,
        PrinterModal,
        BuildMapModal,
        BuildMapSpecificModal,
        ReportModal,
        ExportModal,
        RightClickMenu,
        TopMenu,
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        setMenu(top, left) {
            let largestHeight = this.windHeight - this.$refs.rightClickMenu.$refs.right.offsetHeight - 25;
            let largestWidth = this.windWidth - this.$refs.rightClickMenu.$refs.right.offsetWidth - 25;

            top = top > largestHeight ? largestHeight : top;
            left = left > largestWidth ? largestWidth : left

            this.top = `${top}px`;
            this.left = `${left}px`;
        },
        setMenuLayers(top, left) {
            let largestHeight = this.windHeight -  this.$refs.rightClickMenu.$refs.rightLayers.offsetHeight - 25;
            let largestWidth = this.windWidth -  this.$refs.rightClickMenu.$refs.rightLayers.offsetWidth - 25;

            top = top > largestHeight ? largestHeight : top;
            left = left > largestWidth ? largestWidth : left

            this.top = `${top}px`;
            this.left = `${left}px`;
        },
        closeMenu() {
            this.viewMenu = false;
        },
        closeMenuLayers() {
            this.viewMenuLayers = false;
        },
        openMenu(e) {
            this.viewMenu = true;
            Vue.nextTick(() => {
                this.$refs.rightClickMenu.$refs.right.focus();
                this.setMenu(e.y, e.x);
            });
            e.preventDefault();
        },
        openMenuLayers(e) {
            this.viewMenuLayers = true;
            Vue.nextTick(() => {
                this.$refs.rightClickMenu.$refs.rightLayers.focus();
                this.setMenuLayers(e.y, e.x);
            });
            e.preventDefault();
        },
        openRightLayers() {
            this.rightLayers = !this.rightLayers;
        },
        openRightMap() {
            this.rightMap = !this.rightMap;
        },
        showModal() {
            this.$refs['my-modal'].show()
        },
        hideModal() {
            this.$refs['my-modal'].hide()
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
            }
            this.sendFileToAPI(file, fileType);
        },
        drawLines(fileData) {
            let features = [];
            fileData.forEach(dataItem => {
                dataItem = dataItem.map(
                  value => {
                      if (value !== '') {
                          return value;
                      }
                  }
                );
                dataItem.forEach(lineData => {
                    features.push(new Feature({
                        geometry: new LineString(lineData)
                    }))
                })
            });
            const newLayer = new VectorLayer({
                source: new VectorSource({
                    features: features,
                    wrapX: false,
                }),
                style: new Style({
                    stroke: new Stroke({
                        color: '#f00',
                        width: 3,
                    }),
                }),
                zIndex: this.layersList.length + 1
            });
            let layerGroup = new LayerGroup();
            layerGroup.getLayers().push(newLayer);
            this.map.getLayerGroup().getLayers().push(layerGroup);
            this.layersList.push(layerGroup.getLayers());
            this.SET_LOADING(false);
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
                    if (type === 'shp') {
                        this.drawLines(response.data)
                    } else {
                        this.initPolygons(response.data);
                    }
                }
                this.SET_LOADING(false);
            })
            .catch(function(e){
                $self.$notifyError($self.trans('map_constructor.import_error'));
                $self.SET_LOADING(false);
            });
        },
        initMap(projection) {
            this.map = new Map({
                target: 'olmap',
                layers: this.layerGroups,
                view: new View({
                    projection: projection,
                    center: [projection.extent_[0] + (projection.extent_[2] - projection.extent_[0]) / 2,
                        projection.extent_[1] + (projection.extent_[3] - projection.extent_[1]) / 2],
                    zoom: 1,
                }),
            });
        },
        initPolygons(data) {
            const x1 = data.top_left[0];
            const y1 = data.top_left[1];
            const x2 = data.bottom_right[0];
            const y2 = data.bottom_right[1];
            const extent = [x1, y1, x2, y2];
            const projection = new Projection({
                units: 'pixels',
                extent: extent,
            });
            const internalStyle = new Style({
                stroke: new Stroke({
                    color: 'rgba(255, 255, 255, 0.1)',
                    width: 1,
                }),
                fill: new Fill({
                    color: 'rgba(255, 255, 255, 0.1)',
                }),
            });
            let layerGroup = new LayerGroup();
            const emptyLayer = new VectorLayer({
                source: new VectorSource({
                    features: [new Feature({
                        geometry: new Polygon([[
                            [x1, y1],
                            [x2, y1],
                            [x2, y2],
                            [x1, y2],
                        ]])
                    })]
                }),
                style: internalStyle,
                type: 'empty',
            });
            layerGroup.getLayers().push(emptyLayer);
            let redColor = 255;
            let greenColor = 255;
            data.polygons_per_levels.forEach((polygonsPerLevel, levelIndex) => {
                let internalVectorSource = new VectorSource();
                let externalVectorSource = new VectorSource();
                levelIndex = levelIndex !== 0 ? levelIndex : 1;
                const colorIndex = 255 - 255 / (levelIndex);
                if (levelIndex % 2 === 0) {
                    greenColor = colorIndex;
                } else {
                    redColor = colorIndex;
                }
                polygonsPerLevel.polygons.forEach((polygon) => {
                    const feature = new Feature({
                        geometry: new Polygon([polygon.data])
                    });
                    if (polygon.type === 'internal') {
                        internalVectorSource.addFeature(feature)
                    } else {
                        externalVectorSource.addFeature(feature)
                    }
                });
                const externalStyle = new Style({
                    stroke: new Stroke({
                        color: `rgba(${redColor}, ${greenColor}, 0, 0.5)`,
                        width: 1,
                    }),
                    fill: new Fill({
                        color: `rgba(${redColor}, ${greenColor}, 0, 0.5)`,
                    }),
                });
                let internalVectorLayer = new VectorLayer({
                    source: internalVectorSource,
                    style: internalStyle,
                });
                let externalVectorLayer = new VectorLayer({
                    source: externalVectorSource,
                    style: externalStyle,
                });
                layerGroup.getLayers().push(externalVectorLayer);
                layerGroup.getLayers().push(internalVectorLayer);
            });
            this.layerGroups.push(layerGroup)
            this.layersList.push(layerGroup.getLayers());
            this.initMap(projection);
        },
        toggleOpacity(layerGroup) {
            layerGroup.forEach(layer => {
                if (layer.values_.type !== 'empty') {
                    layer.setOpacity(layer.getOpacity() ? 0 : 1);
                }
            })
        }
    },
}
