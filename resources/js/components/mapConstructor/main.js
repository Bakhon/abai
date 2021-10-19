import RightClickMenu from './shared/RightClickMenu'
import TopMenu from './shared/TopMenu'
import PrinterModal from './modals/PrinterModal'
import BuildMapModal from './modals/BuildMapModal'
import BuildMapSpecificModal from './modals/BuildMapSpecificModal'
import ReportModal from './modals/ReportModal'
import ExportModal from './modals/ExportModal'
import './MyFilter'
import 'ol/ol.css';
import {Vector as VectorLayer} from 'ol/layer';
import {Vector as VectorSource} from 'ol/source';
import {Fill, Stroke, Style, Text} from 'ol/style';
import Feature from 'ol/Feature';
import Map from 'ol/Map';
import Projection from 'ol/proj/Projection';
import View from 'ol/View';
import {Point, LineString, Polygon} from "ol/geom";
import LayerGroup from "ol/layer/Group";
import {globalloadingMutations} from '@store/helpers';
import draggable from 'vuedraggable'
import {Overlay} from "ol";
import Chart from 'ol-ext/style/Chart'
import CircleStyle from "ol/style/Circle";

export default {
    data() {
        return {
            selectedMonth: null,
            viewMenu: false,
            viewMenuLayers: false,
            rightLayers: false,
            rightMap: false,
            top: '0px',
            left: '0px',
            windHeight: window.innerHeight,
            windWidth: window.innerWidth,
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
            gridMapsValues: [],
        }
    },
    components: {
        PrinterModal,
        BuildMapModal,
        BuildMapSpecificModal,
        ReportModal,
        ExportModal,
        RightClickMenu,
        TopMenu,
        draggable,
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
                        color: '#3be7c5',
                        width: 3,
                    }),
                }),
                zIndex: this.layerGroups.length + 1
            });
            let layerGroup = new LayerGroup();
            layerGroup.name = 'Слой ' + this.layerGroups.length;
            layerGroup.getLayers().push(newLayer);
            this.addLayerGroupToMap(layerGroup);
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
                    if (type === 'shp' || type === 'txt') {
                        this.drawLines(response.data)
                    } else {
                        this.addPolygons(response.data);
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
            const mapExtent = projection.getExtent();
            this.map = new Map({
                target: 'olmap',
                layers: this.layerGroups,
                view: new View({
                    projection: projection,
                    center: [mapExtent[0] + (mapExtent[2] - mapExtent[0]) / 2,
                        mapExtent[1] + (mapExtent[3] - mapExtent[1]) / 2],
                    zoom: 1,
                }),
            });
        },
        addPolygons(data) {
            let x1 = data.top_left[0];
            let y1 = data.top_left[1];
            let x2 = data.bottom_right[0];
            let y2 = data.bottom_right[1];
            const extent = [x1, y1, x2, y2];
            const projection = new Projection({
                units: 'pixels',
                extent: extent,
            });
            this.initMap(projection);
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
                levelIndex = levelIndex !== 0 ? levelIndex : 1;
                const colorIndex = 255 - 255 / (levelIndex);
                if (levelIndex % 2 === 0) {
                    redColor = colorIndex;
                } else {
                    greenColor = colorIndex;
                }
                this.getPolygonsLayerGroup(layerGroup, polygonsPerLevel, {
                  'internal': internalStyle,
                  'external': this.getExternalLayerStyle(`rgba(${redColor}, ${greenColor}, 0, 0.7)`,
                    parseInt(polygonsPerLevel.lower_bound).toString()),
                });
            });
            layerGroup.name = 'Слой ' + this.layerGroups.length;
            this.addLayerGroupToMap(layerGroup);
            if (typeof data.grid !== "undefined") {
                this.addGrid(data);
            }
        },
        toggleOpacity(layerGroup) {
            layerGroup.forEach(layer => {
                if (layer.values_.type !== 'empty') {
                    layer.setOpacity(layer.getOpacity() ? 0 : 1);
                }
            })
        },
        layerGroupsChangeOrder() {
            this.layerGroups.forEach((layerGroup, index) => {
                layerGroup.getLayers().forEach(layer => {
                    layer.setZIndex(index);
                })
            })
        },
        addGrid(data) {
            let binValues = this.decodeFromBase64(data.grid);
            let shape = data.shape;
            let resultArray = [];
            for (let i = 0; i < Math.ceil(binValues.length / shape[1]); i++){
                resultArray[i] = binValues.slice((i * shape[1]), (i * shape[1]) + shape[1]);
            }
            if (this.map) {
                const self = this;
                const mapExtent = this.map.getView().getProjection().getExtent();
                this.gridMapsValues.push(resultArray);
                let popupDiv = document.createElement('div');
                let popupOverlay = new Overlay({
                    element: popupDiv,
                });
                this.map.on('pointermove', function (evt) {
                    if (
                      evt.coordinate[0] < mapExtent[0]
                      || evt.coordinate[0] > mapExtent[2]
                      || evt.coordinate[1] < mapExtent[1]
                      || evt.coordinate[1] > mapExtent[3]
                      || evt.dragging
                    ) {
                        popupDiv.classList.add('d-none');
                        return;
                    }
                    if (self.gridMapsValues.length > 0) {
                        const stepX = (mapExtent[2] - mapExtent[0]) / (shape[0] - 1);
                        const stepY = (mapExtent[3] - mapExtent[1]) / (shape[1] - 1);
                        popupDiv.classList.remove('d-none');
                        popupOverlay.setPosition(evt.coordinate);
                        let x = ((evt.coordinate[0] - mapExtent[0]) / stepX).toFixed(0);
                        let y = ((mapExtent[3] - mapExtent[1] - (evt.coordinate[1] - mapExtent[1])) / stepY).toFixed(0);
                        let value = self.gridMapsValues[0][x][y];
                        if (isNaN(value)) {
                            popupDiv.classList.add('d-none');
                            return;
                        }
                        popupDiv.innerHTML = '<div class="bg-white p-1"> Значение: ' + value.toFixed(2) + '</div';
                    }
                });
                this.map.addOverlay(popupOverlay);
            }
            this.SET_LOADING(false);
        },
        decodeFromBase64(encodedString) {
            let binary_string = atob(encodedString);
            let buffer = new ArrayBuffer(binary_string.length);
            let bytes_buffer = new Uint8Array(buffer);

            for (let i = 0; i < binary_string.length; i++) {
                bytes_buffer[i] = binary_string.charCodeAt(i);
            }

            let values = new Float64Array(buffer);
            return Array.from(values);
        },
        showBubbles() {
            const mapExtent = this.map.getView().getProjection().getExtent();
            const middleX = mapExtent[0] + (mapExtent[2] - mapExtent[0]) / 2;
            const middleY = mapExtent[1] + (mapExtent[3] - mapExtent[1]) / 2;
            let oilWithWaterBubbleStyle = new Style({
                image: new Chart({
                    radius: 15,
                    type: "pie",
                    data: [120 , 20],
                    colors: [`rgba(222, 138, 11, 0.8)`, `rgba(10, 134, 145, 0.8)`],
                }),
            });
            let waterBubbleStyle = new Style({
                image: new CircleStyle({
                    radius: 20,
                    fill: new Fill({
                        color: 'rgba(14, 162, 198, 0.6)',
                    }),
                    stroke: new Stroke({
                        color: 'rgba(14, 162, 198, 0.8)',
                        width: 1,
                    }),
                }),
            });
            let bubbleLayers = [
                new VectorLayer({
                    source: new VectorSource({
                        features: [new Feature({
                            geometry: new Point([middleX, middleY]),
                        })]
                    }),
                    style: [oilWithWaterBubbleStyle],
                    zIndex: this.layerGroups.length + 1
                }),
                new VectorLayer({
                    source: new VectorSource({
                        features: [new Feature({
                            geometry: new Point([
                                mapExtent[0] + (mapExtent[2] - mapExtent[0]) / 1.5,
                                mapExtent[1] + (mapExtent[3] - mapExtent[1]) / 2.5,
                            ]),
                        })]
                    }),
                    style: [oilWithWaterBubbleStyle],
                    zIndex: this.layerGroups.length + 1
                }),
                new VectorLayer({
                    source: new VectorSource({
                        features: [new Feature({
                            geometry: new Point([
                                mapExtent[0] + (mapExtent[2] - mapExtent[0]) / 1.5,
                                mapExtent[1] + (mapExtent[3] - mapExtent[1]) / 1.5,
                            ]),
                        })]
                    }),
                    style: [oilWithWaterBubbleStyle],
                    zIndex: this.layerGroups.length + 1
                }),
                new VectorLayer({
                    source: new VectorSource({
                        features: [new Feature({
                            geometry: new Point([
                                mapExtent[0] + (mapExtent[2] - mapExtent[0]) / 4,
                                middleY
                            ]),
                        })]
                    }),
                    style: [waterBubbleStyle],
                    zIndex: this.layerGroups.length + 1
                }),
                new VectorLayer({
                    source: new VectorSource({
                        features: [new Feature({
                            geometry: new Point([
                                mapExtent[0] + (mapExtent[2] - mapExtent[0]) / 4,
                                mapExtent[1] + (mapExtent[3] - mapExtent[1]) / 2.5,
                            ]),
                        })]
                    }),
                    style: [waterBubbleStyle],
                    zIndex: this.layerGroups.length + 1
                }),
            ];
            let layerGroup = new LayerGroup();
            bubbleLayers.forEach(item => {
                layerGroup.getLayers().push(item);
            })
            layerGroup.name = 'Слой ' + this.layerGroups.length;
            this.addLayerGroupToMap(layerGroup);
        },
        addLayerGroupToMap(layerGroup) {
            this.layerGroups.push(layerGroup);
            this.map.getLayerGroup().getLayers().push(layerGroup);
        },
        getPolygonsLayerGroup(layerGroup, polygonsPerLevel, styles) {
            let internalVectorSource = new VectorSource();
            let externalVectorSource = new VectorSource();
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
            let internalVectorLayer = new VectorLayer({
                source: internalVectorSource,
                style: styles.internal,
            });
            let externalVectorLayer = new VectorLayer({
                source: externalVectorSource,
                style: styles.external,
            });
            layerGroup.getLayers().push(externalVectorLayer);
            layerGroup.getLayers().push(internalVectorLayer);
        },
        getExternalLayerStyle(color, text) {
            return new Style({
                stroke: new Stroke({
                    color: color,
                    width: 1,
                }),
                fill: new Fill({
                    color: color,
                }),
                text: new Text({
                    font: '14px bold Calibri,sans-serif',
                    fill: new Fill({
                        color: 'white',
                    }),
                    text: text,
                    placement: 'line',
                }),
            });
        }
    },
}
