<template>
    <div>
        <div class="row m-0 pl-1 pt-1">
            <div class="gtm-dark col-lg-10 p-2 mb-2">

                <div class="block-header block-header pt-1 pb-3">
                    {{ trans('paegtm.distribution_of_unsuccessful_gtm_title') }}
                </div>

                <table class="table table-striped text-center text-white distribution-table mb-2">
                    <thead>
                    <tr>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.dzo') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.workshop') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.oil_field') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.borehole_number') }}</th>
                        <th class="align-middle" colspan="7">{{ trans('paegtm.planned_technological_regime') }}</th>
                        <th class="align-middle" colspan="7">{{ trans('paegtm.parameters_after_gtm') }}</th>
                        <th class="align-middle" colspan="8">{{ trans('paegtm.deviation_of_qн') }}</th>
                    </tr>
                    <tr>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.qh_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.qliq_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.water_cut_percent') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.p_zab_atm') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.p_plast_atm') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.jd_unit') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.kh') }}</th>

                        <th class="align-middle" rowspan="2">{{ trans('paegtm.qh_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.qliq_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.water_cut_percent') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.p_zab_atm') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.p_plast_atm') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.jd_unit') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.kh') }}</th>

                        <th class="align-middle" rowspan="2">&#916;{{ trans('paegtm.delta_qh_day') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.by_water_cut_short') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.water_cut_reason') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.q_liq_common') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.q_liq_p_plast') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.q_liq_p_zab') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.q_liq_kh_mb') }}</th>
                        <th class="align-middle" rowspan="2">{{ trans('paegtm.q_liq_jd') }}</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="mainTableItem in mainTableData">
                        <td v-for="value in mainTableItem" class="align-middle">{{ value }}</td>
                    </tr>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-4 d-none d-lg-block pr-1">
                        <div class="chart-wrapper mb-2 p-3">
                            <div class="block-header pb-0 pl-2 text-center">
                                {{ trans('paegtm.distribution_of_unsuccessful_gtm') }}
                            </div>
                            <div class="p-1 pl-2">
                                <unsuccessfful-gtm-chart :height="280"></unsuccessfful-gtm-chart>
                            </div>
                        </div>
                    </div>

                    <div class="col-4 d-none d-lg-block pl-2 pr-2">
                        <div class="chart-wrapper mb-2 p-3">
                            <div class="block-header pb-0 pl-2 text-center">
                                {{ trans('paegtm.liquid_failure') }}
                            </div>
                            <div class="p-1 pl-2">
                                <fluid-shortfalls-chart :height="280"></fluid-shortfalls-chart>
                            </div>
                        </div>
                    </div>

                    <div class="col-4 d-none d-lg-block pl-1">
                        <div class="chart-wrapper mb-2 p-3">
                            <div class="block-header pb-0 pl-2 text-center">
                                {{ trans('paegtm.failure_water_cut_achieve') }}
                            </div>
                            <div class="p-1 pl-2">
                                <water-cut-failures-chart :height="280"></water-cut-failures-chart>
                            </div>
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
                        @input="dzoFilterChanged"
                        v-model="dzo"
                    >
                    </v-select>
                    <v-select
                        :options="oilFieldsForFilter"
                        label="name"
                        :placeholder="this.trans('paegtm.select_oil_field')"
                        @input="oilFilterChanghed"
                        v-model="oilFileds"
                        :disabled="!oilFieldsForFilter.length"
                    >
                    </v-select>

                    <v-select
                        :options="horizontsForFilter"
                        label="name"
                        :placeholder="'Выберите горизонт'"
                        @input="horizontsFilterChanghed"
                        v-model="horizonts"
                        :disabled="!horizontsForFilter.length"
                    >
                    </v-select>

                    <v-select
                        :options="objectsForFilter"
                        label="name"
                        :placeholder="this.trans('paegtm.select_object')"
                        @input="objectsFilterChanghed"
                        v-model="objects"
                        :disabled="!objectsForFilter.length"
                    >
                    </v-select>
                </div>
                <div class="mt-2">
                    <gtm-date-picker></gtm-date-picker>
                </div>
                <div class="gtm-dark mt-2">
                    <div class="block-header text-center p-2">
                        {{ trans('paegtm.gtmType') }}
                    </div>
                    <div class="gtm-dark text-white pl-2">
                        <b-form-checkbox
                            v-model="gtmTypes"
                            value="all"
                        >
                            {{ trans('paegtm.all_gtm') }}
                        </b-form-checkbox>

                        <b-form-checkbox
                            v-model="gtmTypes"
                            value="vns"
                        >
                            {{ trans('paegtm.gtm_vns') }}
                        </b-form-checkbox>

                        <b-form-checkbox
                            v-model="gtmTypes"
                            value="grp"
                        >
                            {{ trans('paegtm.gtm_grp') }}
                        </b-form-checkbox>

                        <b-form-checkbox
                            v-model="gtmTypes"
                            value="pvlg"
                        >
                            {{ trans('paegtm.gtm_pvlg') }}
                        </b-form-checkbox>

                        <b-form-checkbox
                            v-model="gtmTypes"
                            value="pvr"
                        >
                            {{ trans('paegtm.gtm_pvr') }}
                        </b-form-checkbox>

                        <b-form-checkbox
                            v-model="gtmTypes"
                            value="gtm_"
                        >
                            {{ trans('paegtm.gtm_rir') }}
                        </b-form-checkbox>
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
import Vue from "vue";
import VueChartJs from 'vue-chartjs'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'
import unsuccessfulDistributionMmg from '../mock-data/unsuccessful_distribution_mmg.json'
import orgStructure from '../mock-data/org_structure.json'

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
            mainTableData: unsuccessfulDistributionMmg,

            dzos: orgStructure,
            loaded: false,

            dzo: null,
            oilFileds: [],
            horizonts: [],
            objects: [],
            gtmTypes : [],

            dzosForFilter: [],
            oilFieldsForFilter: [],
            horizontsForFilter: [],
            objectsForFilter: [],
        };
    },
    computed: {

    },
    methods: {
        dzoFilterChanged(dzo) {
            this.oilFieldsForFilter = (dzo.hasOwnProperty('oilFields') && dzo.oilFields.length) ? dzo.oilFields : [];

            //reset selections
            this.oilFileds = 0;
            this.horizonts = 0;
            this.objects = 0;
        },
        oilFilterChanghed(oilFiled) {
            this.horizontsForFilter = (oilFiled.hasOwnProperty('horizonts') && oilFiled.horizonts.length) ? oilFiled.horizonts : [];

            //reset selections
            this.horizonts = 0;
            this.objects = 0;
        },
        horizontsFilterChanghed(horizont) {
            this.objectsForFilter = (horizont.hasOwnProperty('objects') && horizont.objects.length) ? horizont.objects : [];

            //reset selections
            this.objects = 0;
        },
        objectsFilterChanghed(object) {

        },
    },
    mounted() {
        this.dzosForFilter = this.dzos;
    },
}

Vue.component('unsuccessfful-gtm-chart', {
    extends: VueChartJs.Doughnut,
    mounted () {
        this.renderChart({
            labels: [
                this.trans('paegtm.by_liquid'),
                this.trans('paegtm.by_water_cut'),
            ],
            datasets: [
                {
                    hoverBackgroundColor: '#ccc',
                    borderColor: '#272953',
                    borderWidth: 2,
                    data: [45, 55],
                    backgroundColor: ["#2E50E9", "#82BAFF"],
                }
            ],
        }, {
            cutoutPercentage: 80,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#FFF',
                    fontSize: 14,
                    fontFamily: 'Harmonia-sans',
                    fontStyle: '700',
                    borderRadius: 100,
                    padding: 30,
                },
            }
        })
    }
});

Vue.component('fluid-shortfalls-chart', {
    extends: VueChartJs.Doughnut,
    mounted () {
        this.renderChart({
            labels: [
                this.trans('paegtm.rpl'),
                this.trans('paegtm.p_zab'),
                this.trans('paegtm.kh_mb'),
                this.trans('paegtm.s_kin'),
            ],
            datasets: [
                {
                    hoverBackgroundColor: '#ccc',
                    borderColor: '#272953',
                    borderWidth: 2,
                    data: [18, 0, 73,9],
                    backgroundColor: ["#3F51B5", "#fe5c5c", "#82BAFF", "#F0AD81"],
                }
            ],
        }, {
            cutoutPercentage: 80,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#FFF',
                    fontSize: 14,
                    fontFamily: 'Harmonia-sans',
                    fontStyle: '700',
                    borderRadius: 100,
                    padding: 30,
                },
            },
        })
    }
});

Vue.component('water-cut-failures-chart', {
    extends: VueChartJs.Doughnut,
    mounted () {
        this.renderChart({
            labels: [
                this.trans('paegtm.development_of_reserves'),
                this.trans('paegtm.influence_of_ppd'),
                this.trans('paegtm.neck'),
                this.trans('paegtm.zkts'),
            ],
            datasets: [
                {
                    hoverBackgroundColor: '#ccc',
                    borderColor: '#272953',
                    borderWidth: 2,
                    data: [36, 11, 27,26],
                    backgroundColor: ["#3F51B5", "#EF5350", "#82BAFF", "#F0AD81"],
                }
            ],
        }, {
            cutoutPercentage: 80,
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#FFF',
                    fontSize: 14,
                    fontFamily: 'Harmonia-sans',
                    fontStyle: '700',
                    borderRadius: 100,
                    padding: 30,
                },
            }
        })
    }
});
</script>