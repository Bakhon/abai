<template>
    <div>
        <div class="header text-center pt-5">{{trans(this.name)}}</div>
        <apexchart
                height="460"
                style="margin-top:0px"
                :options="chartOptions"
                :series="series"
        ></apexchart>
    </div>
</template>

<style scoped>
    .header {
        height: 50px;
        font-size: 16px;
    }
</style>


<script>
var ru = require("apexcharts/dist/locales/ru.json");
import moment from "moment";
import VueApexCharts from "vue-apexcharts";

export default {
    name: "mix-chart",
    components: {
        "apexchart": VueApexCharts
    },
    props: ["chartData", "name", "isYaxisActive"],
    data: function () {
        return {
        };
    },
    computed: {
        chartOptions() {
            return {
                grid: {
                    show: true,
                    borderColor: "#90A4AE",
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0,
                    },
                },
                legend: {
                    show: false,
                },
                colors: ['#999DC0','#2E50E9'],
                dataLabels: {
                    enabled: false,
                },
                labels: this.chartData.labels,
                tooltip: {
                    enabled: false,
                },
                yaxis: {
                    show: this.isYaxisActive,
                },
                chart: {
                    type: 'bar',
                    toolbar: {
                        show: false,
                    },
                    foreColor: "#FFFFFF",
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        distributed: true
                    }
                },
            };
        },
        series() {
            if (this.chartData.series.length === 0) {
                return [];
            } else {
                return [
                    {
                        data: this.chartData.series,
                    },
                ];
            }
        },
    },
};
</script>
