<template>
    <div v-bind:id="'mcMap_' + projectIndex" class="col" style="min-width: 50%"></div>
</template>

<script>
import Projection from "ol/proj/Projection";
import Map from "ol/Map";
import View from "ol/View";
import {Fill, Stroke, Style, Text} from "ol/style";
import LayerGroup from "ol/layer/Group";
import {Vector as VectorLayer} from "ol/layer";
import {Vector as VectorSource} from "ol/source";
import Feature from "ol/Feature";
import {LineString, Point, Polygon} from "ol/geom";
import {Overlay} from "ol";
import Chart from "ol-ext/style/Chart";
import CircleStyle from "ol/style/Circle";
import {globalloadingMutations} from '@store/helpers';

export default {
    props: {
        data: Object,
        projectIndex: 0,
    },
    components: {
    },
    data() {
        return {
            map: null,
            gridMapsValues: [],
            x1: 0,
            x2: 0,
            y1: 0,
            y2: 0,
        }
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        importData(data, type) {
            this.initMap(data, type).then(() => {
                if (this.isGridMap(type)) {
                    this.addPolygons(data);
                } else {
                    this.drawLines(data);
                }
            }, () => {});
        },
        initMap(data, type) {
            if (!this.isGridMap(type)) {
                data = data[0];
            }
            return new Promise((resolve, reject) => {
                try {
                    this.x1 = data.top_left[0];
                    this.y1 = data.top_left[1];
                    this.x2 = data.bottom_right[0];
                    this.y2 = data.bottom_right[1];
                    if (this.map === null) {
                        const extent = [this.x1, this.y1, this.x2, this.y2];
                        const projection = new Projection({
                            units: 'pixels',
                            extent: extent,
                        });
                        const mapExtent = projection.getExtent();
                        this.map = new Map({
                            target: 'mcMap_' + this.projectIndex,
                            layers: this.data.layerGroups,
                            view: new View({
                                projection: projection,
                                center: [mapExtent[0] + (mapExtent[2] - mapExtent[0]) / 2,
                                    mapExtent[1] + (mapExtent[3] - mapExtent[1]) / 2],
                                zoom: 1,
                            }),
                        });
                    } else {
                        let mapExtent = this.map.getView().getProjection().getExtent();
                        this.x1 = this.x1 < mapExtent[0] ? this.x1 : mapExtent[0];
                        this.x2 = this.x2 > mapExtent[2] ? this.x2 : mapExtent[2];
                        this.y1 = this.y1 < mapExtent[1] ? this.y1 : mapExtent[1];
                        this.y2 = this.y2 > mapExtent[3] ? this.y2 : mapExtent[3];
                        this.map.getView().getProjection().setExtent([this.x1, this.y1, this.x2, this.y2]);
                        this.map.getView().setMinZoom(0.5);
                    }
                } catch (e) {
                    reject();
                }
                resolve();
            })
        },
        isGridMap(type) {
            return !(type === 'shp' || type === 'txt');
        },
        addPolygons(data) {
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
            layerGroup.name = 'Слой ' + this.data.layerGroups.length;
            this.addLayerGroupToMap(layerGroup);
            if (typeof data.grid !== "undefined") {
                this.addGrid(data);
            }
        },
        drawLines(fileData) {
            let features = [];
            fileData.forEach(dataItem => {
                dataItem = dataItem.data.map(
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
                zIndex: this.data.layerGroups.length + 1
            });
            let layerGroup = new LayerGroup();
            layerGroup.name = 'Слой ' + this.data.layerGroups.length;
            layerGroup.getLayers().push(newLayer);
            this.addLayerGroupToMap(layerGroup);
            this.SET_LOADING(false);
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
                zIndex: this.data.layerGroups.length,
            });
            let externalVectorLayer = new VectorLayer({
                source: externalVectorSource,
                style: styles.external,
                zIndex: this.data.layerGroups.length,
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
        },
        addLayerGroupToMap(layerGroup) {
            this.data.layerGroups.push(layerGroup);
            this.map.getLayerGroup().getLayers().push(layerGroup);
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
                    zIndex: this.data.layerGroups.length + 1
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
                    zIndex: this.data.layerGroups.length + 1
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
                    zIndex: this.data.layerGroups.length + 1
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
                    zIndex: this.data.layerGroups.length + 1
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
                    zIndex: this.data.layerGroups.length + 1
                }),
            ];
            let layerGroup = new LayerGroup();
            bubbleLayers.forEach(item => {
                layerGroup.getLayers().push(item);
            })
            layerGroup.name = 'Слой ' + this.data.layerGroups.length;
            this.addLayerGroupToMap(layerGroup);
        },
    }
}
</script>