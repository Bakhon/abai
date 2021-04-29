<template>
  <div class="container-fluid">
    <cat-loader v-show="loading"/>

    <div class="row justify-content-between">
      <select-sc-fa
          :loading="loading"
          :form="form"
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

      const {data} = await this.axios.get(this.localeUrl('/eco_refs_cost_data'), {params: this.form})

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
      return this.columns.map(col => this.trans(`economic_reference.${col}`))
    },

    columnEditIndex() {
      return this.columns.findIndex(col => col === 'edit')
    },

    columns() {
      return [
        'source_data',
        'company',
        'month-year',
        'variable',
        'fix_noWRpayroll',
        'fix_payroll',
        'fix_nopayroll',
        'fix',
        'gaoverheads',
        'wr_nopayroll',
        'wr_payroll',
        'wo',
        'net_back',
        'amort',
        'comment',
        'added_date_author',
        'changed_date_author',
        'edit',
        'id_of_add'
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
