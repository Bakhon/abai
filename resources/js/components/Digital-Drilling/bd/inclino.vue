<template>
    <div class="digitalDrillingWindow">
        <main-content
            :left_content="left_content"
            :right_content="right_content"
            @leftClosed="leftClosed"
        >
            <template #left_function>
                <div class="inc__left_functions" @click="exportExcel">
                    <img src="/img/digital-drilling/excel-icon.png" alt="">
                    Выгрузить в MS-Excel
                </div>
            </template>
            <template #content_body>
                <div class="table">
                    <table class="table defaultTable">
                        <tbody>
                        <tr>
                            <th colspan="10">{{trans('digital_drilling.fact')}}</th>
                        </tr>
                        <tr>
                            <th>{{trans("digital_drilling.inclino.measured_depth")}}</th>
                            <th>{{trans("digital_drilling.inclino.inclination_angle")}}</th>
                            <th>{{trans("digital_drilling.inclino.directional_azimuth")}}</th>
                            <th>{{trans("digital_drilling.inclino.true_vertical_depth")}}</th>
                            <th>{{trans("digital_drilling.inclino.dogleg_severity")}}</th>
                            <th>{{trans("digital_drilling.inclino.build_up_rate")}}</th>
                            <th>{{trans("digital_drilling.inclino.turn_rate")}}</th>
                            <th>{{trans("digital_drilling.inclino.North_South")}}</th>
                            <th>{{trans("digital_drilling.inclino.East_West")}}</th>
                            <th>{{trans("digital_drilling.inclino.horizontal_displacement")}}</th>
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
                         @click="d2Show"
                    >
                        <div class="inc__2d-title" >2D</div>
                        <div class="inc__2d-name">{{trans("digital_drilling.default.window")}}</div>
                        <div class="inc__2d-close" v-if="d2_Show" @click.stop="d2_Close">
                            <img src="/img/digital-drilling/inc-graph-close.png" alt="">
                        </div>
                    </div>
                    <div class="inc__2d"
                         :class="{not_active: !d3_Show}"
                         @click="d3Show"
                    >
                        <div class="inc__2d-title" >3D</div>
                        <div class="inc__2d-name">{{trans("digital_drilling.default.window")}}</div>
                        <div class="inc__2d-close" v-if="d3_Show" @click.stop="d3_Close">
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
                            <div class="inc__charts-name">{{trans("digital_drilling.default.side_view")}}</div>
                            <apexchart height="500" :options="chartOptions" :series="series" v-if="series[0].data.length>0"></apexchart>
                        </div>
                        <div class="inc__charts-left-graph">
                            <div class="inc__charts-name">{{trans("digital_drilling.default.view_from_above")}}</div>
                            <apexchart height="500" :options="chartOptionsAbove" :series="seriesAbove" v-if="seriesAbove[0].data.length>0"></apexchart>
                        </div>
                    </div>
                    <div class="inc__charts-right" v-if="d3_Show">
                        <div class="inc__charts-name">{{trans("digital_drilling.default.3D_view")}}</div>
                        <Inclinometry3D :data="inclino"/>
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
    import Inclinometry3D from '../components/Inclinometry3D'
    export default {
        name: "inclino",
        components: {
            MainContent,
            "apexchart": VueApexCharts,
            Inclinometry3D
        },

        data(){
            return{
                leftBlock: false,
                inclino: [],
                d2_Show: true,
                d3_Show: false,
                maxValue: 50,
                left_content: "digital_drilling.project_data.tabular_data",
                right_content: "digital_drilling.project_data.visualization",
                series: [
                    {
                    name: "Глубина по вертикали",
                    data: []
                    },
                ],
                seriesAbove: [
                    {
                        name: "Глубина по вертикали",
                        data: []
                    },
                ],
                chartOptions: {
                    chart: {
                        zoom: {
                            enabled: true,
                            type: 'xy',
                            autoScaleYaxis: false,
                            zoomedArea: {
                                fill: {
                                    color: '#90CAF9',
                                    opacity: 0.4
                                },
                                stroke: {
                                    color: '#0D47A1',
                                    opacity: 0.4,
                                    width: 1
                                }
                            }
                        },
                        animations: {
                            enabled: false,
                        },
                        height: 500,
                        type: 'line',
                        background: '#2B2E5E',
                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                                selection: true,
                                zoom: true,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                            },
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
                        title: {
                                text: 'Отход от вертикали, м.', style: {
                                color: '#FFFFFF',
                                fontSize: '15px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 700,
                            },
                        },
                        labels: {
                            style: {
                                colors: '#FFFFFF'
                            },
                        },
                        tickAmount: 9,
                        position: 'bottom',
                    },
                    yaxis:{
                        reversed: true,
                        title: {
                            text: 'Глубина по вертикали, м.', style: {
                                color: '#FFFFFF',
                                fontSize: '15px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 700,
                            },
                        },
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
                chartOptionsAbove: {}
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
            leftClosed(){
                this.leftBlock = !this.leftBlock
                if (!this.leftBlock) {
                    this.d3_Show = false
                }
            },
            d3Show(){
                if (!this.leftBlock) {
                    this.d2_Show = false
                }
                this.d3_Show = true
            },
            d2Show(){
                if (!this.leftBlock) {
                    this.d3_Show = false
                }
                this.d2_Show = true
            },
            d2_Close(){
                this.d2_Show = false
                this.d3_Show = true
            },
            d3_Close(){
                this.d3_Show = false
                this.d2_Show = true
            },
            exportExcel(){
                if (this.currentWell.well_id) {
                    window.location.href = process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/inclinometry/' + this.currentWell.well_id + '/?=download'
                }
            },
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
                    x: 9 * this.inclino[this.inclino.length-1].HD,
                    y: null
                })
                this.series=[{
                    name: "Глубина по вертикали",
                        data: coordinates
                }]
                this.chartOptions.annotations = {
                        points: [
                            {
                                x: this.inclino[0].HD,
                                y: this.inclino[0].TVD,
                                marker: {
                                    size: 5,
                                    fillColor: 'green',
                                    strokeColor: 'green',
                                    radius: 2,
                                    cssClass: 'apexcharts-custom-class'
                                },
                            },
                            {
                                x: this.inclino[this.inclino.length-1].HD,
                                y: this.inclino[this.inclino.length-1].TVD,
                                marker: {
                                    size: 5,
                                    fillColor: 'red',
                                    strokeColor: 'red',
                                    radius: 2,
                                    cssClass: 'apexcharts-custom-class'
                                },
                            }
                        ]
                }
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

                let first = this.inclino[0].N_S
                let last = this.inclino[this.inclino.length-1].N_S
                if(first<0){
                    first = -1 * first
                }
                if(last<0){
                    last = -1 * last
                }
                if(last < first){
                    this.maxValue = first
                }else{
                    this.maxValue = last
                }
                let max = this.maxValue
                let minX = this.getMinX()
                let maxX = this.getMaxX()
                let minY = this.getMinY()
                this.seriesAbove = [{
                    name: "Север / Юг , м.",
                    data: coordinates
                }]
                this.chartOptionsAbove = {
                    annotations: {
                        position: 'back',
                        yaxis: [{
                            y: 0,
                            borderColor: '#FFFFFF',
                            label: {
                                borderColor: '#FFFFFF',
                                style: {
                                    color: '#fff',
                                    background: '#00E396',
                                },
                                text: '',
                            }
                        }],
                        xaxis: [{
                            x: 0,
                            borderColor: '#FFFFFF',
                            label: {
                                borderColor: '#FFFFFF',
                                style: {
                                    color: '#fff',
                                    background: '#00E396',
                                },
                                text: '',
                            }
                        }],
                        points: [
                            {
                                x: this.inclino[0].N_S,
                                y: this.inclino[0].E_W,
                                marker: {
                                    size: 5,
                                    fillColor: 'green',
                                    strokeColor: 'green',
                                    radius: 2,
                                    cssClass: 'apexcharts-custom-class',
                            },
                            },
                            {
                                x: this.inclino[this.inclino.length-1].N_S,
                                y: this.inclino[this.inclino.length-1].E_W,
                                marker: {
                                    size: 5,
                                    fillColor: 'red',
                                    strokeColor: 'red',
                                    radius: 2,
                                    cssClass: 'apexcharts-custom-class'
                                },
                            }
                        ]
                    },
                    chart: {
                        zoom: {
                            enabled: true,
                            type: 'xy',
                            autoScaleYaxis: true,
                            zoomedArea: {
                                fill: {
                                    color: '#90CAF9',
                                    opacity: 0.4
                                },
                                stroke: {
                                    color: '#0D47A1',
                                    opacity: 0.4,
                                    width: 1
                                }
                            }
                        },
                        animations: {
                            enabled: false,
                        },
                        height: 500,
                        type: 'line',

                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                                selection: true,
                                zoom: true,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                            },
                        },
                        background: '#2B2E5E',
                        events: {
                            beforeResetZoom: function(chartContext, opts) {
                                return {
                                    xaxis: {
                                        min: -1.5 * max,
                                        max: 1.5 * max
                                    },
                                    yaxis: {
                                        opposite: true,
                                        min: -1.5 * max,
                                        max: 1.5 * max,
                                        axisTicks: {show: true},
                                        axisBorder: {show: true,},
                                        title: {
                                            text: 'Север / Юг , м.', style: {
                                                color: '#FFFFFF',
                                                fontSize: '15px',
                                                fontFamily: 'Helvetica, Arial, sans-serif',
                                                fontWeight: 700,
                                            },
                                        },
                                        labels: {
                                            style: {
                                                colors: '#FFFFFF'
                                            },

                                            formatter: function(val) {
                                                if (val == null)
                                                    return 0;
                                                return val.toFixed(0);
                                            },
                                        }
                                    }
                                }
                            },
                            zoomed: function(chartContext, opts) {
                                return {
                                    yaxis: {
                                        opposite: true,
                                        axisTicks: {show: true},
                                        axisBorder: {show: true,},
                                        title: {
                                            text: 'Север / Юг , м.', style: {
                                                color: '#FFFFFF',
                                                fontSize: '15px',
                                                fontFamily: 'Helvetica, Arial, sans-serif',
                                                fontWeight: 700,
                                            },
                                        },
                                        labels: {
                                            style: {
                                                colors: '#FFFFFF'
                                            },

                                            formatter: function(val) {
                                                if (val == null)
                                                    return 0;
                                                return val.toFixed(0);
                                            },
                                        }
                                    }
                                }
                            },
                            beforeZoom: function(chartContext, { xaxis, yaxis }) {
                                console.log(xaxis)
                                console.log(yaxis)
                                console.log(chartContext)
                                maxX = maxX
                                if (yaxis){
                                    return {
                                        xaxis: {
                                            min: minX,
                                            max: maxX
                                        },
                                        yaxis: {
                                            opposite: true,
                                            min: yaxis[0].min,
                                            max: yaxis[0].max,
                                            axisTicks: {show: true},
                                            axisBorder: {show: true,},
                                            title: {
                                                text: 'Север / Юг , м.', style: {
                                                    color: '#FFFFFF',
                                                    fontSize: '15px',
                                                    fontFamily: 'Helvetica, Arial, sans-serif',
                                                    fontWeight: 700,
                                                },
                                            },
                                            labels: {
                                                style: {
                                                    colors: '#FFFFFF'
                                                },

                                                formatter: function(val) {
                                                    if (val == null)
                                                        return 0;
                                                    return val.toFixed(0);
                                                },
                                            }
                                        }
                                    }
                                }
                                return {
                                    xaxis: {
                                        min: minX,
                                    },
                                    yaxis: {
                                        opposite: true,
                                        min: minY,
                                        axisTicks: {show: true},
                                        axisBorder: {show: true,},
                                        title: {
                                            text: 'Север / Юг , м.', style: {
                                                color: '#FFFFFF',
                                                fontSize: '15px',
                                                fontFamily: 'Helvetica, Arial, sans-serif',
                                                fontWeight: 700,
                                            },
                                        },
                                        labels: {
                                            style: {
                                                colors: '#FFFFFF'
                                            },

                                            formatter: function(val) {
                                                if (val == null)
                                                    return 0;
                                                return val.toFixed(0);
                                            },
                                        }
                                    }
                                }
                            },
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
                        max: 1.5* this.maxValue,
                        min: -1.5 * this.maxValue,
                        title: {
                            text: 'Восток / Запад , м.', style: {
                                color: '#FFFFFF',
                                fontSize: '15px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 700,
                            },
                        },
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
                        tickAmount: 9,
                        position: 'bottom',
                    },

                    yaxis:[
                        {
                            opposite: true,
                            max: 1.5*this.maxValue,
                            min: -1.5 * this.maxValue,
                            axisTicks: {show: true},
                            axisBorder: {show: true,},
                            title: {
                                text: 'Север / Юг , м.', style: {
                                    color: '#FFFFFF',
                                    fontSize: '15px',
                                    fontFamily: 'Helvetica, Arial, sans-serif',
                                    fontWeight: 700,
                                },
                            },
                            labels: {
                                style: {
                                    colors: '#FFFFFF'
                                },

                                formatter: function(val) {
                                    if (val == null)
                                        return 0;
                                    return val.toFixed(0);
                                },
                            }
                        },

                    ],
                }

            },
            async getInclinoByWell(){
                this.SET_LOADING(true);
                try{
                    await this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/inclinometry/'+
                        this.currentWell.well_id).then((response) => {
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
                    this.seriesAbove = [{
                        name: "Desktops",
                        data: []
                    }]
                    this.series = [{
                        name: "Desktops",
                        data: []
                    }]
                }
                this.SET_LOADING(false);
            },
            getMinX(){
                return Math.min.apply(Math, this.inclino.map(function(o) { return o.N_S; }))
            },
            getMaxX(){
                return Math.max.apply(Math, this.inclino.map(function(o) { return o.N_S; }))
            },
            getMinY(){
                return Math.min.apply(Math, this.inclino.map(function(o) { return o.E_W; }))
            },

        },
    }
</script>

<style scoped>
    .digitalDrillingWindow{
        color: black!important;
    }
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
        cursor: pointer;
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
        padding: 6px 35px 6px 10px;
        border-radius: 6px;
        margin-right: 5px;
        cursor: pointer;
        position: relative;
        box-sizing: content-box;
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
        height: 100%;
    }
    .inc__2d-name{
        height: 100%;
    }
    .inc__2d-close{
        margin-left: 10px;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translate(0, -50%);
    }
    .inc__2d-close:hover{
        border-radius: 50%;
        background-color: lightgrey;
        padding: 2px 4px;
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
    .arrow_box{
        color: black!important;
    }
    .arrow_box span{
        color: black!important;
    }
    .apexcharts-tooltip {
        background: red!important;
        color: orange!important;
    }
</style>

