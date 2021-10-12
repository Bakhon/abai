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

        <div class="form-check mr-2">
          <input v-model="isVisibleChartTotal"
                 id="visible_total"
                 type="checkbox"
                 class="form-check-input">
          <label for="visible_total"
                 class="form-check-label text-blue">
            {{ trans('economic_reference.show_charts') }}
          </label>
        </div>

        <select-operating-profit
            :form="form"
            class="mr-2 bg-dark-blue text-blue"
            style="width: 200px"/>

        <button class="btn btn-primary ml-auto">
          {{ trans('economic_reference.export_excel') }}
        </button>
      </div>

      <div class="d-flex flex-wrap mb-3 bg-main1 p-4">
        <div v-for="(wellKey, index) in wellKeys"
             :key="wellKey.prop"
             class="d-flex flex-20 mr-2 mb-2 line-height-16px">
          <div class="d-flex align-items-center form-check mr-2"
               style="flex: 1 0 150px">
            <input v-model="wellKey.isVisible"
                   :id="wellKey.prop"
                   type="checkbox"
                   class="form-check-input mt-0">
            <label :for="wellKey.prop"
                   class="form-check-label">
              {{ wellKey.name }}
            </label>
          </div>

          <select-chart-type
              v-if="isVisibleChartTotal"
              :form="wellKey"
              class="bg-dark-blue text-white mr-3"
              style="flex: 0 0 100px"/>
        </div>
      </div>

      <chart-matrix-total
          v-if="isVisibleChartTotal"
          :dates="dates"
          :well-sum="tableData.wellsSum"
          :well-keys="visibleWellKeys"
          :prs-sum="tableData.prsSum"
          :prs-keys="prsKeys"
          :date-offset="tableTitlesLength"
          class="text-white container-fluid bg-main1 pt-2 px-4"/>

      <vue-table-dynamic
          :params="tableCostParams"
          class="matrix-table bg-main1 pt-4 px-4 pb-2">
        <template
            v-for="(header, index) in tableHeaders"
            :slot="`column-${index}`" slot-scope="{ props }">
          <div class="d-flex align-items-center w-100">
            {{ props.cellData.label }}
          </div>
        </template>
      </vue-table-dynamic>

      <vue-table-dynamic
          :params="tablePrsParams"
          class="matrix-table bg-main1 pt-2 px-4 pb-2">
        <template
            v-for="(header, index) in tableHeaders"
            :slot="`column-${index}`" slot-scope="{ props }">
          <div class="d-flex align-items-center w-100">
            {{ props.cellData.label }}
          </div>
        </template>
      </vue-table-dynamic>

      <vue-table-dynamic
          :params="tableSumParams"
          class="matrix-table bg-main1 pt-2 px-4 pb-4">
        <template
            v-for="(header, index) in tableHeaders"
            :slot="`column-${index}`" slot-scope="{ props }">
          <div class="d-flex align-items-center w-100">
            {{ props.cellData.label }}
          </div>
        </template>
      </vue-table-dynamic>

      <chart-matrix-well
          v-for="uwi in chartUwis"
          :key="uwi"
          :uwi="uwi"
          :well="wells.uwis[uwi]"
          :dates="dates"
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

        <template
            v-for="(header, index) in tableHeaders.slice(1)"
            :slot="`column-${index+1}`" slot-scope="{ props }">
          <div :style="`color: ${props.cellData.color}`"
               class="d-flex align-items-center w-100">
            {{ props.cellData.label }}
          </div>
        </template>
      </vue-table-dynamic>
    </div>
  </div>
</template>

<script>
import ChartMatrixWell from "./ChartMatrixWell";
import ChartMatrixTotal from "./ChartMatrixTotal";
import SelectChartType from "../SelectChartType";
import SelectOperatingProfit from "../SelectOperatingProfit";

export default {
  name: "TableMatrix",
  components: {
    ChartMatrixWell,
    ChartMatrixTotal,
    SelectChartType,
    SelectOperatingProfit
  },
  props: {
    wells: {
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
    isVisibleChartTotal: false,
    form: {
      operatingProfit: 'Operating_profit'
    }
  }),
  created() {
    this.setWellKeys()

    this.resetData()
  },
  computed: {
    uwis() {
      if (!this.wells) {
        return []
      }

      return Object.keys(this.wells.uwis).filter(uwi => {
        return this.isVisibleProfitable && this.wells.uwis[uwi][this.form.operatingProfit].sum > 0
            || this.isVisibleProfitless && this.wells.uwis[uwi][this.form.operatingProfit].sum <= 0
      })
    },

    dates() {
      return this.wells ? Object.keys(this.wells.dates) : []
    },

    datesParams() {
      return this.wells ? Object.values(this.wells.dates) : []
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
        fixed: this.tableTitlesLength - 1,
        columnWidth: this.columnWidth,
        highlight: {column: this.tableTitles.map((title, index) => index)},
        highlightedColor: '#2E50E9'
      }
    },

    tableSumParams() {
      return {
        data: [...[this.tableHeaders], ...this.tableData.wellsSum],
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: false,
        headerHeight: 80,
        rowHeight: 50,
        fixed: this.tableTitlesLength - 1,
        columnWidth: this.columnWidth,
        highlight: {column: this.tableTitles.map((title, index) => index)},
        highlightedColor: '#2E50E9'
      }
    },

    tablePrsParams() {
      return {
        data: [...[this.tableHeaders], ...this.tableData.prsSum],
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: false,
        headerHeight: 80,
        rowHeight: 50,
        fixed: this.tableTitlesLength - 1,
        columnWidth: this.columnWidth,
        highlight: {column: this.tableTitles.map((title, index) => index)},
        highlightedColor: '#2E50E9'
      }
    },

    tableCostParams() {
      return {
        data: [...[this.tableHeaders], ...this.tableData.costSum],
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: false,
        headerHeight: 80,
        rowHeight: 50,
        fixed: this.tableTitlesLength - 1,
        columnWidth: this.columnWidth,
        highlight: {column: this.tableTitles.map((title, index) => index)},
        highlightedColor: '#2E50E9'
      }
    },

    tableData() {
      let dateOffset = this.tableTitlesLength

      let wellsRows = []

      let wellsSum = this.getSumObject(this.visibleWellKeys)

      let wellsSumRows = []

      let prsSum = this.getSumObject(this.prsKeys)

      let prsSumRows = []

      let costSum = this.getSumObject(this.costKeys)

      let costSumRows = []

      let dateRows = []

      this.dates.forEach((date, dateIndex) => {
        dateRows.push({value: '', label: ''})

        this.visibleWellKeys.forEach(key => {
          wellsSum[key.prop].push({value: 0, label: 0})
        })

        this.prsKeys.forEach(key => {
          prsSum[key.prop].push({value: 0, label: 0})
        })

        this.costKeys.forEach(key => {
          costSum[key.prop].push({value: this.datesParams[dateIndex][key.prop], label: 0})
        })
      })

      this.uwis.forEach(uwi => {
        wellsRows.push([
          ...[
            {value: uwi, label: uwi, isCheckbox: true},
            {value: '', label: ''},
            {value: '', label: ''},
          ],
          ...dateRows
        ])

        let well = this.wells.uwis[uwi]

        let wellRows = {}

        this.visibleWellKeys.forEach(key => wellRows[key.prop] = [])

        this.dates.forEach((date, dateIndex) => {
          this.visibleWellKeys.forEach(key => {
            let value = this.getWellValue(well, key, date, true)

            wellsSum[key.prop][dateIndex + dateOffset].value += +value

            wellRows[key.prop].push({
              value: value,
              label: this.getLabel(value, key.dimension, key.fractionDigits),
              color: this.getColor(key, value)
            })
          })

          this.prsKeys.forEach(key => {
            prsSum[key.prop][dateIndex + dateOffset].value += this.getWellValue(well, key, date)
          })
        })

        this.visibleWellKeys.forEach(key => {
          let sum = this.getWellValue(well, key, 'sum')

          wellsSum[key.prop][dateOffset - 1].value += sum

          wellRows[key.prop].unshift(
              {
                value: key.name,
                label: key.name
              },
              {
                value: key.dimension,
                label: key.dimensionTitle
              },
              {
                value: sum,
                label: this.getLabel(sum, key.dimension, key.fractionDigits),
                color: this.getColor(key, sum)
              }
          )

          wellsRows.push(wellRows[key.prop])
        })

        this.prsKeys.forEach(key => {
          if (!key.isTotal) return

          prsSum[key.prop][dateOffset - 1].value += this.getWellValue(well, key, 'sum')
        })
      })

      this.visibleWellKeys.forEach(key => {
        wellsSumRows.push(this.getTotalRow(key, wellsSum))
      })

      this.prsKeys.forEach(key => {
        if (key.isTotal) {
          return prsSumRows.push(this.getTotalRow(key, prsSum))
        }

        prsSum[key.prop][dateOffset - 1].value = key.calcValue(
            prsSum,
            dateOffset - 1,
            this.datesParams ? this.datesParams[0] : [],
        )

        this.dates.forEach((date, dateIndex) => {
          prsSum[key.prop][dateIndex + dateOffset].value = key.calcValue(
              prsSum,
              dateIndex + dateOffset,
              this.datesParams[dateIndex]
          )
        })

        prsSumRows.push(this.getTotalRow(key, prsSum))
      })

      this.costKeys.forEach(key => {
        costSumRows.push(this.getTotalRow(key, costSum))
      })

      return {
        wells: wellsRows,
        wellsSum: wellsSumRows,
        prsSum: prsSumRows,
        costSum: costSumRows
      }
    },

    tableHeaders() {
      return [
        ...this.tableTitles,
        ...this.dates
      ]
    },

    tableTitles() {
      return [
        '',
        this.trans('economic_reference.dimension'),
        this.trans('economic_reference.total'),
      ]
    },

    tableTitlesLength() {
      return this.tableTitles.length
    },

    tablePageSize() {
      return (this.visibleWellKeys.length + 1) * 3
    },

    visibleWellKeys() {
      return this.wellKeys.filter(key => key.isVisible)
    },

    prsKeys() {
      return [
        {
          prop: 'profitable',
          name: this.trans('economic_reference.profitable'),
          isTotal: true,
          isProfitable: true,
          dimensionTitle: `${this.trans('economic_reference.units')}.`,
        },
        {
          prop: 'profitless',
          name: this.trans('economic_reference.profitless'),
          isTotal: true,
          isProfitless: true,
          dimensionTitle: `${this.trans('economic_reference.units')}.`,
        },
        {
          prop: 'prs1',
          name: this.trans('economic_reference.prs_count'),
          dimensionTitle: `${this.trans('economic_reference.units')}.`,
          dimension: 1000,
          calcValue: function (data, dateIndex, dateParams) {
            return dateParams
                ? data.PRS_nopayroll_expenditures[dateIndex].value / dateParams.cost_WR_nopayroll
                : 0
          },
        },
        {
          prop: 'PRS_nopayroll_expenditures',
          name: this.trans('economic_reference.prs_nopayroll_expenditures'),
          isTotal: true,
          dimension: 1000,
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'PRS_expenditures',
          name: this.trans('economic_reference.prs_expenditures'),
          isTotal: true,
          dimension: 1000,
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
      ]
    },

    columnWidth() {
      return this.tableHeaders.map((col, index) => {
        let width = this.tableHeaders.length <= 10 ? null : 120

        switch (index) {
          case 0:
            width = 320
            break
          case 1:
          case 2:
            width = 150
            break
        }

        return {column: index, width: width}
      })
    },

    costKeys() {
      let dailyKeys = this.getDailyKeys('trans_exp').map(key => ({
        prop: key.prop,
        name: `${this.trans('economic_reference.trans_expenditures')} ${key.name}`,
        fractionDigits: 2,
        dimensionTitle: key.dimension,
        isString: true
      }))

      return [
        ...[
          {
            prop: 'cost_variable',
            name: this.trans('economic_reference.cost_variable'),
            fractionDigits: 2,
            dimensionTitle: `
            ${this.trans('economic_reference.tenge')} /
            ${this.trans('economic_reference.cubic_meter')}
          `,
            isString: true
          },
          {
            prop: 'cost_fix_noWRpayroll',
            name: this.trans('economic_reference.cost_fix_no_wr_payroll'),
            fractionDigits: 2,
            dimension: 1000,
            dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')} /
            ${this.trans('economic_reference.month').toLocaleLowerCase()}
          `,
            isString: true
          },
          {
            prop: 'cost_fix_payroll',
            name: this.trans('economic_reference.fot'),
            dimension: 1000,
            dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')} /
            ${this.trans('economic_reference.month').toLocaleLowerCase()}
          `,
            isString: true
          },
          {
            prop: 'cost_fix_nopayroll',
            name: this.trans('economic_reference.cost_fix_nopayroll'),
            dimension: 1000,
            dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')} /
            ${this.trans('economic_reference.month').toLocaleLowerCase()}
          `,
            isString: true
          },
          {
            prop: 'cost_fix',
            name: this.trans('economic_reference.cost_fix'),
            dimension: 1000,
            dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')} /
            ${this.trans('economic_reference.month').toLocaleLowerCase()}
          `,
            isString: true
          },
          {
            prop: 'cost_Gaoverheads',
            name: this.trans('economic_reference.cost_gaoverheads'),
            dimension: 1000,
            dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')} /
            ${this.trans('economic_reference.month').toLocaleLowerCase()}
          `,
            isString: true
          },
          {
            prop: 'cost_WR_nopayroll',
            name: this.trans('economic_reference.cost_prs_without_fot'),
            dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')} /
            ${this.trans('economic_reference.event_short').toLocaleLowerCase()}
          `,
            isString: true
          },
          {
            prop: 'cost_WR_payroll',
            name: this.trans('economic_reference.cost_wr_payroll'),
            dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')} /
            ${this.trans('economic_reference.event_short').toLocaleLowerCase()}
          `,
            isString: true
          },
          {
            prop: 'cost_WR',
            name: this.trans('economic_reference.cost_prs'),
            fractionDigits: 2,
            dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')} /
            ${this.trans('economic_reference.event_short').toLocaleLowerCase()}
          `,
            isString: true
          },
          {
            prop: 'cost_WO',
            name: this.trans('economic_reference.cost_krs'),
            fractionDigits: 2,
            dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')} /
            ${this.trans('economic_reference.event_short').toLocaleLowerCase()}
          `,
            isString: true
          },
        ],
        ...dailyKeys
      ]
    },
  },
  methods: {
    getColor(key, value) {
      if (!key.isColorful) {
        return ''
      }

      return value && value > 0 ? '#23E846' : '#E84663'
    },

    getLabel(value, dimension, fractionDigits = 0, isString = false) {
      if (!value) {
        return isString ? '' : 0
      }

      if (dimension) {
        value = +value / dimension
      }

      return (+value.toFixed(fractionDigits)).toLocaleString()
    },

    getWellValue(well, key, date, isString = false) {
      if (key.isProfitable) {
        if (!well[this.form.operatingProfit].hasOwnProperty(date)) {
          return 0
        }

        return +well[this.form.operatingProfit][date] > 0 ? 1 : 0
      }

      if (key.isProfitless) {
        if (!well[this.form.operatingProfit].hasOwnProperty(date)) {
          return 0
        }

        return +well[this.form.operatingProfit][date] > 0 ? 0 : 1
      }

      if (date === 'sum') {
        if (this.isVisibleProfitable && !this.isVisibleProfitless && well[this.form.operatingProfit].sum <= 0) {
          return 0
        }

        if (this.isVisibleProfitless && !this.isVisibleProfitable && well[this.form.operatingProfit].sum > 0) {
          return 0
        }
      }

      if (key.props) {
        let sum = 0

        key.props.forEach(prop => {
          sum += well[prop] && well[prop][date] ? +well[prop][date] : 0
        })

        return sum
      }

      if (well[key.prop] && well[key.prop][date]) {
        return +well[key.prop][date]
      }

      return isString ? '' : 0
    },

    getTotalRow(key, wellsSum) {
      let sumKey = this.tableTitlesLength - 1

      wellsSum[key.prop][sumKey].label = this.getLabel(
          wellsSum[key.prop][sumKey].value,
          key.dimension,
          key.fractionDigits,
          key.isString
      )

      this.dates.forEach((date, dateIndex) => {
        let dateKey = dateIndex + this.tableTitlesLength

        wellsSum[key.prop][dateKey].label = this.getLabel(
            wellsSum[key.prop][dateKey].value,
            key.dimension,
            key.fractionDigits
        )
      })

      return wellsSum[key.prop]
    },

    toggleUwi(uwi) {
      let index = this.chartUwis.findIndex(well => well === uwi)

      index === -1
          ? this.chartUwis.push(uwi)
          : this.chartUwis.splice(index, 1);
    },

    setWellKeys() {
      this.wellKeys = [
        {
          prop: 'oil',
          name: this.trans('economic_reference.oil_production'),
          isVisible: true,
          chartType: 'line',
          dimensionTitle: this.trans('economic_reference.tons'),
          fractionDigits: 1,
        },
        {
          prop: 'liquid',
          name: this.trans('economic_reference.liquid_production'),
          isVisible: true,
          chartType: 'line',
          dimensionTitle: this.trans('economic_reference.cubic_meter'),
          fractionDigits: 1,
        },
        {
          prop: 'Revenue_export',
          name: this.trans('economic_reference.revenue_export'),
          dimension: 1000,
          isVisible: true,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'Revenue_local',
          name: this.trans('economic_reference.revenue_local'),
          dimension: 1000,
          isVisible: true,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'Revenue_total',
          name: this.trans('economic_reference.revenue_total'),
          dimension: 1000,
          isVisible: true,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'tax_costs',
          props: ['MET_payments', 'ECD_payments', 'ERT_payments'],
          name: this.trans('economic_reference.tax_costs'),
          dimension: 1000,
          isVisible: false,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'Trans_expenditures',
          name: this.trans('economic_reference.trans_expenditures'),
          dimension: 1000,
          isVisible: true,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'NetBack_bf_pr_exp',
          name: `${this.trans('economic_reference.income')} NetBack`,
          dimension: 1000,
          isVisible: true,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'Variable_expenditures',
          name: this.trans('economic_reference.variable_expenditures'),
          dimension: 1000,
          isVisible: true,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'Fixed_nopayroll_expenditures',
          name: this.trans('economic_reference.fixed_nopayroll_expenditures'),
          dimension: 1000,
          isVisible: false,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'Fixed_payroll_expenditures',
          name: this.trans('economic_reference.fot'),
          dimension: 1000,
          isVisible: false,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'Fixed_expenditures',
          name: this.trans('economic_reference.fixed_expenditures'),
          dimension: 1000,
          isVisible: false,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'Gaoverheads_expenditures',
          name: this.trans('economic_reference.gaoverheads'),
          dimension: 1000,
          isVisible: false,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'Overall_expenditures',
          name: this.trans('economic_reference.costs'),
          dimension: 1000,
          isVisible: false,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
        {
          prop: 'Operating_profit',
          name: this.trans('economic_reference.operating_profit'),
          dimension: 1000,
          isVisible: false,
          isColorful: true,
          chartType: 'line',
          dimensionTitle: `
            ${this.trans('economic_reference.thousand')}
            ${this.trans('economic_reference.tenge')}
          `,
        },
      ]
    },

    resetData() {
      this.resetSelectedUwis()

      this.resetCharts()
    },

    resetSelectedUwis() {
      this.uwis.forEach(uwi => this.selectedUwis[uwi] = false)
    },

    resetCharts() {
      this.chartUwis = []
    },

    getSumObject(keys) {
      let sum = {}

      keys.forEach(key => {
        sum[key.prop] = [
          {value: key.name, label: key.name},
          {value: key.dimension, label: key.dimensionTitle},
          {value: 0, label: 0},
        ]
      })

      return sum
    },

    getDailyKeys(prefix) {
      let exportDimension = '$ / bbl'

      let localDimension = `
             ${this.trans('economic_reference.thousand')}
             ${this.trans('economic_reference.tenge')} /
             ${this.trans('economic_reference.ton_declination')}
            `

      return [
        {
          prop: `${prefix}_export_AA`,
          name: 'AA',
          dimension: exportDimension,
        },
        {
          prop: `${prefix}_export_KTK`,
          name: 'KTK',
          dimension: exportDimension,
        },
        {
          prop: `${prefix}_export_Samara`,
          name: 'Samara',
          dimension: exportDimension,
        },
        {
          prop: `${prefix}_export_Aktau`,
          name: 'Aktau',
          dimension: exportDimension,
        },
        {
          prop: `${prefix}_export_other`,
          name: 'other',
          dimension: exportDimension,
        },
        {
          prop: `${prefix}_local_ANPZ`,
          name: 'ANPZ',
          dimension: localDimension,
        },
        {
          prop: `${prefix}_local_PNHZ`,
          name: 'PNHZ',
          dimension: localDimension,
        },
        {
          prop: `${prefix}_local_PKOP`,
          name: 'PKOP',
          dimension: localDimension,
        },
        {
          prop: `${prefix}_local_KBITUM`,
          name: 'KBITUM',
          dimension: localDimension,
        },
        {
          prop: `${prefix}_local_other`,
          name: 'other',
          dimension: localDimension,
        },
      ];
    }
  },
  watch: {
    data() {
      this.resetData()
    },
  }
}
</script>

<style scoped>
.matrix-table >>> .v-table-body {
  height: fit-content !important;
}

.matrix-table >>> .v-table-row {
  height: 30px !important;
}

.matrix-table >>> .table-cell {
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

.bg-dark-blue {
  background-color: #333975;
}

.line-height-16px {
  line-height: 16px;
}

.flex-20 {
  flex: 0 0 20%;
}
</style>