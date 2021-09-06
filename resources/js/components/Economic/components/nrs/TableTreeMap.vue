<template>
  <div>
    <select-tech-structure
        :form="form"
        form-key="ngdu"
        class="mb-3"
        @change="form.cdng_id = null"/>

    <select-tech-structure
        v-if="form.ngdu_id"
        :form="form"
        :fetch-params="{ngdu_id: form.ngdu_id}"
        form-key="cdng"
        class="mb-3"
        @change="form.gu_id = null"/>

    <select-tech-structure
        v-if="form.cdng_id"
        :form="form"
        :fetch-params="{cdng_id: form.cdng_id}"
        form-key="gu"
        class="mb-3"/>

    <div v-for="chart in charts"
         :key="chart.title"
         :id="chart.title">
    </div>
  </div>
</template>

<script>
import {treemapMixin} from "../../mixins/treemapMixin";

import SelectTechStructure from "../SelectTechStructure";

export default {
  name: "TableTreeMap",
  components: {
    SelectTechStructure
  },
  mixins: [treemapMixin],
  props: {
    data: {
      required: true,
      type: Object
    },
  },
  data: () => ({
    form: {
      gu_id: null,
      ngdu_id: null,
      cdng_id: null,
      field_id: null,
    }
  }),
  computed: {
    uwis() {
      return Object.keys(this.data.uwis)
    },

    wells() {
      return this.uwis.map(uwi => {
        let well = {uwi: uwi}

        this.charts.forEach(chart => well[chart.key] = this.data.uwis[uwi][chart.key].sum)

        return well
      })
    },

    chartSeries() {
      let series = {}

      this.charts.forEach(chart => {
        let wells = []

        this.wells.forEach(well => {
          let value = +well[chart.key]

          if (chart.hasOwnProperty('positive') && value < 0) return

          if (chart.hasOwnProperty('negative') && value >= 0) return

          let color = this.getColor(well, 'Operating_profit')

          wells.push({
            name: well.uwi,
            value: Math.abs(value),
            fill: color,
            fillOriginal: color
          })
        })

        series[chart.title] = wells
      })

      return series
    },

    charts() {
      return [
        {
          title: this.trans('economic_reference.operating_profit') + '+',
          key: 'Operating_profit',
          positive: true
        },
        {
          title: this.trans('economic_reference.operating_profit') + '-',
          key: 'Operating_profit',
          negative: true
        },
        {
          title: this.trans('economic_reference.liquid_production'),
          key: 'liquid'
        },
        {
          title: this.trans('economic_reference.oil_production'),
          key: 'oil'
        },
      ]
    }
  }
}
</script>

<style scoped>

</style>