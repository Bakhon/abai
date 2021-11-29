<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      {{ trans('economic_reference.production_loss_from_stops') }}
    </subtitle>

    <div class="mt-2 text-white font-size-14px line-height-16px">
      <div class="d-flex text-center font-weight-600">
        <div class="bg-blue p-2 border-grey min-width-50px"></div>

        <div
            class="bg-blue p-2 border-grey flex-grow-1 d-flex align-items-center justify-content-center min-width-300px">
          {{ trans('economic_reference.nomination') }}
        </div>

        <div v-for="(header, headerIndex) in tableHeaders"
             :key="headerIndex"
             :class="header.styleClass"
             class="bg-blue d-flex flex-column flex-95px">
          <div class="px-1 py-3 border-grey flex-grow-1 w-100 d-flex align-items-center justify-content-center">
            {{ header.title }}
          </div>

          <div class="p-1 border-grey">
            {{ header.dimensionTitle }}
          </div>
        </div>
      </div>

      <table-financial-loss-row
          v-for="(row, rowIndex) in tableRows"
          :key="rowIndex"
          :row="row"
          :headers="tableHeaders"
      />

      <table-financial-loss-row
          v-for="(row, rowIndex) in tableProposedRows"
          :key="`${rowIndex}_optimized`"
          :row="row"
          :headers="tableHeaders"
          :class="rowIndex ? '' : 'mt-14px'"
      />

      <table-financial-loss-row
          v-for="(row, rowIndex) in tableDiffRows"
          :key="`${rowIndex}_subtraction`"
          :row="row"
          :headers="tableHeaders"
          :class="rowIndex ? '' : 'mt-14px'"
      />

      <div v-for="(row, rowIndex) in tableGrowthRows"
           :key="`${rowIndex}_growth`"
           class="mt-14px d-flex text-center font-weight-600">
        <div class="px-2 py-1 border-grey min-width-50px text-center bg-dark-blue">
          {{ row.order }}
        </div>

        <div class="px-2 py-1 border-grey min-width-300px flex-grow-1 text-left bg-dark-blue">
          {{ row.title }}
        </div>

        <div class="bg-dark-blue ml-2 flex-285px d-flex justify-content-end">
          <div class="py-1 pr-1 border-grey bg-orange flex-95px">
            {{ row.value }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {formatValueMixin} from "../../mixins/formatMixin";

import Subtitle from "../../components/Subtitle";
import TableFinancialLossRow from "./TableFinancialLossRow";

export default {
  title: "TableFinancialLoss",
  components: {
    Subtitle,
    TableFinancialLossRow
  },
  mixins: [
    formatValueMixin
  ],
  props: {
    wells: {
      required: true,
      type: Array
    },
    proposedWells: {
      required: true,
      type: Array
    }
  },
  created() {
    this.$emit('updateWide', false)
  },
  computed: {
    sumKeys() {
      return [
        ...this.tableHeaders.map(header => header.key),
        ...['prs_cost']
      ]
    },

    sumData() {
      return this.sumWellParamsByProfitability('wells')
    },

    sumProposedData() {
      return this.sumWellParamsByProfitability('proposedWells')
    },

    tableHeaders() {
      return [
        {
          title: this.trans('economic_reference.count_well_short'),
          dimensionTitle: this.trans('economic_reference.units'),
          key: 'uwi_count'
        },
        {
          title: this.trans('economic_reference.liquid_production'),
          dimension: 1000,
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.cubic_meter')}
          `,
          key: 'liquid'
        },
        {
          title: this.trans('economic_reference.oil_production'),
          dimension: 1000,
          dimensionTitle: this.trans('economic_reference.thousand_tons'),
          key: 'oil'
        },
        {
          title: this.trans('economic_reference.time_all'),
          dimension: 24,
          dimensionTitle: this.trans('economic_reference.days'),
          key: 'total_hours',
        },
        {
          title: this.trans('economic_reference.time_worked'),
          dimension: 24,
          dimensionTitle: this.trans('economic_reference.days'),
          key: 'active_hours'
        },
        {
          title: this.trans('economic_reference.downtime_days'),
          dimension: 24,
          dimensionTitle: this.trans('economic_reference.days'),
          key: 'paused_hours'
        },
        {
          title: this.trans('economic_reference.income'),
          dimension: 1000,
          dimensionTitle: this.trans('economic_reference.million_tenge'),
          key: 'netback',
          styleClass: 'ml-2',
        },
        {
          title: this.trans('economic_reference.costs'),
          dimension: 1000,
          dimensionTitle: this.trans('economic_reference.million_tenge'),
          key: 'overall_expenditures',
        },
        {
          title: this.trans('economic_reference.profit_loss'),
          dimension: 1000,
          dimensionTitle: this.trans('economic_reference.million_tenge'),
          key: 'operating_profit',
        },
      ]
    },

    tableRows() {
      return [
        {
          title: this.trans('economic_reference.factual_indicators'),
          order: '1.',
          values: this.tableHeaders.map(header => ({
            value: this.sumData[header.key].total
          })),
          style: 'background: #333868',
        },
        {
          title: this.trans('economic_reference.profitless'),
          values: this.tableHeaders.map(header => ({
            value: this.sumData[header.key].profitless
          })),
          style: 'background: #7D5F52'
        },
        {
          title: this.trans('economic_reference.profitable'),
          values: this.tableHeaders.map(header => ({
            value: this.sumData[header.key].profitable
          })),
          style: 'background: #1A5855'
        },
        {
          title: this.trans('economic_reference.idle'),
          values: this.tableHeaders.map(header => ({
            value: 0
          })),
          style: 'background: #2B2E5E'
        }
      ]
    },

    tableProposedRows() {
      return [
        {
          title: this.trans('economic_reference.proposed_variant'),
          order: '2.',
          values: this.tableHeaders.map(header => ({
            value: this.sumProposedData[header.key].total
          })),
          style: 'background: #333868',
        },
        {
          title: this.trans('economic_reference.profitless'),
          values: this.tableHeaders.map(header => ({
            value: this.sumProposedData[header.key].profitless
          })),
          style: 'background: #7D5F52'
        },
        {
          title: this.trans('economic_reference.profitable'),
          values: this.tableHeaders.map(header => ({
            value: this.sumProposedData[header.key].profitable
          })),
          style: 'background: #1A5855'
        },
        {
          title: this.trans('economic_reference.idle'),
          values: this.tableHeaders.map(header => ({
            value: 0
          })),
          style: 'background: #2B2E5E'
        }
      ]
    },

    tableDiffRows() {
      return [
        {
          title: this.trans('economic_reference.proposed_variant_minus_factual_indicators'),
          order: '3.',
          values: this.tableHeaders.map((header, headerIndex) => ({
            value: this.getTableDiff(headerIndex, 0),
            style: headerIndex === this.tableHeaders.length - 1
                ? 'background: #B97919 !important'
                : ''
          })),
          style: 'background: #333868',
        },
        {
          title: this.trans('economic_reference.profitless'),
          values: this.tableHeaders.map((header, headerIndex) => ({
            value: this.getTableDiff(headerIndex, 1),
          })),
          style: 'background: #7D5F52'
        },
        {
          title: this.trans('economic_reference.profitable'),
          values: this.tableHeaders.map((header, headerIndex) => ({
            value: this.getTableDiff(headerIndex, 2),
          })),
          style: 'background: #1A5855'
        },
        {
          title: this.trans('economic_reference.idle'),
          values: this.tableHeaders.map((header, headerIndex) => ({
            value: this.getTableDiff(headerIndex, 3),
          })),
          style: 'background: #2B2E5E'
        }
      ]
    },

    tableGrowthRows() {
      return [
        {
          title: this.trans('economic_reference.profit_growth_from_profitless_wells'),
          order: '4.',
          value: this.localeValue(
              this.sumProposedData.operating_profit.profitable -
              this.sumData.operating_profit.profitable,
              1000
          ),
        },
        {
          title: this.trans('economic_reference.profit_growth_from_disable_prs'),
          order: '5.',
          value: this.localeValue(
              this.sumData.prs_cost.profitless -
              this.sumProposedData.prs_cost.profitless,
              1000
          ),
        },
        {
          title: this.trans('economic_reference.decreased_profits_due_to_abandonment_fot'),
          order: '6.',
          value: this.localeValue(
              this.sumData.operating_profit.profitless -
              this.sumProposedData.operating_profit.profitless -
              this.sumData.prs_cost.profitless +
              this.sumProposedData.prs_cost.profitless,
              1000
          ),
        },
      ]
    },
  },
  methods: {
    sumWellParamsByProfitability(wellKey) {
      let sum = {}

      this.sumKeys.forEach(key => {
        sum[key] = {
          profitable: 0,
          profitless: 0,
          total: 0,
        }
      })

      this[wellKey].forEach(well => {
        this.sumKeys.forEach(key => {
          sum[key][well.profitability] += +well[key]

          sum[key].total += +well[key]
        })
      })

      return sum
    },

    getTableDiff(headerIndex, rowIndex) {
      if (!headerIndex) {
        return 0
      }

      let proposedValue = this.tableProposedRows[rowIndex].values[headerIndex].value

      let originalValue = this.tableRows[rowIndex].values[headerIndex].value

      return proposedValue - originalValue
    }
  }
}
</script>

<style scoped>
.bg-blue {
  background: #333975;
}

.bg-dark-blue {
  background: #333868;
}

.bg-orange {
  background: #B97919 !important;
}

.border-grey {
  border: 1px solid #454D7D
}

.flex-95px {
  flex: 0 0 95px;
}

.flex-285px {
  flex: 0 0 285px;
}

.font-weight-600 {
  font-weight: 600;
}

.font-size-14px {
  font-size: 14px;
}

.line-height-16px {
  line-height: 16px;
}

.line-height-18px {
  line-height: 18px;
}

.min-width-50px {
  min-width: 50px;
}

.min-width-300px {
  min-width: 300px;
}

.mt-14px {
  margin-top: 14px;
}
</style>