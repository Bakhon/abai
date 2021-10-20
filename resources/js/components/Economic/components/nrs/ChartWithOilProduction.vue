<template>
  <div>
    <div class="d-flex justify-content-center pt-2">
      <div class="form-check">
        <input v-model="isStacked"
               id="stacked"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="stacked">
          {{ trans(`economic_reference.stacked`) }}
        </label>
      </div>

      <div class="form-check ml-2">
        <input v-model="isScaled"
               id="scaled"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="scaled">
          {{ trans(`economic_reference.scaled`) }}
        </label>
      </div>
    </div>

    <apexchart
        :options="chartOptions"
        :series="chartSeries"
        :height="chartHeight"/>
  </div>
</template>

<script>
const ru = require("apexcharts/dist/locales/ru.json");

import chart from "vue-apexcharts";
import {chartInitMixin} from "../../mixins/chartMixin";

export default {
  name: 'ChartWithOilProduction',
  components: {apexchart: chart},
  mixins: [chartInitMixin],
  props: {
    title: {
      required: true,
      type: String,
    },
  },
  computed: {
    tooltipText() {
      return this.isScaled
          ? this.trans('economic_reference.thousand_tons')
          : this.trans('economic_reference.tons')
    },

    chartDimension() {
      return this.isScaled ? 1000 : null
    }
  }
}
</script>

