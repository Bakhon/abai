<template>
  <div>
    <div class="text-white">
      <div class="d-flex align-items-center mb-3 bg-main1 p-4">
        <div class="form-check mr-2">
          <input v-model="isVisibleProfitable"
                 id="visible_profitable"
                 type="checkbox"
                 class="form-check-input">
          <label for="visible_profitable"
                 class="form-check-label text-blue">
            {{ trans('economic_reference.profitable') }}
          </label>
        </div>

        <div class="form-check mr-2">
          <input v-model="isVisibleProfitless"
                 id="visible_profitless"
                 type="checkbox"
                 class="form-check-input">
          <label for="visible_profitable"
                 class="form-check-label text-blue">
            {{ trans('economic_reference.profitless') }}
          </label>
        </div>

        <div class="form-check mr-2">
          <input v-model="isVisibleWells"
                 id="visible_wells"
                 type="checkbox"
                 class="form-check-input">
          <label for="visible_wells"
                 class="form-check-label text-blue">
            {{ trans('economic_reference.show_wells') }}
          </label>
        </div>

        <button class="btn btn-primary ml-auto">
          {{ trans('economic_reference.export_excel') }}
        </button>
      </div>

      <div class="d-flex flex-wrap mb-3 bg-main1 p-4">
        <div v-for="(wellKey, index) in wellKeys"
             :key="wellKey.prop"
             class="form-check mr-2 mb-2"
             style="flex: 0 0 20%;">
          <input v-model="wellKey.isVisible"
                 :id="wellKey.prop"
                 type="checkbox"
                 class="form-check-input">
          <label :for="wellKey.prop"
                 class="form-check-label">
            {{ wellKey.name }}
          </label>
        </div>
      </div>

      <vue-table-dynamic
          :params="tableSumParams"
          class="matrix-table bg-main1 p-4">
        <template :slot="`column-0`" slot-scope="{ props }">
          <div class="d-flex align-items-center w-100">
            {{ props.cellData.label }}
          </div>
        </template>

        <template :slot="`column-1`" slot-scope="{ props }">
          <div> {{ props.cellData.label }}</div>
        </template>

        <template
            v-for="(date, index) in data.dates"
            :slot="`column-${index+2}`"
            slot-scope="{ props }">
          <div> {{ props.cellData.label }}</div>
        </template>
      </vue-table-dynamic>

      <chart-matrix
          v-for="uwi in chartUwis"
          :key="uwi"
          :uwi="uwi"
          :well="data.uwis[uwi]"
          :dates="data.dates"
          class="text-white container-fluid bg-main1 p-4 mt-3"/>

      <vue-table-dynamic
          v-if="isVisibleWells"
          :params="tableParams"
          class="matrix-table mt-3 bg-main1 p-4">
        <template :slot="`column-0`" slot-scope="{ props }">
          <div class="d-flex align-items-center w-100">
            <div> {{ props.cellData.label }}</div>

            <div v-if="props.cellData.isCheckbox" class="d-flex align-items-center ml-2">
              <input
                  v-model="selectedUwis[props.cellData.label]"
                  type="checkbox"
                  class="form-check-input m-0"
                  @change="toggleUwi(props.cellData.label)">
            </div>
          </div>
        </template>

        <template :slot="`column-1`" slot-scope="{ props }">
          <div :style="`color: ${props.cellData.color}`">
            {{ props.cellData.label }}
          </div>
        </template>

        <template
            v-for="(date, index) in data.dates"
            :slot="`column-${index+2}`"
            slot-scope="{ props }">
          <div :style="`color: ${props.cellData.color}`">
            {{ props.cellData.label }}
          </div>
        </template>
      </vue-table-dynamic>
    </div>
  </div>
</template>

<script>
import ChartMatrix from "./ChartMatrix";

export default {
  name: "TableMatrix",
  components: {ChartMatrix},
  props: {
    data: {
      required: true,
      type: Object
    },
  },
  data: () => ({
    selectedUwis: {},
    chartUwis: [],
    wellKeys: [],
    isVisibleWells: false,
    isVisibleProfitable: true,
    isVisibleProfitless: true,
  }),
  created() {
    this.initWellKeys()

    this.initSelectedUwis()
  },
  computed: {
    uwis() {
      return Object.keys(this.data.uwis).filter(uwi => {
        return this.isVisibleProfitable && this.data.uwis[uwi].Operating_profit.sum > 0
            || this.isVisibleProfitless && this.data.uwis[uwi].Operating_profit.sum <= 0
      })
    },

    tableParams() {
      return {
        data: [...[this.tableHeaders], ...this.tableData.wells],
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        pageSize: this.tablePageSize,
        pageSizes: [this.tablePageSize, this.tablePageSize * 2, this.tablePageSize * 4],
        headerHeight: 80,
        rowHeight: 50,
        fixed: 1,
        columnWidth: this.tableHeaders.map((col, index) => ({
          column: index,
          width: index > 0 ? 100 : 180
        })),
        highlight: {column: [0, 1]},
        highlightedColor: '#2E50E9'
      }
    },

    tableSumParams() {
      return {
        data: [...[this.tableHeaders], ...this.tableData.totalSum],
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: false,
        headerHeight: 80,
        rowHeight: 50,
        fixed: 1,
        columnWidth: this.tableHeaders.map((col, index) => ({
          column: index,
          width: index > 0 ? 100 : 180
        })),
        highlight: {column: [0, 1]},
        highlightedColor: '#2E50E9'
      }
    },

    tableData() {
      let rows = []

      let totalSumRows = []

      let totalSum = {}

      this.visibleWellKeys.forEach(key => {
        totalSum[key.prop] = [
          {value: key.name, label: key.name},
          {value: 0, label: 0},
        ]
      })

      this.data.dates.forEach(date => {
        this.visibleWellKeys.forEach(key => {
          totalSum[key.prop].push({value: 0, label: 0})
        })
      })

      this.uwis.forEach(uwi => {
        let tableRows = {
          uwi: [
            {value: uwi, label: uwi, isCheckbox: true},
            {value: '', label: ''}
          ]
        }

        this.visibleWellKeys.forEach(key => tableRows[key.prop] = [])

        let well = this.data.uwis[uwi]

        this.data.dates.forEach((date, dateIndex) => {
          this.visibleWellKeys.forEach(key => {
            let value = 0

            key.props
                ? key.props.forEach(prop => {
                  value += well[prop] && well[prop][date] ? +well[prop][date] : 0
                })
                : value = well[key.prop] && well[key.prop][date] ? +well[key.prop][date] : ''

            totalSum[key.prop][dateIndex + 2].value += +value

            tableRows[key.prop].push({
              value: value,
              label: this.getLabel(value, key.dimension),
              color: this.getColor(key, value)
            })
          })

          tableRows.uwi.push({value: '', label: ''})
        })

        rows.push(tableRows.uwi)

        this.visibleWellKeys.forEach(key => {
          let sum = 0

          key.props
              ? key.props.forEach(prop => {
                sum += well[prop] ? +well[prop]['sum'] : 0
              })
              : sum = well[key.prop] ? +well[key.prop]['sum'] : 0

          totalSum[key.prop][1].value += sum

          tableRows[key.prop].unshift(
              {
                value: key.name,
                label: key.name
              },
              {
                value: sum,
                label: this.getLabel(sum, key.dimension),
                color: this.getColor(key, sum)
              }
          )

          rows.push(tableRows[key.prop])
        })
      })

      this.visibleWellKeys.forEach(key => {
        totalSum[key.prop][1].label = this.getLabel(totalSum[key.prop][1].value, key.dimension)

        this.data.dates.forEach((date, dateIndex) => {
          totalSum[key.prop][dateIndex + 2].label = this.getLabel(
              totalSum[key.prop][dateIndex + 2].value,
              key.dimension
          )
        })

        totalSumRows.push(totalSum[key.prop])
      })

      return {wells: rows, totalSum: totalSumRows}
    },

    tableHeaders() {
      return [
        ...[
          '',
          `${this.trans('economic_reference.total')}, ${this.trans('economic_reference.thousand_tenge')}`
        ],
        ...this.data.dates
      ]
    },

    tablePageSize() {
      return (this.visibleWellKeys.length + 1) * 3
    },

    visibleWellKeys() {
      return this.wellKeys.filter(key => key.isVisible)
    },
  },
  methods: {
    getColor(key, value) {
      if (!key.isColorful) {
        return ''
      }

      return value && value > 0 ? '#23E846' : '#E84663'
    },

    getLabel(value, dimension) {
      if (!value) {
        return 0
      }

      if (dimension) {
        value = +value / dimension
      }

      return (+value.toFixed(1)).toLocaleString()
    },

    toggleUwi(uwi) {
      let index = this.chartUwis.findIndex(well => well === uwi)

      index === -1
          ? this.chartUwis.push(uwi)
          : this.chartUwis.splice(index, 1);
    },

    initWellKeys() {
      this.wellKeys = [
        {
          prop: 'oil',
          name: this.trans('economic_reference.oil_production'),
          isVisible: true,
        },
        {
          prop: 'liquid',
          name: this.trans('economic_reference.liquid_production'),
          isVisible: true,
        },
        {
          prop: 'prs',
          name: this.trans('economic_reference.prs_count'),
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'PRS_nopayroll_expenditures',
          name: this.trans('economic_reference.prs_nopayroll_expenditures'),
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'PRS_expenditures',
          name: this.trans('economic_reference.prs_expenditures'),
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'Revenue_export',
          name: this.trans('economic_reference.revenue_export'),
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'Revenue_local',
          name: this.trans('economic_reference.revenue_local'),
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'tax_costs',
          props: ['MET_payments', 'ECD_payments', 'ERT_payments'],
          name: this.trans('economic_reference.tax_costs'),
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'Trans_expenditures',
          name: this.trans('economic_reference.trans_expenditures'),
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'NetBack_bf_pr_exp',
          name: `${this.trans('economic_reference.income')} NetBack`,
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'Variable_expenditures',
          name: this.trans('economic_reference.variable_expenditures'),
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'Fixed_nopayroll_expenditures',
          name: this.trans('economic_reference.fixed_nopayroll_expenditures'),
          dimension: 1000,
          isVisible: false,
        },
        {
          prop: 'Fixed_payroll_expenditures',
          name: this.trans('economic_reference.fot'),
          dimension: 1000,
          isVisible: false,
        },
        {
          prop: 'Fixed_expenditures',
          name: this.trans('economic_reference.fixed_expenditures'),
          dimension: 1000,
          isVisible: false,
        },
        {
          prop: 'Gaoverheads_expenditures',
          name: this.trans('economic_reference.gaoverheads'),
          dimension: 1000,
          isVisible: false,
        },
        {
          prop: 'Overall_expenditures',
          name: this.trans('economic_reference.costs'),
          dimension: 1000,
          isVisible: false,
        },
        {
          prop: 'Operating_profit',
          name: this.trans('economic_reference.operating_profit'),
          dimension: 1000,
          isVisible: false,
          isColorful: true,
        },
      ]
    },

    initSelectedUwis() {
      this.uwis.forEach(uwi => this.selectedUwis[uwi] = false)
    },
  }
}
</script>

<style scoped>
.matrix-table >>> .v-table-body {
  height: fit-content !important;
}

.matrix-table >>> .v-table-row {
  height: 45px !important;
}

.matrix-table >>> .v-table-fixed .table-cell {
  line-height: 13px;
}

.matrix-table >>> .v-table-fixed {
  color: #fff;
}

.matrix-table >>> .table-pagination .page-item,
.matrix-table >>> .table-pagination .size-item,
.matrix-table >>> .table-pagination .pagination-size,
.matrix-table >>> .v-table .table-cell,
.matrix-table >>> .v-table-row {
  background: #272953;
  color: #fff;
}

.text-blue {
  color: #23AFE8;
}
</style>