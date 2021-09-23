<script>
    import {Line, mixins} from "vue-chartjs";

    const {reactiveProp} = mixins;

    export default {
        extends: Line,
        data: function () {
            return {
                monthMapping: [
                    this.trans("visualcenter.jan"),
                    this.trans("visualcenter.feb"),
                    this.trans("visualcenter.mar"),
                    this.trans("visualcenter.apr"),
                    this.trans("visualcenter.may"),
                    this.trans("visualcenter.june"),
                    this.trans("visualcenter.july"),
                    this.trans("visualcenter.aug"),
                    this.trans("visualcenter.sept"),
                    this.trans("visualcenter.oct"),
                    this.trans("visualcenter.nov"),
                    this.trans("visualcenter.dec"),
                ],
                initialChartColors: {
                    plan: "#fff",
                    opecPlan: "#2E50E9",
                    fact: "#9EA4C9",
                    monthlyPlan: '#009846',
                },
                initialChartLabels: {
                    plan: this.trans("visualcenter.planOPEK"),
                    opecPlan: this.trans("visualcenter.Plan") + " " + this.trans("visualcenter.utv"),
                    monthlyPlan: this.trans("visualcenter.requiredDailyPlan"),
                    fact: this.trans("visualcenter.Fact"),
                    deviation: this.trans("visualcenter.deviation"),
                },
            }
        },
        methods: {
            updateChartOptions: function (chartSummary) {
                let color1;
                let color2;
                let plan1;
                let plan2;

                let formattedChartSummary = {
                    plan: [],
                    fact: [],
                    planOpec: [],
                    monthlyPlan: [],
                    labels: []
                };
                let self = this;

                _.forEach(chartSummary.dzoCompaniesSummaryForChart, function (item) {
                    formattedChartSummary.labels.push(self.getFormattedDate(item.time));
                    formattedChartSummary.plan.push(item.productionPlanForChart2);
                    formattedChartSummary.fact.push(item.productionFactForChart);
                    formattedChartSummary.planOpec.push(item.productionPlanForChart);
                    formattedChartSummary.monthlyPlan.push(item.monthlyPlan);
                });

                let canvas = document.getElementById("line-chart");
                if (!canvas) {
                    return;
                }
                let ctx = canvas.getContext("2d", {antialias: false, depth: false});
                ctx.fillStyle = "transparent";
                let fillPattern = (function () {
                    let tmpCanvas = document.createElement("canvas");
                    tmpCanvas.width = 32;
                    tmpCanvas.height = 16;
                    let pCtx = tmpCanvas.getContext("2d");
                    let x0 = 36;
                    let x1 = -4;
                    let y0 = -2;
                    let y1 = 18;
                    let offset = 32;

                    pCtx.strokeStyle = "#5e62cc";
                    pCtx.fillStyle = "transparent";
                    pCtx.lineWidth = 1;
                    pCtx.beginPath();
                    pCtx.moveTo(x0, y0);
                    pCtx.lineTo(x1, y1);
                    pCtx.moveTo(x0 - offset, y0);
                    pCtx.lineTo(x1 - offset, y1);
                    pCtx.moveTo(x0 + offset, y0);
                    pCtx.lineTo(x1 + offset, y1);
                    pCtx.stroke();
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    return ctx.createPattern(tmpCanvas, "repeat");
                })();

                let chartColors = _.cloneDeep(this.initialChartColors);
                let chartLabels = _.cloneDeep(this.initialChartLabels);

                let planChartOptions = {
                    label: chartLabels.plan,
                    borderColor: chartColors.plan,
                    fill: false,
                    backgroundColor: fillPattern,
                    showLine: true,
                    data: formattedChartSummary.plan,
                    pointRadius: 0,
                };
                let factChartOptions = {
                    label: chartLabels.fact,
                    borderColor: chartColors.fact,
                    fill: false,
                    showLine: true,
                    data: formattedChartSummary.fact,
                    pointRadius: 0,
                };

                let planOpecChartOptions = {
                    label: chartLabels.opecPlan,
                    borderColor: chartColors.opecPlan,
                    fill: 1,
                    backgroundColor: fillPattern,
                    showLine: true,
                    data: formattedChartSummary.planOpec,
                    pointRadius: 0,
                };
                let monthlyPlan = {
                    label: chartLabels.monthlyPlan,
                    borderColor: chartColors.monthlyPlan,
                    fill: false,
                    backgroundColor: fillPattern,
                    showLine: true,
                    data: formattedChartSummary.monthlyPlan,
                    pointRadius: 0,
                };

                let datasets = [planChartOptions,factChartOptions,planOpecChartOptions];
                if (chartSummary.isFilterTargetPlanActive) {
                    datasets = [planChartOptions,factChartOptions,planOpecChartOptions,monthlyPlan];
                }

                this.renderChart(
                    {
                        labels: formattedChartSummary.labels,
                        datasets,
                    },
                    {
                        responsive: true,
                        maintainAspectRatio: false,
                        legend: {
                            position: "bottom",
                            labels: {
                                fontColor: "#fff",
                                generateLabels: (chart) => {
                                    return this.getLabelsByDatasets(chart,chartSummary, fillPattern)
                                }
                            },
                        },
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        fontColor: "#fff",
                                        callback: (num) => {
                                            return this.getFormattedNumber(num);
                                        },
                                    },
                                },
                            ],
                            xAxes: [
                                {
                                    ticks: {
                                        fontColor: "#fff",
                                    },
                                },
                            ],
                        },
                        tooltips: {
                            intersect: false,
                            callbacks: {
                                label: (tooltipItem,data) => {
                                    if (data.datasets.length !== 4) {
                                        return tooltipItem.value;
                                    }
                                    return this.getFormattedNumber(tooltipItem.value);
                                }
                            }
                        }
                    }
                );
            },

            getFormattedNumber(num) {
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
            },

            getLabelsByDatasets(chart,chartSummary,fillPattern) {
                let chartOptions = chart.data;
                if (!chartOptions.labels.length && !chartOptions.datasets.length) {
                    return [];
                }
                let labels = chartOptions.datasets.map(function (dataset, index) {
                    let meta = chart.getDatasetMeta(index);
                    let style = meta.controller.getStyle(index);
                    return {
                        text: dataset.label,
                        fillStyle: style.borderColor,
                    };
                });
                labels.push({
                    text: this.trans("visualcenter.deviation"),
                    fillStyle: fillPattern,
                });
                return labels;
            },

            getFormattedDate(timestamp) {
                let date = new Date(Number(timestamp));
                return date.getDate() + " / " + this.monthMapping[date.getMonth()] + " / " + date.getFullYear();
            },
        },
        created: function () {
            this.$parent.$on("data", this.updateChartOptions);
        },
    };
</script>
