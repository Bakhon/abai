<template>
    <div>
        <apexchart
                v-if="series.length"
                height="480"
                style="margin-top: 0px"
                :options="chartOptions"
                :series="series"
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
            chartType: 'bar'
        };
    },
    computed: {
        chartOptions() {
            let datetime;
            if (this.chartData.labels.length > 1) {
                datetime = "datetime";
            }
            if (this.chartData.labels.length > 100) {
                this.chartType = 'line';
            } else {
                this.chartType = 'bar';
            }
            if (!this.chartData) {
                return {};
            }

            return {
                grid: {
                    show: true,
                    borderColor: "#90A4AE",
                    strokeDashArray: 0,
                    position: "back",
                    row: {
                        colors: undefined,
                        opacity: 0.5,
                    },
                    column: {
                        colors: undefined,
                        opacity: 0.5,
                    },
                    padding: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0,
                    },
                },
                tooltip: {
                    enabled: true,
                    enabledOnSeries: undefined,
                    shared: true,
                    followCursor: false,
                    intersect: false,
                    inverseOrder: false,
                    custom: undefined,
                    fillSeriesColor: false,
                    theme: false,
                    y: {
                        formatter: function (value) {
                            if (value) {
                                return (new Intl.NumberFormat("ru-RU").format(Math.round(value)));
                            }
                            return value;
                        },
                    },
                },
                colors: ["#4A90E2", "#0080FF", "#F5FCFF"],
                chart: {
                    type: this.chartType,
                    stacked: false,
                    locales: [ru],
                    defaultLocale: "ru",
                    toolbar: {
                        show: false,
                        Color: "#373d3f",
                    },
                    foreColor: "#FFFFFF",
                },
                stroke: {
                    width: 2,
                },
                plotOptions: {
                    bar: {
                        rangeBarOverlap: true,
                        columnWidth: "20%",
                    },
                },
                dataLabels: {
                    enabled: false,
                    formatter: function (val) {
                        return val;
                    },
                    offsetY: -20,
                    style: {
                        fontSize: "12px",
                        colors: ["#c5c5c5"],
                    },
                },
                labels: this.chartData.labels,
                legend: {
                    show: false,
                    position: "bottom",
                    horizontalAlign: "right",
                },

                yaxis: {
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: true,
                        formatter: function (val) {
                            return val;
                        },
                    },
                },
                yaxis: {
                    lines: {
                        show: true,
                    },
                },
                xaxis: {
                    lines: {
                        show: true,
                    },
                    labels: {
                        formatter: function (val) {
                            return moment(val).format("DD / MMM / YYYY");
                        },
                        type: datetime,
                        datetimeFormatter: {
                            day: "dd MMM yy",
                            month: "dd MMM yy",
                            year: "yy",
                        },
                    },
                    position: "bottom",
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
            };
        },
        series() {
            if (!this.chartData) {
                return [];
            } else {
                return [
                    {
                        name: this.trans("visualcenter.Fact"),
                        data: this.chartData.series,
                    },
                ];
            }
        },
    },
};
</script>
