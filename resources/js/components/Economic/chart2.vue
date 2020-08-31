<template>
<div class="example">
  <apexchart height="350" type="line" :options="chartOptions" :series="series"></apexchart>
</div>
</template>

<script>
export default {
  name: 'MixedExample',
  data: function() {
    return {
      chartOptions: {
        chart: {
          stacked: false,
        },
        stroke: {
          width: [0, 2, 5],
          curve: 'smooth'
        },
        colors:['#13B062', '#F7BB2E', '#AB130E'],
        chart: {
            stacked: true,
            foreColor: '#FFFFFF'
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
          title: {
            text: 'Добыча нефти',
          },
          min: 0
        },
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: function(y) {
              if (typeof y !== "undefined") {
                return y.toFixed(0) + " тонн";
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
        name: 'Нерентабельные скважины 2',
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
                name: 'Нерентабельные скважины 2',
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
    this.$parent.$on('chart2', this.setValue);
  }
}
</script>
