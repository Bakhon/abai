<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Потери добычи от остановок за май-октябрь 2020 г.
    </subtitle>

    <div class="mt-2 text-white font-size-14px line-height-16px">
      <div class="d-flex text-center font-weight-600">
        <div class="bg-blue p-2 border-grey min-width-50px"></div>

        <div
            class="bg-blue p-2 border-grey flex-grow-1 d-flex align-items-center justify-content-center min-width-300px">
          Наименование
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
          title: 'Кол-во скважин',
          dimensionTitle: 'ед.',
          key: 'uwi_count'
        },
        {
          title: 'Добыча жидкости',
          dimension: 1000,
          dimensionTitle: 'тыс. м3',
          key: 'liquid'
        },
        {
          title: 'Добыча нефти',
          dimension: 1000,
          dimensionTitle: 'тыс. тон',
          key: 'oil'
        },
        {
          title: 'Время всего',
          dimension: 24,
          dimensionTitle: 'дни',
          key: 'total_hours',
        },
        {
          title: 'Отр время',
          dimension: 24,
          dimensionTitle: 'дни',
          key: 'active_hours'
        },
        {
          title: 'Дни простоя',
          dimension: 24,
          dimensionTitle: 'дни',
          key: 'paused_hours'
        },
        {
          title: 'Доходы',
          dimension: 1000,
          dimensionTitle: 'млн. тенге',
          key: 'netback',
          styleClass: 'ml-2',
        },
        {
          title: 'Расходы',
          dimension: 1000,
          dimensionTitle: 'млн. тенге',
          key: 'overall_expenditures',
        },
        {
          title: 'Прибыль / убыток',
          dimension: 1000,
          dimensionTitle: 'млн. тенге',
          key: 'operating_profit',
        },
      ]
    },

    tableRows() {
      return [
        {
          title: 'Фактические показатели',
          order: '1.',
          values: this.tableHeaders.map(header => ({
            value: this.sumData[header.key].total
          })),
          style: 'background: #333868',
        },
        {
          title: 'Нерентабельные',
          values: this.tableHeaders.map(header => ({
            value: this.sumData[header.key].profitless
          })),
          style: 'background: #7D5F52'
        },
        {
          title: 'Рентабельные',
          values: this.tableHeaders.map(header => ({
            value: this.sumData[header.key].profitable
          })),
          style: 'background: #1A5855'
        },
        {
          title: 'Простой',
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
          title: 'Предлагаемый вариант',
          order: '2.',
          values: this.tableHeaders.map(header => ({
            value: this.sumProposedData[header.key].total
          })),
          style: 'background: #333868',
        },
        {
          title: 'Нерентабельные',
          values: this.tableHeaders.map(header => ({
            value: this.sumProposedData[header.key].profitless
          })),
          style: 'background: #7D5F52'
        },
        {
          title: 'Рентабельные',
          values: this.tableHeaders.map(header => ({
            value: this.sumProposedData[header.key].profitable
          })),
          style: 'background: #1A5855'
        },
        {
          title: 'Простой',
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
          title: 'Предлагаемый вариант минус фактические показатели',
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
          title: 'Нерентабельные',
          values: this.tableHeaders.map((header, headerIndex) => ({
            value: this.getTableDiff(headerIndex, 1),
          })),
          style: 'background: #7D5F52'
        },
        {
          title: 'Рентабельные',
          values: this.tableHeaders.map((header, headerIndex) => ({
            value: this.getTableDiff(headerIndex, 2),
          })),
          style: 'background: #1A5855'
        },
        {
          title: 'Простой',
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
          title: 'Рост прибыли от подбора нерентабельных скважин',
          order: '4.',
          value: this.localeValue(
              this.sumProposedData.operating_profit.profitable -
              this.sumData.operating_profit.profitable,
              1000
          ),
        },
        {
          title: 'Рост прибыли от исключения ПРС на отключаемых скважинах',
          order: '5.',
          value: this.localeValue(
              this.sumData.prs_cost.profitless -
              this.sumProposedData.prs_cost.profitless,
              1000
          ),
        },
        {
          title: 'Снижение прибыли из-за оставления 70% ФОТ, постоянных',
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