<template>
    <div class="h-100">
        <Plotly :data="chart" :layout="layout" :display-mode-bar="false"></Plotly>
    </div>
</template>

<script>
    import { Plotly } from "vue-plotly";
    export default {
        name: "Inclinometry3D",
        components: {'Plotly': Plotly},
        props: ['data'],
        data(){
            return{
                dzArray: null,
                dxArray: null,
                dyArray: null,
                xArr: null,
                yArr: null,
                zArr: null,
                indexZ: null,
                pointZ: null,
                pointX: null,
                pointY: null,
                chart: null,
                xChart: [],
                yChart: [],
                zChart: [],
                dlsColor: [],
                layout: {
                    showlegend: false,
                    plot_bgcolor: "#272953",
                    paper_bgcolor: "#2b2e5e",
                    margin: {
                        l: 0,
                        r: 0,
                        b: 0,
                        t: 0,
                        pad: 0
                    },
                    height: 450,
                    gridcolor: "white",
                    font: { color: "white" },

                    scene: {
                        xaxis: {
                            title: 'dx',
                            range: [0, 0],
                            gridcolor: "white",
                            zerolinecolor: "white",
                            hovertemplate: "",
                        },
                        yaxis: {
                            title: 'dy',
                            range: [0, 0],
                            gridcolor: "white",
                            zerolinecolor: "white",
                            hovertemplate: "",
                        },
                        zaxis: {
                            title: 'md',
                            gridcolor: "white",
                            zerolinecolor: "white",
                            hovertemplate: "",
                        },

                    }
                }
            }
        },
        mounted(){
        },
        methods:{
            async buildModel() {
                this.xChart = []
                this.yChart = []
                this.zChart = []
                this.dlsColor = []
                for(let i=0; i<this.data.length; i++) {
                    this.xChart.push(this.data[i].E_W)
                    this.yChart.push(this.data[i].N_S)
                    this.zChart.push(this.data[i].Measured_Depth)
                    this.dlsColor.push('#2E50E9')
                }
                let maxX = Math.max(...this.xChart.map(a => Math.abs(a)))
                let maxY = Math.max(...this.yChart.map(a => Math.abs(a)))

                if (maxX < 50 && maxY < 50) {
                    this.layout['scene']['xaxis']['range'][0] = 50
                    this.layout['scene']['xaxis']['range'][1] = -50
                    this.layout['scene']['yaxis']['range'][0] = 50
                    this.layout['scene']['yaxis']['range'][1] = -50
                } else {
                    this.layout['scene']['xaxis']['range'][0] = maxX * 1.5
                    this.layout['scene']['xaxis']['range'][1] = maxX * -1.5
                    this.layout['scene']['yaxis']['range'][0] = maxY * 1.5
                    this.layout['scene']['yaxis']['range'][1] = maxY * -1.5
                }

                this.chart = [{
                    type: 'scatter3d',
                    mode: 'lines',
                    x: this.xChart,
                    y: this.yChart,
                    z: this.zChart.map(x => x * -1),
                    text: "Test",
                    hovertemplate:  "MD = %{z} м<br>" + "EW = %{x} м<br>" + "NS = %{y} м<br>" + "<extra></extra>",
                    opacity: 1,
                    line: {
                        width: 12,
                        color: this.dlsColor,
                        colorscale: [[0, '#2E50E9'], [1, '#2E50E9']],
                        type: 'heatmap'
                    },
                }]
            },
        },
        created(){
            this.buildModel()
        },
    }
</script>

<style scoped>

</style>