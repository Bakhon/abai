<template>
    <div>
        <div class="row mx-0 mt-lg-2 gtm">
            <div class="gtm-dark col-lg-10 p-0">
                <div class="row col-12 p-0 m-0">
                    <div class="col-6 d-none d-lg-block p-0 pl-1">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                {{ trans('paegtm.accumulatedOilProdTitle') }}
                            </div>
                            <div class="p-1 pl-2 mh-370">
                                <gtm-line-chart
                                    v-if="loaded"
                                    :chartdata="{labels: accumOilProdLabels, datasets: accumOilProdData}"
                                    :options="lineChartOptions"
                                    :height="360">
                                </gtm-line-chart>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                {{ trans('paegtm.comparisonIndicatorsTitle') }}
                            </div>
                            <div class="p-1 pl-2 h-75">
                                <table class="table text-center text-white podbor-middle-table h-100">
                                    <thead>
                                    <tr>
                                        <th class="align-middle" rowspan="2">{{ trans('paegtm.gtmType') }}</th>
                                        <th class="align-middle" rowspan="2">{{ trans('paegtm.countTh') }}</th>
                                        <th colspan="2">{{ trans('paegtm.avgDebitTh') }}</th>
                                        <th colspan="2">{{ trans('paegtm.additionalMiningTh') }}</th>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
                                        <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
                                        <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
                                        <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="comparisonIndicatorsItem in comparisonIndicators">
                                        <td v-for="value in comparisonIndicatorsItem" class="align-middle">{{ value }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-12 p-0 m-0">
                    <div class="col-6 d-none d-lg-block p-0 pl-1">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2">
                                {{ trans('paegtm.profitabilityIndexTitle') }}
                            </div>
                            <div class="p-1 pl-2">
                                <bar-chart :height="360"></bar-chart>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0">
                        <div class="h-100 pb-2">
                            <div class="block-header pb-0 pl-2">
                                {{ trans('paegtm.plannedGrowthReasonsTitle') }}
                            </div>
                            <div class="p-1 pl-2">
                                <doughnut-chart :height="180"></doughnut-chart>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 p-0 pl-2 pr-1">
                <div class="gtm-dark">
                    <div class="block-header text-center p-2">
                        НДО
                    </div>
                    <div class="gtm-dark table-responsive table-scroll m-0">
                        <table class="table table-striped table-borderless text-center text-white near-wells-big">
                            <tbody>
                            <tr class="near-wells-table-item" v-for="ndoItem in ndo">
                                <td v-for="item in ndoItem">{{ item }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-2 row m-0">
                    <div class="col-5 p-0">
                        <div class="calendar-filter-block d-flex align-items-center">
                            01.08.2018
                            <img class="calendar-icon" src="/img/GTM/calendar_icon.svg">
                        </div>
                    </div>
                    <div class="col-5 p-0">
                        <div class="ml-1 calendar-filter-block d-flex align-items-center">
                            01.08.2018
                            <img class="calendar-icon" src="/img/GTM/calendar_icon.svg">
                        </div>
                    </div>
                    <div class="col-1 p-0">
                        <div class="ml-1 calendar-filter-block d-flex align-items-center">
                            <img class="gear-icon m-auto" src="/img/GTM/gear.svg">
                        </div>
                    </div>
                </div>
                <div class="gtm-dark mt-2">
                    <div class="block-header text-center p-2">
                        Вид ГТМ
                    </div>
                    <div class="gtm-dark text-white pl-2">
                        1) Все ГТМ <br />
                        2) ВНС <br />
                        3) ГРП <br />
                        4) ПВЛГ <br />
                        5) ПВР <br />
                        6) РИР <br />
                    </div>
                </div>
                <div class="gtm-dark mt-2 row m-0">
                    <div class="col-1 text-right mt-1 mb-1 p-0">
                        <img src="/img/GTM/lens.svg">
                    </div>
                    <div class="col-11 m-0 mt-1 mb-1 row p-0">
                        <input class="search-input w-75" type="text" placeholder="Поиск по скважине">
                        <button class="search-button pl-2 pr-2">Поиск</button>
                    </div>
                    <div class="gtm-dark text-white pl-2" style="min-height: 156px;">
                        Все скважины
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueChartJs from 'vue-chartjs'
Vue.component('bar-chart', {
    extends: VueChartJs.Bar,
    mounted () {
        this.renderChart({
            labels: [
                'Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_4937',
                'Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_4937',
                'Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_4937',
                'Jet_2596', 'Jet_3303', 'Jet_4937', 'Jet_3303', 'Jet_4937', 'Jet_3303'
            ],
            datasets: [
                {
                    label: this.trans('paegtm.fact'),
                    borderColor: "#F27E31",
                    backgroundColor: '#F27E31',
                    data: [
                        4.5, 18, 32.3, 45, 58.9, 67, 75.8, 90, 105.6, 117.5, 125.2, 136,
                        4.5, 18, 32.3, 45, 58.9, 67, 75.8, 90, 105.6, 117.5, 125.2, 136,
                        4.5, 18, 32.3, 45, 58.9, 67, 75.8, 90, 105.6, 117.5, 125.2, 136
                    ],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: this.trans('paegtm.plan') ,
                    borderColor: "#82BAFF",
                    backgroundColor: '#82BAFF',
                    data: [
                        28.1, 32, 46.2, 60, 74.7, 75, 91, 98, 107.8, 131, 134.4, 138,
                        28.1, 32, 46.2, 60, 74.7, 75, 91, 98, 107.8, 131, 134.4, 138,
                        28.1, 32, 46.2, 60, 74.7, 75, 91, 98, 107.8, 131, 134.4, 138
                    ],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                }
            ],
        },
        {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        color: '#3C4270',
                    },
                    ticks: {
                        fontColor: '#FFFFFF',
                    },
                }],
                xAxes: [{
                    gridLines: {
                        display: false,
                    },
                    ticks: {
                        fontColor: '#FFFFFF',
                        maxRotation: 90,
                        minRotation: 90,
                    },
                }],
            }
        })
    }
});
Vue.component('doughnut-chart', {
    extends: VueChartJs.Doughnut,
    mounted () {
        this.renderChart({
            labels: [
                'Обводненность',
                'Выработка запасов',
                'Низкое РПЛ',
                'Технологическая',
                'Ухудшение ФЕС',
                'ГНО',
                'Выход на режим'
            ],
            datasets: [
                {
                    hoverBackgroundColor: '#ccc',
                    borderColor: '#272953',
                    borderWidth: 2,
                    data: [35, 55, 17, 16, 12, 15, 5],
                    backgroundColor: ["#EF5350", "#4CAF50", "#F0AD81", "#2196F3", "#F27E31", "#3F51B5", "#3951CE"],
                }
            ],
        }, {
            cutoutPercentage: 80,
            legend: {
                display: true,
                position: 'left',
                labels: {
                    fontColor: '#FFF',
                    fontSize: 14,
                    fontFamily: 'Harmonia-sans',
                    fontStyle: '700',
                },
            },
            onClick: function (event, legendItem) {
                let legendItemIndex = legendItem[0]['_index'];
            }
        })
    }
});
export default {
    data: function () {
        return {
            ndo: [
                ['ОМГ', '', ''],
                ['ЭМГ', 'Жетыбай', 'Ю-2+3'],
                ['', '', 'Ю-4'],
                ['', '', 'Ю-5'],
                ['', '', 'Ю-6'],
                ['', '', ''],
                ['', '', ''],
                ['', 'Аскар', ''],
                ['', 'Каламкас', ''],
            ],
            comparisonIndicators: [],
            accumOilProdLabels: [],
            accumOilProdData: [],
            accumOilProdNewData: {
                accumOilProdFactData: [],
                accumOilProdPlanData: [],
            },
            lineChartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        fontSize: 14,
                        fontColor: '#FFF',
                    },
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            color: '#3C4270',
                        },
                        ticks: {
                            fontColor: '#FFF',
                            fontSize: 10,
                        },
                    }],
                    xAxes: [{
                        gridLines: {
                            fontColor: '#3C4270',
                        },
                        ticks: {
                            fontColor: '#FFF',
                            fontSize: 10,
                        },
                    }],
                }
            },
            loaded: false,
        };
    },
    watch: {
        accumOilProdNewData (newData) {
            this.accumOilProdData = [
                {
                    label: this.trans('paegtm.fact'),
                    borderColor: "#F27E31",
                    backgroundColor: '#F27E31',
                    data: newData.accumOilProdFactData,
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: this.trans('paegtm.plan'),
                    borderColor: "#82BAFF",
                    backgroundColor: '#82BAFF',
                    data: newData.accumOilProdPlanData,
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                }
            ]
        }
    },
    created() {
        this.$store.commit('globalloading/SET_LOADING',true);
    },
    async mounted () {
        this.axios.get(this.localeUrl('/paegtm') + '/accum_oil_prod_data').then((response) => {
            let data = response.data;
            if (data) {
                let accumOilProdFactData = [];
                let accumOilProdPlanData = [];
                this.accumOilProdLabels = [];
                this.accumOilProdNewData = {};
                data.forEach((item) => {
                    this.accumOilProdLabels.push(item.date)
                    accumOilProdFactData.push(Math.round(item.accumOilProdFactData))
                    accumOilProdPlanData.push(Math.round(item.accumOilProdPlanData))
                });
                this.accumOilProdNewData.accumOilProdFactData = accumOilProdFactData;
                this.accumOilProdNewData.accumOilProdPlanData = accumOilProdPlanData;
            }
            this.loaded = true
        });
        this.axios.get(this.localeUrl('/paegtm') + '/comparison_indicators_data').then((response) => {
            let data = response.data;
            if (data) {
                this.comparisonIndicators = [];
                data.forEach((item) => {
                    this.comparisonIndicators.push([
                        item.gtm_kind,
                        item.wellsCount,
                        Math.round(item.avgDebitPlan * 100) / 100,
                        Math.round(item.avgDebitFact * 100) / 100,
                        Math.round(item.plan_add_prod_12m),
                        Math.round(item.add_prod_12m),
                    ])
                });
            }
            this.$store.commit('globalloading/SET_LOADING',false);
            this.loaded = true
        });
    }
}
</script>