<template>
  <div>
    <cat-loader v-show="loading"/>

    <div class="container-fluid bg-light p-4 mb-4">
      <scenario-form/>
    </div>

    <div class="container-fluid bg-light p-4">
      <div v-for="scFa in scFas" :key="scFa.id" class="row">
        <button
            type="button"
            class="btn btn-link"
            @click="form.sc_fa = scFa.id">
          {{ scFa.name }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import CatLoader from "../../ui-kit/CatLoader";
import ScenarioForm from "../components/ScenarioForm";

export default {
  name: "economic-data-scenario-component",
  components: {
    CatLoader,
    ScenarioForm
  },
  data: () => ({
    form: {
      sc_fa: null
    },
    scFas: [],
    data: [],
    loading: false
  }),
  created() {
    this.getScFas()
  },
  methods: {
    async getScFas() {
      this.loading = true

      let params = {is_fact: 0}

      const {data} = await this.axios.get(this.localeUrl('/eco_refs_sc_fas'), {params: params})

      this.scFas = data.data

      this.loading = false
    },

    async getData() {
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
