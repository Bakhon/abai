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
            <div class="col-8 gtm-dark p-1 overflow-hidden">
                <img src="/img/GTM/main_map.svg" class="gtm-main-map-img">
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
            <div class="col-6 gtm-dark ">
                <img src="/img/GTM/main_demo_graph.svg" height="190">
            </div>
            <div class="col-6 pr-0">
                <div class="gtm-dark h-100">
                    <div class="p-0">
                        <img src="/img/GTM/main_demo_graph.svg" height="190">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

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
            ]
        };
    },
    mounted () {
        this.$store.commit('globalloading/SET_LOADING', false);
    }
}
</script>