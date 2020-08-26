<template>
  <div class="example">
    <apexchart type="line" height=360 :options="chartOptions" :series="series"></apexchart>
  </div>
</template>

<script>
export default {
  name: 'LineExample',
  data: function() {
    return {
      chartOptions: {
        xaxis: {
          type: 'datetime',
          categories: ['01/01/2003', '02/01/2003','03/01/2003','04/01/2003','05/01/2003','06/01/2003','07/01/2003','08/01/2003'],
        },
      },
      series: [{
        name: 'Series A',
        data: [30, 40, 45, 50, 49, 60, 70, 91]
      }, {
        name: 'Series B',
        data: [23, 43, 54, 12, 44, 52, 32, 11]
      }]
    }
  }
}
</script>
