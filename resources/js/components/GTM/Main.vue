<template>
    <div>
        <div class="row m-0 p-0 pl-1 pr-1">
            <div class="col-8 gtm-dark p-1">
                <gtm-main-indicator
                    v-bind:data="[
                        {
                            number: 356,
                            units: 'мероприятий',
                            title: 'Количество ГТМ и ВНС',
                            progressValue: 356,
                            progressMax: 394,
                            progressPercents: 356 / 394 * 100,
                        },
                        {
                            number: 263000,
                            units: 'тонн',
                            title: 'Дополнительная добыча нефти от ВНС',
                            progressValue: 263000,
                            progressMax: 300000,
                            progressPercents: 263000 / 300000 * 100,
                        },
                        {
                            number: 293000,
                            units: 'тонн',
                            title: 'Дополнительная добыча нефти от ГТМ',
                            progressValue: 293000,
                            progressMax: 438000,
                            progressPercents: 293000 / 438000 * 100,
                        },
                        {
                            number: 2054300,
                            units: 'тонн',
                            title: 'Базовая добыча нефти',
                            progressValue: 2054300,
                            progressMax: 2100000,
                            progressPercents: 2054300 / 2100000 * 100,
                        },
                    ]"
                ></gtm-main-indicator>
            </div>
            <div class="col-4 p-0 pl-2">
                <div class="gtm-dark h-100 pl-2 p-1">
                    <gtm-main-indicator
                        v-bind:data="[
                        {
                            number: 2610300,
                            units: 'тонн',
                            title: 'Добыча нефти',
                            progressValue: 2610300,
                            progressMax: 2623500,
                            progressPercents: 2610300 / 2623500 * 100,
                        },
                    ]"
                    ></gtm-main-indicator>
                </div>
            </div>
        </div>
        <div class="row m-0 p-1">
            <div class="gtm-dark col-8 p-0 gtm-main-table">
                <div class="position-absolute p-0 pr-2 pt-2 w-100 d-flex justify-content-end">
                    <div @click="showMainMap = !showMainMap" class="d-flex cursor-pointer switch-map-button dr-fw-700">
                        <img class="align-middle mr-1" :src="mainBlockButtonIcon" alt="" width="18">
                        <div class="align-middle">{{ mainBlockButtonText }}</div>
                    </div>
                </div>
                <div v-if="!showMainMap">
                    <div class="p-0">
                        <table class="table table-striped text-center text-white podbor-middle-table h-100">
                            <thead>
                            <tr>
                                <th class="align-middle" rowspan="2">ДЗО</th>
                                <th colspan="3">Дополнительная добыча ВРС, тонн</th>
                                <th colspan="3">Дополнительная добыча ГТМ, тонн</th>
                                <th colspan="3">Базовая добыча</th>
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
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="mainTableItem in mainTableData">
                                <td v-for="value in mainTableItem" class="align-middle">{{ value }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-if="showMainMap">
                    <div class="text-center">
                        <img src="/img/GTM/main_map.svg" class="gtm-main-map-img">
                    </div>
                </div>
            </div>
            <div class="col-4 p-0 pl-2">
                <div class="gtm-dark h-100">
                    <div class="p-0">
                        <table class="table text-center text-white podbor-middle-table h-100">
                            <thead>
                            <tr>
                                <th class="align-middle" rowspan="2">{{ trans('paegtm.gtmType') }}</th>
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
    </div>
</template>

<script>
import {paegtmMapActions, paegtmMapGetters} from '@store/helpers';
import moment from "moment";
Vue.component("gtm-modal", {
  template: "#modal-template"
});

export default {
    data: function () {
        return {
            mainTableData: [
                ['АО "Озенмунайгаз"', 300245, 270221, -30025, 345281, 310753, -34528, 300245, 270221, -30025],
                ['АО "ЭмбаМунайГаз"', 300245, 270221, -30025, 345281, 310753, -34528, 300245, 270221, -30025],
                ['АО "Мангистаумунайгаз"', 300245, 270221, -30025, 345281, 310753, -34528, 300245, 270221, -30025],
                ['АО "Каражанбасмунайгаз"', 300245, 270221, -30025, 345281, 310753, -34528, 300245, 270221, -30025],
                ['АО "Казгермунай"', 300245, 270221, -30025, 345281, 310753, -34528, 300245, 270221, -30025],
                ['АО "Казахтуркмунай"', 300245, 270221, -30025, 345281, 310753, -34528, 300245, 270221, -30025],
                ['АО "Казахойл Актобе"', 300245, 270221, -30025, 345281, 310753, -34528, 300245, 270221, -30025],
            ],
            comparisonIndicators: [
                ['Бурение', 15, 17, 78, 81],
                ['ГРП', 15, 17, 78, 81],
                ['ПВЛГ', 15, 17, 78, 81],
                ['Скин ГРП', 15, 17, 78, 81],
                ['ПВР', 15, 17, 78, 81],
                ['РИР', 15, 17, 78, 81],
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