<template>
  <div class="container p-4 bg-light" style="max-width: 90vw">    
    <subtitle class="mb-3 text-center">{{ title }}</subtitle>

    <select-sc-fa
        :form="form"
        :is-forecast="isForecast"
        form-key="sc_fa"
        @loading="SET_LOADING(true)"
        @loaded="SET_LOADING(false)"
        @change="getData"/>
    

    <vue-table-dynamic
        v-if="form.sc_fa"
        ref="table"
        :params="params"
        class="height-fit-content">
      <a :slot="`column-${columnEditIndex}`"
         slot-scope="{ props }"
         :href="props.cellData">
        {{ trans('app.edit') }}
      </a>
    </vue-table-dynamic>
  </div>
</template>

<script>
import VueTableDynamic from 'vue-table-dynamic';
import {globalloadingMutations} from '@store/helpers';
import Subtitle from "../components/Subtitle";
import SelectScFa from "../components/SelectScFa";

export default {
  name: "economic-data-component",
  components: {
    VueTableDynamic,
    Subtitle,
    SelectScFa

  },
  props: {
    isForecast: {
      required: false,
      type: Boolean
    }
  },
  data: () => ({
    form: {
      sc_fa: null
    },
    data: [],
  }),
  methods: {
    ...globalloadingMutations(
      ['SET_LOADING']
    ),

    async getData() {
      if (!this.form.sc_fa) return

      this.SET_LOADING(true);

      this.data = []

      const {data} = await this.axios.get(this.localeUrl('module_economy/eco_refs_costs'), {params: this.form})

      this.data = [...[this.headers], ...data.data]

      this.SET_LOADING(false);
    },
  },
  computed: {
    params() {
      return {
        data: this.data,
        enableSearch: true,
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        sort: this.columns.map((col, index) => (index)),
        pageSize: 12,
        pageSizes: [12, 24, 48],
        headerHeight: 120,
        rowHeight: 50,
        columnWidth: this.columns.map((col, index) => ({column: index, width: 180}))
      }
    },

    headers() {
      return this.columns.map(col => {
        let value = this.trans(`economic_reference.${col.value}`)

        let dimension = col.dimension
            ? this.trans(`economic_reference.${col.dimension}`)
            : ''

        return dimension
            ? `${value}, ${dimension}`
            : value
      })
    },

    columnEditIndex() {
      return this.columns.findIndex(col => col.value === 'edit')
    },

    columns() {
      let dimensionPerPeriod = this.isForecast ? 'tenge_per_month' : 'tenge_per_day'

      return [
        {value: this.isForecast ? 'scenario' : 'source_data'},
        {value: 'company'},
        {value: 'month-year'},
        {value: 'variable', dimension: 'tenge_per_cube_liquid'},
        {value: 'variable_processing', dimension: 'tenge_per_ton_oil'},
        {value: 'fix_noWRpayroll', dimension: dimensionPerPeriod},
        {value: 'fix_payroll', dimension: dimensionPerPeriod},
        {value: 'fix_nopayroll', dimension: dimensionPerPeriod},
        {value: 'fix', dimension: dimensionPerPeriod},
        {value: 'gaoverheads', dimension: dimensionPerPeriod},
        {value: 'wr_nopayroll', dimension: 'thousand_tenge'},
        {value: 'wr_payroll', dimension: 'thousand_tenge'},
        {value: 'wo', dimension: 'thousand_tenge'},
        {value: 'net_back', dimension: 'tenge_per_day'},
        {value: 'amort', dimension: 'tenge_per_ton'},
        {value: 'comment'},
        {value: 'added_date_author'},
        {value: 'changed_date_author'},
        {value: 'edit'},
        {value: 'id_of_add'}
      ]
    },

    title() {
      return this.isForecast
          ? this.trans('economic_reference.eco_refs_scenario')
          : this.trans('economic_reference.eco_refs_cost')
    },
  }
};
</script>
<style scoped>
.height-fit-content >>> .v-table-body {
  height: fit-content !important;
}
</style>
