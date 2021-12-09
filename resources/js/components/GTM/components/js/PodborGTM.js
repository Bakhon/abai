import {globalloadingMutations, paegtmMapActions, paegtmMapState} from "../../../../store/helpers";
import {
    createExcelBody,
    createTreeBody,
    downloadExcel,
    getTableWell,
    getTreeData,
    postTreeData
} from "../api/podborGTM";
import VueApexCharts from "vue-apexcharts";
import moment from "moment"
import fileDownload from "js-file-download";

export default {
    components: {
        apexchart: VueApexCharts,
    },

    data: function () {
        return {
            showBlock: 2,
            menuArrowUp: '/img/GTM/icon_menu_arrow_up.svg',
            menuArrowDown: '/img/GTM/icon_menu_arrow_down.svg',
            url: process.env.MIX_PODBOR_GTM_URL,
            isHidden: true,
            bswVal: [],
            liquidRate: [],
            oilRate: [],
            wellNumber: null,
            table: {
                header: null,
                data: null,
            },
            dataRangeInfo: {
                days: Number,
                is_days_group: Boolean
            },
            fieldName: null,
            mainData: null,
            serviceOffline: true,
            body: {
                action_type: 'page_initialized',
                main_data: "\"название страницы\""
            },
            treeData: [],
            waterFallChartOptions: {
                chart: {
                    height: 320,
                    type: 'rangeBar',
                    foreColor: '#ffffff',
                    background: '#20274f',
                    toolbar: {
                        show: true,
                        export: {
                            png: {
                                filename: ''
                            }
                        }
                    }
                },
                title: {
                    text: this.wellNumber,
                    align: 'center',

                    style: {
                        color: undefined,
                        fontSize: '15px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 700,
                        cssClass: 'apexcharts-yaxis-title',
                    },
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#808080'],
                    curve: 'smooth',
                },
                yaxis: [
                    {
                        title: {
                            text: `${this.trans('pgno.q_nefti')} ${this.trans('measurements.m3')}`, style: {
                                color: undefined,
                                fontSize: '15px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 700,
                                cssClass: 'apexcharts-yaxis-title',
                            },
                        }
                    },],
                plotOptions: {
                    bar: {
                        horizontal: false
                    }
                },
                dataLabels: {
                    enabled: true,
                    // formatter: v => v.toFixed()
                },
            },
            waterFallChartSeries: null,
            lineChartSeries: null,
            lineChartOptions: {
                chart: {
                    height: 350,
                    type: 'area',
                    foreColor: '#ffffff',
                    background: '#20274f',
                    toolbar: {
                        show: true
                    }
                },
                title: {
                    text: '',
                    align: 'center',
                    style: {
                        color: undefined,
                        fontSize: '15px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        fontWeight: 700,
                        cssClass: 'apexcharts-yaxis-title',
                    },
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
                stroke: {
                    curve: 'straight',
                    dashArray: [0, 0, 2]
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
                        seriesName: `${this.trans('pgno.q_nefti')} ${this.trans('measurements.m3/day')}`,
                        axisTicks: {show: true},
                        axisBorder: {show: true,},
                        title: {
                            text: `${this.trans('pgno.q_nefti')} ${this.trans('measurements.m3/day')}`, style: {
                                color: undefined,
                                fontSize: '15px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 700,
                                cssClass: 'apexcharts-yaxis-title',
                            },
                        },
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
            isMinimize: true,
            days: null,
            dzosForFilter: [],
            oilFieldsForFilter: [],
            horizontsForFilter: [],
            objectsForFilter: [],
            showShadow: false,
            activeItem: 0
        };
    },
    computed: {
        ...paegtmMapState([
            'clickable',
            'treeDate',
            'treeStore',
            'clickableTable'
        ]),
    },
    watch: {},
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        ...paegtmMapActions([
            'changeTreeDate',
            'onGetTableByClickableValue',
            'changeTreeStore'
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
        onClickWell(v, idx) {
            this.activeItem = idx
            this.wellNumber = v
            this.setNotify(`Выбрана скважина ${v}`, "Success", "success")
            let params = {action_type: 'well_name_clicked', main_data: v, distance: 500}
            let body = {url: this.url, body: params}
            this.SET_LOADING(true);
            getTableWell(body).then((res) => {
                this.lineChartOptions.xaxis.categories = Object.values(res.main_data.dt)
                this.lineChartSeries = [
                    {
                        name: res.main_data.labels.liquid_rate,
                        data: Object.values(res.main_data.liquid_rate),
                        showLine: false,
                        stroke: {
                            dashArray: 2
                        }
                    },
                    {
                        name: res.main_data.labels.oil_rate,
                        data: Object.values(res.main_data.oil_rate),
                        pointBorderColor: "#FFFFFF",
                    },
                    {
                        name: res.main_data.labels.bsw_val,
                        data: Object.values(res.main_data.bsw_val),
                        pointBorderColor: "#FFFFFF",
                    },
                ],
                    this.waterFallChartSeries = [{
                        data: [
                            {
                                x: res.fa_plot.labels.pbeg_oil_prod,
                                y: res.fa_plot.pbeg_oil_prod.values.map(a => parseFloat(a).toFixed(0)),
                                fillColor: res.fa_plot.pbeg_oil_prod.color,
                            }, {
                                x: res.fa_plot.labels.influenceWC,
                                y: res.fa_plot.influenceWC.values.map(a => parseFloat(a).toFixed(0)),
                                fillColor: res.fa_plot.influenceWC.color,
                            }, {
                                x: res.fa_plot.labels.influencePres,
                                y: res.fa_plot.influencePres.values.map(a => parseFloat(a).toFixed(0)),
                                fillColor: res.fa_plot.influencePres.color,
                            }, {
                                x: res.fa_plot.labels.influenceLiquidPI,
                                y: res.fa_plot.influenceLiquidPI.values.map(a => parseFloat(a).toFixed(0)),
                                fillColor: res.fa_plot.influenceLiquidPI.color,
                            }, {
                                x: res.fa_plot.labels.influenceBHP,
                                y: res.fa_plot.influenceBHP.values.map(a => parseFloat(a).toFixed(0)),
                                fillColor: res.fa_plot.influenceBHP.color,
                            }, {
                                x: res.fa_plot.labels.influenceWorkDay,
                                y: res.fa_plot.influenceWorkDay.values.map(a => parseFloat(a).toFixed(0)),
                                fillColor: res.fa_plot.influenceWorkDay.color,
                            }, {
                                x: res.fa_plot.labels.pend_oil_prod,
                                y: res.fa_plot.pend_oil_prod.values.map(a => parseFloat(a).toFixed(0)),
                                fillColor: res.fa_plot.pend_oil_prod.color,
                            }
                        ]
                    }]
            }).finally(() => {
                this.SET_LOADING(false);
                this.$refs.lineChartOptionsRef.updateOptions({title: {text: v}})})
        },
        closeTree() {
            this.treeChildrenComponent = 0;
            this.treeSettingComponent = 0;
            this.showShadow = false
        },
        onHoverTree() {
          this.showShadow = true
        },
        async onGetTreeData() {
            let body = { url: this.url, body: this.body }
            this.SET_LOADING(true);
            await getTreeData(body).then((res) => {
                this.dataRangeInfo = res.date_range_model;
                this.changeTreeStore(res.finder_model.children)
                this.fieldName = res.org_struct;
            }).finally(() => {
                this.SET_LOADING(false);
            })
            this.changeTreeDate(this.dataRangeInfo);
        },
        async onDownloadExcel() {
            let bodyExcel = createExcelBody("table_export_clicked", this.clickable)
            let filename = this.clickable + ".xlsx"
            let body = {url: this.url, body: bodyExcel, responseType: 'blob'}
            await downloadExcel(body).then((response) => {
                fileDownload(response.data, filename);
            })
        },
        onChangeDays(e) {
            this.dataRangeInfo.days = e.target.value
        },
        onHideDays() {
            this.isHidden = !this.isHidden
        },
        async onPostTreeData(v) {
            this.changeTreeStore(v)
            this.dataRangeInfo = _.clone(this.treeDate)
            this.dataRangeInfo.begin_date = moment(this.treeDate.begin_date).format('YYYY-MM-DD').toString()
            this.dataRangeInfo.end_date = moment(this.treeDate.end_date).format('YYYY-MM-DD').toString()
            this.changeTreeDate(this.dataRangeInfo);
            const bodyTree = createTreeBody('calc_button_pressed',this.dataRangeInfo, this.fieldName, {name: 'root', children: v})
            let body = {url: this.url, body: bodyTree}
            this.SET_LOADING(true);
            await postTreeData(body).then((res) => {
            }).finally(() => {
                this.SET_LOADING(false);
            })
        },
        nodeClick(data) {
            this.$_setTreeChildrenComponent(data);
            this.showShadow = true
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
    mounted() {
        this.onGetTreeData();
    },
}