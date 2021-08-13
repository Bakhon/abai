import PrinterModal from './modals/PrinterModal'
import BuildMapModal from './modals/BuildMapModal'
import BuildMapSpecificModal from './modals/BuildMapSpecificModal'
import ReportModal from './modals/ReportModal'
import ExportModal from './modals/ExportModal'
import './MyFilter'
import moment from 'moment'
import {Datetime} from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'
import 'ol/ol.css';
import {Vector as VectorLayer} from 'ol/layer';
import {Vector as VectorSource} from 'ol/source';
import {Fill, Stroke, Style, Text} from 'ol/style';
import Feature from 'ol/Feature';
import Point from 'ol/geom/Point';
import Select from 'ol/interaction/Select';
import 'ol/ol.css';
import ImageLayer from 'ol/layer/Image';
import Map from 'ol/Map';
import Projection from 'ol/proj/Projection';
import View from 'ol/View';
import CircleStyle from 'ol/style/Circle';
import Overlay from 'ol/Overlay';
import Static from 'ol/source/ImageStatic';
import Chart from 'ol-ext/style/Chart'
import monthlyOilValue from './data.json'
export default {
    data() {
        return {
            monthlyOilValue: monthlyOilValue.data,
            isLoading: false,
            date3: null,
            accumulatedSelected: false,
            currentSelected: false,
            data: null,
            monthLabels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июнь', 'Июль', 'Авг', 'Сеп', 'Окт', 'Ноя', 'Дек'],
            selectedMonth: null,
            min: null,
            max: null,
            files: [],
            viewMenu: false,
            viewMenuLayers: false,
            rightLayers: false,
            rightMap: false,
            top: '0px',
            left: '0px',
            windHeight: window.innerHeight,
            windWidth: window.innerWidth,
            date: null,
            isSelected: false
        }
    },
    components: {
        Datetime,
        PrinterModal,
        BuildMapModal,
        BuildMapSpecificModal,
        ReportModal,
        ExportModal
    },
    methods: {
        mapInit() {
            this.isSelected = false;
            setTimeout(() => this.mapInit2(), 100);
        },
        async mapInit2() {
            this.isSelected = true;

            let extent = [11705000, 5089113, 11718100, 5100000];

            let projection = new Projection({
                code: 'myOwnProjection',
                units: 'pixels',
                extent: extent,
            });
            let layers = [
                new ImageLayer({
                    source: await new Static({
                        url: '/img/map-constructor/map.jpg',
                        projection: projection,
                        imageExtent: extent,
                    }),
                }),
            ];
            let map = new Map({
                layers: layers,
                target: 'olmap',
                view: await new View({
                    projection: projection,
                    center: [11710374.75, 5095815.04],
                    extent: extent,
                    zoom: 1,
                }),
            });
            let popup = new Overlay({
                element: document.getElementById('popup'),
            });
            map.addOverlay(popup);

            let styleCache = {};

            function getFeatureStyle(feature, sel) {
                let k = $("#graph").val() + "-" + $("#color").val() + "-" + (sel ? "1-" : "") + feature.get("data");
                let style = styleCache[k];
                if (!style) {
                    let radius;
                    radius = 8 * Math.sqrt(feature.get("sum") / Math.PI);
                    let data = feature.get("data");
                    let name = feature.get("name").toString();

                    style = [new Style({
                        image: new Chart({
                            type: "pie",
                            radius: radius,
                            data: data,
                            colors: ["#150fba", "#873e23"],
                            rotateWithView: true,
                        }),
                        text: new Text({
                            font: 'bold 14px "Open Sans", "Arial Unicode MS", "sans-serif"',
                            placement: 'point',
                            fill: new Fill({color: 'black'}),
                            text: name,
                        }),
                    })];

                    if (sel) {
                        let pos = feature.get("position");
                        let data = feature.get("data");
                        let sum = feature.get("sum");
                        let name = feature.get("name");
                        let water_percent = feature.get("water_percent");
                        let element = popup.getElement();
                        $(element).popover('dispose');
                        popup.setPosition(pos);
                        $(element).popover({
                            container: element,
                            placement: 'top',
                            animation: false,
                            html: true,
                            content: '<p>Скважина\n<code class="text-dark font-weight-bold">' + name + '</code></p>' + '<p> Жидкость, м3/сут\n<code class="text-dark font-weight-bold">' + sum + '</code></p>' + '<p>Нефть, м3/сут\n<code class="text-dark font-weight-bold">' + data[1] + '</code></p>' + '<p>Обводненность, %\n<code class="text-dark font-weight-bold">' + water_percent + '</code></p>' + '<p>Координаты:\n</p><p><code class="text-dark font-weight-bold">' + pos[0] + '</code></p><p><code class="text-dark font-weight-bold">' + pos[1] + '</code></p>',
                        });
                        $(element).popover('show');
                        map.on('movestart', function () {
                            $(element).popover('dispose');
                        });
                    }
                }
                return style;
            }

            function getFeatureStyle2(feature, sel) {
                let k = $("#graph").val() + "-" + $("#color").val() + "-" + (sel ? "1-" : "") + feature.get("data");
                let style = styleCache[k];
                if (!style) {
                    let radius;
                    radius = 8 * Math.sqrt(feature.get("sum") / Math.PI) / 2;
                    let data = feature.get("data");
                    let name = feature.get("name").toString();

                    style = [new Style({
                        image: new CircleStyle({
                            radius: radius,
                            data: data,
                            fill: new Fill({
                                color: '#0079FF'
                            }),
                            rotateWithView: true,
                            stroke: new Stroke({
                                color: "black",
                                width: 2
                            }),
                        }),
                        text: new Text({
                            font: 'bold 14px "Open Sans", "Arial Unicode MS", "sans-serif"',
                            placement: 'point',
                            fill: new Fill({color: 'black'}),
                            text: name
                        }),
                    })];

                    if (sel) {
                        let pos = feature.get("position");
                        let data = feature.get("data");
                        let sum = feature.get("sum");
                        let name = feature.get("name");
                        let element = popup.getElement();
                        $(element).popover('dispose');
                        popup.setPosition(pos);
                        $(element).popover({
                            container: element,
                            placement: 'top',
                            animation: false,
                            html: true,
                            content: '<p>Скважина\n<code class="text-dark font-weight-bold">' + name + '</code></p>' + '<p>Среднесуточная приемистость, м3/сут\n<code class="text-dark font-weight-bold">' + sum + '</code></p>' + '<p>Координаты:\n</p><p><code class="text-dark font-weight-bold">' + pos[0] + '</code></p><p><code class="text-dark font-weight-bold">' + pos[1] + '</code></p>',
                        });
                        $(element).popover('show');
                    }
                }
                return style;
            }

            function getFeatureStyle3(feature, sel) {
                let k = $("#graph").val() + "-" + $("#color").val() + "-" + (sel ? "1-" : "") + feature.get("data");
                let style = styleCache[k];
                if (!style) {
                    let radius;
                    radius = 8 * Math.sqrt(feature.get("sum") / Math.PI) / 40;
                    let data = feature.get("data");
                    let name = feature.get("name").toString();

                    style = [new Style({
                        image: new Chart({
                            type: "pie",
                            radius: radius,
                            data: data,
                            colors: ["#150fba", "#873e23"],
                            rotateWithView: true,
                        }),
                        text: new Text({
                            font: 'bold 14px "Open Sans", "Arial Unicode MS", "sans-serif"',
                            placement: 'point',
                            fill: new Fill({color: 'black'}),
                            text: name
                        }),
                    })];

                    if (sel) {
                        let pos = feature.get("position");
                        let data = feature.get("data");
                        let sum = feature.get("sum");
                        let name = feature.get("name");
                        let water_percent = feature.get("water_percent");
                        let element = popup.getElement();
                        $(element).popover('dispose');
                        popup.setPosition(pos);
                        $(element).popover({
                            container: element,
                            placement: 'top',
                            animation: false,
                            html: true,
                            content: '<p>Скважина\n<code class="text-dark font-weight-bold">' + name + '</code></p>' + '<p> Жидкость, м3\n<code class="text-dark font-weight-bold">' + sum + '</code></p>' + '<p>Нефть, т\n<code class="text-dark font-weight-bold">' + data[1] + '</code></p>' + '<p>Обводненность, %\n<code class="text-dark font-weight-bold">' + water_percent + '</code></p>' + '<p>Координаты:\n</p><p><code class="text-dark font-weight-bold">' + pos[0] + '</code></p><p><code class="text-dark font-weight-bold">' + pos[1] + '</code></p>',
                        });
                        $(element).popover('show');
                        map.on('movestart', function () {
                            $(element).popover('dispose');
                        });
                    }
                }
                return style;
            }

            function getFeatureStyle4(feature, sel) {
                let k = $("#graph").val() + "-" + $("#color").val() + "-" + (sel ? "1-" : "") + feature.get("data");
                let style = styleCache[k];
                if (!style) {
                    let radius;
                    radius = 8 * Math.sqrt(feature.get("sum") / Math.PI) / 5;
                    let data = feature.get("data");
                    let name = feature.get("name").toString();

                    style = [new Style({
                        image: new CircleStyle({
                            radius: radius,
                            data: data,
                            fill: new Fill({
                                color: '#0079FF'
                            }),
                            rotateWithView: true,
                            stroke: new Stroke({
                                color: "black",
                                width: 2
                            }),
                        }),
                        text: new Text({
                            font: 'bold 20px "Open Sans", "Arial Unicode MS", "sans-serif"',
                            placement: 'point',
                            fill: new Fill({color: 'black'}),
                            text: name
                        }),
                    })];

                    if (sel) {
                        let pos = feature.get("position");
                        let data = feature.get("data");
                        let sum = feature.get("sum");
                        let name = feature.get("name");
                        let element = popup.getElement();
                        $(element).popover('dispose');
                        popup.setPosition(pos);
                        $(element).popover({
                            container: element,
                            placement: 'top',
                            animation: false,
                            html: true,
                            content: '<p>Скважина\n<code class="text-dark font-weight-bold">' + name + '</code></p>' + '<p>Закачка, м3\n<code class="text-dark font-weight-bold">' + sum + '</code></p>' + '<p>Координаты:\n</p><p><code class="text-dark font-weight-bold">' + pos[0] + '</code></p><p><code class="text-dark font-weight-bold">' + pos[1] + '</code></p>',
                        });
                        $(element).popover('show');
                    }
                }
                return style;
            }

            let selectedDate = moment(this.selectedMonth).format('01.MM.YYYY');

            let features = [];
            let features2 = [];

            if (this.currentSelected) {
                switch (selectedDate) {
                    case '01.01.2021':
                        for (let i = 0; i < this.monthlyOilValue[0].sum.length; i++) {
                            let data = this.monthlyOilValue[0].values;
                            let sum = this.monthlyOilValue[0].sum;
                            let position = this.monthlyOilValue[0].coordinates;
                            let name = this.monthlyOilValue[0].name_numbers;
                            let water_percent = this.monthlyOilValue[0].water_percent;
                            features[i] = new Feature({
                                geometry: new Point(position[i]),
                                data: data[i],
                                sum: sum[i],
                                name: name[i],
                                position: position[i],
                                water_percent: water_percent[i]
                            });
                        }
                        break
                    case '01.02.2021':
                        for (let i = 0; i < this.monthlyOilValue[1].sum.length; i++) {
                            let data = this.monthlyOilValue[1].values;
                            let sum = this.monthlyOilValue[1].sum;
                            let position = this.monthlyOilValue[1].coordinates;
                            let name = this.monthlyOilValue[1].name_numbers;
                            let water_percent = this.monthlyOilValue[1].water_percent;
                            features[i] = new Feature({
                                geometry: new Point(position[i]),
                                data: data[i],
                                sum: sum[i],
                                name: name[i],
                                position: position[i],
                                water_percent: water_percent[i]
                            });
                        }
                        break
                    case '01.03.2021':
                        for (let i = 0; i < this.monthlyOilValue[2].sum.length; i++) {
                            let data = this.monthlyOilValue[2].values;
                            let sum = this.monthlyOilValue[2].sum;
                            let position = this.monthlyOilValue[2].coordinates;
                            let name = this.monthlyOilValue[2].name_numbers;
                            let water_percent = this.monthlyOilValue[2].water_percent;
                            features[i] = new Feature({
                                geometry: new Point(position[i]),
                                data: data[i],
                                sum: sum[i],
                                name: name[i],
                                position: position[i],
                                water_percent: water_percent[i]
                            });
                        }
                        break
                    case '01.04.2021':
                        for (let i = 0; i < this.monthlyOilValue[3].sum.length; i++) {
                            let data = this.monthlyOilValue[3].values;
                            let sum = this.monthlyOilValue[3].sum;
                            let position = this.monthlyOilValue[3].coordinates;
                            let name = this.monthlyOilValue[3].name_numbers;
                            let water_percent = this.monthlyOilValue[3].water_percent;
                            features[i] = new Feature({
                                geometry: new Point(position[i]),
                                data: data[i],
                                sum: sum[i],
                                name: name[i],
                                position: position[i],
                                water_percent: water_percent[i]
                            });
                        }
                        break
                    case '01.05.2021':
                        for (let i = 0; i < this.monthlyOilValue[4].sum.length; i++) {
                            let data = this.monthlyOilValue[4].values;
                            let sum = this.monthlyOilValue[4].sum;
                            let position = this.monthlyOilValue[4].coordinates;
                            let name = this.monthlyOilValue[4].name_numbers;
                            let water_percent = this.monthlyOilValue[4].water_percent;
                            features[i] = new Feature({
                                geometry: new Point(position[i]),
                                data: data[i],
                                sum: sum[i],
                                name: name[i],
                                position: position[i],
                                water_percent: water_percent[i]
                            });
                        }
                        break
                }
                if (selectedDate == '01.01.2021') {
                    for (let i = 0; i <= 11; i++) {
                        let data = [
                            [161.67742, 0],
                            [358.29032, 0],
                            [84.32258, 0],
                            [113.67742, 0],
                            [255.87097, 0],
                            [11.06452, 0],
                            [346.41935, 0],
                            [301.58065, 0],
                            [28.83871, 0],
                            [270.83871, 0],
                            [123, 0],
                            [77.77419, 0]
                        ];
                        let sum = [
                            [161.67742],
                            [358.29032],
                            [84.32258],
                            [113.67742],
                            [255.87097],
                            [11.06452],
                            [346.41935],
                            [301.58065],
                            [28.83871],
                            [270.83871],
                            [123],
                            [77.77419]
                        ];
                        let position = [
                            [11712546.71, 5092582.00],
                            [11711451.85, 5095102.09],
                            [11712417.45, 5097500.02],
                            [11711108.05, 5091233.02],
                            [11712355.59, 5095574.05],
                            [11710800.02, 5097163.99],
                            [11713742.79, 5092050.38],
                            [11712350.59, 5091197.07],
                            [11711566.00, 5092883.53],
                            [11714039.49, 5093151.73],
                            [11713430.74, 5096884.58],
                            [11710951.19, 5092407.06]
                        ];
                        let name = [
                            ['214'],
                            ['217'],
                            ['220'],
                            ['221'],
                            ['225'],
                            ['240'],
                            ['241'],
                            ['247'],
                            ['249'],
                            ['250'],
                            ['299'],
                            ['424']
                        ];

                        features2[i] = new Feature({
                            geometry: new Point(position[i]),
                            data: data[i],
                            sum: sum[i],
                            name: name[i],
                            position: position[i],
                        });
                    }
                }
                if (selectedDate == '01.02.2021') {
                    for (let i = 0; i <= 12; i++) {
                        let data = [
                            [165.96429, 0],
                            [347.82143, 0],
                            [85.28571, 0],
                            [112.96429, 0],
                            [252.64286, 0],
                            [108.95238, 0],
                            [7, 0],
                            [335.28571, 0],
                            [296, 0],
                            [30.28571, 0],
                            [268.53571, 0],
                            [122.17857, 0],
                            [81.07143, 0]
                        ];
                        let sum = [
                            [165.96429],
                            [347.82143],
                            [85.28571],
                            [112.96429],
                            [252.64286],
                            [108.95238],
                            [7],
                            [335.28571],
                            [296],
                            [30.28571],
                            [268.53571],
                            [122.17857],
                            [81.07143]
                        ];
                        let position = [
                            [11712546.71, 5092582.00],
                            [11711451.85, 5095102.09],
                            [11712417.45, 5097500.02],
                            [11711108.05, 5091233.02],
                            [11712355.59, 5095574.05],
                            [11709343.64, 5096824.16],
                            [11710800.02, 5097163.99],
                            [11713742.79, 5092050.38],
                            [11712350.59, 5091197.07],
                            [11711566.00, 5092883.53],
                            [11714039.49, 5093151.73],
                            [11713430.74, 5096884.58],
                            [11710951.19, 5092407.06]
                        ];
                        let name = [
                            ['214'],
                            ['217'],
                            ['220'],
                            ['221'],
                            ['225'],
                            ['24'],
                            ['240'],
                            ['241'],
                            ['247'],
                            ['249'],
                            ['250'],
                            ['299'],
                            ['424']
                        ];

                        features2[i] = new Feature({
                            geometry: new Point(position[i]),
                            data: data[i],
                            sum: sum[i],
                            name: name[i],
                            position: position[i],
                        });
                    }
                }
                if (selectedDate == '01.03.2021') {
                    for (let i = 0; i <= 13; i++) {
                        let data = [
                            [170.09677, 0],
                            [328.67742, 0],
                            [89.6129, 0],
                            [112.35484, 0],
                            [252.09677, 0],
                            [39.05882, 0],
                            [32.48387, 0],
                            [316.87097, 0],
                            [290.35484, 0],
                            [31.54839, 0],
                            [266.03226, 0],
                            [105.3871, 0],
                            [196.83871, 0],
                            [90.22581, 0]
                        ];
                        let sum = [
                            [170.09677],
                            [328.67742],
                            [89.6129],
                            [112.35484],
                            [252.09677],
                            [39.05882],
                            [32.48387],
                            [316.87097],
                            [290.35484],
                            [31.54839],
                            [266.03226],
                            [105.3871],
                            [196.83871],
                            [90.22581]
                        ];
                        let position = [
                            [11712546.71, 5092582],
                            [11711451.85, 5095102.09],
                            [11712417.45, 5097500.02],
                            [11711108.05, 5091233.02],
                            [11712355.59, 5095574.05],
                            [11709343.64, 5096824.16],
                            [11710800.02, 5097163.99],
                            [11713742.79, 5092050.38],
                            [11712350.59, 5091197.07],
                            [11711566, 5092883.53],
                            [11714039.49, 5093151.73],
                            [11713430.737, 5096884.576],
                            [11709257.39, 5093365.82],
                            [11710951.186, 5092407.061]
                        ];
                        let name = [
                            ['214'],
                            ['217'],
                            ['220'],
                            ['221'],
                            ['225'],
                            ['24'],
                            ['240'],
                            ['241'],
                            ['247'],
                            ['249'],
                            ['250'],
                            ['299'],
                            ['347'],
                            ['424']
                        ];

                        features2[i] = new Feature({
                            geometry: new Point(position[i]),
                            data: data[i],
                            sum: sum[i],
                            name: name[i],
                            position: position[i],
                        });
                    }
                }
                if (selectedDate == '01.04.2021') {
                    for (let i = 0; i <= 13; i++) {
                        let data = [
                            [160.86667, 0],
                            [110.96667, 0],
                            [108.63636, 0],
                            [113.8, 0],
                            [213.13333, 0],
                            [47.96667, 0],
                            [92.36667, 0],
                            [194.8, 0],
                            [293.5, 0],
                            [30.53333, 0],
                            [277.73333, 0],
                            [146.06667, 0],
                            [114.36364, 0],
                            [89.96667, 0]
                        ];
                        let sum = [
                            [160.86667],
                            [110.96667],
                            [108.63636],
                            [113.8],
                            [213.13333],
                            [47.96667],
                            [92.36667],
                            [194.8],
                            [293.5],
                            [30.53333],
                            [277.73333],
                            [146.06667],
                            [114.36364],
                            [89.96667]
                        ];
                        let position = [
                            [11712546.71, 5092582],
                            [11711451.85, 5095102.09],
                            [11712417.45, 5097500.02],
                            [11711108.05, 5091233.02],
                            [11712355.59, 5095574.05],
                            [11709343.64, 5096824.16],
                            [11710800.02, 5097163.99],
                            [11713742.79, 5092050.38],
                            [11712350.59, 5091197.07],
                            [11711566, 5092883.53],
                            [11714039.49, 5093151.73],
                            [11713430.737, 5096884.576],
                            [11709257.39, 5093365.82],
                            [11710951.186, 5092407.061]
                        ];
                        let name = [
                            ['214'],
                            ['217'],
                            ['220'],
                            ['221'],
                            ['225'],
                            ['24'],
                            ['240'],
                            ['241'],
                            ['247'],
                            ['249'],
                            ['250'],
                            ['299'],
                            ['347'],
                            ['424']
                        ];

                        features2[i] = new Feature({
                            geometry: new Point(position[i]),
                            data: data[i],
                            sum: sum[i],
                            name: name[i],
                            position: position[i],
                        });
                    }
                }
                if (selectedDate == '01.05.2021') {
                    for (let i = 0; i <= 13; i++) {
                        let data = [
                            [159.25806, 0],
                            [130.80645, 0],
                            [91.87097, 0],
                            [112.96774, 0],
                            [168.93548, 0],
                            [49.67742, 0],
                            [78.32258, 0],
                            [201.83871, 0],
                            [315, 0],
                            [29.83871, 0],
                            [294.35484, 0],
                            [180.77419, 0],
                            [92.14286, 0],
                            [91.67742, 0]
                        ];
                        let sum = [
                            [159.25806],
                            [130.80645],
                            [91.87097],
                            [112.96774],
                            [168.93548],
                            [49.67742],
                            [78.32258],
                            [201.83871],
                            [315],
                            [29.83871],
                            [294.35484],
                            [180.77419],
                            [92.14286],
                            [91.67742]
                        ];
                        let position = [
                            [11712546.71, 5092582],
                            [11711451.85, 5095102.09],
                            [11712417.45, 5097500.02],
                            [11711108.05, 5091233.02],
                            [11712355.59, 5095574.05],
                            [11709343.64, 5096824.16],
                            [11710800.02, 5097163.99],
                            [11713742.79, 5092050.38],
                            [11712350.59, 5091197.07],
                            [11711566, 5092883.53],
                            [11714039.49, 5093151.73],
                            [11713430.737, 5096884.576],
                            [11709257.39, 5093365.82],
                            [11710951.186, 5092407.061]
                        ];
                        let name = [
                            ['214'],
                            ['217'],
                            ['220'],
                            ['221'],
                            ['225'],
                            ['24'],
                            ['240'],
                            ['241'],
                            ['247'],
                            ['249'],
                            ['250'],
                            ['299'],
                            ['347'],
                            ['424']
                        ];

                        features2[i] = new Feature({
                            geometry: new Point(position[i]),
                            data: data[i],
                            sum: sum[i],
                            name: name[i],
                            position: position[i],
                        });
                    }
                }
            }

            let features3 = [];
            let features4 = [];

            if (this.accumulatedSelected) {
                switch (selectedDate) {
                    case '01.01.2021':
                        for (let i = 0; i < this.monthlyOilValue[0].accum_sum.length; i++) {
                            let data = this.monthlyOilValue[0].accum_values;
                            let sum = this.monthlyOilValue[0].accum_sum;
                            let position = this.monthlyOilValue[0].coordinates;
                            let name = this.monthlyOilValue[0].name_numbers;
                            let water_percent = this.monthlyOilValue[0].water_percent;
                            features3[i] = new Feature({
                                geometry: new Point(position[i]),
                                data: data[i],
                                sum: sum[i],
                                name: name[i],
                                position: position[i],
                                water_percent: water_percent[i]
                            });
                        }
                        break
                    case '01.02.2021':
                        for (let i = 0; i < this.monthlyOilValue[1].accum_sum.length; i++) {
                            let data = this.monthlyOilValue[1].accum_values;
                            let sum = this.monthlyOilValue[1].accum_sum;
                            let position = this.monthlyOilValue[1].coordinates;
                            let name = this.monthlyOilValue[1].name_numbers;
                            let water_percent = this.monthlyOilValue[1].water_percent;
                            features3[i] = new Feature({
                                geometry: new Point(position[i]),
                                data: data[i],
                                sum: sum[i],
                                name: name[i],
                                position: position[i],
                                water_percent: water_percent[i]
                            });
                        }
                        break
                    case '01.03.2021':
                        for (let i = 0; i < this.monthlyOilValue[2].accum_sum.length; i++) {
                            let data = this.monthlyOilValue[2].accum_values;
                            let sum = this.monthlyOilValue[2].accum_sum;
                            let position = this.monthlyOilValue[2].coordinates;
                            let name = this.monthlyOilValue[2].name_numbers;
                            let water_percent = this.monthlyOilValue[2].water_percent;
                            features3[i] = new Feature({
                                geometry: new Point(position[i]),
                                data: data[i],
                                sum: sum[i],
                                name: name[i],
                                position: position[i],
                                water_percent: water_percent[i]
                            });
                        }
                        break
                    case '01.04.2021':
                        for (let i = 0; i < this.monthlyOilValue[3].accum_sum.length; i++) {
                            let data = this.monthlyOilValue[3].accum_values;
                            let sum = this.monthlyOilValue[3].accum_sum;
                            let position = this.monthlyOilValue[3].coordinates;
                            let name = this.monthlyOilValue[3].name_numbers;
                            let water_percent = this.monthlyOilValue[3].water_percent;
                            features3[i] = new Feature({
                                geometry: new Point(position[i]),
                                data: data[i],
                                sum: sum[i],
                                name: name[i],
                                position: position[i],
                                water_percent: water_percent[i]
                            });
                        }
                        break
                    case '01.05.2021':
                        for (let i = 0; i < this.monthlyOilValue[4].accum_sum.length; i++) {
                            let data = this.monthlyOilValue[4].accum_values;
                            let sum = this.monthlyOilValue[4].accum_sum;
                            let position = this.monthlyOilValue[4].coordinates;
                            let name = this.monthlyOilValue[4].name_numbers;
                            let water_percent = this.monthlyOilValue[4].water_percent;
                            features3[i] = new Feature({
                                geometry: new Point(position[i]),
                                data: data[i],
                                sum: sum[i],
                                name: name[i],
                                position: position[i],
                                water_percent: water_percent[i]
                            });
                        }
                        break
                }
                if (selectedDate == '01.01.2021') {
                    for (let i = 0; i <= 11; i++) {
                        let data = [
                            [5012, 0],
                            [11107, 0],
                            [2614, 0],
                            [3524, 0],
                            [7932, 0],
                            [343, 0],
                            [10739, 0],
                            [9349, 0],
                            [894, 0],
                            [8396, 0],
                            [3813, 0],
                            [2411, 0]
                        ];
                        let sum = [
                            [5012],
                            [11107],
                            [2614],
                            [3524],
                            [7932],
                            [343],
                            [10739],
                            [9349],
                            [894],
                            [8396],
                            [3813],
                            [2411]
                        ];
                        let position = [
                            [11712546.71, 5092582.00],
                            [11711451.85, 5095102.09],
                            [11712417.45, 5097500.02],
                            [11711108.05, 5091233.02],
                            [11712355.59, 5095574.05],
                            [11710800.02, 5097163.99],
                            [11713742.79, 5092050.38],
                            [11712350.59, 5091197.07],
                            [11711566.00, 5092883.53],
                            [11714039.49, 5093151.73],
                            [11713430.74, 5096884.58],
                            [11710951.19, 5092407.06]
                        ];
                        let name = [
                            ['214'],
                            ['217'],
                            ['220'],
                            ['221'],
                            ['225'],
                            ['240'],
                            ['241'],
                            ['247'],
                            ['249'],
                            ['250'],
                            ['299'],
                            ['424']
                        ];

                        features4[i] = new Feature({
                            geometry: new Point(position[i]),
                            data: data[i],
                            sum: sum[i],
                            name: name[i],
                            position: position[i],
                        });
                    }
                }
                if (selectedDate == '01.02.2021') {
                    for (let i = 0; i <= 12; i++) {
                        let data = [
                            [4647, 0],
                            [9739, 0],
                            [2388, 0],
                            [3163, 0],
                            [7074, 0],
                            [2288, 0],
                            [196, 0],
                            [9388, 0],
                            [8288, 0],
                            [848, 0],
                            [7519, 0],
                            [3421, 0],
                            [2270, 0]
                        ];
                        let sum = [
                            [4647],
                            [9739],
                            [2388],
                            [3163],
                            [7074],
                            [2288],
                            [196],
                            [9388],
                            [8288],
                            [848],
                            [7519],
                            [3421],
                            [2270]
                        ];
                        let position = [
                            [11712546.71, 5092582.00],
                            [11711451.85, 5095102.09],
                            [11712417.45, 5097500.02],
                            [11711108.05, 5091233.02],
                            [11712355.59, 5095574.05],
                            [11709343.64, 5096824.16],
                            [11710800.02, 5097163.99],
                            [11713742.79, 5092050.38],
                            [11712350.59, 5091197.07],
                            [11711566.00, 5092883.53],
                            [11714039.49, 5093151.73],
                            [11713430.74, 5096884.58],
                            [11710951.19, 5092407.06]
                        ];
                        let name = [
                            ['214'],
                            ['217'],
                            ['220'],
                            ['221'],
                            ['225'],
                            ['24'],
                            ['240'],
                            ['241'],
                            ['247'],
                            ['249'],
                            ['250'],
                            ['299'],
                            ['424']
                        ];

                        features4[i] = new Feature({
                            geometry: new Point(position[i]),
                            data: data[i],
                            sum: sum[i],
                            name: name[i],
                            position: position[i],
                        });
                    }
                }
                if (selectedDate == '01.03.2021') {
                    for (let i = 0; i <= 13; i++) {
                        let data = [
                            [5273, 0],
                            [10189, 0],
                            [2778, 0],
                            [3483, 0],
                            [7815, 0],
                            [664, 0],
                            [1007, 0],
                            [9823, 0],
                            [9001, 0],
                            [978, 0],
                            [8247, 0],
                            [3267, 0],
                            [6102, 0],
                            [2797, 0]
                        ];
                        let sum = [
                            [5273],
                            [10189],
                            [2778],
                            [3483],
                            [7815],
                            [664],
                            [1007],
                            [9823],
                            [9001],
                            [978],
                            [8247],
                            [3267],
                            [6102],
                            [2797]
                        ];
                        let position = [
                            [11712546.71, 5092582],
                            [11711451.85, 5095102.09],
                            [11712417.45, 5097500.02],
                            [11711108.05, 5091233.02],
                            [11712355.59, 5095574.05],
                            [11709343.64, 5096824.16],
                            [11710800.02, 5097163.99],
                            [11713742.79, 5092050.38],
                            [11712350.59, 5091197.07],
                            [11711566, 5092883.53],
                            [11714039.49, 5093151.73],
                            [11713430.737, 5096884.576],
                            [11709257.39, 5093365.82],
                            [11710951.186, 5092407.061]
                        ];
                        let name = [
                            ['214'],
                            ['217'],
                            ['220'],
                            ['221'],
                            ['225'],
                            ['24'],
                            ['240'],
                            ['241'],
                            ['247'],
                            ['249'],
                            ['250'],
                            ['299'],
                            ['347'],
                            ['424']
                        ];

                        features4[i] = new Feature({
                            geometry: new Point(position[i]),
                            data: data[i],
                            sum: sum[i],
                            name: name[i],
                            position: position[i],
                        });
                    }
                }
                if (selectedDate == '01.04.2021') {
                    for (let i = 0; i <= 13; i++) {
                        let data = [
                            [4826, 0],
                            [3329, 0],
                            [2390, 0],
                            [3414, 0],
                            [6394, 0],
                            [1439, 0],
                            [2771, 0],
                            [5844, 0],
                            [8805, 0],
                            [916, 0],
                            [8332, 0],
                            [4382, 0],
                            [2516, 0],
                            [2699, 0]
                        ];
                        let sum = [
                            [4826],
                            [3329],
                            [2390],
                            [3414],
                            [6394],
                            [1439],
                            [2771],
                            [5844],
                            [8805],
                            [916],
                            [8332],
                            [4382],
                            [2516],
                            [2699]
                        ];
                        let position = [
                            [11712546.71, 5092582],
                            [11711451.85, 5095102.09],
                            [11712417.45, 5097500.02],
                            [11711108.05, 5091233.02],
                            [11712355.59, 5095574.05],
                            [11709343.64, 5096824.16],
                            [11710800.02, 5097163.99],
                            [11713742.79, 5092050.38],
                            [11712350.59, 5091197.07],
                            [11711566, 5092883.53],
                            [11714039.49, 5093151.73],
                            [11713430.737, 5096884.576],
                            [11709257.39, 5093365.82],
                            [11710951.186, 5092407.061]
                        ];
                        let name = [
                            ['214'],
                            ['217'],
                            ['220'],
                            ['221'],
                            ['225'],
                            ['24'],
                            ['240'],
                            ['241'],
                            ['247'],
                            ['249'],
                            ['250'],
                            ['299'],
                            ['347'],
                            ['424']
                        ];

                        features4[i] = new Feature({
                            geometry: new Point(position[i]),
                            data: data[i],
                            sum: sum[i],
                            name: name[i],
                            position: position[i],
                        });
                    }
                }
                if (selectedDate == '01.05.2021') {
                    for (let i = 0; i <= 13; i++) {
                        let data = [
                            [4937, 0],
                            [4055, 0],
                            [2848, 0],
                            [3502, 0],
                            [5237, 0],
                            [1540, 0],
                            [2428, 0],
                            [6257, 0],
                            [8820, 0],
                            [925, 0],
                            [9125, 0],
                            [5604, 0],
                            [2580, 0],
                            [2842, 0]
                        ];
                        let sum = [
                            [4937],
                            [4055],
                            [2848],
                            [3502],
                            [5237],
                            [1540],
                            [2428],
                            [6257],
                            [8820],
                            [925],
                            [9125],
                            [5604],
                            [2580],
                            [2842]
                        ];
                        let position = [
                            [11712546.71, 5092582],
                            [11711451.85, 5095102.09],
                            [11712417.45, 5097500.02],
                            [11711108.05, 5091233.02],
                            [11712355.59, 5095574.05],
                            [11709343.64, 5096824.16],
                            [11710800.02, 5097163.99],
                            [11713742.79, 5092050.38],
                            [11712350.59, 5091197.07],
                            [11711566, 5092883.53],
                            [11714039.49, 5093151.73],
                            [11713430.737, 5096884.576],
                            [11709257.39, 5093365.82],
                            [11710951.186, 5092407.061]
                        ];
                        let name = [
                            ['214'],
                            ['217'],
                            ['220'],
                            ['221'],
                            ['225'],
                            ['24'],
                            ['240'],
                            ['241'],
                            ['247'],
                            ['249'],
                            ['250'],
                            ['299'],
                            ['347'],
                            ['424']
                        ];

                        features4[i] = new Feature({
                            geometry: new Point(position[i]),
                            data: data[i],
                            sum: sum[i],
                            name: name[i],
                            position: position[i],
                        });
                    }
                }
            }

            let vector = new VectorLayer({
                name: 'Vector',
                source: new VectorSource({features: features}),
                style: function (f) {
                    return getFeatureStyle(f);
                }
            })
            let vector2 = new VectorLayer({
                name: 'Vector2',
                source: new VectorSource({features: features2}),
                style: function (f) {
                    return getFeatureStyle2(f);
                }
            })
            let vector3 = new VectorLayer({
                name: 'Vector3',
                source: new VectorSource({features: features3}),
                style: function (f) {
                    return getFeatureStyle3(f);
                }
            })
            let vector4 = new VectorLayer({
                name: 'Vector4',
                source: new VectorSource({features: features4}),
                style: function (f) {
                    return getFeatureStyle4(f);
                }
            })

            map.addLayer(vector4);
            map.addLayer(vector3);
            map.addLayer(vector);
            map.addLayer(vector2);

            let selectNew = new Select();
            map.addInteraction(selectNew);

            selectNew.on('select', function (evt) {
                if (evt.selected.length > 0) {
                    let pieData = evt.selected[0].values_
                    if (pieData.data[1] === 0 && pieData.sum[0] % 1 !== 0) {
                        selectNew.style_ = function (f) {
                            return getFeatureStyle2(f, true);
                        }
                        map.addInteraction(selectNew);
                    }
                    if (pieData.data[1] === 0 && pieData.sum[0] % 1 === 0) {
                        selectNew.style_ = function (f) {
                            return getFeatureStyle4(f, true);
                        }
                        map.addInteraction(selectNew);
                    }
                    if (pieData.sum[0] < 200 && pieData.data[1] !== 0) {
                        selectNew.style_ = function (f) {
                            return getFeatureStyle(f, true);
                        }
                        map.addInteraction(selectNew);
                    }
                    if (pieData.sum[0] > 200 && pieData.data[1] !== 0) {
                        selectNew.style_ = function (f) {
                            return getFeatureStyle3(f, true);
                        }
                        map.addInteraction(selectNew);
                    }
                }
            });

        },
        setMenu(top, left) {
            let largestHeight = this.windHeight - this.$refs.right.offsetHeight - 25;
            let largestWidth = this.windWidth - this.$refs.right.offsetWidth - 25;

            top = top > largestHeight ? largestHeight : top;
            left = left > largestWidth ? largestWidth : left

            this.top = `${top}px`;
            this.left = `${left}px`;
        },
        setMenuLayers(top, left) {
            let largestHeight = this.windHeight - this.$refs.rightLayers.offsetHeight - 25;
            let largestWidth = this.windWidth - this.$refs.rightLayers.offsetWidth - 25;

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
                this.$refs.right.focus();
                this.setMenu(e.y, e.x);
            });
            e.preventDefault();
        },
        openMenuLayers(e) {
            this.viewMenuLayers = true;
            Vue.nextTick(() => {
                this.$refs.rightLayers.focus();
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
        showFiles() {
            let more = document.getElementById(`files`);
            let arrow = document.getElementById(`arrow`);
            if (more.style.display === "block") {
                more.style.display = "none";
                arrow.classList.remove('rotate90')
            } else {
                more.style.display = "block";
                arrow.classList.add('rotate90')
            }
        },
        addFile() {
            this.files += 1;
            if (this.files === 1) {
                this.showFiles();
            }
        },
    }
}
