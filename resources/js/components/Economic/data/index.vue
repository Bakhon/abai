<template>
  <div class="container-fluid economic-wrap">
    <cat-loader v-show="loading"/>

    <div class="row justify-content-between">
      <select-sc-fa
          :loading="loading"
          :form="form"
          :fetch-params="{is_fact: 1}"
          @loading="loading = true"
          @loaded="loading = false"
          @change="getData"/>

      <vue-table-dynamic v-if="form.sc_fa" :params="params" ref="table">
        <a slot="column-17" slot-scope="{ props }" :href="props.cellData">
          {{ trans('app.edit') }}
        </a>
      </vue-table-dynamic>
    </div>
  </div>
</template>

<script>
import VModal from 'vue-js-modal'
import VueTableDynamic from 'vue-table-dynamic'
import CatLoader from "../../ui-kit/CatLoader";
import SelectScFa from "../components/SelectScFa";

Vue.use(VModal, {dynamicDefault: {draggable: true, resizable: true}});

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
    params: {
      data: [],
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
      columnWidth: [
        {column: 0, width: 100},
        {column: 1, width: 120},
        {column: 2, width: 80},
        {column: 3, width: 80},
        {column: 4, width: 150},
        {column: 5, width: 120},
        {column: 6, width: 120},
        {column: 7, width: 120},
        {column: 8, width: 120},
        {column: 9, width: 100},
        {column: 10, width: 100},
        {column: 11, width: 100},
        {column: 12, width: 100},
        {column: 13, width: 150},
        {column: 14, width: 150},
        {column: 15, width: 120},
        {column: 16, width: 120},
        {column: 17, width: 80},
      ]
    },
    loading: false
  }),
  methods: {
    async getData() {
      this.loading = true

      this.params.data = []

      const {data} = await this.axios.get(this.localeUrl('/eco_refs_cost_data'), {params: this.form})

      this.params.data = [...[this.headers], ...data.data]

      this.loading = false
    },
  },
  computed: {
    headers() {
      return this.columns.map(column => this.trans(`economic_reference.${column}`))
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
<style lang="scss" scoped>
</style>
