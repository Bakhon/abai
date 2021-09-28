<template>
    <div class="digitalDrillingWindow">
        <main-content
            left_content="Табличные данные"
            right_content="Визуализация"
        >
            <template #left_function>
                <div class="inc__left_functions">
                    <img src="/img/digital-drilling/excel-icon.png" alt="">
                    Выгрузить в MS-Excel
                </div>
            </template>
            <template #content_body>
                <div class="table">
                    <table class="table defaultTable">
                        <tbody>
                        <tr>
                            <th colspan="10">Факт</th>
                        </tr>
                        <tr>
                            <th>Глубина по стволу, м</th>
                            <th>Зенитный угол, гр°</th>
                            <th>Дирекционный азимут, гр°</th>
                            <th>Глубина по вертикали, м</th>
                            <th>Интенсивность искривления, гр°/30м</th>
                            <th>Интенсивность набора угла.</th>
                            <th>Интенсивность разворота</th>
                            <th>Север / Юг , м</th>
                            <th>Восток / Запад , м</th>
                            <th>Восток / Запад , м</th>
                        </tr>
                        <tr v-for="i in 20">
                            <td v-for="i in 10"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </template>
            <template #right_function>
                <div class="inc__right_functions">
                    <div class="inc__2d"
                        :class="{not_active: !d2_Show}"
                    >
                        <div class="inc__2d-title">2D</div>
                        <div class="inc__2d-name">окно</div>
                        <div class="inc__2d-close" v-if="d2_Show">
                            <img src="/img/digital-drilling/inc-graph-close.png" alt="">
                        </div>
                    </div>
                    <div class="inc__2d"
                         :class="{not_active: !d3_Show}"
                    >
                        <div class="inc__2d-title">3D</div>
                        <div class="inc__2d-name">окно</div>
                        <div class="inc__2d-close" v-if="d3_Show">
                            <img src="/img/digital-drilling/inc-graph-close.png" alt="">
                        </div>
                    </div>
                </div>
            </template>
            <template #content_body_right>
                <div class="inc__charts"
                     :class="{full: d2_Show && d3_Show}"
                >
                    <div class="inc__charts-left" v-if="d2_Show">
                        <div class="inc__charts-left-graph">
                            <div class="inc__charts-name">Вид сбоку</div>
                            <apexchart height="320" :options="chartOptions" :series="series"></apexchart>
                        </div>
                        <div class="inc__charts-left-graph">
                            <div class="inc__charts-name">Вид сверху</div>
                            <apexchart height="320" :options="chartOptions" :series="series"></apexchart>
                        </div>
                    </div>
                    <div class="inc__charts-right" v-if="d3_Show">
                        <div class="inc__charts-name">Трехмерный вид</div>
                        <apexchart height="700" :options="chartOptions" :series="series"></apexchart>
                    </div>
                </div>
            </template>
        </main-content>
    </div>
</template>

<script>
    import VueApexCharts from "vue-apexcharts";
    import MainContent from '../components/MainContent'
    export default {
        name: "inclino",
        components: {
            MainContent,
            "apexchart": VueApexCharts
        },
        data(){
            return{
                d2_Show: true,
                d3_Show: false,
                series: [{
                    name: "Desktops",
                    data: [-10, 41, 35, 51, 49, 62, 69, 91, 148]
                    },
                    {
                        name: "Desktops",
                        data: [-10, 31, 45, 60, 59, 72, 19, 11, 48]
                    }],
                chartOptions: {
                    chart: {
                        height: 320,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },
                        background: '#2B2E5E',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#2E50E9', '#E3000F'],
                    stroke: {
                        curve: 'smooth',
                    },
                    legend:{
                        labels: {
                            colors: '#FFFFFF'
                        },
                        show: false,
                    },

                    grid: {
                        show: true,
                        borderColor: '#454D7D',
                        strokeDashArray: 0,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: true
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            },
                        },
                        row: {
                            colors: ['transparent'],
                            opacity: 0.5
                        },
                        column: {
                            colors: ['transparent'],
                            opacity: 0.5
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        },
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                        labels: {
                            style: {
                                colors: '#FFFFFF'
                            }
                        },
                    },
                    yaxis:{
                        labels: {
                            style: {
                                colors: '#FFFFFF'
                            }
                        },

                    },

                },
            }
        }
    }
</script>

<style scoped>
    th, td{
        font-size: 12px!important;
    }
    .inc__left_functions{
        display: flex;
        align-items: center;
    }
    .inc__left_functions img{
        margin-right: 8px;
    }
    .inc__right_functions{
        display: flex;
        align-items: center;
    }
    .inc__2d{
        display: flex;
        align-items: center;
        background: #2E50E9;
        padding: 6px 10px;
        border-radius: 6px;
        margin-right: 5px;
        cursor: pointer;
    }
    .inc__2d.not_active{
        opacity: 0.5;
    }
    .inc__2d-title{
        padding: 3px 5px;
        font-weight: bold;
        border-radius: 6px;
        background-color: #FFFFFF;
        margin-right: 7px;
        color: blue;
    }
    .inc__2d-close{
        margin-left: 10px;
    }
    .inc__charts-name{
        background: #323370;
        font-size: 16px;
        line-height: 19px;
        text-align: center;
        color: #FFFFFF;
        padding: 17px 0;
    }
    .inc__charts.full{
        display: flex;
        justify-content: space-between;
    }
    .inc__charts.full .inc__charts-left,
    .inc__charts.full .inc__charts-right{
        width: calc(50% - 7px);
    }
</style>

