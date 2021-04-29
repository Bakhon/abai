<template>
  <div>
    <cat-loader v-show="loading"/>

    <div class="container-fluid bg-light p-4 mb-4">
      <scenario-form @created="addScenario"/>
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
    scenarios: [],
    loading: false
  }),
  methods: {
    async getScenarios() {
      this.loading = true

      try {
        const {data} = await this.axios.get(this.localeUrl('/eco_refs_scenarios'))

        this.scFas = data.data
      } catch (e) {
        console.log(e)
      }

      this.loading = false
    },

    addScenario(form) {
      this.scFas.push(form)
    }
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
