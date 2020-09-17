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
            stacked: false,
            foreColor: '#FFFFFF'
        },
        colors:['#AB130E','#13B062'],
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
            text: 'Скважины'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(val) + " тыс. тенге"
            }
          }
        }
      },
      series: [{
        name: 'Топ 20 рентабельных скважин',
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
      },{
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
                data: [
                    value.Operating_profit[0],
                    value.Operating_profit[1],
                    value.Operating_profit[2],
                    value.Operating_profit[3],
                    value.Operating_profit[4],
                    value.Operating_profit[5],
                    value.Operating_profit[6],
                    value.Operating_profit[7],
                    value.Operating_profit[8],
                    value.Operating_profit[9],
                ]
            },
            {
                name: 'Топ 20 рентабельных скважин',
                data: [
                    value.Operating_profit[10],
                    value.Operating_profit[11],
                    value.Operating_profit[12],
                    value.Operating_profit[13],
                    value.Operating_profit[14],
                    value.Operating_profit[15],
                    value.Operating_profit[16],
                    value.Operating_profit[17],
                    value.Operating_profit[18],
                    value.Operating_profit[19],
                ]
            }
            ];

        this.chartOptions = {
            xaxis: {
            categories: [
                    value.uwi[0],
                    value.uwi[1],
                    value.uwi[2],
                    value.uwi[3],
                    value.uwi[4],
                    value.uwi[5],
                    value.uwi[6],
                    value.uwi[7],
                    value.uwi[8],
                    value.uwi[9],
                    value.uwi[10],
                    value.uwi[11],
                    value.uwi[12],
                    value.uwi[13],
                    value.uwi[14],
                    value.uwi[15],
                    value.uwi[16],
                    value.uwi[17],
                    value.uwi[18],
                    value.uwi[19],
                ],
            },
        };
    }
  },
  created: function() {
    this.$parent.$on('chart3', this.setValue);
  }
}
</script>
