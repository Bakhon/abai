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
                            <th>Горизонтальное смещение, м</th>
                        </tr>
                        <tr v-for="item in inclino ">
                            <td>{{item.Measured_Depth}}</td>
                            <td>{{item.Inclinometry}}</td>
                            <td>{{item.Azimut}}</td>
                            <td>{{item.TVD}}</td>
                            <td>{{item.DLS}}</td>
                            <td>{{item.BU}}</td>
                            <td>{{item.TR}}</td>
                            <td>{{item.N_S}}</td>
                            <td>{{item.E_W}}</td>
                            <td>{{item.HD}}</td>
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
                            <apexchart height="500" :options="chartOptions" :series="series" v-if="series[0].data.length>0"></apexchart>
                        </div>
                        <div class="inc__charts-left-graph">
                            <div class="inc__charts-name">Вид сверху</div>
                            <apexchart height="500" :options="chartOptionsAbove" :series="seriesAbove" v-if="seriesAbove[0].data.length>0"></apexchart>
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
    import {digitalDrillingState} from '@store/helpers';
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
                inclino: [],
                d2_Show: true,
                d3_Show: false,
                series: [
                    {
                    name: "Desktops",
                    data: []
                    },
                ],
                seriesAbove: [
                    {
                        name: "Desktops",
                        data: []
                    },
                ],
                chartOptions: {
                    chart: {
                        height: 500,
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
                            colors: ['#FFFFFF']
                        },
                        show: false,
                    },
                    tooltip: {
                        fillSeriesColor: true,
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
                        // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                        labels: {
                            style: {
                                colors: '#FFFFFF'
                            },
                        },
                        tickAmount: 9,
                        position: 'top',
                    },
                    yaxis:{
                        reversed: true,
                        labels: {
                            style: {
                                colors: '#FFFFFF'
                            },

                            formatter: function(val) {
                                if (val == null)
                                    return 0;
                                return val.toFixed(0);
                            },
                        },

                    },
                },
                chartOptionsAbove: {
                    chart: {
                        height: 500,
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
                            colors: ['#FFFFFF']
                        },
                        show: false,
                    },
                    tooltip: {
                        fillSeriesColor: true,
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
                        // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                        labels: {
                            style: {
                                colors: '#FFFFFF'
                            },
                        },
                        tickAmount: 9,
                        position: 'bottom',
                    },
                    yaxis:{
                        opposite: true,
                        labels: {
                            style: {
                                colors: '#FFFFFF'
                            },

                            formatter: function(val) {
                                if (val == null)
                                    return 0;
                                return val.toFixed(0);
                            },
                        },

                    },
                },
            }
        },
        computed:{
            ...digitalDrillingState([
                'currentWell'
            ]),
        },
        mounted(){
            this.getInclinoByWell()
        },
        watch: {
            currentWell: function (val) {
                this.getInclinoByWell()
            }
        },
        methods:{
            setParametersChartSideView(){
                let coordinates = []
                let coordinate = {}
                for (let i=0; i<this.inclino.length; i++) {
                    coordinate ={
                        x: this.inclino[i].HD,
                        y: this.inclino[i].TVD
                    }
                    coordinates.push(coordinate)
                }
                this.series[0].data = coordinates
                // this.series[0].data =null
                // let coordinatesX = []
                // let coordinatesY = []
                // coordinatesX= [
                // 0.00,
                // 0.00,
                // 0.00,
                // 0.17,
                // 1.09,
                // 2.79,
                // 5.28,
                // 8.54,
                // 12.59,
                // 17.41,
                // 23.00,
                // 29.37,
                // 36.50,
                // 44.39,
                // 53.03,
                // 62.43,
                // 72.56,
                // 83.44,
                // 95.04,
                // 107.36,
                // 120.39,
                // 134.12,
                // 148.55,
                // 163.58,
                // 263.86,
                // 324.19,
                // 878.34,
                // 973.68,
                // 982.47,
                // 998.53,
                // 1015.17,
                // 1032.37,
                // 1050.11,
                // 1058.91,
                // 1241.86,
                // 1560.12,
                // 1637.53,
                // 1759.59,
                // 1763.86,
                // 1808.45,
                // 1826.53,
                // 1826.55]
                // coordinatesY = [
                //     0.00,
                //     9.43,
                //     400.00,
                //     420.00,
                //     449.98,
                //     479.93,
                //     509.83,
                //     539.64,
                //     569.37,
                //     598.98,
                //     628.45,
                //     657.76,
                //     686.90,
                //     715.84,
                //     744.56,
                //     773.05,
                //     801.29,
                //     829.24,
                //     856.91,
                //     884.26,
                //     911.28,
                //     937.94,
                //     964.24,
                //     990.01,
                //     1156.97,
                //     1257.40,
                //     2179.97,
                //     2338.70,
                //     2353.12,
                //     2378.45,
                //     2403.40,
                //     2427.95,
                //     2452.09,
                //     2463.63,
                //     2700.79,
                //     3112.80,
                //     3212.94,
                //     3370.80,
                //     3376.32,
                //     3433.98,
                //     3457.36,
                //     3457.39,
                //
                // ]
                // for (let i=0; i<coordinatesX.length; i++) {
                //         coordinate ={
                //             x: coordinatesX[i],
                //             y: coordinatesY[i]
                //         }
                //         coordinates.push(coordinate)
                //     }
                //     this.series[0].data = coordinates
            },
            setParametersChartAboveView(){
                let coordinates = []
                let coordinate = {}
                for (let i=0; i<this.inclino.length; i++) {
                    coordinate ={
                        x: this.inclino[i].E_W,
                        y: this.inclino[i].N_S
                    }
                    coordinates.push(coordinate)
                }
                this.seriesAbove[0].data = coordinates
                // let coorX = [
                //     0.00,
                //     0.00,
                //     0.00,
                //     0.14,
                //     0.88,
                //     2.24,
                //     4.23,
                //     6.86,
                //     10.10,
                //     13.97,
                //     18.46,
                //     23.57,
                //     29.29,
                //     35.63,
                //     42.57,
                //     50.11,
                //     58.24,
                //     66.97,
                //     76.28,
                //     86.17,
                //     96.63,
                //     107.65,
                //     119.23,
                //     131.29,
                //     211.78,
                //     260.20,
                //     704.97,
                //     781.49,
                //     788.51,
                //     801.16,
                //     814.04,
                //     827.14,
                //     840.46,
                //     846.99,
                //     982.15,
                //     1216.97,
                //     1274.04,
                //     1364.01,
                //     1367.16,
                //     1400.02,
                //     1413.35,
                //     1413.36,
                // ]
                // let coorY = [
                //     0.00,
                //     0.00,
                //     0.00,
                //     -0.10,
                //     -0.65,
                //     -1.66,
                //     -3.15,
                //     -5.09,
                //     -7.51,
                //     -10.38,
                //     -13.72,
                //     -17.52,
                //     -21.77,
                //     -26.48,
                //     -31.63,
                //     -37.24,
                //     -43.28,
                //     -49.77,
                //     -56.69,
                //     -64.04,
                //     -71.81,
                //     -80.01,
                //     -88.61,
                //     -97.57,
                //     -157.39,
                //     -193.38,
                //     -523.93,
                //     -580.80,
                //     -586.09,
                //     -596.00,
                //     -606.56,
                //     -617.75,
                //     -629.58,
                //     -635.54,
                //     -759.99,
                //     -976.20,
                //     -1028.75,
                //     -1111.58,
                //     -1114.48,
                //     -1144.74,
                //     -1157.01,
                //     -1157.02,
                //
                // ]
                // for (let i=0; i<coorX.length; i++) {
                //     coordinate ={
                //         x: coorY[i],
                //         y: coorX[i]
                //     }
                //     coordinates.push(coordinate)
                // }
                // this.seriesAbove[0].data = coordinates
            },
            async getInclinoByWell(){
                try{
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/inclinometry/'+
                        this.currentWell[this.currentWell.length-1].id).then((response) => {
                        let data = response.data;
                        if (data) {
                            this.inclino = data;
                            this.setParametersChartSideView()
                            this.setParametersChartAboveView()
                        } else {
                            console.log('No data');
                        }
                    });
                }
                catch (e) {
                    console.log(e)
                    this.inclino = []
                }
            },
        },
    }
</script>

<style scoped>
    .apexcharts-tooltip {
        background: #f3f3f3;
        color: orange;
    }

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

