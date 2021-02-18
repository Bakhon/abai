<script>
import { Line, mixins } from "vue-chartjs";
const { reactiveProp } = mixins;

export default {
  extends: Line,
    data: function () {
      return {
          monthMapping : [
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
      }
    },
  methods: {
      updateChartOptions: function (chartSummary) {
      let opec = chartSummary.opec;
      let color1;
      let color2;
      let plan1;
      let plan2;
      let datasets;

      let formattedChartSummary = {
          plan: [],
          fact: [],
          planOpec: [],
          labels: []
      };
      let self = this;
      _.forEach(chartSummary.dzoCompaniesSummaryForChart, function (item) {
          formattedChartSummary.labels.push(self.getFormattedDate(item.time));
          formattedChartSummary.plan.push(item.productionPlanForChart);
          formattedChartSummary.fact.push(item.productionFactForChart);
          formattedChartSummary.planOpec.push(item.productionPlanForChart2);
      });

      let canvas = document.getElementById("line-chart");
      let ctx = canvas.getContext("2d", { antialias: false, depth: false });
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

      if (opec === "ОПЕК+") {
        color1 = "#fff";
        color2 = "#2E50E9";
        plan1 = this.trans("visualcenter.planOPEK");
        // "План ОПЕК+";
        plan2 =
          this.trans("visualcenter.Plan") +
          " " +
          this.trans("visualcenter.utv");
        // "План утв.";
      } else {
        color1 = "#2E50E9";
        color2 = "#fff";
        plan1 =
          this.trans("visualcenter.Plan") +
          " " +
          this.trans("visualcenter.utv");
        // "План утв.";
        plan2 = this.trans("visualcenter.planOPEK");
        // "План ОПЕК+";
      }
      let planChartOptions = {
        label: plan1,
        borderColor: color1,
        fill: 1,
        backgroundColor: fillPattern,
        showLine: true,
        data: formattedChartSummary.plan,
        pointRadius: 0,
      };
      let factChartOptions = {
        label: this.trans("visualcenter.Fact"),
        // "Факт",
        borderColor: "#9EA4C9",
        fill: false,
        showLine: true,
        data: formattedChartSummary.fact,
        pointRadius: 0,
      };

      let planOpecChartOptions = {
        label: plan2,
        borderColor: color2,
        fill: false,
        backgroundColor: fillPattern,
        showLine: true,
        data: formattedChartSummary.planOpec,
        pointRadius: 0,
      };

      if (opec === "ОПЕК+") {
          datasets = [planChartOptions, factChartOptions, planOpecChartOptions];
      } else {
          datasets = [planChartOptions, factChartOptions];
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
                let data = chart.data;
                if (data.labels.length && data.datasets.length) {
                  let returnData = data.datasets.map(function (item, i) {
                    let meta = chart.getDatasetMeta(i);
                    let style = meta.controller.getStyle(i);
                    return {
                      text: item.label,
                      fillStyle: style.borderColor,
                    };
                  });
                  returnData.push({
                    text: this.trans("visualcenter.deviation"),
                    // "Отклонение",
                    fillStyle: fillPattern,
                  });

                  return returnData;
                }
                return [];
              },
            },
          },
          scales: {
            yAxes: [
              {
                ticks: {
                  fontColor: "#fff",
                  callback: function (num) {
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
        }
      );
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
