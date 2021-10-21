<template>
  <div class="h-100 text-center d-flex">
    <div class="flex-50">
      <subtitle font-size="16" class="line-height-18px">
        Факт
      </subtitle>

      <apexchart
          :options="chartOptions"
          :series="chartSeries"
          :height="535"/>
    </div>

    <div class="flex-50">
      <subtitle font-size="16" class="line-height-18px">
        Предлагаемый вариант
      </subtitle>

      <apexchart
          :options="chartOptions"
          :series="chartSeries"
          :height="535"/>
    </div>
  </div>
</template>

<script>
import chart from "vue-apexcharts";
import Subtitle from "../Subtitle";

const ru = require("apexcharts/dist/locales/ru.json");

export default {
  name: "TableWellDistribution",
  components: {
    apexchart: chart,
    Subtitle
  },
  computed: {
    chartSeries() {
      return []
    },

    chartOptions() {
      return {
        stroke: {
          width: 4,
          curve: 'smooth'
        },
        colors: [
            '#374AB4',
            '#009847',
            '#E31F25',
        ],
        chart: {
          stacked: false,
          foreColor: '#FFFFFF',
          locales: [ru],
          defaultLocale: 'ru'
        },
        markers: {
          size: 0
        },
        tooltip: {
          shared: true,
          intersect: false,
        },
        fill: {
          opacity: 0.9,
        }
      }
    },
  }
}
</script>

<style scoped>
.line-height-18px {
  line-height: 18px;
}

.flex-50 {
  flex: 0 0 50%;
}
</style>