<template>
  <div>
    <select-log
        :form="form"
        :fetch-params="{type_id: EconomicDataLogTypeModel.WELL_FORECAST}"
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

import SelectLog from "../../components/SelectLog";

import {EconomicDataLogTypeModel} from "../../models/EconomicDataLogTypeModel";

export default {
  name: "TableTechnicalWellForecast",
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

      data.forEach(well => {
        let row = []

        this.headers.forEach(header => {
          if (header.isUser) {
            return row.push(well[header.key] ? `${well.created_at} ${well[header.key].name}` : '')
          }

          if (header.isStatus) {
            return row.push(well[header.key] ? well[header.key].name : '')
          }

          row.push(well[header.key])
        })

        this.data.push(row)
      })

      this.SET_LOADING(false)
    },
  },
  computed: {
    url() {
      return this.localeUrl('economic/technical/well_forecast/get-data')
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
          width: header.isUser || header.isStatus ? 180 : 120
        }))
      }
    },

    headers() {
      return [
        {
          label: this.trans('economic_reference.well'),
          key: 'uwi'
        },
        {
          label: this.trans('economic_reference.date'),
          key: 'date'
        },
        {
          label: `
           ${this.trans('economic_reference.oil_production')}
           ${this.trans('economic_reference.fact').toLocaleLowerCase()}
          `,
          key: 'oil'
        },
        {
          label: `
           ${this.trans('economic_reference.liquid_production')}
           ${this.trans('economic_reference.fact').toLocaleLowerCase()}
          `,
          key: 'liquid'
        },
        {
          label: this.trans('economic_reference.active_hours'),
          key: 'active_hours'
        },
        {
          label: this.trans('economic_reference.paused_hours'),
          key: 'paused_hours'
        },
        {
          label: this.trans('economic_reference.status'),
          key: 'status',
          isStatus: true,
        },
        {
          label: this.trans('economic_reference.prs_portions'),
          key: 'prs_portion'
        },
        {
          label: this.trans('economic_reference.cause_of_loss'),
          key: 'loss_status',
          isStatus: true,
        },
        {
          label: `
           ${this.trans('economic_reference.oil_production')}
           ${this.trans('economic_reference.forecast').toLocaleLowerCase()}
          `,
          key: 'oil_forecast'
        },
        {
          label: this.trans('economic_reference.oil_losses'),
          key: 'oil_loss'
        },
        {
          label: `
           ${this.trans('economic_reference.liquid_production')}
           ${this.trans('economic_reference.forecast').toLocaleLowerCase()}
          `,
          key: 'liquid_forecast'
        },
        {
          label: this.trans('economic_reference.liquid_losses'),
          key: 'liquid_loss'
        },
        {
          label: `
           ${this.trans('economic_reference.tech_short')}.
           ${this.trans('economic_reference.oil_losses').toLocaleLowerCase()}
          `,
          key: 'oil_tech_loss'
        },
        {
          label: `
           ${this.trans('economic_reference.tech_short')}.
           ${this.trans('economic_reference.liquid_losses').toLocaleLowerCase()}
          `,
          key: 'liquid_tech_loss'
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