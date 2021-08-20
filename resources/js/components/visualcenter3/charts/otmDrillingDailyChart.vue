<template>
    <div>
        <div class="header text-center" style="padding-top: 40px;">{{trans(name[0])}}</div>
        <apexchart
                height="230"
                style="margin-top:0px"
                :options="chartOptions"
                :series="seriesComission"
        ></apexchart>
        <div class="header text-center" style="margin-top: -20px">{{trans(name[1])}}</div>
        <apexchart
                height="230"
                style="margin-top: -50px"
                :options="chartOptions"
                :series="seriesDrilling"
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
    props: ["chartData", "name"],
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
                dataLabels: {
                    enabled: false,
                },
                labels: this.chartData.labels,
                tooltip: {
                    enabled: false,
                },
                yaxis: {
                    show: true,
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
                    }
                },
            };
        },
        seriesComission() {
            if (this.chartData.series.comission.length === 0) {
                return [];
            } else {
                return [
                    {
                        data: this.chartData.series.comission,
                    },
                ];
            }
        },
        seriesDrilling() {
            if (this.chartData.series.drilling.length === 0) {
                return [];
            } else {
                return [
                    {
                        data: this.chartData.series.drilling,
                    },
                ];
            }
        },
    },
};
</script>
