<template>
  <div class="container p-4 bg-light" style="max-width: 90vw">
    <subtitle class="text-center">
      {{ trans('economic_reference.table_well_forecast_title') }}
    </subtitle>

    <vue-table-dynamic
        :params="params"
        class="height-fit-content"/>
  </div>
</template>

<script>
import VueTableDynamic from 'vue-table-dynamic';

import {globalloadingMutations} from '@store/helpers';

import Subtitle from "../components/Subtitle";

export default {
  name: "economic-data-well-forecast-component",
  components: {
    VueTableDynamic,
    Subtitle,
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
      this.SET_LOADING(true);

      this.data = [this.headers.map(header => header.label)]

      const {data} = await this.axios.get(this.url)

      data.forEach(well => {
        let row = []

        this.headers.forEach(header => {
          if (header.isAuthor) {
            return row.push(well.author ? `${well.created_at} ${well.author.name}` : '')
          }

          row.push(well[header.key])
        })

        this.data.push(row)
      })

      this.SET_LOADING(false);
    },
  },
  computed: {
    url() {
      return this.localeUrl('economic/well_forecast/get-data')
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
        columnWidth: this.headers.map((col, index) => ({column: index, width: 120}))
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
          label: this.trans('economic_reference.active_days'),
          key: 'active_days'
        },
        {
          label: this.trans('economic_reference.paused_days'),
          key: 'paused_days'
        },
        {
          label: this.trans('economic_reference.prs_portions'),
          key: 'prs_portion'
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
          key: 'author',
          isAuthor: true
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
</style>
