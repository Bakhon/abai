import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import {globalloadingMutations} from "../../../../store/helpers";
import VueApexCharts from "vue-apexcharts";
import tableGtm from '../../mock-data/response-data-export_item_click.json'
import myJson from '../../mock-data/my.json'
import _ from 'lodash'
import {paegtmMapState} from "@store/helpers";


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
            table: {
                main_data: {
                    header: null,
                    data: null,
                },

            },
            myTable: myJson,
            dataRange: null,
            fieldName: null,
            mainData: null,
            serviceOffline: true,
            body: {
                action_type: 'page_initialized',
                main_data: "\"название страницы\""
            },
            dzosForFilter: [
                { name: 'АО "Озенмунайгаз"', code: 'omg'},
                { name: 'АО "ЭмбаМунайГаз"',code: 'emba'},
                { name: 'АО "Мангистаумунайгаз"',code: 'mmg'},
                { name: 'АО "Каражанбасмунай"',code: 'krm'},
                { name: 'ТОО "СП "Казгермунай"',code: 'kazger'},
                { name: 'ТОО "Казтуркмунай"',code: 'ktm'},
                { name: 'ТОО "Казахойл Актобе"',code: 'koa'},
            ],
            oilFieldsForFilter: [
                { name: 'Акшабулак', code: 'oil_1'},
                { name: 'Актобе', code: 'oil_2'},
                { name: 'Алтыколь', code: 'oil_3'},
                { name: 'Жетыбай', code: 'oil_4'},
                { name: 'Жыланды', code: 'oil_5'},
                { name: 'Жыланды', code: 'oil_6'},
                { name: 'Каламкас', code: 'oil_7'},
                { name: 'Каражанбас', code: 'oil_8'},
            ],
            objectsForFilter: [{ name: 'Вариант 1'}],
            structuresForFilter: [{ name: 'Вариант 1'}],
            gusForFilter: [{ name: 'Вариант 1'}],
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
            lineLabels: ['Янв.', 'Фев.', 'Мар.', 'Апр.', 'Май', 'Июнь', 'Июль', 'Авг.', 'Сен.', 'Окт.', 'Ноя.', 'Дек.'],
            lineChartSeries: [
                {
                    name: 'Пласт',
                    borderColor: "rgba(242, 126, 49, 1)",
                    data: [1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500, 1500],
                    fill: false,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    name: 'Обводненность',
                    borderColor: "rgba(57, 81, 206, 1)",
                    data: [3200, 4700, 1950, 2800, 2400, 3300, 800, 1100, 3100, 4400, 1000, 2700],
                    fill: false,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    name: 'Qн (По МЭР), м3/сут',
                    borderColor: "rgba(239, 83, 80, 1)",
                    backgroundColor: 'rgba(239, 83, 80, 0.2)',
                    data: [500, 700, 900, 500, 1100, 1500, 1000, 560, 780, 1300, 2000, 1750],
                    fill: true,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    name: 'Qж (По МЭР), м3/сут',
                    borderColor: "rgba(76, 175, 80, 1)",
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    data: [2800, 4700, 2400, 1000, 2400, 200, 2800, 3400, 2450, 2000, 1000, 800],
                    fill: true,
                    showLine: true,
                    pointRadius: 0,
                    pointBorderColor: "#FFFFFF",
                }
            ],
            lineChartOptions: {
                chart: {
                    height: 350,
                    type: 'area',
                    foreColor: '#fff'
                },
                dataLabels: {
                    enabled: false
                },
                grid: {
                    show: true,
                    borderColor: '#454d7d',
                    strokeDashArray: 0,
                    position: 'back',
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },
                    yaxis: {
                        lines: {
                            show: true
                        }
                    },
                },
            },
            treeSettingHeader: '',
            treeSettingBody: '',
            treeSettingComponent: null,
            treeChildrenComponent: null,
        };
    },
    computed: {
        ...paegtmMapState([
            'clickable',
        ]),
    },
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
        onClickableValue() {
            const body = {
                action_type: 'finder_item_clicked',
                main_data: this.clickable,
            }
            this.axios({
                method: 'POST',
                headers: { 'content-type': 'application/json' },
                data: body,
                url: 'http://172.20.103.51:7577/api/gtmfinder'
            })
                .then((res) => {
                    this.table.main_data.header = res.data.main_data.header
                    this.table.main_data.data = res.data.main_data.data
                    if(res.status === 200) {
                        this.setNotify("Таблица пришла", "Success", "success")
                    } else {
                        this.setNotify("Что-то пошло не так", "Error", "danger")
                    }
                })
                .finally(() => {
                    this.SET_LOADING(false);
                })
        },
        onClickWell(v) {
            //TODO 'get well data which one is clicked'
            this.setNotify(`Вы нажали на скважину ${v}`, "Success", "success")
        },
        closeTree() {
            this.treeChildrenComponent = 0;
            this.treeSettingComponent = 0;
        },
        getTreeData() {
            this.axios({
                method: 'POST',
                headers: { 'content-type': 'application/json' },
                data: this.body,
                url: 'http://172.20.103.51:7577/api/gtmfinder'
            })
                .then((res) => {
                    this.dataRange = res.data.date_range_model;
                    this.treeData = res.data.finder_model.children;
                    this.fieldName = res.data.field_name;
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
            this.axios({
                method: 'POST',
                headers: { 'content-type': 'application/json' },
                data: body,
                url: 'http://172.20.103.51:7577/api/gtmfinder'
            })
                .then((res) => {
                    if(res.status === 200) {
                        this.setNotify("Скважины пришли", "Success", "success")
                    } else {
                        this.setNotify("Что-то пошло не так", "Error", "danger")
                    }
                })
                .finally(() => {
                    this.SET_LOADING(false);
                })
        },
        nodeClick (data) {
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
                template: '<div class="block-header text-center"><div>'+ data.node.name + '</div><gtm-tree :treeData="treeData"></gtm-tree></div>',
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
                    '       <div class="block-header text-center">'+ data.node.name +
                    '</div><gtm-tree :treeData="treeData" @node-click="handleClick">' +
                    '</gtm-tree></div>',
                methods: {
                    handleClick (data) {
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