<template>
  <div>
    <div class="d-flex">
      <div class="form-check">
        <input v-model="showInWork"
               id="in-work"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="in-work">
          {{ trans(`economic_reference.in_work`) }}
        </label>
      </div>

      <div class="form-check ml-2">
        <input v-model="showInPause"
               id="in-pause"
               type="checkbox"
               class="form-check-input cursor-pointer">

        <label class="form-check-label cursor-pointer"
               for="in-pause">
          {{ trans(`economic_reference.in_pause`) }}
        </label>
      </div>
    </div>

    <apexchart
        :options="chartOptions"
        :series="chartSeries"
        :height="745"
        type="line"/>
  </div>
</template>

<script>
import {GRANULARITY_DAY} from "./SelectGranularity";

const ru = require("apexcharts/dist/locales/ru.json");

import chart from "vue-apexcharts";
import {chartInitMixin} from "../mixins/chartMixin";

export default {
  name: 'Chart1',
  components: {apexchart: chart},
  mixins: [chartInitMixin],
  props: {
    title: {
      required: true,
      type: String,
    },
    tooltipText: {
      required: false,
      type: String,
    },
    dataInPause: {
      required: true,
      type: Object
    }
  },
  data: () => ({
    showInWork: true,
    showInPause: false
  }),
  methods: {
    tooltipFormatter(y) {
      if (y === undefined) {
        return y
      }

      return new Intl.NumberFormat(
          'en-IN',
          {maximumSignificantDigits: 3}
      ).format(y.toFixed(0)) + ` ${this.tooltipText || ''}`;
    }
  },
  computed: {
    chartSeries() {
      const keys = this.isProfitabilityFull
          ? ['profitable', 'profitless_cat_2', 'profitless_cat_1']
          : ['profitable', 'profitless_cat_1']

      let data = []

      keys.forEach(key => {
        if (this.showInWork) {
          data.push({
            name: this.trans(`economic_reference.wells_${key}`),
            type: 'area',
            data: this.data[key]
          })
        }

        if (this.showInPause) {
          data.push({
            name: `${this.trans(`economic_reference.wells_${key}`)} ${this.trans(`economic_reference.in_pause`).toLowerCase()}`,
            type: 'area',
            data: this.dataInPause[key]
          })
        }
      })

      return data
    },

    chartColors() {
      const colorsInWork = this.isProfitabilityFull
          ? ['#13B062', '#F7BB2E', '#AB130E']
          : ['#13B062', '#AB130E']

      const colorsInPause = this.isProfitabilityFull
          ? ['#0E7D45', '#C49525', '#780D0A']
          : ['#0E7D45', '#780D0A']

      let colors = []

      colorsInWork.forEach((color, index) => {
        if (this.showInWork) {
          colors.push(color)
        }

        if (this.showInPause) {
          colors.push(colorsInPause[index])
        }
      })

      return colors
    },

    chartOptions() {
      return {
        labels: this.data.hasOwnProperty('dt') ? this.data.dt : [],
        stroke: {
          width: 4,
          curve: 'smooth'
        },
        colors: this.chartColors,
        chart: {
          stacked: true,
          foreColor: '#FFFFFF',
          locales: [ru],
          defaultLocale: 'ru',
        },
        markers: {
          size: 0
        },
        xaxis: {
          type: this.granularity === GRANULARITY_DAY
              ? 'datetime'
              : 'date'
        },
        yaxis: {
          labels: {
            formatter(val) {
              return Math.round(val);
            }
          },
          title: {
            text: this.title,
          },
          min: 0
        },
        tooltip: {
          shared: true,
          intersect: false,
          y: {
            formatter: (y) => this.tooltipFormatter(y)
          }
        }
      }
    },
  },
}
</script>

