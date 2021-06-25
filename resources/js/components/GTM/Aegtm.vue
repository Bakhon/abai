<template>
    <div>
        <div class="row mx-0 mt-lg-2 gtm">
            <div class="gtm-dark col-lg-10 p-0">
                <div class="row col-12 p-0 m-0 mb-4">
                    <div class="col-6 d-none d-lg-block p-0 pl-1">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2 pt-2 pb-2">
                                {{ trans('paegtm.accumulatedOilProdTitle') }}
                            </div>
                            <div class="p-1 pl-2 mh-370">
                                <gtm-line-chart
                                    v-if="loaded"
                                    :chartdata="{labels: accumOilProdLabels, datasets: accumOilProdData}"
                                    :options="lineChartOptions"
                                    :height="360"
                                >
                                </gtm-line-chart>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2 pt-2 pb-2">
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
                    <div class="col-6 d-none d-lg-block p-2 pl-1">
                        <div class="block-header pb-2">
                            {{ trans('paegtm.profitabilityIndexTitle') }}
                        </div>
                        <div class="chart-wrapper p-3 min-h-420">
                            <bar-chart :height="360"></bar-chart>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-2">
                        <div class="block-header pb-0 pl-2 pb-2">
                            {{ trans('paegtm.successfulWellsProportionTitle') }}
                        </div>
                        <div class="chart-wrapper p-3 min-h-420">
                            <doughnut-chart :height="180"></doughnut-chart>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 p-0 pl-2 pr-1">
                <div class="gtm-dark gtm-filter p-2">
                    <v-select
                        :options="dzosForFilter"
                        label="name"
                        :placeholder="this.trans('paegtm.select_dzo')"
                    >
                    </v-select>
                    <v-select
                        :options="oilFieldsForFilter"
                        label="name"
                        :placeholder="this.trans('paegtm.select_oil_field')"
                    >
                    </v-select>

                    <v-select
                        :options="objectsForFilter"
                        label="name"
                        :placeholder="this.trans('paegtm.select_object')"
                    >
                    </v-select>

                    <v-select
                        :options="structuresForFilter"
                        label="name"
                        :placeholder="this.trans('paegtm.select_structure')"
                    >
                    </v-select>

                    <v-select
                        :options="gusForFilter"
                        label="name"
                        :placeholder="this.trans('paegtm.select_gu')"
                    >
                    </v-select>

                </div>
                <div class="mt-2">
                    <gtm-date-picker @dateChanged="getData"></gtm-date-picker>
                </div>
                <div class="gtm-dark mt-2">
                    <div class="block-header text-center p-2">
                        {{ trans('paegtm.gtmType') }}
                    </div>
                    <div class="gtm-dark text-white pl-2">
                        {{ trans('paegtm.all_gtm') }}<br>
                        {{ trans('paegtm.gtm_vns') }}<br>
                        {{ trans('paegtm.gtm_grp') }}<br>
                        {{ trans('paegtm.gtm_pvlg') }}<br>
                        {{ trans('paegtm.gtm_pvr') }}<br>
                        {{ trans('paegtm.gtm_rir') }}<br>
                    </div>
                </div>
                <div class="gtm-dark mt-2 row m-0">
                    <div class="col-1 text-right mt-1 mb-1 p-0">
                        <img src="/img/GTM/lens.svg">
                    </div>
                    <div class="col-11 m-0 mt-1 mb-1 row p-0">
                        <input class="search-input w-75" type="text" :placeholder="this.trans('paegtm.search_by_well')">
                        <button class="search-button pl-2 pr-2">{{ trans('paegtm.search') }}</button>
                    </div>
                    <div class="gtm-dark text-white pl-2" style="min-height: 156px;">
                        {{ trans('paegtm.all_wells') }}
                    </div>
                </div>
                <div class="gtm-dark mt-2 row m-0 mb-2">
                    <div class="gtm-indicator-item flex-fill d-inline-block p-2">
                        <div class="bigNumber">356 <span class="units">{{ trans('paegtm.successful_events_count') }}</span></div>
                        <div class="title">{{ trans('paegtm.gtm_and_vns_count') }}</div>
                        <div class="progress gtm-progress mb-0">
                            <div
                                class="progress-bar"
                                role="progressbar"
                                style="width: 89%"
                            >
                            </div>
                        </div>
                        <div class="d-flex justify-content-between m-0 mt-1">
                            <div class="d-inline-block m-0 text-white dr-fw-700">89,25%</div>
                            <div class="progressMax d-inline-block m-0">291 167</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {paegtmMapActions} from '@store/helpers';
import Vue from "vue";
import VueChartJs from 'vue-chartjs'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

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
        let that = this
        this.renderChart({
            labels: [
                this.trans('paegtm.successful'),
                this.trans('paegtm.unsuccessful')
            ],
            datasets: [
                {
                    hoverBackgroundColor: '#ccc',
                    borderColor: '#272953',
                    borderWidth: 2,
                    data: [27, 73],
                    backgroundColor: ["#4CAF50", "#EF5350"],
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

                that.$emit('menuClick', {
                    name: "child-component",
                    template: "<div><gtm-aegtm-unsuccessful-distribution></gtm-aegtm-unsuccessful-distribution></div>",
                    parentType: "aegtm"
                });
            }
        })
    }
});
export default {
    components: {
        vSelect
    },
    data: function () {
        return {
            comparisonIndicators: [],
            accumOilProdLabels: [],
            accumOilProdFactData: [],
            accumOilProdPlanData: [],
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
            loaded: false,
        };
    },
    computed: {
            accumOilProdData: function () {
                return [
                    {
                        label: this.trans('paegtm.fact'),
                        borderColor: "#F27E31",
                        backgroundColor: '#F27E31',
                        data: this.accumOilProdFactData,
                        fill: false,
                        showLine: true,
                        pointRadius: 4,
                        pointBorderColor: "#FFFFFF",
                    },
                    {
                        label: this.trans('paegtm.plan'),
                        borderColor: "#82BAFF",
                        backgroundColor: '#82BAFF',
                        data: this.accumOilProdPlanData,
                        fill: false,
                        showLine: true,
                        pointRadius: 4,
                        pointBorderColor: "#FFFFFF",
                    }
                ]
            }
    },
    methods: {
        getData() {
            this.$store.commit('globalloading/SET_LOADING',true);
            this.axios.get(
                this.localeUrl('/paegtm/accum_oil_prod_data'),
                {params: {dateStart: this.$store.state.dateStart, dateEnd: this.$store.state.dateEnd}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    let accumOilProdFactData = [];
                    let accumOilProdPlanData = [];
                    this.accumOilProdLabels = [];
                    data.forEach((item) => {
                        this.accumOilProdLabels.push(item.date)
                        accumOilProdFactData.push(Math.round(item.accumOilProdFactData))
                        accumOilProdPlanData.push(Math.round(item.accumOilProdPlanData))
                    });
                    this.accumOilProdFactData = accumOilProdFactData;
                    this.accumOilProdPlanData = accumOilProdPlanData;
                }
                this.loaded = true;
            });
            this.axios.get(
                this.localeUrl('/paegtm/comparison_indicators_data'),
                {params: {dateStart: this.$store.state.dateStart, dateEnd: this.$store.state.dateEnd}}
            ).then((response) => {
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
            });
            this.$store.commit('globalloading/SET_LOADING',false);
        }
    },
    mounted() {
        this.getData();
    },
}
</script>