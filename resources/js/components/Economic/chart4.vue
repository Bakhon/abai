<template>
<div class="example">
  <apexchart height="350" type="bar" :options="chartOptions" :series="series"></apexchart>
</div>
</template>

<script>
export default {
  name: 'ColumnExample',
  data: function() {
    return {
      chartOptions: {
        plotOptions: {
          bar: {
            horizontal: true,
            endingShape: 'rounded',
            columnWidth: '55%',
          },
        },
        chart: {
            stacked: true,
            foreColor: '#FFFFFF'
        },
        colors:['#AB130E'],
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['', '', '', '', '', '', '', '', '','', '', '', '', '', '', '', '', '', '', ''],
        },
        yaxis: {
          title: {
            text: 'Топ 20 нерентабельных скважин'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return val + " тенге"
            }
          }
        }
      },
      series: [{
        name: 'Топ 20 нерентабельных скважин',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      }],
    }
  },
  methods: {
    setValue: function(value) {
        this.series = [
            {
                name: 'Топ 20 нерентабельных скважин',
                data: value.Operating_profit
            }
            ];

        this.chartOptions = {
            xaxis: {
            categories: value.uwi,
            },
        };
    }
  },
  created: function() {
    this.$parent.$on('chart4', this.setValue);
  }
}
</script>
