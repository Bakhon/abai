<script>
import { Line, mixins } from 'vue-chartjs'
const { reactiveProp } = mixins

export default {
  extends: Line,
  methods: {
    setValue: function (value) {
      let productionFactForChart = [];
      let productionPlanForChart = [];
      let labels = [];
      const monthNames = ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"
      ];
      _.forEach(value, function (item, key) {
        let date = new Date(Number(item.time));
        labels.push(date.getDate()+' / '+monthNames[date.getMonth()] + " / " + date.getFullYear());
        productionFactForChart.push(item.productionFactForChart);
        productionPlanForChart.push(item.productionPlanForChart);
      });
      // productionPlanForChart = [30000, 43000, 23000, 43000];
      // productionFactForChart = [25000, 65000, 12000, 64000];
      // labels = ['Сен / 2020', 'Окт / 2020', 'Ноя / 2020', 'Дек / 2020'];
      let canvas = document.getElementById('line-chart');
      let ctx = canvas.getContext('2d', { antialias: false, depth: false });
      ctx.fillStyle = 'transparent';
      let fillPattern = (function () {
        let tmpCanvas = document.createElement("canvas")
        tmpCanvas.width = 32;
        tmpCanvas.height = 16;
        let pCtx = tmpCanvas.getContext('2d');
        let x0 = 36;
        let x1 = -4;
        let y0 = -2;
        let y1 = 18;
        let offset = 32;

        pCtx.strokeStyle = "#5e62cc";
        pCtx.fillStyle = 'transparent';
        pCtx.lineWidth = 1;
        pCtx.beginPath();
        pCtx.moveTo(x0, y0);
        pCtx.lineTo(x1, y1);
        pCtx.moveTo(x0 - offset, y0);
        pCtx.lineTo(x1 - offset, y1);
        pCtx.moveTo(x0 + offset, y0);
        pCtx.lineTo(x1 + offset, y1);
        pCtx.stroke();
        ctx.fillRect(0, 0, canvas.width,canvas.height);

        return ctx.createPattern(tmpCanvas,'repeat');
      })();
      this.renderChart({
        labels: labels,
        datasets: [
          {
            label: "План",
            borderColor: '#2E50E9',
            fill: 1,
            backgroundColor: fillPattern,
            showLine: true,
            data: productionPlanForChart,
            pointRadius: 0
          },
          {
            label: "Факт",
            borderColor: '#9EA4C9',
            fill: false,
            showLine: true,
            data: productionFactForChart,
            pointRadius: 0
          },
        ]
      }, {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: "bottom",
          labels: {
            fontColor: '#fff',
            generateLabels: (chart) => {
              let data = chart.data;
              if (data.labels.length && data.datasets.length) {
                let returnData = data.datasets.map(function(item, i) {
                  let meta = chart.getDatasetMeta(i);
                  let style = meta.controller.getStyle(i);
                  return {
                    text: item.label,
                    fillStyle: style.borderColor,
                  };
                });
                returnData.push({
                  text: "Отклонение",
                  fillStyle: fillPattern,
                });

                return returnData;
              }
              return [];
            }
          }
        },
        scales: {
          yAxes: [{
            ticks: {
              fontColor: '#fff',
              callback: function(value) {
                return Math.round(value / 1000);
              }
            }
          }],
          xAxes: [{
            ticks: {
              fontColor: '#fff',
            }
          }]
        }
      })
    }
  },
  created: function () {
    this.$parent.$on("data", this.setValue);
  },
}
</script>
