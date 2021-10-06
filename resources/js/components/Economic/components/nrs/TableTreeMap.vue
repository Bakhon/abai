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

    <div v-if="loadingTreemap" class="w-100 text-white text-center mb-3">
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

import {treemapMixin} from "../../mixins/treemapMixin";
import {waterCutMixin} from "../../mixins/wellMixin";

import SelectTechStructure from "../SelectTechStructure";

export default {
  name: "TableTreeMap",
  components: {
    SelectTechStructure
  },
  mixins: [treemapMixin, waterCutMixin],
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

        well[this.waterCutKey] = +this.calcWaterCut(well.liquid, well.oil)

        return well
      })
    },

    charts() {
      return [
        {
          title: this.trans('economic_reference.operating_profit') + '+',
          key: this.profitabilityKey,
          positive: true,
          hasSubtitle: true,
          showCount: true
        },
        {
          title: this.trans('economic_reference.operating_profit') + '-',
          key: this.profitabilityKey,
          negative: true,
          sort: 'asc',
          hasSubtitle: true,
          showCount: true
        },
        {
          title: this.trans('economic_reference.liquid_production'),
          key: 'liquid',
          hasSubtitle: true,
        },
        {
          title: this.trans('economic_reference.oil_production'),
          key: 'oil',
          hasSubtitle: true,
        },
        {
          title: this.trans('economic_reference.water_cut'),
          key: this.waterCutKey,
          hasSubtitle: true,
        },
      ]
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

    updateForm(key) {
      this.form[key] = null

      this.getWells()
    },
  }
}
</script>

<style scoped>

</style>