<template>
  <div>
    <select-tech-structure
        :form="form"
        form-key="ngdu"
        class="mb-3"
        @change="updateForm('cdng_id')"/>

    <select-tech-structure
        v-if="form.ngdu_id"
        :form="form"
        :fetch-params="{ngdu_id: form.ngdu_id}"
        form-key="cdng"
        class="mb-3"
        @change="updateForm('gu_id')"/>

    <select-tech-structure
        v-if="form.cdng_id"
        :form="form"
        :fetch-params="{cdng_id: form.cdng_id}"
        form-key="gu"
        class="mb-3"
        @change="getWells"/>

    <div v-if="loadingTreemap" class="text-white">
      {{ trans('economic_reference.loading_treemap') }}...
    </div>

    <div v-for="chart in loading ? [] : charts"
         :key="chart.title"
         :id="chart.title">
    </div>
  </div>
</template>

<script>
import {globalloadingMutations, globalloadingState} from '@store/helpers';

import {SELECTED_COLOR, treemapMixin} from "../../mixins/treemapMixin";

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
    },
    selectedWells: [],
  }),
  computed: {
    ...globalloadingState(['loading']),

    uwis() {
      return Object.keys(this.data.uwis)
    },

    wells() {
      return this.uwis.map(uwi => {
        let well = {uwi: uwi}

        this.charts.forEach(chart => {
          if (this.data.uwis[uwi][chart.key]) {
            well[chart.key] = this.data.uwis[uwi][chart.key].sum
          }
        })

        well.water_cut = +this.calcWaterCut(well)

        return well
      })
    },

    chartSeries() {
      let series = {}

      this.charts.forEach(chart => series[chart.title] = [])

      this.wells.forEach(well => {
        this.charts.forEach(chart => {
          let value = +well[chart.key]

          if (chart.hasOwnProperty('positive') && value < 0) return

          if (chart.hasOwnProperty('negative') && value >= 0) return

          let color = this.getColor(well, 'Operating_profit')

          series[chart.title].push({
            name: well.uwi,
            value: Math.abs(value),
            fill: this.selectedWells.includes(well.uwi) ? SELECTED_COLOR : color,
            fillOriginal: color
          })
        })
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
        {
          title: this.trans('economic_reference.water_cut'),
          key: 'water_cut'
        },
      ]
    },

    chartsSum() {
      let sum = {}

      this.charts.forEach(chart => {
        sum[chart.title] = {profitable: 0, profitless: 0}
      })

      this.wells.forEach(well => {
        let sumKey = +well.Operating_profit > 0 ? 'profitable' : 'profitless'

        this.charts.forEach(chart => {
          let value = +well[chart.key]

          if (chart.hasOwnProperty('positive') && value < 0) return

          if (chart.hasOwnProperty('negative') && value >= 0) return

          sum[chart.title][sumKey] += value
        })
      })

      return sum
    },
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getWells() {
      this.SET_LOADING(true)

      this.chartTrees = []

      let url = this.localeUrl('/economic/technical/forecast/get-data')

      let params = {...{only_well_id: 1}, ...this.form}

      const {data} = await this.axios.get(url, {params: params})

      this.selectedWells = data

      this.SET_LOADING(false)

      this.loadingTreemap = true

      this.$nextTick(() => this.plotCharts())
    },

    selectWells(wells) {
      wells.forEach(well => {
        this.chartTrees.forEach(tree => {
          let item = tree.search('name', well)

          if (!item) return

          item.set("fill", SELECTED_COLOR)
        })
      })
    },

    updateForm(key) {
      this.form[key] = null

      this.getWells()
    },

    calcWaterCut({liquid, oil}) {
      return liquid
          ? (100 * (liquid - oil) / liquid).toFixed(2)
          : 0
    }
  }
}
</script>

<style scoped>

</style>