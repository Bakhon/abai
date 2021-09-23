<template>
    <div>
        <apexchart
                height="120"
                :options="chartOptions"
                style="margin-top:-30px"
                :series="seriesDrilling"
        ></apexchart>
    </div>
</template>

<script>
var ru = require("apexcharts/dist/locales/ru.json");
import moment from "moment";
import VueApexCharts from "vue-apexcharts";

export default {
    name: "mix-chart",
    components: {
        "apexchart": VueApexCharts
    },
    props: ["chartData"],
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
                    enabled: true,
                    formatter: function(num) {
                        return (new Intl.NumberFormat("ru-RU").format(Math.round(num)));
                    }
                },
                labels: this.chartData.labels,
                tooltip: {
                    enabled: false,
                },
                yaxis: {
                    show: true,
                    labels: {
                        style: {
                            fontSize: '14px'
                        }
                    }
                },
                xaxis: {
                    labels: {
                        formatter: (num) => {
                            return new Intl.NumberFormat("ru-RU").format(num);
                        }
                    },
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
                        dataLabels: {
                            position: 'top',
                        },
                        distributed: true
                    }
                },
            };
        },
        seriesDrilling() {
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
