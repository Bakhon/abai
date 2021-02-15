<template>
<div class="example">
  <apexchart height="350" type="line" :options="chartOptions" :series="series"></apexchart>
</div>
</template>

<script>
var ru = require("apexcharts/dist/locales/ru.json");
export default {
  name: 'MixedExample',
  data: function() {
    return {
      chartOptions: {
        stroke: {
          width: 4,
          curve: 'smooth'
        },
        colors:['#13B062', '#F7BB2E', '#AB130E'],
        chart: {
            stacked: true,
            foreColor: '#FFFFFF',
            locales: [ru],
            defaultLocale: 'ru'
        },
        plotOptions: {
          bar: {
            columnWidth: '50%'
          }
        },
        labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003', '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'],
        markers: {
          size: 0
        },
        xaxis: {
          type: 'datetime'
        },
        yaxis: {
          labels: {
            formatter: function (value) {
                return Math.floor(value);  // Remove distortion from BSW data
            }
          },
          title: {
            text: 'Добыча жидкости',
          },
          min: 0
        },
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: function(y) {
              if (typeof y !== "undefined") {
                // return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(y.toFixed(0)) + " тыс. тонн";
                let liquid = y.toString().split('.');
                if (liquid.length > 1) {
                  return `${liquid[0]} тыс. тонн, обв: ${liquid[1]}%`;
                } else {
                  return `${liquid[0]} тыс. тонн`;
                }
              }
              return y;
            }
          }
        }
      },
      series: [{
        name: 'Рентабельные скважины',
        type: 'area',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }, {
        name: 'Условно-рентабельные скважины',
        type: 'area',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }, {
        name: 'Нерентабельные скважины',
        type: 'area',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }],
    }
  },
  methods: {
    setValue: function(value) {
        this.series = [
            {
                name: 'Рентабельные скважины',
                type: 'area',
                data: value.profitable
            },
            {
                name: 'Условно-рентабельные скважины',
                type: 'area',
                data: value.profitless_cat_2
            },
            {
                name: 'Нерентабельные скважины',
                type: 'area',
                data: value.profitless_cat_1
            }
            ];

        this.chartOptions = {
            labels: value.dt
        };
    }
  },
  created: function() {
    this.$parent.$on('chart4', this.setValue);
  }
}
</script>
