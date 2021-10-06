import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import {globalloadingMutations} from "../../../../store/helpers";
import VueApexCharts from "vue-apexcharts";
import {paegtmMapState} from "@store/helpers";
import {toArray} from "html-to-image/es/util";


export default {
    components: {
        vSelect,
        apexchart: VueApexCharts
    },

    data: function () {
        return {
            showBlock: 2,
            menuArrowUp: '/img/GTM/icon_menu_arrow_up.svg',
            menuArrowDown: '/img/GTM/icon_menu_arrow_down.svg',
            url: process.env.MIX_PODBOR_GTM_URL,
            bswVal: [],
            liquidRate: [],
            oilRate: [],
            wellNumber: null,
            table: {
                main_data: {
                    header: null,
                    data: null,
                },
            },
            dataRange: null,
            fieldName: null,
            mainData: null,
            serviceOffline: true,
            body: {
                action_type: 'page_initialized',
                main_data: "\"название страницы\""
            },
            dzosForFilter: [
                {name: 'АО "Озенмунайгаз"', code: 'omg'},
                {name: 'АО "ЭмбаМунайГаз"', code: 'emba'},
                {name: 'АО "Мангистаумунайгаз"', code: 'mmg'},
                {name: 'АО "Каражанбасмунай"', code: 'krm'},
                {name: 'ТОО "СП "Казгермунай"', code: 'kazger'},
                {name: 'ТОО "Казтуркмунай"', code: 'ktm'},
                {name: 'ТОО "Казахойл Актобе"', code: 'koa'},
            ],
            oilFieldsForFilter: [
                {name: 'Акшабулак', code: 'oil_1'},
                {name: 'Актобе', code: 'oil_2'},
                {name: 'Алтыколь', code: 'oil_3'},
                {name: 'Жетыбай', code: 'oil_4'},
                {name: 'Жыланды', code: 'oil_5'},
                {name: 'Жыланды', code: 'oil_6'},
                {name: 'Каламкас', code: 'oil_7'},
                {name: 'Каражанбас', code: 'oil_8'},
            ],
            objectsForFilter: [{name: 'Вариант 1'}],
            structuresForFilter: [{name: 'Вариант 1'}],
            gusForFilter: [{name: 'Вариант 1'}],
            candidates: [
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
                [4320, 'ГРП', 7.9, 5.53, 70],
            ],
            treeData: [],
            waterFallChartOptions: {
                chart: {
                    height: 320,
                    type: 'rangeBar',
                    foreColor: '#fff'
                },
                plotOptions: {
                    bar: {
                        horizontal: false
                    }
                },
                dataLabels: {
                    enabled: true,
                    // formatter: v => v.toFixed()
                }
            },
            waterFallChartSeries: null,
            lineChartSeries: null,
            lineChartOptions: {
                chart: {
                    height: 350,
                    type: 'area',
                    foreColor: '#fff'
                },
                options: {
                    legend: {
                        fontSize: '5px',
                        horizontalAlign: "left",
                    },
                },
                colors: ["#04f689", "#fa4202", '#0253fa'],

                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: null,
                    tickAmount: 6,
                    lines: {
                        show: true,
                        tickAmount: 20,
                        min: 10,
                        max: 20,

                    },
                    labels: {
                        style: {
                            fontSize: '10px'
                        }
                    }
                },
                yaxis: [
                    {
                        seriesName: `${this.trans('pgno.q_nefti')} ${this.trans('measurements.t/d')}`,
                        axisTicks: {show: true},
                        axisBorder: {show: true,},
                        title: {
                            text: `${this.trans('pgno.q_nefti')} ${this.trans('measurements.t/d')}`, style: {
                                color: undefined,
                                fontSize: '15px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 700,
                                cssClass: 'apexcharts-yaxis-title',
                            },
                        },
                    },
                    {
                        seriesName: `${this.trans('pgno.q_liq')} ${this.trans('measurements.m3/day')}`,
                        axisTicks: {show: true},
                        axisBorder: {show: true,},
                        title: {
                            text: `${this.trans('pgno.q_liq')} ${this.trans('measurements.m3/day')}`, style: {
                                color: undefined,
                                fontSize: '15px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 700,
                                cssClass: 'apexcharts-yaxis-title',
                            },
                        }
                    },
                    {
                        seriesName: `${this.trans('pgno.obvodnenost')} %`,
                        opposite: true,
                        max: 100,
                        title: {
                            text: `${this.trans('pgno.obvodnenost')} %`, style: {
                                color: undefined,
                                fontSize: '15px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 700,
                                cssClass: 'apexcharts-yaxis-title',
                            },
                        }
                    },
                ],
                grid: {
                    show: true,
                    borderColor: '#454d7d',
                    strokeDashArray: 0,
                    position: 'back',
                },
            },
            treeSettingHeader: '',
            treeSettingBody: '',
            treeSettingComponent: null,
            treeChildrenComponent: null,
            isMinimize: true
        };
    },
    computed: {
        ...paegtmMapState([
            'clickable',
        ]),
    },
    watch: {},
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        setNotify(message, title, type) {
            this.$bvToast.toast(message, {
                title: title,
                variant: type,
                solid: true,
                toaster: "b-toaster-top-center",
                autoHideDelay: 8000,
            });
        },
        onMinimizeChart() {
            this.isMinimize = !this.isMinimize;
        },
        onClickableValue() {
            const body = {
                action_type: 'finder_item_clicked',
                main_data: this.clickable,
            }
            this.SET_LOADING(true);
            axios.post(this.url, {action_type: 'finder_item_clicked', main_data: this.clickable,})
                .then((res) => {
                    this.table.main_data.header = res.data.main_data.header
                    this.table.main_data.data = res.data.main_data.data
                    if (res.status === 200) {
                        this.setNotify("Данные получены", "Success", "success")
                    } else {
                        this.setNotify("Что-то пошло не так", "Error", "danger")
                    }
                })
                .finally(() => {
                    this.SET_LOADING(false);
                })
        },
        onClickWell(v) {
            this.wellNumber = v
            this.setNotify(`Выбрана скважина ${v}`, "Success", "success")

            this.SET_LOADING(true);
            axios.post(this.url, {action_type: 'well_name_clicked', main_data: v, distance: 500})
                .then((res) => {
                    this.lineChartOptions.xaxis.categories = Object.values(res.data.main_data.dt)
                    this.lineChartSeries = [
                        {
                            name: res.data.main_data.labels.liquid_rate,
                            data: Object.values(res.data.main_data.liquid_rate),
                            showLine: false,
                        },
                        {
                            name: res.data.main_data.labels.oil_rate,
                            data: Object.values(res.data.main_data.oil_rate),
                            pointBorderColor: "#FFFFFF",
                        },
                        {
                            name: res.data.main_data.labels.bsw_val,
                            data: Object.values(res.data.main_data.bsw_val),
                            pointBorderColor: "#FFFFFF",
                        },
                    ],
                        this.waterFallChartSeries = [{
                            data: [
                                {
                                    x: res.data.fa_plot.labels.pbeg_oil_prod,
                                    y: res.data.fa_plot.pbeg_oil_prod.values.map(a => parseInt(a).toFixed(0)),
                                    fillColor: res.data.fa_plot.pbeg_oil_prod.color,
                                }, {
                                    x: res.data.fa_plot.labels.influenceWC,
                                    y: res.data.fa_plot.influenceWC.values.map(a => parseInt(a).toFixed(0)),
                                    fillColor: res.data.fa_plot.influenceWC.color,
                                }, {
                                    x: res.data.fa_plot.labels.influencePres,
                                    y: res.data.fa_plot.influencePres.values.map(a => parseInt(a).toFixed(0)),
                                    fillColor: res.data.fa_plot.influencePres.color,
                                }, {
                                    x: res.data.fa_plot.labels.influenceLiquidPI,
                                    y: res.data.fa_plot.influenceLiquidPI.values.map(a => parseInt(a).toFixed(0)),
                                    fillColor: res.data.fa_plot.influenceLiquidPI.color,
                                }, {
                                    x: res.data.fa_plot.labels.influenceBHP,
                                    y: res.data.fa_plot.influenceBHP.values.map(a => parseInt(a).toFixed(0)),
                                    fillColor: res.data.fa_plot.influenceBHP.color,
                                }, {
                                    x: res.data.fa_plot.labels.influenceWorkDay,
                                    y: res.data.fa_plot.influenceWorkDay.values.map(a => parseInt(a).toFixed(0)),
                                    fillColor: res.data.fa_plot.influenceWorkDay.color,
                                }, {
                                    x: res.data.fa_plot.labels.pend_oil_prod,
                                    y: res.data.fa_plot.pend_oil_prod.values.map(a => parseInt(a).toFixed(0)),
                                    fillColor: res.data.fa_plot.pend_oil_prod.color,
                                }
                            ]
                        }]

                    if (res.status === 200) {
                        this.setNotify("Данные получены", "Success", "success")
                    } else {
                        this.setNotify("Что-то пошло не так", "Error", "danger")
                    }
                })
                .finally(() => {
                    this.SET_LOADING(false);
                })
        },
        closeTree() {
            this.treeChildrenComponent = 0;
            this.treeSettingComponent = 0;
        },
        getTreeData() {
            this.SET_LOADING(true);
            axios.post(this.url, {action_type: 'page_initialized', main_data: "\"название страницы\""})
                .then((res) => {
                    this.dataRange = res.data.date_range_model;
                    this.treeData = res.data.finder_model.children;
                    this.fieldName = res.data.field_name;
                }).finally(() => {
                this.SET_LOADING(false);
            })
        },
        postTreeData(v) {
            const body = {
                action_type: 'calc_button_pressed',
                date_range_model: this.dataRange,
                fieldName: this.fieldName,
                finder_model: {
                    name: "root",
                    children: v
                }
            }
            this.SET_LOADING(true);
            axios.post(this.url, {
                action_type: 'calc_button_pressed', date_range_model: this.dataRange, fieldName: this.fieldName,
                finder_model: {
                    name: "root",
                    children: v
                }
            })
                .then((res) => {
                    if (res.status === 200) {
                        this.setNotify("Информация о скважинах получена", "Success", "success")
                    } else {
                        this.setNotify("Что-то пошло не так", "Error", "danger")
                    }
                })
                .finally(() => {
                    this.SET_LOADING(false);
                })
        },
        nodeClick(data) {
            this.$_setTreeChildrenComponent(data);
            this.treeSettingComponent = {
                name: 'gtm-tree-setting',
                data: function () {
                    return {
                        treeData: {
                            children: data.node.setting_model.children
                        },
                    }
                },
                template: '<div class="block-header text-center"><div>' + data.node.name + '</div><gtm-tree :treeData="treeData"></gtm-tree></div>',
            };
        },
        $_setTreeChildrenComponent(data) {
            let node = data.node;
            if (node.ioi_finder_model === undefined) {
                if (data.hideIoiMenu) {
                    this.treeChildrenComponent = null;
                    return;
                } else {
                    return;
                }
            }
            this.treeChildrenComponent = {
                name: 'gtm-tree-setting',
                data: function () {
                    return {
                        treeData: {
                            children: node.ioi_finder_model.children
                        },
                    }
                },
                template: '<div>' +
                    '       <div class="block-header text-center">' + data.node.name +
                    '</div><gtm-tree :treeData="treeData" @node-click="handleClick">' +
                    '</gtm-tree></div>',
                methods: {
                    handleClick(data) {
                        this.$emit('node-click', {node: data.node, hideIoiMenu: false});
                    },
                }
            };
        },
    },
    created() {
        this.getTreeData();
    },
}