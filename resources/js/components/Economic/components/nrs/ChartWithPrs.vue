<template>
  <div>
    <div class="d-flex justify-content-center pt-2">
      <div class="form-check">
        <input v-model="isVisibleInWork"
               id="in-work"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="in-work">
          {{ trans(`economic_reference.in_work`) }}
        </label>
      </div>

      <div class="form-check ml-2">
        <input v-model="isVisibleInPause"
               id="in-pause"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="in-pause">
          {{ trans(`economic_reference.in_pause`) }}
        </label>
      </div>

      <div class="form-check ml-2">
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
        ref="chart"
        :options="chartOptions"
        :series="chartSeries"
        :height="chartHeight"/>
  </div>
</template>

<script>
import chart from "vue-apexcharts";
import {chartInitMixin} from "../../mixins/chartMixin";

const ru = require("apexcharts/dist/locales/ru.json");

export default {
  name: 'ChartWithPrs',
  components: {apexchart: chart},
  mixins: [chartInitMixin],
  props: {
    pausedData: {
      required: true,
      type: Object
    },
    totalData: {
      required: true,
      type: Object
    }
  },
  data: () => ({
    isVisibleInPause: true
  }),
  computed: {
    chartSeries() {
      let data = [...this.defaultSeries]

      if (this.isVisibleInPause && this.isVisibleInWork) {
        this.chartKeys.forEach(key => {
          data.push(this.chartArea(key, this.totalData))
        })

        return data
      }

      if (this.isVisibleInPause) {
        this.chartKeys.forEach(key => {
          data.push(this.chartArea(key, this.pausedData))
        })

        return data
      }

      if (this.isVisibleInWork) {
        this.chartKeys.forEach(key => {
          data.push(this.chartArea(key, this.data))
        })

        return data
      }

      return data
    },

    title() {
      return this.trans('economic_reference.count_prs')
    }
  },
}
</script>

