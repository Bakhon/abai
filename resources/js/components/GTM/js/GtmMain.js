import Vue from "vue";
import {paegtmMapActions, paegtmMapGetters, globalloadingMutations} from '@store/helpers';
import VueApexCharts from "vue-apexcharts";
import _ from 'lodash';

Vue.component("gtm-modal", {
    template: "#modal-template"
});

export default {
    components: {
        "apexchart": VueApexCharts
    },
    data: function () {
        return {
            mainIndicatorData: [],
            additionalIndicatorData: [],
            mainTableData: [],
            comparisonIndicators: [],
            chartData: [],
            chartOptions2: [],
            series1: [
                {
                    name: this.trans('paegtm.planEd'),
                    type: 'column',
                    data: [1, 2, 6, 11, 19, 27, 35, 40, 49, 57, 65, 74],
                },
                {
                    name: this.trans('paegtm.factEd'),
                    type: 'column',
                    data: [2, 3, 7, 16, 18, 29, 38, 43, 53, 53, 72, 89],
                },
                {
                    name: this.trans('paegtm.planOil'),
                    type: 'line',
                    data: [20, 30, 40, 55, 67, 75, 87, 98, 110, 120, 145, 155],
                },
                {
                    name: this.trans('paegtm.factOil'),
                    type: 'line',
                    data: [10, 25, 35, 47, 53, 62, 77, 81, 92, 103, 120, 130]
                }
            ],
            series2: [
                {
                    name: this.trans('paegtm.planEd'),
                    type: 'column',
                    data: [1, 4, 7, 13, 23, 30, 33, 39, 47, 56, 64, 77],
                },
                {
                    name: this.trans('paegtm.factEd'),
                    type: 'column',
                    data: [3, 5, 8, 14, 17, 24, 33, 47, 52, 65, 69, 76],
                },
                {
                    name: this.trans('paegtm.planOil'),
                    type: 'line',
                    data: [19, 27, 39, 52, 63, 77, 84, 96, 107, 117, 129, 141],
                },
                {
                    name: this.trans('paegtm.factOil'),
                    type: 'line',
                    data: [14, 23, 37, 43, 57, 61, 75, 86, 97, 107, 118, 133]
                }
            ],
            chartOptions: {
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
                    row: {
                        colors: undefined,
                        opacity: 3
                    },
                    column: {
                        colors: undefined,
                        opacity: 3
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0
                    },
                },
                colors: ['#2e50e996', '#9ea4c9b3', '#2e50e9', '#9ea4c9'],
                chart: {
                    background: '#272953',
                    type: 'line',
                    foreColor: '#fff',
                    width: '10%',
                },
                stroke: {
                    width: 3
                },
                title: {
                    text: this.trans('paegtm.dynamicEnterOil'),
                    align: 'center',
                    style: {
                        fontSize: '14px',
                        fontWeight: 'bolder',
                        offsetY: 10
                    },
                },
                markers: {
                    size: 4,
                    colors: undefined,
                    strokeWidth: 0
                },
                dataLabels: {
                    enabled: true,
                    enabledOnSeries: [0, 1],
                    background: {
                        enabled: true,
                        foreColor: '#fff',
                        opacity: 0,
                        padding: 0,
                        dropShadow: {
                            enabled: false,
                        }
                    },
                    style: {
                        fontSize: '11px',
                        fontWeight: 'bold'
                    }
                },
                labels: [
                    this.trans('paegtm.Jan'),
                    this.trans('paegtm.Feb'),
                    this.trans('paegtm.Mar'),
                    this.trans('paegtm.Apr'),
                    this.trans('paegtm.May'),
                    this.trans('paegtm.Jun'),
                    this.trans('paegtm.Jul'),
                    this.trans('paegtm.Aug'),
                    this.trans('paegtm.Sep'),
                    this.trans('paegtm.Oct'),
                    this.trans('paegtm.Nov'),
                    this.trans('paegtm.Dec')
                ],
            },
            isModalHide: true,
            showMainMap: false,
        };
    },
    methods: {
        ...paegtmMapActions([
            'changeDateStart',
            'changeDateEnd',
            'changeDzoId',
            'changeDzoName',
        ]),
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        showModal(modalName) {
            this.$modal.show(modalName);
        },
        closeModal(modalName) {
            this.$modal.hide(modalName)
        },
        getGtmInfo() {
            this.axios.get(
                this.localeUrl('/paegtm/get-gtms'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    this.comparisonIndicators = data
                }
            });
        },
        getMainTableData() {
            this.axios.get(
                this.localeUrl('/paegtm/get-main-table-data'),
                {params: {selectedDdzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    this.mainTableData = JSON.parse(JSON.stringify(data));
                }
            });

        },
        getMainIndicatorData() {
            this.axios.get(
                this.localeUrl('/paegtm/get-main-indicator-data'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    this.mainIndicatorData = data
                }
            });
        },
        getAdditionalIndicatorData() {
            this.axios.get(
                this.localeUrl('/paegtm/get-additional-indicator-data'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    this.additionalIndicatorData = data
                }
            });
        },
        getChartData() {
            this.axios.get(
                this.localeUrl('/paegtm/get-chart-data'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    this.chartData = data
                }
            }).finally(() => this.SET_LOADING(false));
        },
        getData() {
            this.SET_LOADING(true);
            this.getMainIndicatorData();
            this.getAdditionalIndicatorData();
            this.getGtmInfo();
            this.getMainTableData();
            this.getChartData();
        },
        selectDzo(dzo) {
            let data = JSON.parse(JSON.stringify(this.mainTableData));

            Object.entries(data).forEach(([key, dzoItem]) => {
                if (dzoItem.org_name_short == dzo.org_name_short) {
                    dzo.selected = !dzo.selected
                } else {
                    dzo.selected = false;
                }
            });

            let selectedDzoName = null;

            if (dzo.org_name_short != this.dzoName) {
                selectedDzoName = dzo.org_name_short;
            }

            this.changeDzoName(selectedDzoName);
            this.getData();
        },
        changeChartOptions() {
            this.chartOptions2 = _.cloneDeep(this.chartOptions);
            this.chartOptions2.title.text = this.trans('paegtm.dynamicChartOil')
        }

    },
    computed: {
        ...paegtmMapGetters([
            'dateStart',
            'dateEnd',
            'dzoId',
            'dzoName',
        ]),
        mainBlockButtonText: function () {
            return this.showMainMap ? this.trans('paegtm.table') : this.trans('paegtm.map')
        },
        mainBlockButtonIcon: function () {
            return this.showMainMap ? '/img/GTM/icon_main_table_button.svg' : '/img/GTM/icon_main_map_button.svg'
        },
    },
    beforeCreate() {

    },
    created() {
        this.SET_LOADING(false);
        this.changeChartOptions()
    },
    mounted() {
        this.getData();
    }
}