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
      return this.trans('economic_reference.tons')
    },
  },
  methods: {
    labelsFormatter(value) {
      value = this.isStacked ? +value.toFixed(0) : +value.toFixed(1)

      return value.toLocaleString()
    },
  }
}
</script>

