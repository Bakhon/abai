<template>
  <div>
    <select-log
        :form="form"
        :fetch-params="{type_id: EconomicDataLogTypeModel.ANALYSIS_PARAM}"
        class="mt-3"
        @change="getData()"/>

    <vue-table-dynamic
        :params="params"
        class="height-fit-content"/>
  </div>
</template>

<script>
import VueTableDynamic from 'vue-table-dynamic';

import {globalloadingMutations} from '@store/helpers';

import SelectLog from "../SelectLog";

import {EconomicDataLogTypeModel} from "../../models/EconomicDataLogTypeModel";

export default {
  name: "TableAnalysisParam",
  components: {
    VueTableDynamic,
    SelectLog
  },
  data: () => ({
    EconomicDataLogTypeModel,
    form: {
      log_id: null
    },
    data: []
  }),
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true)

      this.data = [this.headers.map(header => header.label)]

      const {data} = await this.axios.get(this.url, {params: this.form})

      data.forEach(item => {
        let row = []

        this.headers.forEach(header => {
          if (header.isUser) {
            return row.push(item[header.key] ? `${item.created_at} ${item[header.key].name}` : '')
          }

          row.push(item[header.key])
        })

        this.data.push(row)
      })

      this.SET_LOADING(false)
    },
  },
  computed: {
    url() {
      return this.localeUrl('economic/analysis/param/get-data')
    },

    params() {
      return {
        data: this.data,
        enableSearch: true,
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        sort: this.headers.map((col, index) => (index)),
        pageSize: 12,
        pageSizes: [12, 24, 48],
        headerHeight: 120,
        rowHeight: 50,
        columnWidth: this.headers.map((header, index) => ({
          column: index,
          width: header.width || (header.isUser ? 180 : 120)
        }))
      }
    },

    headers() {
      return [
        {
          label: this.trans('economic_reference.date'),
          key: 'date'
        },
        {
          label: `
           ${this.trans('economic_reference.net_back')}
           ${this.trans('economic_reference.plan').toLocaleLowerCase()}
           (${this.trans('economic_reference.tenge')} /
           ${this.trans('economic_reference.ton').toLocaleLowerCase()})
          `,
          key: 'netback_plan'
        },
        {
          label: `
           ${this.trans('economic_reference.net_back')}
           ${this.trans('economic_reference.fact').toLocaleLowerCase()}
           (${this.trans('economic_reference.tenge')} /
           ${this.trans('economic_reference.ton').toLocaleLowerCase()})
          `,
          key: 'netback_fact'
        },
        {
          label: `
           ${this.trans('economic_reference.net_back')}
           ${this.trans('economic_reference.forecast').toLocaleLowerCase()}
           (${this.trans('economic_reference.tenge')} /
           ${this.trans('economic_reference.ton').toLocaleLowerCase()})
          `,
          key: 'netback_forecast'
        },
        {
          label: `
            ${this.trans('economic_reference.variable_cost')}
            (${this.trans('economic_reference.tenge_per_ton_liquid')})
          `,
          key: 'variable_cost'
        },
        {
          label: `
            ${this.trans('economic_reference.conditional_fixed_costs')}
            (${this.trans('economic_reference.thousand_tenge')} /
            ${this.trans('economic_reference.well_short').toLocaleLowerCase()} /
            ${this.trans('economic_reference.day').toLocaleLowerCase()}
            ${this.trans('economic_reference.with_fot')})
          `,
          key: 'permanent_cost',
        },
        {
          label: `
            ${this.trans('economic_reference.avg_cost_prs')}
            (${this.trans('economic_reference.thousand_tenge')} /
            ${this.trans('economic_reference.rem_short')}
            ${this.trans('economic_reference.without_fot')})
          `,
          key: 'avg_prs_cost',
          width: 110
        },
        {
          label: `
            ${this.trans('economic_reference.oil_density')}
            (${this.trans('economic_reference.ton').toLocaleLowerCase()} /
            ${this.trans('economic_reference.cubic_meter')})
          `,
          key: 'oil_density',
          width: 110
        },
        {
          label: this.trans('economic_reference.days_in_month'),
          key: 'days'
        },
        {
          label: `
            ${this.trans('economic_reference.conditional_fixed_costs')}
            (${this.trans('economic_reference.thousand_tenge')} /
            ${this.trans('economic_reference.well_short').toLocaleLowerCase()}
            ${this.trans('economic_reference.year')}
            ${this.trans('economic_reference.with_fot')})
          `,
          key: 'permanent_year_cost'
        },
        {
          label: `
            ${this.trans('economic_reference.conditional_fixed_costs')}
            (${this.trans('economic_reference.fact').toLocaleLowerCase()})
          `,
          key: 'permanent_stop_cost'
        },
        {
          label: `
            ${this.trans('economic_reference.conditional_fixed_costs')}
            (${this.trans('economic_reference.proposed').toLocaleLowerCase()})
          `,
          key: 'permanent_stop_cost_propose',
          width: 130
        },
        {
          label: this.trans('economic_reference.added_date_author'),
          key: 'user',
          isUser: true
        },
      ]
    },
  }
}
</script>

<style scoped>
.height-fit-content >>> .v-table-body {
  height: fit-content !important;
}
</style>