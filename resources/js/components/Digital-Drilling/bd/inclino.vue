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
    import {digitalDrillingState, globalloadingMutations} from '@store/helpers';
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
                        background: '#2B2E5E',

                        zoom: {
                            enabled: true,
                            type: 'x',
                            autoScaleYaxis: true,
                        },
                        toolbar: {
                            autoSelected: 'zoom'
                        }
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
                            enabled: true,
                            type: 'x',
                            autoScaleYaxis: true,
                        },
                        toolbar: {
                            autoSelected: 'zoom'
                        },
                        background: '#2B2E5E',

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
            ...globalloadingMutations([
                'SET_LOADING'
            ]),
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
                coordinates.push({
                    x: 250,
                    y: null
                })
                this.series[0].data = coordinates
            },
            setParametersChartAboveView(){
                let coordinates = []
                let coordinate = {}
                for (let i=0; i<this.inclino.length; i++) {
                    coordinate ={
                        x: this.inclino[i].N_S,
                        y: this.inclino[i].E_W
                    }
                    coordinates.push(coordinate)
                }
                this.seriesAbove[0].data = coordinates
            },
            async getInclinoByWell(){
                this.SET_LOADING(true);
                try{
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/inclinometry/'+
                        this.currentWell.id).then((response) => {
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
                this.SET_LOADING(false);
            },
        },
    }
</script>

<style scoped>
    .inc__charts{
        color: black!important;
    }
    .apexcharts-tooltip {
        background: #f3f3f3!important;
        color: orange!important;
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

