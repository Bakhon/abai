<template>
  <vue-table-dynamic
      ref="table"
      :params="params"
      class="height-fit-content height-unset">
    <div slot="column-11" slot-scope="{ props }" class="mx-auto">
      <delete-button @click.native="deleteScenario(props.rowData[0].data)"/>
    </div>
  </vue-table-dynamic>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import LaunchButton from "../../../components/LaunchButton";
import DeleteButton from "../../../components/DeleteButton";

export default {
  name: "TableScenario",
  components: {
    LaunchButton,
    DeleteButton
  },
  data: () => ({
    data: [],
  }),
  created() {
    this.getData()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true)

      this.data = [this.headers.map(header => header.label)]

      const {data} = await this.axios.get(`${this.url}/get-data`)

      data.forEach(scenario => {
        let row = []

        this.headers.forEach(header => {
          if (header.isUser) {
            return row.push(scenario[header.key] ? `${scenario.created_at} ${scenario[header.key].name}` : '')
          }

          if (header.isRelationName) {
            return row.push(scenario[header.key] ? scenario[header.key].name : '')
          }

          if (header.isParams) {
            let value = ''

            scenario.params[header.key].forEach((param, paramIndex) => {
              value += paramIndex ? `, ${param.value}` : param.value
            })

            return row.push(value)
          }

          if (header.isProgress) {
            return row.push(`${scenario.calculated_variants}/${scenario.total_variants}`)
          }

          row.push(scenario[header.key])
        })

        this.data.push(row)
      })

      this.SET_LOADING(false)
    },

    async deleteScenario(id) {
      this.SET_LOADING(true)

      try {
        await this.axios.delete(`${this.url}/${id}`)

        let index = this.data.findIndex(x => x[0] === id)

        if (index !== -1) {
          this.data.splice(index, 1)
        }
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false)
    },
  },
  computed: {
    url() {
      return this.localeUrl('/economic/scenario')
    },

    params() {
      return {
        data: this.data,
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        pageSize: 12,
        pageSizes: [12, 24, 48],
        headerHeight: 80,
        rowHeight: 50,
        columnWidth: this.headers.map((header, index) => ({
          column: index,
          width: header.width || 180
        }))
      }
    },

    headers() {
      return [
        {
          label: 'id',
          key: 'id',
          width: 50
        },
        {
          label: this.trans('economic_reference.name'),
          key: 'name',
        },
        {
          label: this.trans('economic_reference.economic_data'),
          key: 'sc_fa',
          isRelationName: true
        },
        {
          label: this.trans('economic_reference.technical_data'),
          key: 'source',
          isRelationName: true
        },
        {
          label: this.trans('economic_reference.gtm_kit'),
          key: 'gtm_kit',
          isRelationName: true
        },
        {
          label: this.trans('economic_reference.oil_prices'),
          key: 'oil_prices',
          isParams: true
        },
        {
          label: this.trans('economic_reference.course_prices'),
          key: 'dollar_rates',
          isParams: true
        },
        {
          label: this.trans('economic_reference.salary_optimization'),
          key: 'cost_wr_payrolls',
          isParams: true
        },
        {
          label: this.trans('economic_reference.retention_percents'),
          key: 'fixed_nopayrolls',
          isParams: true
        },
        {
          label: this.trans('economic_reference.added_date_author'),
          key: 'user',
          isUser: true
        },
        {
          label: this.trans('economic_reference.progress'),
          key: 'progress',
          isProgress: true
        },
        {
          label: '',
          key: 'deleted_btn',
        },
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
