<template>
  <div>
    <select-source
        :form="form"
        @change="getData"/>

    <vue-table-dynamic
        :params="params"
        class="height-fit-content"/>
  </div>
</template>

<script>
import VueTableDynamic from 'vue-table-dynamic'

import {globalloadingMutations} from '@store/helpers';

import SelectSource from "../../../components/SelectSource";

export default {
  name: "TableTechnicalDataForecast",
  components: {
    VueTableDynamic,
    SelectSource
  },
  data: () => ({
    form: {
      source_id: null
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
          if (header.isAuthor) {
            return row.push(item[header.key] ? `${item.created_at} ${item[header.key].name}` : '')
          }

          if (header.isObjectName) {
            return row.push(item[header.key] ? item[header.key].name : '')
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
      return this.localeUrl('/economic/technical/forecast/get-data')
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
        headerHeight: 80,
        rowHeight: 50,
        columnWidth: this.headers.map((header, index) => ({
          column: index,
          width: 150
        }))
      }
    },

    headers() {
      return [
        {
          label:this.trans('forecast.gu'),
          key: 'gu',
          isObjectName: true
        },
        {
          label:this.trans('forecast.well'),
          key: 'well_id',
        },
        {
          label:this.trans('forecast.pes'),
          key: 'pes',
          isObjectName: true
        },
        {
          label:this.trans('forecast.date'),
          key: 'date',
        },
        {
          label:this.trans('forecast.oil-production'),
          key: 'oil',
        },
        {
          label:this.trans('forecast.extraction-liquid'),
          key: 'liquid',
        },
        {
          label:this.trans('forecast.days-worked'),
          key: 'days_worked',
        },
        {
          label:this.trans('forecast.prs'),
          key: 'prs',
        },
        {
          label:this.trans('forecast.comment'),
          key: 'comment',
        },
        {
          label: this.trans('economic_reference.added_date_author'),
          key: 'author',
          isAuthor: true
        },
      ]
    }
  }
};
</script>
<style scoped>
.height-fit-content >>> .v-table-body {
  height: fit-content !important;
}
</style>
