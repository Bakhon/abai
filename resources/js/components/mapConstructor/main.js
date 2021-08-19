import RightClickMenu from './shared/RightClickMenu'
import TopMenu from './shared/TopMenu'
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
            mapInitialized: false,
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
        mapInit() {
            this.mapInitialized = false;
            this.$nextTick(() => this.mapInit2())
        },
        async mapInit2() {
            this.mapInitialized = true;

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

            function drawData (feature, sel, rad, circleType) {
                let k = $("#graph").val() + "-" + $("#color").val() + "-" + (sel ? "1-" : "") + feature.get("data");
                let style = styleCache[k];
                if (!style) {
                    let radius;
                    radius = 8 * Math.sqrt(feature.get("sum") / Math.PI) / rad;
                    let data = feature.get("data");
                    let name = feature.get("name").toString();
                    let pos = feature.get("position");
                    let sum = feature.get("sum");
                    let water_percent = feature.get("water_percent");
                    let element = popup.getElement();

                    if (circleType === 'pieChart') {
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
                            $(element).popover('dispose');
                            popup.setPosition(pos);
                            switch (rad) {
                                case 1:
                                    $(element).popover({
                                        container: element,
                                        placement: 'top',
                                        animation: false,
                                        html: true,
                                        content: '<p>Скважина\n<code class="text-dark font-weight-bold">' + name + '</code></p>' + '<p> Жидкость, м3/сут\n<code class="text-dark font-weight-bold">' + sum + '</code></p>' + '<p>Нефть, м3/сут\n<code class="text-dark font-weight-bold">' + data[1] + '</code></p>' + '<p>Обводненность, %\n<code class="text-dark font-weight-bold">' + water_percent + '</code></p>' + '<p>Координаты:\n</p><p><code class="text-dark font-weight-bold">' + pos[0] + '</code></p><p><code class="text-dark font-weight-bold">' + pos[1] + '</code></p>',
                                    });
                                    break
                                case 40:
                                    $(element).popover({
                                        container: element,
                                        placement: 'top',
                                        animation: false,
                                        html: true,
                                        content: '<p>Скважина\n<code class="text-dark font-weight-bold">' + name + '</code></p>' + '<p> Жидкость, м3\n<code class="text-dark font-weight-bold">' + sum + '</code></p>' + '<p>Нефть, т\n<code class="text-dark font-weight-bold">' + data[1] + '</code></p>' + '<p>Обводненность, %\n<code class="text-dark font-weight-bold">' + water_percent + '</code></p>' + '<p>Координаты:\n</p><p><code class="text-dark font-weight-bold">' + pos[0] + '</code></p><p><code class="text-dark font-weight-bold">' + pos[1] + '</code></p>',
                                    });
                                    break
                            }
                            $(element).popover('show');
                        }
                    }
                    if (circleType === 'circle') {
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
                            $(element).popover('dispose');
                            popup.setPosition(pos);
                            switch (rad) {
                                case 5:
                                    $(element).popover({
                                        container: element,
                                        placement: 'top',
                                        animation: false,
                                        html: true,
                                        content: '<p>Скважина\n<code class="text-dark font-weight-bold">' + name + '</code></p>' + '<p>Закачка, м3\n<code class="text-dark font-weight-bold">' + sum + '</code></p>' + '<p>Координаты:\n</p><p><code class="text-dark font-weight-bold">' + pos[0] + '</code></p><p><code class="text-dark font-weight-bold">' + pos[1] + '</code></p>',
                                    });
                                    break
                                case 2:
                                    $(element).popover({
                                        container: element,
                                        placement: 'top',
                                        animation: false,
                                        html: true,
                                        content: '<p>Скважина\n<code class="text-dark font-weight-bold">' + name + '</code></p>' + '<p>Среднесуточная приемистость, м3/сут\n<code class="text-dark font-weight-bold">' + sum + '</code></p>' + '<p>Координаты:\n</p><p><code class="text-dark font-weight-bold">' + pos[0] + '</code></p><p><code class="text-dark font-weight-bold">' + pos[1] + '</code></p>',
                                    });
                                    break
                            }
                            $(element).popover('show');
                            map.on('movestart', function () {
                                $(element).popover('dispose');
                            });
                        }
                    }

                }
                return style;
            }

            let selectedDate = moment(this.selectedMonth).format('01.MM.YYYY');

            let currentProductionFeatures = [];
            let currentInjectionFeatures = [];
            let accumProductionFeatures = [];
            let accumInjectionFeatures = [];
            let dateIndex;
            switch (selectedDate) {
                case '01.01.2021':
                    dateIndex = 0;
                    break
                case '01.02.2021':
                    dateIndex = 1;
                    break
                case '01.03.2021':
                    dateIndex = 2;
                    break
                case '01.04.2021':
                    dateIndex = 3;
                    break
                case '01.05.2021':
                    dateIndex = 4;
                    break
            }
            if (this.currentSelected) {
                for (let i = 0; i < this.monthlyOilValue[dateIndex].production.names.length; i++) {
                    let data = this.monthlyOilValue[dateIndex].production.current.values;
                    let sum = this.monthlyOilValue[dateIndex].production.current.sum;
                    let position = this.monthlyOilValue[dateIndex].production.coordinates;
                    let name = this.monthlyOilValue[dateIndex].production.names;
                    let water_percent = this.monthlyOilValue[dateIndex].production.water_percent;
                    currentProductionFeatures[i] = new Feature({
                        geometry: new Point(position[i]),
                        data: data[i],
                        sum: sum[i],
                        name: name[i],
                        position: position[i],
                        water_percent: water_percent[i]
                    });
                }
                for (let i = 0; i < this.monthlyOilValue[dateIndex].injection.names.length; i++) {
                    let data = this.monthlyOilValue[dateIndex].injection.current.values;
                    let sum = this.monthlyOilValue[dateIndex].injection.current.sum;
                    let position = this.monthlyOilValue[dateIndex].injection.coordinates;
                    let name = this.monthlyOilValue[dateIndex].injection.names;
                    currentInjectionFeatures[i] = new Feature({
                        geometry: new Point(position[i]),
                        data: data[i],
                        sum: sum[i],
                        name: name[i],
                        position: position[i],
                    });
                }
            }
            if (this.accumulatedSelected) {
                for (let i = 0; i < this.monthlyOilValue[dateIndex].production.names.length; i++) {
                    let data = this.monthlyOilValue[dateIndex].production.accumulated.values;
                    let sum = this.monthlyOilValue[dateIndex].production.accumulated.sum;
                    let position = this.monthlyOilValue[dateIndex].production.coordinates;
                    let name = this.monthlyOilValue[dateIndex].production.names;
                    let water_percent = this.monthlyOilValue[dateIndex].production.water_percent;
                    accumProductionFeatures[i] = new Feature({
                        geometry: new Point(position[i]),
                        data: data[i],
                        sum: sum[i],
                        name: name[i],
                        position: position[i],
                        water_percent: water_percent[i]
                    });
                }
                for (let i = 0; i < this.monthlyOilValue[dateIndex].injection.names.length; i++) {
                    let data = this.monthlyOilValue[dateIndex].injection.accumulated.values;
                    let sum = this.monthlyOilValue[dateIndex].injection.accumulated.sum;
                    let position = this.monthlyOilValue[dateIndex].injection.coordinates;
                    let name = this.monthlyOilValue[dateIndex].injection.names;
                    accumInjectionFeatures[i] = new Feature({
                        geometry: new Point(position[i]),
                        data: data[i],
                        sum: sum[i],
                        name: name[i],
                        position: position[i],
                    });
                }
            }

            let vectorCurrentProd = new VectorLayer({
                name: 'vectorCurrentProd',
                source: new VectorSource({features: currentProductionFeatures}),
                style: (f) => {
                    return drawData(f, false,1,'pieChart');
                }
            })
            let vectorCurrentInject = new VectorLayer({
                name: 'vectorCurrentInject',
                source: new VectorSource({features: currentInjectionFeatures}),
                style: function (f) {
                    return drawData(f, false, 2 , 'circle');
                }
            })
            let vectorAccumProd = new VectorLayer({
                name: 'vectorAccumProd',
                source: new VectorSource({features: accumProductionFeatures}),
                style: function (f) {
                    return drawData(f, false,40,'pieChart');
                }
            })
            let vectorAccumInject = new VectorLayer({
                name: 'vectorAccumInject',
                source: new VectorSource({features: accumInjectionFeatures}),
                style: function (f) {
                    return drawData(f, false, 5 , 'circle');
                }
            })

            map.addLayer(vectorAccumInject);
            map.addLayer(vectorAccumProd);
            map.addLayer(vectorCurrentProd);
            map.addLayer(vectorCurrentInject);

            let selectNew = new Select();
            map.addInteraction(selectNew);

            selectNew.on('select', function (evt) {
                if (evt.selected.length > 0) {
                    let pieData = evt.selected[0].values_
                    if (pieData.data[1] === 0 && pieData.sum[0] % 1 !== 0) {
                        selectNew.style_ = function (f) {
                            return drawData(f, true,2,'circle');
                        }
                        map.addInteraction(selectNew);
                    }
                    if (pieData.data[1] === 0 && pieData.sum[0] % 1 === 0) {
                        selectNew.style_ = function (f) {
                            return drawData(f, true,5,'circle');
                        }
                        map.addInteraction(selectNew);
                    }
                    if (pieData.sum[0] < 200 && pieData.data[1] !== 0) {
                        selectNew.style_ = function (f) {
                            return drawData(f, true,1,'pieChart');
                        }
                        map.addInteraction(selectNew);
                    }
                    if (pieData.sum[0] > 200 && pieData.data[1] !== 0) {
                        selectNew.style_ = function (f) {
                            return drawData(f, true,40,'pieChart');
                        }
                        map.addInteraction(selectNew);
                    }
                }
            });

        },
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
