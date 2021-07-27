<template>
    <div>
        <div class="row m-0 p-0 pl-1 pr-1">
            <div class="col-8 gtm-dark p-1 mt-1">
                <gtm-main-indicator
                    v-bind:data="[
                        {
                            number: 1458,
                            units: this.trans('paegtm.activities'),
                            title: this.trans('paegtm.number_of_gtm_and_vns'),
                            progressValue: 1458,
                            progressMax: 1441,
                            progressPercents: 1458 / 1441 * 100,
                        },
                        {
                            number: 695,
                            units: this.trans('paegtm.tons'),
                            title: this.trans('paegtm.additional_oil_production_from_vns'),
                            progressValue: 695,
                            progressMax: 713,
                            progressPercents: 695 / 713 * 100,
                        },
                        {
                            number: 766,
                            units: this.trans('paegtm.tons'),
                            title: this.trans('paegtm.additional_oil_production_from_gtm'),
                            progressValue: 766,
                            progressMax: 867,
                            progressPercents: 766 / 867 * 100,
                        },
                        {
                            number: 16998,
                            units: this.trans('paegtm.tons'),
                            title: this.trans('paegtm.basic_oil_production'),
                            progressValue: 16998,
                            progressMax: 16973,
                            progressPercents: 16998 / 16973 * 100,
                        },
                    ]"
                ></gtm-main-indicator>
            </div>
            <div class="col-4 p-0 pl-2 mt-1">
                <div class="gtm-dark h-100 pl-2 p-1">
                    <gtm-main-indicator
                        v-bind:data="[
                        {
                            number: 18475,
                            units: this.trans('paegtm.tons'),
                            title: this.trans('paegtm.oil_production'),
                            progressValue: 18475,
                            progressMax: 18568,
                            progressPercents: 18475 / 18568 * 100,
                        },
                    ]"
                    ></gtm-main-indicator>
                </div>
            </div>
        </div>
        <div class="row m-0 p-1 pt-2">
            <div class="gtm-dark col-9 p-0 gtm-main-table">
                <div class="position-absolute p-0 pl-2 pt-2 w-100 d-flex justify-content-start">
                    <div @click="showMainMap = !showMainMap" class="d-flex cursor-pointer switch-map-button dr-fw-700">
                        <img class="align-middle mr-1" :src="mainBlockButtonIcon" alt="" width="18">
                        <div class="align-middle">{{ mainBlockButtonText }}</div>
                    </div>
                </div>
                <div v-if="!showMainMap" class="h-100">
                      <table class="table table-striped text-center text-white podbor-middle-table h-100">
                          <thead>
                          <tr>
                            <th class="align-middle" rowspan="2">{{ trans('paegtm.dzo') }}</th>
                            <th class="align-middle" colspan="3">{{ trans('paegtm.additional_production_of_vns') }}</th>
                            <th class="align-middle" colspan="3">{{ trans('paegtm.additional_production_of_gtm') }}</th>
                            <th class="align-middle" colspan="3">{{ trans('paegtm.basic_loot') }}</th>
                            <th class="align-middle" colspan="3">{{ trans('paegtm.total_production') }}</th>
                          </tr>
                          <tr>
                              <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
                              <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
                              <th>+/-</th>
                              <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
                              <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
                              <th>+/-</th>
                              <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
                              <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
                              <th>+/-</th>
                              <th>{{ trans('paegtm.plan').toLowerCase() }}</th>
                              <th>{{ trans('paegtm.fact').toLowerCase() }}</th>
                              <th>+/-</th>
                          </tr>
                          </thead>
                          <tbody>
                          <tr v-for="mainTableItem in mainTableData">
                              <td v-for="value in mainTableItem" class="align-middle">{{ value }}</td>
                          </tr>
                          </tbody>
                      </table>
                </div>
                <div v-if="showMainMap">
                    <div class="text-center">
                        <img src="/img/GTM/main_map.svg" class="gtm-main-map-img">
                    </div>
                </div>
            </div>
            <div class="col-3 p-0 pl-2">
                <div class="gtm-dark h-100">
                    <div class="p-0">
                        <table class="table text-center text-white podbor-middle-table h-100 mb-0">
                            <thead>
                            <tr>
                                <th class="align-middle" rowspan="2" style="width: 250px;">{{ trans('paegtm.gtmType') }}</th>
                                <th colspan="2">{{ trans('paegtm.countThLong') }}</th>
                                <th class="align-middle" rowspan="2">{{ trans('paegtm.headway.tech') }}</th>
                                <th class="align-middle" rowspan="2">{{ trans('paegtm.headway.econom') }}</th>
                            </tr>
                            <tr>
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

        <div class="row p-1">
            <div class="col-6 pr-0">
                <main-page-chart-1></main-page-chart-1>
            </div>
            <div class="col-6 pl-2">
                <main-page-chart-2></main-page-chart-2>
            </div>
        </div>

        <!--
        <div class="row m-0 p-1">
            <div class="col-6 gtm-dark">
                <div class="w-100 d-flex justify-content-end cursor-pointer">
                    <img @click="showModal" src="/img/icons/link.svg" alt="" class="m-1 mt-2" width="18">
                </div>
                <bar-chart :height="190"></bar-chart>
            </div>
            <div class="col-6 pr-0">
                <div class="gtm-dark pr-2">
                    <div class="w-100 d-flex justify-content-end cursor-pointer">
                        <img @click="showModal" src="/img/icons/link.svg" alt="" class="m-1 mt-2" width="18">
                    </div>
                    <bar-chart :height="190"></bar-chart>
                </div>
            </div>
        </div>
        <gtm-modal v-if="!isModalHide" @close="hideModal"></gtm-modal>
        <script type="text/x-template" id="modal-template">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-container gtm-dark">
                            <div class="modal-body">
                                <slot name="body">
                                    <bar-chart :height="500"></bar-chart>
                                </slot>
                            </div>
                            <div class="d-flex justify-content-end">
                                <slot name="footer">
                                    <button class="modal-default-button gtm-dark-light p-1 px-2" @click="$emit('close')">
                                        Close
                                    </button>
                                </slot>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </script>
        -->
    </div>
</template>

<script>
import Vue from "vue";
import {paegtmMapActions, paegtmMapGetters} from '@store/helpers';
import moment from "moment";
Vue.component("gtm-modal", {
  template: "#modal-template"
});

export default {
    data: function () {
        return {
            mainTableData: [
              ['АО "Озенмунайгаз"', 231, 284, +53, 384, 368, -16, 4724, 4687, -37, 5341, 5341, 0],
              ['АО "ЭмбаМунайГаз"', 61, 74, +13, 87, 120, +33, 2453, 2407, -46, 2600, 2601, 0],
              ['АО "Мангистаумунайгаз"', 348, 274, -74, 283, 184, -100, 5273, 5496, +223, 5922, 5954, +32],
              ['АО "Каражанбасмунай"', 50, 46, -3, 26, 24, -2, 2077, 1930, -147, 2153, 2002, -150],
              ['ТОО "СП "Казгермунай"', 15, 10, -5, 58, 45, -13, 1465, 1482, +17, 1538, 1555, +17],
              ['ТОО "Казтуркмунай"', 9, 8, -1, 26, 24, -2, 396, 409, +13, 425, 432, +7],
              ['ТОО "Казахойл Актобе"', 0, 0, 0, 3, 1, -2, 586, 588, +2, 588, 589, +1],
            ],
            comparisonIndicators: [
                ['Бурение', 414, 417, 58, 65],
                ['ОПЛ', 0, 1, 0, 100],
                ['Ввод оценочных скважин из бурения', 2, 9, '-', '-'],
                ['Углубление', 1, 1, 100, 100],
                ['Бурение нагнет. скв.', 10, 10, '-', '-'],
                ['ГРП', 235, 221, 56, 78],
                ['Прочие КРС', 138, 151,54, 65],
                ['Ввод скважин из БД', 13, 11, 50, 60],
                ['Скин-ГРП', 100,100,56, 79],
                ['ПВР', 342, 343, 48,	75],
                ['ПВЛГ', 144, 130, 34, 47],
                ['РИР', 4, 3, 100, 100],
                ['НДГ', 2, 2, 0,50],
                ['ИДН', 0, 1, 100, 6],
                ['Прочие ГТМ', 36, 58, 54, 73],
            ],
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
            isModalHide: true,
            showMainMap: false,
        };
    },
    methods: {
        ...paegtmMapActions([
            'changeDateStart',
            'changeDateEnd',
        ]),
        showModal() {
            this.isModalHide = false;
        },
        hideModal() {
            this.isModalHide = true;
        }
    },
    computed: {
        ...paegtmMapGetters([
            'dateStart',
            'dateEnd',
        ]),
        mainBlockButtonText: function () {
            return this.showMainMap ? this.trans('paegtm.table') : this.trans('paegtm.map')
        },
        mainBlockButtonIcon: function () {
            return this.showMainMap ? '/img/GTM/icon_main_table_button.svg' : '/img/GTM/icon_main_map_button.svg'
        },
    },
    mounted () {
        this.$store.commit('globalloading/SET_LOADING', false);
        this.changeDateStart(this.dateStart);
        this.changeDateEnd(this.dateEnd);
    }
}
</script>
