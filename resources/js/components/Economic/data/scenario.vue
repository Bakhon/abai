<template>
  <div>
    <cat-loader v-show="loading"/>

    <div class="container-fluid bg-light p-4 mb-4">
      <scenario-form @created="addScenario"/>
    </div>

    <div class="container-fluid bg-light p-4">
      <vue-table-dynamic
          ref="table"
          :params="params"
          class="height-fit-content height-unset">
        <div slot="column-3" slot-scope="{ props }">
          <div v-for="(oil_price, index) in props.cellData"
               :key="index"
               class="mr-1">
            {{ oil_price.value }}
          </div>
        </div>

        <div slot="column-4" slot-scope="{ props }">
          <div v-for="(course_price, index) in props.cellData"
               :key="index">
            {{ course_price.value }}
          </div>
        </div>

        <div slot="column-5" slot-scope="{ props }">
          <div v-for="(optimization, index) in props.cellData"
               :key="index">
            <span class="mr-1">{{ optimization.fixed_nopayroll }},</span>
            <span>{{ optimization.fixed_payroll }}</span>
          </div>
        </div>

        <div slot="column-6" slot-scope="{ props }" class="mx-auto">
          <delete-button @click.native="deleteScenario(props.rowData[0].data)"/>
        </div>

      </vue-table-dynamic>
    </div>
  </div>
</template>

<script>
import CatLoader from "../../ui-kit/CatLoader";
import ScenarioForm from "../components/ScenarioForm";
import DeleteButton from "../components/DeleteButton";

export default {
  name: "economic-data-scenario-component",
  components: {
    CatLoader,
    ScenarioForm,
    DeleteButton
  },
  data: () => ({
    data: [],
    loading: false
  }),
  created() {
    this.getData()
  },
  methods: {
    async getData() {
      this.loading = true

      try {
        const {data} = await this.axios.get(this.localeUrl('/eco_refs_scenarios'))

        this.data = [...[this.headers], ...data.data]
      } catch (e) {
        console.log(e)
      }

      this.loading = false
    },

    async deleteScenario(id) {
      try {
        await this.axios.delete(this.localeUrl(`/eco_refs_scenario/${id}`))

        let index = this.data.findIndex(x => x[0] === id)

        if (index !== -1) {
          this.data.splice(index, 1)
        }
      } catch (e) {
        console.log(e)
      }
    },

    addScenario(model) {
      this.data.push(model)
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
        pageSize: 12,
        pageSizes: [12, 24, 48],
        headerHeight: 80,
        rowHeight: 50,
      }
    },

    headers() {
      return [
        'id',
        this.trans('economic_reference.name'),
        this.trans('economic_reference.scenario'),
        this.trans('economic_reference.oil_prices'),
        this.trans('economic_reference.course_prices'),
        this.trans('economic_reference.optimization_percents'),
        '',
      ]
    },

    columns() {
      return [
        'id',
        'name',
        'sc_fa_name',
        'oil_prices',
        'course_prices',
        'optimizations',
        'delete',
      ]
    },
  }
};
</script>
<style scoped>
.height-fit-content >>> .v-table-body {
  height: fit-content !important;
}

.height-unset >>> .v-table-row {
  height: unset !important;
  padding: 5px 0;
}
</style>
