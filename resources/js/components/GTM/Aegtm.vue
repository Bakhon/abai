<template>
    <div>
        <div class="row mx-0 mt-lg-2 gtm">
            <div class="col-lg-10 p-0">
                <div class="row col-12 p-0 m-0">
                    <div class="col-6 d-none d-lg-block p-0 pl-1 gtm-map-block">
                        <div class="gtm-dark h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                Накопленная добыча нефти, тыc. т
                            </div>
                            <div class="gtm-dark p-1 pl-2 mh-370">
                                <line-chart :height="360"></line-chart>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0 gtm-map-block">
                        <div class="gtm-dark h-100">
                            <div class="block-header pb-0 pl-2 pt-1">
                                Сопоставление плановых и фактических дебитов нефти новых скважин
                            </div>
                            <div class="gtm-dark p-1 pl-2">
                                <table class="table text-center text-white podbor-middle-table">
                                    <thead>
                                    <tr>
                                        <th class="align-middle" rowspan="2">№ скв.</th>
                                        <th colspan="2">Кол-во</th>
                                        <th colspan="2">Ср. дебит</th>
                                        <th colspan="2">Доп.добыча, тыс.т</th>
                                        <th class="align-middle" rowspan="2">% усп.</th>
                                    </tr>
                                    <tr>
                                        <th>план</th>
                                        <th>факт</th>
                                        <th>план</th>
                                        <th>факт</th>
                                        <th>план</th>
                                        <th>факт</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="statisticsItem in statistics">
                                        <td>{{ statisticsItem[0] }}</td>
                                        <td>{{ statisticsItem[1] }}</td>
                                        <td>{{ statisticsItem[2] }}</td>
                                        <td>{{ statisticsItem[3] }}</td>
                                        <td>{{ statisticsItem[4] }}</td>
                                        <td>{{ statisticsItem[5] }}</td>
                                        <td>{{ statisticsItem[6] }}</td>
                                        <td>{{ statisticsItem[7] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-12 p-0 m-0 pb-2">
                    <div class="col-6 d-none d-lg-block p-0 pl-1 gtm-map-block">
                        <div class="gtm-dark h-100">
                            <div class="block-header pb-0 pl-2">
                                Индекс прибыльности и сопоставление плановых дебитов нефти с фактическими
                            </div>
                            <div class="gtm-dark p-1 pl-2">
                                <bar-chart :height="360"></bar-chart>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none d-lg-block p-0 gtm-map-block">
                        <div class="gtm-dark h-100 pb-2">
                            <div class="block-header pb-0 pl-2">
                                Причины недостижения планового прироста
                            </div>
                            <div class="gtm-dark p-1 pl-2">
<!--                                <pie-chart :height="360"></pie-chart>-->
                                <img class="demo-img" src="/img/GTM/demo_img_circle.png" height="350">
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
Vue.component('line-chart', {
    extends: VueChartJs.Line,
    mounted () {
        this.renderChart({
            labels: ['Янв.', 'Фев.', 'Мар.', 'Апр.', 'Май', 'Июнь', 'Июль', 'Авг.', 'Сен.', 'Окт.', 'Ноя.', 'Дек.'],
            datasets: [
                {
                    label: 'Факт',
                    borderColor: "#F27E31",
                    backgroundColor: '#F27E31',
                    data: [4.5, 18, 32.3, 45, 58.9, 67, 75.8, 90, 105.6, 117.5, 125.2, 136, 148.8],
                    fill: false,
                    showLine: true,
                    pointRadius: 4,
                    pointBorderColor: "#FFFFFF",
                },
                {
                    label: 'План',
                    borderColor: "#82BAFF",
                    backgroundColor: '#82BAFF',
                    data: [28.1, 32, 46.2, 60, 74.7, 75, 91, 98, 107.8, 131, 134.4, 138, 150.8],
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
                        suggestedMax: 350,
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
                    label: 'Факт',
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
                    label: 'План',
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
Vue.component('pie-chart', {
    extends: VueChartJs.Doughnut,
    mounted () {
        this.renderChart({
            labels: [
                'Освободненность',
                'Выработка запасов',
                'Низкое РПЛ',
                'Технологическая',
                'Ухудшение ФЕС',
                'ГНО',
                'Выход на режим'
            ],
            datasets: [
                {
                    data: [35, 55, 17, 16, 12, 15, 5],
                    backgroundColor: ["#EF5350", "#4CAF50", "#F0AD81", "#2196F3", "#F27E31", "#3F51B5", "#3951CE"],
                }
            ],
        }, {
            borderWidth: 1,
            hoverBorderWidth: 5,
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
            statistics: [
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
                [4320, 7.9, 5.53, 70, 4320, 7.9, 5.53, 70],
            ],
        };
    }
}
</script>