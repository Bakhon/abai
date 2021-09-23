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
    props: ["chartData", "name",'isDaily'],
    data: function () {
        return {
        };
    },
    computed: {
        chartOptions() {
            return {
                grid: {
                    show: false,
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
                colors: ['#999DC0','#2E50E9'],
                tooltip: {
                    enabled: true,
                    theme: 'dark',
                },
                yaxis: {
                    show: true,
                    labels: {
                        formatter: (num) => {
                            if (this.isDaily) {
                                return new Intl.NumberFormat("ru-RU").format(num);
                            }
                            if (num >= 1000) {
                                num = (num / 1000).toFixed(0);
                            } else if (num >= 100) {
                                num = Math.round((num / 1000) * 10) / 10;
                            } else if (num >= 10) {
                                num = Math.round((num / 1000) * 100) / 100;
                            } else if (num > 0) {
                                num = 0.01;
                            } else {
                                num = 0;
                            }
                            return new Intl.NumberFormat("ru-RU").format(num);
                        }
                    },
                },
                xaxis: {
                    tickAmount: 5,
                    labels: {
                        rotate: 0,
                        formatter: (num) => {
                            return moment(num,'DD.MM.YYYY').format('DD MMM');
                        }
                    },
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
    }
};
</script>
