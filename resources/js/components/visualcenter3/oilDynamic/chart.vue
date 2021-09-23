<template>
    <div>
        <apexchart
                height="300"
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
.comission-header {
    padding-top: 40px;
}
.drilling-header {
    margin-top: -20px
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
                dataLabels: {
                    enabled: false,
                },
                labels: this.chartData.labels,
                colors: ['#009847','#2E50E9'],
                tooltip: {
                    enabled: true,
                    theme: 'dark',
                },
                yaxis: {
                    show: true,
                },
                chart: {
                    type: 'line',
                    toolbar: {
                        show: false,
                    },
                    foreColor: "#FFFFFF",
                    zoom: {
                        enabled: false,
                    },
                    distributed: true
                },
                title: {
                    text: this.name,
                    align: 'center',
                    style: {
                        fontFamily:  'HarmoniaSansProCyr-Regular, Harmonia-sans',
                    },
                },
            };
        },
        series() {
            return this.chartData.series;
        }
    },
};
</script>
