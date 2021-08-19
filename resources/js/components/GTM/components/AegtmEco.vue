<template>
    <div>
        <div class="row mx-0 mt-lg-2 gtm pt-1">
            <div class="gtm-dark col-lg-10 p-0">
                <div class="row col-12 p-0 m-0">
                    <div class="col-6 d-none d-lg-block p-0 pl-1">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2">
                                {{ trans('paegtm.revenues_from_additional_oil_production') }}
                            </div>
                            <div class="p-1 pl-2">
                                <gtm-bar-chart :chartdata="{labels: barLabels, datasets: firstBarData}" :options="barOptions" :height="350"></gtm-bar-chart>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                {{ trans('paegtm.free_cash_flows') }}
                            </div>
                            <div class="p-1 pl-2">
                                <gtm-bar-chart :chartdata="{labels: barLabels, datasets: secondBarData}" :options="barOptions" :height="350"></gtm-bar-chart>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-12 p-0 m-0">
                    <div class="col-6 d-none d-lg-block p-0 pl-1">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2">
                                {{ trans('paegtm.expenses_for_gtm') }}
                            </div>
                            <div class="p-1 pl-2">
                                <gtm-bar-chart :chartdata="{labels: barLabels, datasets: thirdBarData}" :options="barOptions" :height="350"></gtm-bar-chart>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                {{ trans('paegtm.well_drilling_fro_9_months') }}
                            </div>
                            <div class="p-1 pl-2 mh-370">
                                <line-chart :height="350"></line-chart>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 p-0 pl-2 pr-1">
                <div class="gtm-dark gtm-filter p-2 mb-2">
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
                <gtm-date-picker @dateChanged="getData"></gtm-date-picker>
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
                    <div class="gtm-dark text-white pl-2" style="min-height: 140px;">
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
import vSelect from "vue-select";
import 'vue-select/dist/vue-select.css'
import orgStructure from '../mock-data/org_structure.json'

Vue.component('line-chart', {
    extends: VueChartJs.Line,
    mounted () {
        this.renderChart({
                labels: [0, 10000, 20000, 30000, 40000, 50000, 60000],
                datasets: [
                    {
                        label: this.trans('paegtm.fact'),
                        borderColor: "#F27E31",
                        backgroundColor: '#F27E31',
                        data: [100, 800, 900, 1400, 1200, 2100, 2900],
                        fill: false,
                        showLine: true,
                        pointRadius: 4,
                        pointBorderColor: "#FFFFFF",
                    },
                    {
                        label: this.trans('paegtm.plan'),
                        borderColor: "#82BAFF",
                        backgroundColor: '#82BAFF',
                        data: [200, 900, 1100, 1600, 1700, 2200, 3100],
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
                            suggestedMin: 0,
                            suggestedMax: 7000,
                            fontColor: '#FFFFFF',
                        },
                    }],
                    xAxes: [{
                        gridLines: {
                            display: true,
                            color: '#3C4270'
                        },
                        ticks: {
                            fontColor: '#FFFFFF',
                        },
                    }],
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
            barOptions: {
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
                            suggestedMin: 0,
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
            },
            barLabels: [
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
            firstBarData: [
                {
                    label: this.trans('paegtm.plan'),
                    borderColor: "#F27E31",
                    backgroundColor: '#F27E31',
                    data: [3100, 4600, 1900, 2700, 2200, 3200, 500, 990, 2990, 4200, 840, 2500],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: this.trans('paegtm.fact_plus_forecast'),
                    borderColor: "#82BAFF",
                    backgroundColor: '#82BAFF',
                    data: [3200, 4700, 1950, 2800, 2400, 3300, 800, 1100, 3100, 4400, 1000, 2700],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                }
            ],
            secondBarData: [
                {
                    label: this.trans('paegtm.fact_plus_forecast'),
                    borderColor: "#F27E31",
                    backgroundColor: '#F27E31',
                    data: [16200, 12500, 14000, 13800, 15700, 16200, 15800, 14100, 14400, 14100, 15500, 19100],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: this.trans('paegtm.plan'),
                    borderColor: "#82BAFF",
                    backgroundColor: '#82BAFF',
                    data: [16000, 14500, 14100, 13900, 15800, 17000, 16100, 14200, 14600, 14200, 16200, 18800],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                }
            ],
            thirdBarData: [
                {
                    label: this.trans('paegtm.plan'),
                    borderColor: "#4CAF50",
                    backgroundColor: '#4CAF50',
                    data: [16200, 12500, 14000, 13800, 15700, 16200, 15800, 14100, 14400, 14100, 15500, 19100],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: this.trans('paegtm.fact_plus_forecast'),
                    borderColor: "#2196F3",
                    backgroundColor: '#2196F3',
                    data: [16000, 14500, 14100, 13900, 15800, 17000, 16100, 14200, 14600, 14200, 16200, 18800],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                }
            ],
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
    methods: {
        getData: function () {
        },
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
</script>