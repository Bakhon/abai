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
            <div class="col-8 gtm-dark-light-transparent p-0 overflow-hidden">
                <div class="text-center">
                    <img src="/img/GTM/main_map.svg" class="gtm-main-map-img">
                </div>
                <div class="d-flex justify-content-around gtm-dark-light text-white p-1">
                    <div class="d-flex">
                        <img src="/img/GTM/main_map_line_blue.svg" alt="" class="my-auto mr-2">
                        <div class="my-auto dr-fw-700">
                            Действующий нефтепровод
                        </div>
                    </div>
                    <div class="d-flex">
                        <img src="/img/GTM/main_map_line_gray.svg" alt="" class="my-auto mr-2">
                        <div class="my-auto dr-fw-700">
                            Действующий газопровод
                        </div>
                    </div>
                    <div class="d-flex">
                        <img src="/img/GTM/main_map_icon_well.svg" alt="" class="my-auto mr-2">
                        <img src="/img/GTM/main_map_icon_sea_well.svg" alt="" class="my-auto mr-2">
                        <div class="my-auto dr-fw-700">
                            Разведка и добыча
                        </div>
                    </div>
                    <div class="d-flex">
                        <img src="/img/GTM/main_map_icon_processing.svg" alt="" class="my-auto mr-2">
                        <div class="my-auto dr-fw-700">
                            Переработка
                        </div>
                    </div>
                    <div class="d-flex">
                        <img src="/img/GTM/main_map_icon_point.svg" alt="" class="my-auto mr-2">
                        <div class="my-auto dr-fw-700">
                            ДЗО
                        </div>
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
        <modal v-if="!isModalHide" @close="hideModal"></modal>
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
                            <div class="modal-footer">
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
Vue.component("modal", {
    template: "#modal-template"
});

export default {
    data: function () {
        return {
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
        };
    },
    methods: {
        showModal() {
            this.isModalHide = false;
        },
        hideModal() {
            this.isModalHide = true;
        }
    },
    mounted () {
        this.$store.commit('globalloading/SET_LOADING', false);
    }
}
</script>