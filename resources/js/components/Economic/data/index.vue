<template>
  <div class="container-fluid">
    <cat-loader v-show="loading"/>

    <div class="row justify-content-between">
      <select-sc-fa
          :loading="loading"
          :form="form"
          :is-forecast="isForecast"
          form-key="sc_fa"
          @loading="loading = true"
          @loaded="loading = false"
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
  </div>
</template>

<script>
import VueTableDynamic from 'vue-table-dynamic'
import CatLoader from "../../ui-kit/CatLoader";
import SelectScFa from "../components/SelectScFa";

export default {
  name: "economic-data-component",
  components: {
    VueTableDynamic,
    CatLoader,
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
    loading: false
  }),
  methods: {
    async getData() {
      if (!this.form.sc_fa) return

      this.loading = true

      this.data = []

      const {data} = await this.axios.get(this.localeUrl('/eco_refs_costs'), {params: this.form})

      this.data = [...[this.headers], ...data.data]

      this.loading = false
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
        sort: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13],
        pageSize: 12,
        pageSizes: [12, 24, 48],
        headerHeight: 120,
        rowHeight: 50,
        columnWidth: this.columns.map((col, index) => ({column: index, width: 150}))
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
      return [
        {value: this.isForecast ? 'scenario' : 'source_data'},
        {value: 'company'},
        {value: 'month-year'},
        {value: 'variable', dimension: 'tenge_per_ton'},
        {value: 'fix_noWRpayroll', dimension: this.isForecast ? 'tenge_per_month' : 'tenge_per_day'},
        {value: 'fix_payroll', dimension: this.isForecast ? 'tenge_per_month' : 'tenge_per_day'},
        {value: 'fix_nopayroll', dimension: this.isForecast ? 'tenge_per_month' : 'tenge_per_day'},
        {value: 'fix', dimension: this.isForecast ? 'tenge_per_month' : 'tenge_per_day'},
        {value: 'gaoverheads', dimension: this.isForecast ? 'tenge_per_month' : 'tenge_per_day'},
        {value: 'wr_nopayroll', dimension: this.isForecast ? 'million_tenge' : 'thousand_tenge'},
        {value: 'wr_payroll', dimension: this.isForecast ? 'million_tenge' : 'thousand_tenge'},
        {value: 'wo', dimension: this.isForecast ? 'million_tenge' : 'thousand_tenge'},
        {value: 'net_back', dimension: this.isForecast ? 'tenge_per_month' : 'tenge_per_day'},
        {value: 'amort', dimension: 'tenge_per_ton'},
        {value: 'comment'},
        {value: 'added_date_author'},
        {value: 'changed_date_author'},
        {value: 'edit'},
        {value: 'id_of_add'}
      ]
    },
  }
};
</script>
<style scoped>
.height-fit-content >>> .v-table-body {
  height: fit-content !important;
}
</style>
