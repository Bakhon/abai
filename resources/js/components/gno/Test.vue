<template>
<vue-chart
  style="width: 800px; height: 600px;"
  :data="chartData"
  :options="{scales: {yAxes: [{ticks: {beginAtZero: true}}]}}"
  :update-config="{duration: 2000, easing: 'easeOutBounce'}"
  type="bar"
/>
</template>

<script>
  //import LineChart from './LineChart.js'

//import VueChart from '@seregpie/vue-chart';
export default {
  components: {
 LineChart,
  },
  chartData: [
        {
          label: 'Data One',
          backgroundColor: '#f87979',
          data: [40, 39, 10, 40, 39, 80, 40]
        }]
};
</script>

<style>
  .small {
    max-width: 600px;
    margin:  150px auto;
  }
</style>