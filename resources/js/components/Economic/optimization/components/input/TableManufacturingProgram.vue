<template>
  <div>
    <select-log
        :form="form"
        :fetch-params="{type_id: EconomicDataLogTypeModel.MANUFACTURING_PROGRAM}"
        @change="getData()"/>

    <vue-table-dynamic
        :params="params"
        class="mt-2 height-fit-content"/>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import {formatValueMixin} from "../../../mixins/formatMixin";

import VueTableDynamic from 'vue-table-dynamic';
import SelectLog from "../../../components/SelectLog";

import {EconomicDataLogTypeModel} from "../../../models/EconomicDataLogTypeModel";

export default {
  name: "TableManufacturingProgram",
  components: {
    VueTableDynamic,
    SelectLog,
  },
  mixins: [
    formatValueMixin
  ],
  data: () => ({
    EconomicDataLogTypeModel,
    form: {
      log_id: null
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
          if (header.isUser) {
            return row.push(item[header.key] ? `${item.created_at} ${item[header.key].name}` : '')
          }

          if (header.isRelationName) {
            return row.push(item[header.key] ? item[header.key].name : '')
          }

          row.push(this.localeValue(item[header.key]))
        })

        this.data.push(row)
      })

      this.SET_LOADING(false)
    },
  },
  computed: {
    url() {
      return this.localeUrl('economic/manufacturing_program/get-data')
    },

    params() {
      return {
        data: this.data,
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        headerHeight: 120,
        rowHeight: 50,
        columnWidth: this.headers.map((header, index) => ({
          column: index,
          width: 160
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
          label: `
            ${this.trans(`economic_reference.course_prices`)},
            ${this.trans(`economic_reference.tenge`)}
          `,
          key: 'dollar_rate',
        },
        {
          label: `
            ${this.trans(`economic_reference.oil_price`)},
            ${this.trans(`economic_reference.dollar_per_bar`)}
          `,
          key: 'oil_price',
        },
        {
          label: `
            ${this.trans(`economic_reference.oil_production`)}:
            ${this.trans(`economic_reference.total`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.thousand_tons`)}
          `,
          key: 'oil',
        },
        {
          label: `
            ${this.trans(`economic_reference.oil_production`)}:
            ${this.trans(`economic_reference.from_transfer_wells`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.thousand_tons`)}
          `,
          key: 'oil_from_transfer_wells',
        },
        {
          label: `
            ${this.trans(`economic_reference.oil_production`)}:
            ${this.trans(`economic_reference.from_new_wells`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.thousand_tons`)}
          `,
          key: 'oil_from_new_wells',
        },
        {
          label: `
            ${this.trans(`economic_reference.oil_production`)}:
            ${this.trans(`economic_reference.from_gtm`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.thousand_tons`)}
          `,
          key: 'oil_from_gtm',
        },
        {
          label: `
            ${this.trans(`economic_reference.oil_sale`)}:
            ${this.trans(`economic_reference.total`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.thousand_tons`)}
          `,
          key: 'oil_sale',
        },
        {
          label: `
            ${this.trans(`economic_reference.oil_sale`)}:
            ${this.trans(`economic_reference.export`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.thousand_tons`)}
          `,
          key: 'oil_sale_export',
        },
        {
          label: `
            ${this.trans(`economic_reference.oil_sale`)}:
            ${this.trans(`economic_reference.home_market`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.thousand_tons`)}
          `,
          key: 'oil_sale_local',
        },
        {
          label: `
            ${this.trans(`economic_reference.production_wells_fund`)}:
            ${this.trans(`economic_reference.total`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.wells_count_short`)}
          `,
          key: 'wells',
        },
        {
          label: `
            ${this.trans(`economic_reference.production_wells_fund`)}:
            ${this.trans(`economic_reference.transfer_wells`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.wells_count_short`)}
          `,
          key: 'transfer_wells',
        },
        {
          label: `
            ${this.trans(`economic_reference.production_wells_fund`)}:
            ${this.trans(`economic_reference.new_wells`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.wells_count_short`)}
          `,
          key: 'new_wells',
        },
        {
          label: `
            ${this.trans(`economic_reference.count_prs`)},
            ${this.trans(`economic_reference.units`)}
          `,
          key: 'prs',
        },
        {
          label: `
            ${this.trans(`economic_reference.number_prs_brigades`)},
            ${this.trans(`economic_reference.units`)}
          `,
          key: 'brigade_prs',
        },
        {
          label: `
            ${this.trans(`economic_reference.count_krs`)},
            ${this.trans(`economic_reference.units`)}
          `,
          key: 'krs',
        },
        {
          label: `
            ${this.trans(`economic_reference.number_pp`)},
            ${this.trans(`economic_reference.people_short`)}
          `,
          key: 'pp',
        },
        {
          label: `
            ${this.trans(`economic_reference.number_aup`)},
            ${this.trans(`economic_reference.people_short`)}
          `,
          key: 'aup',
        },
        {
          label: `
            ${this.trans(`economic_reference.income`)},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'revenue',
        },
        {
          label: `
            ${this.trans(`economic_reference.costs`)}:
            ${this.trans(`economic_reference.total`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'expenditures',
        },
        {
          label: `
            ${this.trans(`economic_reference.cost_price`)}:
            ${this.trans(`economic_reference.total`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'cost_price',
        },
        {
          label: `
            ${this.trans(`economic_reference.cost_price`)}:
            ${this.trans(`economic_reference.variables`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'cost_price_variable',
        },
        {
          label: `
            ${this.trans(`economic_reference.cost_price`)}:
            ${this.trans(`economic_reference.personnel_costs`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'cost_price_staff',
        },
        {
          label: `
            ${this.trans(`economic_reference.cost_price`)}:
            ${this.trans(`economic_reference.ndpi`)},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'cost_price_ndpi',
        },
        {
          label: `
            ${this.trans(`economic_reference.cost_price`)}:
            ${this.trans(`economic_reference.fixed_costs`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'cost_price_permanent',
        },
        {
          label: `
            ${this.trans(`economic_reference.cost_price`)}:
            ${this.trans(`economic_reference.amort`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'cost_price_amort',
        },
        {
          label: `
            ${this.trans(`economic_reference.realization_cost`)}:
            ${this.trans(`economic_reference.total`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'realization_cost',
        },
        {
          label: `
            ${this.trans(`economic_reference.realization_cost`)}:
            ${this.trans(`economic_reference.rent_tax`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'realization_cost_rent_tax',
        },
        {
          label: `
            ${this.trans(`economic_reference.realization_cost`)}:
            ${this.trans(`economic_reference.etp`)},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'realization_cost_etp',
        },
        {
          label: `
            ${this.trans(`economic_reference.realization_cost`)}:
            ${this.trans(`economic_reference.trans_expenditures`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'realization_cost_trans_expenditures',
        },
        {
          label: `
            ${this.trans(`economic_reference.oar_financing_expenditures`)},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'oar_financing_expenditures',
        },
        {
          label: `
            ${this.trans(`economic_reference.revenue_before_tax`)},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'revenue_before_tax',
        },
        {
          label: `
            ${this.trans(`economic_reference.kpn`)},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'kpn',
        },
        {
          label: `
            ${this.trans(`economic_reference.ept`)},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'ept',
        },
        {
          label: `
            ${this.trans(`economic_reference.operating_profit_loss`)},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'operating_profit',
        },
        {
          label: `
            ${this.trans(`economic_reference.capital_investment`)}:
            ${this.trans(`economic_reference.total`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'capital_investment',
        },
        {
          label: `
            ${this.trans(`economic_reference.capital_investment`)}:
            ${this.trans(`economic_reference.drilling`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'capital_investment_drilling',
        },
        {
          label: `
            ${this.trans(`economic_reference.capital_investment`)}:
            ${this.trans(`economic_reference.os_acquisition`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'capital_investment_os',
        },
        {
          label: `
            ${this.trans(`economic_reference.capital_investment`)}:
            ${this.trans(`economic_reference.building`).toLocaleLowerCase()}-
            ${this.trans(`economic_reference.modernization`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'capital_investment_building',
        },
        {
          label: `
            ${this.trans(`economic_reference.capital_investment`)}:
            ${this.trans(`economic_reference.other_expenses`).toLocaleLowerCase()},
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'capital_investment_other',
        },
        {
          label: `
            ${this.trans(`economic_reference.cash_flow`)}:
            ${this.trans(`economic_reference.million_tenge`)}
          `,
          key: 'cash_flow',
        },
        {
          label: this.trans('economic_reference.added_date_author'),
          key: 'user',
          isUser: true
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
