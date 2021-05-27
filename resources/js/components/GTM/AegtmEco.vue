<template>
    <div>
        <div class="row mx-0 mt-lg-2 gtm">
            <div class="gtm-dark col-lg-10 p-0">
                <div class="row col-12 p-0 m-0">
                    <div class="col-6 d-none d-lg-block p-0 pl-1">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2">
                                Доходы от дополнительной добычи нефти
                            </div>
                            <div class="p-1 pl-2">
                                <gtm-bar-chart :chartdata="{labels: barLabels, datasets: firstBarData}" :options="barOptions" :height="350"></gtm-bar-chart>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                Свободные денежные потоки (FCF) 2020г
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
                                Расходы на ГТМ
                            </div>
                            <div class="p-1 pl-2">
                                <gtm-bar-chart :chartdata="{labels: barLabels, datasets: thirdBarData}" :options="barOptions" :height="350"></gtm-bar-chart>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0">
                        <div class="h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                Бурение скважин за 9 месяцев  2020г
                            </div>
                            <div class="p-1 pl-2 mh-370">
                                <line-chart :height="350"></line-chart>
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
                    <gtm-date-picker @dateChanged="getData"></gtm-date-picker>
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
                    <div class="gtm-dark text-white pl-2" style="min-height: 140px;">
                        Все скважины
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueChartJs from 'vue-chartjs'
Vue.component('line-chart', {
    extends: VueChartJs.Line,
    mounted () {
        this.renderChart({
                labels: [0, 10000, 20000, 30000, 40000, 50000, 60000],
                datasets: [
                    {
                        label: 'Факт',
                        borderColor: "#F27E31",
                        backgroundColor: '#F27E31',
                        data: [100, 800, 900, 1400, 1200, 2100, 2900],
                        fill: false,
                        showLine: true,
                        pointRadius: 4,
                        pointBorderColor: "#FFFFFF",
                    },
                    {
                        label: 'План',
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
                ['', 'Асар', ''],
                ['', 'Каламкас', ''],
            ],
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
            barLabels: ['Янв.', 'Фев.', 'Мар.', 'Апр.', 'Май', 'Июнь', 'Июль', 'Авг.', 'Сен.', 'Окт.', 'Ноя.', 'Дек.'],
            firstBarData: [
                {
                    label: 'План',
                    borderColor: "#F27E31",
                    backgroundColor: '#F27E31',
                    data: [3100, 4600, 1900, 2700, 2200, 3200, 500, 990, 2990, 4200, 840, 2500],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: 'Факт+прогноз',
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
                    label: 'Факт+прогноз',
                    borderColor: "#F27E31",
                    backgroundColor: '#F27E31',
                    data: [16200, 12500, 14000, 13800, 15700, 16200, 15800, 14100, 14400, 14100, 15500, 19100],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: 'План',
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
                    label: 'План',
                    borderColor: "#4CAF50",
                    backgroundColor: '#4CAF50',
                    data: [16200, 12500, 14000, 13800, 15700, 16200, 15800, 14100, 14400, 14100, 15500, 19100],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: 'Факт+прогноз',
                    borderColor: "#2196F3",
                    backgroundColor: '#2196F3',
                    data: [16000, 14500, 14100, 13900, 15800, 17000, 16100, 14200, 14600, 14200, 16200, 18800],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                }
            ],
        };
    },
    methods: {
        getData: function () {
        }
    }
}
</script>