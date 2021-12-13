<template>
    <div v-bind:id="projectKey" class="col p-0" style="min-width: 50%"></div>
</template>

<script>
import Projection from "ol/proj/Projection";
import Map from "ol/Map";
import View from "ol/View";
import {Icon, Fill, Stroke, Style, Text} from "ol/style";
import LayerGroup from "ol/layer/Group";
import {Vector as VectorLayer} from "ol/layer";
import {OSM, Vector as VectorSource, XYZ} from "ol/source";
import Feature from "ol/Feature";
import {LineString, Point, Polygon} from "ol/geom";
import {Overlay} from "ol";
import Chart from "ol-ext/style/Chart";
import LegendControl from "ol-ext/control/Legend";
import Legend from "ol-ext/legend/Legend";
import CircleStyle from "ol/style/Circle";
import {globalloadingMutations} from '@store/helpers';
import TileLayer from "ol/layer/Tile";
import {Control, defaults as defaultControls, ScaleLine} from 'ol/control';
import jspdf from "jspdf";
import moment from 'moment';

export default {
    props: {
        data: Object,
        projectKey: '',
    },
    data() {
        return {
            base64Data: null,
            map: null,
            gridMapsValues: [],
            legend: null,
            legendControl: null,
            mapOverlay: null,
            overlayValues: {
                grid: {
                    html: '',
                },
                featureValues: {
                    html: '',
                },
            },
            x1: 0,
            x2: 0,
            y1: 0,
            y2: 0,
            polygonsType: null,
        }
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        importData(data, type) {
            this.polygonsType = type;
            this.initMap(data, type).then(() => {
                if (this.isGridMap(type)) {
                    this.base64Data = data;
                    this.addPolygons(data);
                } else {
                    this.drawLines(data);
                }
              this.refreshLegend();
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
                            units: 'm',
                            metersPerUnit: 20,
                            extent: extent,
                        });
                        const mapExtent = projection.getExtent();
                        this.map = new Map({
                            controls: defaultControls().extend([
                                new ScaleLine({
                                    units: 'metric',
                                }),
                                new ExportMap(),
                            ]),
                            target: this.projectKey,
                            layers: this.data.layerGroups,
                            view: new View({
                                projection: projection,
                                center: [mapExtent[0] + (mapExtent[2] - mapExtent[0]) / 2,
                                    mapExtent[1] + (mapExtent[3] - mapExtent[1]) / 2],
                                zoom: 1,
                            }),
                        });
                        this.addMapOverlay();
                        this.addMapLegend();
                    } else {
                        let mapExtent = this.map.getView().getProjection().getExtent();
                        this.x1 = Math.min(this.x1, mapExtent[0]);
                        this.x2 = Math.max(this.x2, mapExtent[2]);
                        this.y1 = Math.min(this.y1, mapExtent[1]);
                        this.y2 = Math.max(this.y2, mapExtent[3]);
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
            return !['shp', 'txt'].includes(type);
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
            let isolinesShow = typeof data.show !== "undefined" ? data.show : true;
            if (this.polygonsType === 'grid_without_isolines') {
                isolinesShow = false;
            }
            let layerGroup = new LayerGroup();
            layerGroup.type = 'polygon';
            const polygonsCount = data.polygons_per_levels.length;
            const colorDivider = Math.ceil(polygonsCount / 3);
            let colorIndex = 0;
            let color = [255, 0, 0];
            let legendItems = [];
            data.polygons_per_levels.forEach((polygonsPerLevel, levelIndex) => {
                let correctDivider = levelIndex % colorDivider + 1;
                if (levelIndex > 0 && levelIndex % colorDivider === 0) {
                    colorIndex++;
                    color = [0, 0, 0];
                }
                color[colorIndex] = (255 / correctDivider).toFixed();
                if (correctDivider < 2) {
                    color[colorIndex - 1] = (128 - 128 / correctDivider).toFixed();
                }
                legendItems.push({
                    title: '> ' + polygonsPerLevel.lower_bound.toString(),
                    typeGeom: 'Polygon',
                    className: 'legend-item',
                    style: new Style({
                        stroke: new Stroke({
                            color: `rgba(${color[2]}, ${color[1]}, ${color[0]}, 0.7)`
                        }),
                        fill: new Fill({
                            color: `rgba(${color[2]}, ${color[1]}, ${color[0]}, 0.7)`
                        }),
                    }),
                })
                this.getPolygonsLayerGroup(layerGroup, polygonsPerLevel, {
                    'internal': internalStyle,
                    'external': this.getExternalLayerStyle(`rgba(${color[2]}, ${color[1]}, ${color[0]}, 0.7)`,
                        parseInt(polygonsPerLevel.lower_bound).toString(), isolinesShow),
                });
            });
            layerGroup.name = 'Грид карта  ' + (this.data.layerGroups.length + 1);
            layerGroup.legendItems = legendItems;
            layerGroup.selectedFilterType = typeof data.selectedFilterType !== "undefined"
                ? data.selectedFilterType : 0;
            layerGroup.selectedFilterValue = typeof data.selectedFilterValue !== "undefined"
                ? data.selectedFilterValue : layerGroup.selectedFilterType === 0 ? 10 : 0;
            layerGroup.step = typeof data.step !== "undefined" ? data.step : 0;
            layerGroup.bounds = typeof data.bounds !== "undefined" ? data.bounds : [0, 0];
            layerGroup.show = isolinesShow;
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
            const lineStyle = new Style({
                stroke: new Stroke({
                    color: '#3be7c5',
                    width: 3,
                }),
            });
            const newLayer = new VectorLayer({
                source: new VectorSource({
                    features: features,
                    wrapX: false,
                }),
                style: lineStyle,
                zIndex: this.data.layerGroups.length + 1,
            });
            let legendItems = [{
                title: 'Контур ' + this.data.layerGroups.length,
                typeGeom: 'Line',
                className: 'legend-item',
                style: lineStyle,
            }]
            let layerGroup = new LayerGroup();
            layerGroup.name = 'Контур ' + this.data.layerGroups.length;
            layerGroup.type = 'border';
            layerGroup.legendItems = legendItems;
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
        getExternalLayerStyle(color, text, show = true) {
            let stroke = null;
            let textStyle = null;
            if (show) {
                stroke = new Stroke({
                    color: '#000',
                    width: 1,
                });
                textStyle = new Text({
                    font: '14px bold Calibri,sans-serif',
                    fill: new Fill({
                        color: '#000',
                    }),
                    text: text,
                    placement: 'line',
                });
            }
            return new Style({
                stroke: stroke,
                fill: new Fill({
                    color: color,
                }),
                text: textStyle,
            });
        },
        addLayerGroupToMap(layerGroup) {
            this.data.layerGroups.push(layerGroup);
            this.map.getLayerGroup().getLayers().push(layerGroup);
        },
        removeOldBubbleLayerGroupFromMap() {
            let oldLayers = this.map.getLayers();
            oldLayers.forEach(item => {
                if (typeof item.key !== "undefined" && item.key.startsWith('bubbles')) {
                    this.map.removeLayer(item);
                }
            });
            let indexToRemove = null;
            this.data.layerGroups.forEach((item, index) => {
                if (typeof item.key !== "undefined" && item.key.startsWith('bubbles')) {
                    indexToRemove = index;
                }
            });
            if (indexToRemove !== null) {
                this.data.layerGroups.splice(indexToRemove, 1)
            }
        },
        addGrid(data) {
            let binValues = this.decodeFromBase64(data.grid);
            let shape = data.shape;
            let resultArray = [];
            for (let i = 0; i < Math.ceil(binValues.length / shape[1]); i++){
                resultArray[i] = binValues.slice((i * shape[1]), (i * shape[1]) + shape[1]);
            }
            if (this.map) {
                const $self = this;
                const mapExtent = this.map.getView().getProjection().getExtent();
                this.gridMapsValues.push(resultArray);
                this.map.on('pointermove', function (evt) {
                    if (
                        evt.coordinate[0] < mapExtent[0]
                        || evt.coordinate[0] > mapExtent[2]
                        || evt.coordinate[1] < mapExtent[1]
                        || evt.coordinate[1] > mapExtent[3]
                        || evt.dragging
                    ) {
                        return;
                    }
                    if ($self.gridMapsValues.length > 0) {
                        const stepX = (mapExtent[2] - mapExtent[0]) / (shape[0] - 1);
                        const stepY = (mapExtent[3] - mapExtent[1]) / (shape[1] - 1);
                        let x = ((evt.coordinate[0] - mapExtent[0]) / stepX).toFixed(0);
                        let y = ((mapExtent[3] - mapExtent[1] - (evt.coordinate[1] - mapExtent[1])) / stepY).toFixed(0);
                        let value = $self.gridMapsValues[0][x][y];
                        if (isNaN(value)) {
                            return;
                        }
                        $self.overlayValues.grid.html = '<div> Значение грид карты: ' + value.toFixed(2) + '</div>';
                    }
                });
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
        showBubbles(data, type) {
            if (this.map === null) {
                let coords = {
                    x: [],
                    y: [],
                };
                data.forEach(item => {
                    coords.x.push(item.coords[0]);
                    coords.y.push(item.coords[1]);
                });
                const maxX = Math.max(...coords.x);
                const minX = Math.min(...coords.x);
                const maxY = Math.max(...coords.y);
                const minY = Math.min(...coords.y);
                this.initMap({
                    top_left: [minX, minY],
                    bottom_right: [maxX, maxY],
                })
            }
            let bubbleLayers = [];
            let waterBubbleLayers = [];
            const defaultRadius = 5;
            let legendBubbleStyle = null;
            let legendBubbleTitle = 'Нефть/Вода';
            if (type === 'oil_with_water') {
                legendBubbleStyle = new Style({
                    image: new Chart({
                        radius: 10,
                        type: "pie",
                        data: [
                            50,
                            50,
                        ],
                        colors: [`rgba(10, 134, 145, 0.8)`, `rgba(222, 138, 11, 0.8)`],
                    }),
                });
                data.forEach(item => {
                    let dailyDivider = 1;
                    let measLiqTitle = 'Жидкость, м3';
                    let oilTitle = 'Нефть, т';
                    if (data.dataType === 'kto') {
                        measLiqTitle = 'Жидкость, м3/сут'
                        oilTitle = 'Нефть, т/сут';
                        dailyDivider = data.period ? data.period : moment(this.selectedMonth).daysInMonth();
                    }
                    if (item.oilWithWaterData.liquid) {
                        const measLiqSum = item.oilWithWaterData.liquid / dailyDivider;
                        const measWaterCutPercent = parseInt(item.oilWithWaterData.wcut);
                        const oilSum = item.oilWithWaterData.oil / dailyDivider;
                        let oilWithWaterBubbleStyle = new Style({
                            image: new Chart({
                                radius: defaultRadius + (20 / 100 * (item.oilWithWaterData.liquid / item.oilWithWaterData.cnt)),
                                type: "pie",
                                data: [
                                    measWaterCutPercent,
                                    100 - measWaterCutPercent,
                                ],
                                colors: [`rgba(10, 134, 145, 0.8)`, `rgba(222, 138, 11, 0.8)`],
                            }),
                        });
                        if (measLiqSum > 0 || oilSum > 0) {
                            bubbleLayers.push(
                                new VectorLayer({
                                    source: new VectorSource({
                                        features: [new Feature({
                                            geometry: new Point([item.coords[0], item.coords[1]]),
                                            values: [
                                                {
                                                    key: 'Скважина',
                                                    value: item.name,
                                                },
                                                {
                                                    key: measLiqTitle,
                                                    value: measLiqSum.toFixed(2),
                                                },
                                                {
                                                    key: 'Обводненность, %',
                                                    value: measWaterCutPercent.toFixed(2),
                                                },
                                                {
                                                    key: oilTitle,
                                                    value: oilSum.toFixed(2),
                                                },
                                            ],
                                        })]
                                    }),
                                    style: [oilWithWaterBubbleStyle],
                                    zIndex: this.data.layerGroups.length + 1,
                                }),
                            );
                        }
                    }
                    if (item.pressure) {
                        const pressure = item.pressure ?
                            item.pressure / dailyDivider : null;
                        let waterBubbleStyle = new Style({
                            image: new CircleStyle({
                                radius: defaultRadius + (20 * (item.pressure / item.pressureMax)),
                                fill: new Fill({
                                    color: 'rgba(0, 65, 248, 0.8)',
                                }),
                                stroke: new Stroke({
                                    color: 'rgba(0, 65, 248, 0.8)',
                                    width: 1,
                                }),
                            }),
                        });
                        waterBubbleLayers.push(
                            new VectorLayer({
                                source: new VectorSource({
                                    features: [new Feature({
                                        geometry: new Point([item.coords[0], item.coords[1]]),
                                        values: [
                                            {
                                                key: 'Скважина',
                                                value: item.name,
                                            },
                                            {
                                                key: 'Закачка жидкости, м3',
                                                value: pressure.toFixed(2),
                                            },
                                        ],
                                    })]
                                }),
                                style: [waterBubbleStyle],
                                zIndex: this.data.layerGroups.length + 1,
                            })
                        );
                    }
                });
            } else if(type === 'ppm') {
                const bubbleData = data.data
                const ppmMax = Math.max(...bubbleData.map(function(item) {
                    return item.ppm;
                }));
                legendBubbleStyle = new Style({
                    image: new CircleStyle({
                        radius: 10,
                        fill: new Fill({
                            color: 'rgba(233,149,46, 0.6)',
                        }),
                        stroke: new Stroke({
                            color: 'rgba(179,93,27, 0.8)',
                            width: 1,
                        }),
                    }),
                });
                legendBubbleTitle = 'ppm';
                bubbleData.forEach(item => {
                    let waterBubbleStyle = new Style({
                        image: new CircleStyle({
                            radius: defaultRadius + (30 / 100 * (item.ppm / (ppmMax / 100))),
                            fill: new Fill({
                                color: 'rgba(233,149,46, 0.6)',
                            }),
                            stroke: new Stroke({
                                color: 'rgba(179,93,27, 0.8)',
                                width: 1,
                            }),
                        }),
                        text: new Text({
                            font: '8px bold Calibri,sans-serif',
                            fill: new Fill({
                                color: 'black',
                            }),
                            text: 'ГУ: ' + item.id + "\r\n" + 'ppm: ' + item.ppm.toFixed(2),
                            placement: 'point',
                        }),
                    });
                    bubbleLayers.push(
                        new VectorLayer({
                            source: new VectorSource({
                                features: [new Feature({
                                    geometry: new Point([item.lat, item.lon]),
                                    values: [
                                        {
                                            key: 'ГУ',
                                            value: item.id,
                                        },
                                        {
                                            key: 'ppm',
                                            value: item.ppm.toFixed(2),
                                        },
                                    ],
                                })]
                            }),
                            style: [waterBubbleStyle],
                            zIndex: this.data.layerGroups.length + 1
                        }),
                    );
                });
                if (this.map.getView().getZoom() < 5) {
                    this.map.getView().setZoom(11);
                    this.map.getView().centerOn(
                        [bubbleData[bubbleData.length - 1].lat, bubbleData[bubbleData.length - 1].lon],
                        this.map.getSize(),
                        [700, 300]
                    );
                }
            }
            if (bubbleLayers.length > 0 || waterBubbleLayers.length > 0) {
                if (type === 'ppm') {
                    this.removeOldBubbleLayerGroupFromMap();
                }
                if (bubbleLayers.length > 0) {
                    let layerGroup = new LayerGroup();
                    bubbleLayers.forEach(item => {
                        layerGroup.getLayers().push(item);
                    })
                    layerGroup.name = typeof data.date !== "undefined" ? data.date : 'Добыча';
                    layerGroup.name += typeof data.dataType === "undefined" ? '' :
                        data.dataType === 'kto' ? '(текущие)' : '(накопленные)';
                    layerGroup.name += typeof data.selectedMonth === "undefined" ? '' : ' за ' + data.selectedMonth;
                    layerGroup.key = 'bubbles' + data.date;
                    layerGroup.type = 'bubbles';
                    layerGroup.legendItems = [{
                        title: legendBubbleTitle,
                        feature: new Feature({
                            geometry: new Point([0, 0]),
                        }),
                        className: 'legend-item',
                        style: legendBubbleStyle,
                    }];
                    this.addLayerGroupToMap(layerGroup);
                }
                if (waterBubbleLayers.length > 0) {
                    let layerGroup = new LayerGroup();
                    waterBubbleLayers.forEach(item => {
                        layerGroup.getLayers().push(item);
                    })
                    layerGroup.name = typeof data.date !== "undefined" ? data.date : 'Нагнетение';
                    layerGroup.name += typeof data.dataType === "undefined" ? '' :
                        data.dataType === 'kto' ? '(текущие)' : '(накопленные)';
                    layerGroup.name += typeof data.selectedMonth === "undefined" ? '' : ' за ' + data.selectedMonth;
                    layerGroup.legendItems = [{
                        title: 'Закачка жидкости, м3',
                        feature: new Feature({
                            geometry: new Point([0, 0]),
                        }),
                        className: 'legend-item',
                        style: new Style({
                            image: new CircleStyle({
                                radius: 10,
                                fill: new Fill({
                                    color: 'rgba(0, 65, 248, 0.8)',
                                }),
                                stroke: new Stroke({
                                    color: 'rgba(0, 65, 248, 0.8)',
                                    width: 1,
                                }),
                            }),
                        }),
                    }];
                    this.addLayerGroupToMap(layerGroup);
                }
                this.refreshLegend();
            } else {
                this.$notifyError(this.trans('map_constructor.empty_data'));
            }
        },
        updateMapSize() {
            if (this.map !== null) {
                this.map.updateSize();
            }
        },
        addGeographicalMap() {
            let satelliteMapLayer = new TileLayer({
                source: new XYZ({
                    attributions: 'Copyright:© 2013 ESRI, i-cubed, GeoEye',
                    url:
                        'https://services.arcgisonline.com/arcgis/rest/services/' +
                        'ESRI_Imagery_World_2D/MapServer/tile/{z}/{y}/{x}',
                    maxZoom: 11,
                    projection: 'EPSG:4326',
                    tileSize: 512,
                    maxResolution: 180 / 512,
                    wrapX: true,
                    crossOrigin:"anonymous",
                }),
                visible: true,
            });
            let defaultMapLayer = new TileLayer({
                source: new OSM(),
                visible: false,
            });
            this.map = new Map({
                controls: defaultControls().extend([
                    new ScaleLine({
                        units: 'metric',
                    }),
                    new ToggleMapStyle(),
                    new ExportMap(),
                ]),
                target: this.projectKey,
                view: new View({
                    projection: 'EPSG:4326',
                    zoom: 0,
                    center: [0, 0],
                }),
            });
            let layerGroup = new LayerGroup();
            layerGroup.name = 'Географическая карта';
            layerGroup.type = 'map';
            layerGroup.getLayers().push(defaultMapLayer);
            layerGroup.getLayers().push(satelliteMapLayer);
            this.addLayerGroupToMap(layerGroup);
            this.addMapLegend();
        },
        addMapOverlay() {
            let $self = this;
            let popupDiv = document.getElementById("bubblePopup_" + this.projectKey);
            if (popupDiv === null) {
                popupDiv = document.createElement('div');
                popupDiv.setAttribute("id", "bubblePopup_" + this.projectKey);
                popupDiv.classList.add("bubblePopup");
            }
            this.mapOverlay = new Overlay({
                element: popupDiv,
            });
            this.map.addOverlay(this.mapOverlay);
            this.map.on('pointermove', function (e) {
                if (e.dragging) {
                    return;
                }
                let values = [];
                this.forEachFeatureAtPixel(e.pixel, function (f) {
                    values = f.values_.values;
                    $self.mapOverlay.setPosition(e.coordinate);
                    return true;
                });
                $self.mapOverlay.getElement().innerHTML = '';
                let valuesText = '';
                if (typeof values !== "undefined" && values.length > 0) {
                    values.forEach(item => {
                        valuesText += `<div>${item.key}: ${item.value}</div>`
                    });
                }
                $self.overlayValues.featureValues.html = valuesText;
                for (const [key, item] of Object.entries($self.overlayValues)) {
                    $self.mapOverlay.getElement().innerHTML += `${item.html}`;
                }
            });
        },
        addMapLegend() {
            this.legend = new Legend({
                title: 'Легенда',
                margin: 2
            });
            this.legendControl = new LegendControl({
              className: 'ol-legend mapLegend',
              legend: this.legend,
            });
            this.map.addControl(this.legendControl);
        },
        refreshLegend() {
          let $self = this;
          this.legend.getItems().clear();
          this.data.layerGroups.forEach(item => {
            if (typeof item.legendItems !== "undefined" && item.legendItems) {
              item.legendItems.forEach(legendItem => {
                $self.legend.addItem(legendItem);
              })
            }
          });
        },
        showWells(data) {
            if (this.map === null) {
                let coords = {
                    x: [],
                    y: [],
                };
                data.forEach(item => {
                    coords.x.push(item.coords[0]);
                    coords.y.push(item.coords[1]);
                });
                const maxX = Math.max(...coords.x);
                const minX = Math.min(...coords.x);
                const maxY = Math.max(...coords.y);
                const minY = Math.min(...coords.y);
                this.initMap({
                    top_left: [minX, minY],
                    bottom_right: [maxX, maxY],
                })
            }
            let wellLayers = [];
            data.forEach(item => {
                const itemStyle = new Style({
                    image: new Icon({
                        crossOrigin: 'anonymous',
                        src: '/img/icons/map-constructor/' + item.icon,
                        size: [20, 50],
                        color: '#fff',
                    }),
                    text: new Text({
                        font: '10px bold Calibri,sans-serif',
                        fill: new Fill({
                            color: '#fff',
                        }),
                        text: item.name,
                    })
                });
                wellLayers.push(
                    new VectorLayer({
                        source: new VectorSource({
                            features: [
                                new Feature({
                                    geometry: new Point(item.coords),
                                })]
                        }),
                        style: [itemStyle],
                    }),
                );
            });
            if (wellLayers.length > 0) {
                let layerGroup = new LayerGroup();
                wellLayers.forEach(item => {
                    layerGroup.getLayers().push(item);
                })
                layerGroup.name = 'Скважины ' + this.data.layerGroups.length;
                this.addLayerGroupToMap(layerGroup);
            } else {
                this.$notifyError(this.trans('map_constructor.empty_data'));
            }
        }
    }
}

class ToggleMapStyle extends Control {
    constructor(opt_options) {
        const options = opt_options || {};

        const toggleMapStyleButton = document.createElement('button');
        toggleMapStyleButton.innerHTML = 'Спутник';

        const toggleMapStyleElement = document.createElement('div');
        toggleMapStyleElement.className = 'change-map-style activeBg ol-unselectable ol-control';
        toggleMapStyleElement.appendChild(toggleMapStyleButton);
        super({
            element: toggleMapStyleElement,
            target: options.target,
        });

        toggleMapStyleButton.addEventListener('click', this.handleToggleMapStyle.bind(this), false);
    }

    handleToggleMapStyle() {
        if (this.element.className.split(" ").indexOf("activeBg") > -1) {
            this.element.classList.remove("activeBg");
        } else {
            this.element.classList.add("activeBg");
        }
        let mapLayers = this.getMap().getLayers();
        mapLayers.forEach(item => {
            if (item.type === 'map') {
                item.getLayers().forEach(tileLayer => {
                    tileLayer.setOpacity(tileLayer.values_.visible ? 0 : 1);
                    tileLayer.values_.visible = !tileLayer.values_.visible;
                })
            }
        })
    }
}

class ExportMap extends Control {
    constructor(opt_options) {
        const options = opt_options || {};

        const exportButton = document.createElement('button');
        exportButton.innerHTML = 'PDF';
        const exportElement = document.createElement('div');
        exportElement.className = 'export-map ol-unselectable ol-control';
        exportElement.appendChild(exportButton);
        super({
            element: exportElement,
            target: options.target,
        });

        exportElement.addEventListener('click', this.handleExportMap.bind(this), false);
    }

    handleExportMap() {
        document.body.style.cursor = 'progress';

        const resolution = 150;
        const dim = [297, 210];
        const width = Math.round((dim[0] * resolution) / 25.4);
        const height = Math.round((dim[1] * resolution) / 25.4);
        const size = this.getMap().getSize();
        const viewResolution = this.getMap().getView().getResolution();

        this.getMap().once('rendercomplete', function () {
            const mapCanvas = document.createElement('canvas');
            mapCanvas.width = width;
            mapCanvas.height = height;
            const mapContext = mapCanvas.getContext('2d');
            Array.prototype.forEach.call(
                document.querySelectorAll('.ol-layer canvas'),
                function (canvas) {
                    if (canvas.width > 0) {
                        const opacity = canvas.parentNode.style.opacity;
                        mapContext.globalAlpha = opacity === '' ? 1 : Number(opacity);
                        const transform = canvas.style.transform;
                        const matrix = transform
                            .match(/^matrix\(([^\(]*)\)$/)[1]
                            .split(',')
                            .map(Number);
                        CanvasRenderingContext2D.prototype.setTransform.apply(
                            mapContext,
                            matrix
                        );
                        mapContext.drawImage(canvas, 0, 0);
                    }
                }
            );
            const pdf = new jspdf('landscape', undefined, 'a4');
            pdf.addImage(
                mapCanvas.toDataURL(),
                'PNG',
                0,
                0,
                dim[0],
                dim[1],
            );
            pdf.save('map.pdf');
            this.setSize(size);
            this.getView().setResolution(viewResolution);
            document.body.style.cursor = 'auto';
        });

        const printSize = [width, height];
        this.getMap().setSize(printSize);
        const scaling = Math.min(width / size[0], height / size[1]);
        this.getMap().getView().setResolution(viewResolution / scaling);
    }
}
</script>
<style>
.bubblePopup {
    border-radius: 2px;
    color: white;
    background: rgba(0, 0, 0, 0.5);
}
.bubblePopup div {
    padding: 0.1rem 0.5rem;
}
.activeBg {
    background-color: rgba(157, 255, 0, 0.6);
}
.change-map-style {
    top: 65px;
    left: 0.48rem;
}
.export-map {
    top: 95px;
    left: 0.48rem;
}
.change-map-style button, .export-map button {
    margin: 0;
    padding: 0.2rem;
    width: 100%;
}
.ol-control.mapLegend {
    bottom: 2.5em;
}
</style>