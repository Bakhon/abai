<template>
  <div>
    <select-sc-fa
        :form="form"
        form-key="sc_fa"
        is-forecast
        @loading="SET_LOADING(true)"
        @loaded="SET_LOADING(false)"
        @change="getData"/>

    <vue-table-dynamic
        :params="params"
        class="height-fit-content"/>
  </div>
</template>

<script>
import VueTableDynamic from 'vue-table-dynamic';

import {globalloadingMutations} from '@store/helpers';

import SelectScFa from "../../../components/SelectScFa";

export default {
  name: "TableCosts",
  components: {
    VueTableDynamic,
    SelectScFa
  },
  data: () => ({
    form: {
      sc_fa: null
    },
    data: [],
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

          if (header.isRelationName) {
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
      return this.localeUrl('economic/cost/get-data')
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
          width: 180
        }))
      }
    },

    headers() {
      return [
        {
          label: this.trans(`economic_reference.company`),
          key: 'company',
          isRelationName: true
        },
        {
          label: this.trans(`economic_reference.pes`),
          key: 'pes',
          isRelationName: true
        },
        {
          label: this.trans(`economic_reference.date`),
          key: 'date',
        },
        {
          label: `
            ${this.trans(`economic_reference.variable`)},
            ${this.trans(`economic_reference.tenge_per_cube_liquid`)}
          `,
          key: 'variable',
        },
        {
          label: `
            ${this.trans(`economic_reference.variable_processing`)},
            ${this.trans(`economic_reference.tenge_per_ton_oil`)}
          `,
          key: 'variable_processing',
        },
        {
          label: `
            ${this.trans(`economic_reference.fix_noWRpayroll`)},
            ${this.trans(`economic_reference.tenge_per_month`)}
          `,
          key: 'fix_noWRpayroll',
        },
        {
          label: `
            ${this.trans(`economic_reference.fix_payroll`)},
            ${this.trans(`economic_reference.tenge_per_month`)}
          `,
          key: 'fix_payroll',
        },
        {
          label: `
            ${this.trans(`economic_reference.fix_nopayroll`)},
            ${this.trans(`economic_reference.tenge_per_month`)}
          `,
          key: 'fix_nopayroll',
        },
        {
          label: `
            ${this.trans(`economic_reference.fix`)},
            ${this.trans(`economic_reference.tenge_per_month`)}
          `,
          key: 'fix',
        },
        {
          label: `
            ${this.trans(`economic_reference.gaoverheads`)},
            ${this.trans(`economic_reference.tenge_per_month`)}
          `,
          key: 'gaoverheads',
        },
        {
          label: `
            ${this.trans(`economic_reference.wr_nopayroll`)},
            ${this.trans(`economic_reference.thousand_tenge`)}
          `,
          key: 'wr_nopayroll',
        },
        {
          label: `
            ${this.trans(`economic_reference.wr_payroll`)},
            ${this.trans(`economic_reference.thousand_tenge`)}
          `,
          key: 'wr_payroll',
        },
        {
          label: `
            ${this.trans(`economic_reference.wo`)},
            ${this.trans(`economic_reference.thousand_tenge`)}
          `,
          key: 'wo',
        },
        {
          label: `
            ${this.trans(`economic_reference.net_back`)},
            ${this.trans(`economic_reference.tenge_per_day`)}
          `,
          key: 'net_back',
        },
        {
          label: `
            ${this.trans(`economic_reference.amort`)},
            ${this.trans(`economic_reference.tenge_per_ton`)}
          `,
          key: 'amort',
        },
        {
          label: this.trans(`economic_reference.comment`),
          key: 'comment',
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
