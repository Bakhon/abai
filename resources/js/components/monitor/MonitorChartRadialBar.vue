<template>
    <div id="chart">
        <apexchart
            type="radialBar"
            height="250"
            :options="chartOptions"
            :series="series"
        ></apexchart>
        <div class="legend">с <input class="square2" v-model="series[0]"> мг.м3</div>
    </div>
</template>
<script>
export default {
    data: function () {
        return {
            series: [''],
            chartOptions: {
                chart: {
                    type: "radialBar",
                    offsetY: -20,
                    sparkline: {
                        enabled: true,
                    },
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            margin: 0,
                            size: "60%"
                        },
                        startAngle: -90,
                        endAngle: 90,
                        track: {
                            background: "#323370"
                        },
                        dataLabels: {
                            name: {
                                show: false,
                            },
                            value: {
                                show: false,
                                offsetY: -2,
                                fontSize: "22px",
                            },
                        },
                    },
                },
                grid: {
                    padding: {
                        top: -10,
                    },
                },
                fill: {
                    color: '#2e50e9'
                },
                stroke: {
                    width: '50%'
                },
                labels: ["Average Results"],

            },
        };
    },
    methods: {
        setValue: function (value) {
            this.series = [
                value
            ];
        }
    },
    created: function () {
        this.$parent.$on('chart5', this.setValue);
    }
};
</script>
