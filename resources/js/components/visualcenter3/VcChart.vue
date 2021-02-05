<script>
import { Line, mixins } from "vue-chartjs";
const { reactiveProp } = mixins;

export default {
  extends: Line,
  methods: {
    setValue: function (value) {
      let opec = value[1]["opec"];
      let color1;
      let color2;
      let plan1;
      let plan2;
      let productionFactForChart = [];
      let productionPlanForChart = [];
      let productionPlanForChart2 = [];
      let labels = [];
      let datasets;
      const monthNames = [
        // "Янв",
        this.trans("visualcenter.jan"),
        // "Фев",
        this.trans("visualcenter.feb"),
        // "Мар",
        this.trans("visualcenter.mar"),
        // "Апр",
        this.trans("visualcenter.apr"),
        // "Май",
        this.trans("visualcenter.may"),
        // "Июн",
        this.trans("visualcenter.june"),
        // "Июл",
        this.trans("visualcenter.july"),
        // "Авг",
        this.trans("visualcenter.aug"),
        // "Сен",
        this.trans("visualcenter.sept"),
        // "Окт",
        this.trans("visualcenter.oct"),
        // "Ноя",
        this.trans("visualcenter.nov"),
        // "Дек",
        this.trans("visualcenter.dec"),
      ];

      console.log(value[0]["productionForChart"]);
      _.forEach(value[0]["productionForChart"], function (item, key) {
        let date = new Date(Number(item.time));
        labels.push(
          date.getDate() +
            " / " +
            monthNames[date.getMonth()] +
            " / " +
            date.getFullYear()
        );
        productionFactForChart.push(item.productionFactForChart);
        productionPlanForChart.push(item.productionPlanForChart);
        productionPlanForChart2.push(item.productionPlanForChart2);
      });
      // productionPlanForChart = [30000, 43000, 23000, 43000];
      // productionFactForChart = [25000, 65000, 12000, 64000];
      // labels = ['Сен / 2020', 'Окт / 2020', 'Ноя / 2020', 'Дек / 2020'];
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
      // console.log("test");

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
      let datasets1 = {
        label: plan1,
        borderColor: color1,
        fill: 1,
        backgroundColor: fillPattern,
        showLine: true,
        data: productionPlanForChart,
        pointRadius: 0,
      };
      let datasets2 = {
        label: this.trans("visualcenter.Fact"),
        // "Факт",
        borderColor: "#9EA4C9",
        fill: false,
        showLine: true,
        data: productionFactForChart,
        pointRadius: 0,
      };

      let datasets3 = {
        label: plan2,
        borderColor: color2,
        fill: false,
        backgroundColor: fillPattern,
        showLine: true,
        data: productionPlanForChart2,
        pointRadius: 0,
      };

      if (opec === "ОПЕК+") {
        datasets = [datasets1, datasets2, datasets3];
      } else {
        datasets = [datasets1, datasets2];
      }

      this.renderChart(
        {
          labels: labels,
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

                    // return Math.round(value / 100);
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
  },
  created: function () {
    this.$parent.$on("data", this.setValue);
  },
};
</script>
