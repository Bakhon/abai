<template>
  <div>
    <div class="p-3 bg-main1 mb-3 mx-auto max-width-88vw">
      <div class="d-flex mb-3">
        <div>
          <label for="granularity">
            {{ trans('economic_reference.group_by') }}
          </label>

          <select-granularity
              id="granularity"
              :form="form"
              @change="toggleGranularity()"/>
        </div>

        <select-permanent-stop-coefficient
            :form="form"
            class="ml-2"/>

        <select-technical-well-forecast-kit
            :form="form"
            form-key="kit_ids"
            class="ml-2"
            is-multiple/>

        <i v-if="form.kit_ids.length && form.permanent_stop_coefficient"
           class="fas fa-search cursor-pointer ml-2"
           style="margin-top: 40px"
           @click="getData()"></i>
      </div>

      <div>
        <div v-if="form.granularity === 'month'" class="form-check">
          <input id="sort_group"
                 type="checkbox"
                 class="form-check-input"
                 :checked="sort.isGroup"
                 @change="toggleSortKey('isGroup')">
          <label for="sort_group"
                 class="form-check-label text-blue">
            {{ trans('economic_reference.group_values') }}
          </label>
        </div>

        <select
            v-show="form.granularity === 'day'"
            v-model="form.uwi"
            :title="trans('economic_reference.select_well')"
            data-style="text-white bg-main1 border-white"
            data-live-search="true"
            class="well-search"
            @change="getData()">
          <option v-for="uwi in uwis" :key="uwi">
            {{ uwi }}
          </option>
        </select>
      </div>
    </div>

    <div class="mx-auto max-width-88vw bg-main1 pt-4 px-4 pb-2">
      <div class="mb-3 d-flex align-items-center">
        <i :class="sort.isAsc ? 'fa-sort-amount-up' :'fa-sort-amount-down-alt'"
           class="fas text-white cursor-pointer mr-3"
           style="font-size: 22px"
           @click="toggleSortKey('isAsc')"></i>

        <select
            :value="sort.key"
            class="form-control bg-dark-blue text-white"
            style="width: 280px"
            @change="updateSortKey">
          <option :value="null" disabled selected>
            {{ trans('economic_reference.select_sort') }}
          </option>

          <option
              v-for="header in tableHeaders.filter(header => !header.isString)"
              :key="header.key"
              :value="header.key">
            {{ header.name }}
          </option>
        </select>
      </div>

      <vue-table-dynamic
          :params="tableParams"
          class="matrix-table">
        <template
            v-for="(header, headerIndex) in tableHeaders"
            :slot="`column-${headerIndex}`"
            slot-scope="{ props }">
          <div :class="getHeaderStyleClass(header, props.cellData)"
               class="h-100 customScroll pb-2 d-flex align-items-center"
               style="overflow-x: hidden; overflow-y: auto">
            {{ getHeaderValue(header, props.row, props.cellData) }}
          </div>
        </template>
      </vue-table-dynamic>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import SelectGranularity from "../components/SelectGranularity";
import SelectPermanentStopCoefficient from "./components/SelectPermanentStopCoefficient";
import SelectTechnicalWellForecastKit from "./components/SelectTechnicalWellForecastKit";

import 'bootstrap-select/dist/css/bootstrap-select.min.css';
import 'bootstrap-select/dist/js/bootstrap-select.min';
import 'bootstrap-select/dist/js/i18n/defaults-ru_RU.min';

export default {
  name: "economic-analysis-wells",
  components: {
    SelectGranularity,
    SelectPermanentStopCoefficient,
    SelectTechnicalWellForecastKit,
  },
  data: () => ({
    form: {
      granularity: 'month',
      permanent_stop_coefficient: 0.7,
      uwi: null,
      kit_ids: [],
    },
    wells: null,
    sort: {
      isGroup: true,
      isAsc: true,
      key: null,
    },
    uwis: []
  }),
  async mounted() {
    this.$emit('updateWide', false)
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      if (this.form.granularity === 'day') {
        this.sort.isGroup = false

        if (!this.form.uwi) {
          return $('.well-search').selectpicker()
        }
      } else {
        this.form.uwi = null

        $('.well-search').selectpicker('destroy')
      }

      this.SET_LOADING(true)

      this.wells = null

      try {
        const {data} = await this.axios.get(this.url, {params: this.form})

        let wells = []

        Object.values(data).forEach(wellsByKit => {
          wells = [...wells, ...wellsByKit]
        })

        this.wells = wells

        if (!this.uwis.length) {
          this.setUwis()
        }
      } catch (e) {
        this.wells = null
      }

      this.SET_LOADING(false)
    },

    getChangedStatus(well) {
      switch (well.changed_status) {
        case -1:
          return this.trans('economic_reference.candidate_to_stop')
        case 0:
          return ''
        case 1:
          return this.trans('economic_reference.candidate_to_launch')
        case 2:
          return this.trans('economic_reference.do_not_deoptimize')
      }
    },

    getTableRow(well, isConvertChangedStatus = false) {
      return this.tableHeaders.map(header => {
        if (header.key === 'changed_status' && isConvertChangedStatus) {
          return this.getChangedStatus(well)
        }

        return header.isString ? well[header.key] : +well[header.key]
      })
    },

    getHeaderValue(header, rowIndex, value) {
      if (header.key === 'profitability') {
        return value ? this.trans(`economic_reference.${value}`) : ''
      }

      if (header.isString) {
        return value
      }

      let fractionDigits = rowIndex > 1 ? 2 : 0

      return (+value.toFixed(fractionDigits)).toLocaleString()
    },

    getHeaderStyleClass(header, value) {
      return this.sort.isGroup && header.isMultiple && value && value.length > 34
          ? 'pt-35px'
          : 'pt-2';
    },

    setUwis() {
      let uwis = {}

      this.wells.forEach(well => uwis[well.uwi] = 1)

      this.uwis = Object.keys(uwis)
    },

    toggleSortKey(key) {
      this.SET_LOADING(true)

      setTimeout(() => {
        this.sort[key] = !this.sort[key]

        this.SET_LOADING(false)
      })
    },

    toggleGranularity() {
      this.wells = null

      if (this.form.granularity === 'day') {
        this.sort.isGroup = false

        if (!this.form.uwi) {
          return $('.well-search').selectpicker()
        }
      } else {
        this.form.uwi = null

        $('.well-search').selectpicker('destroy')
      }
    },

    updateSortKey(event) {
      let key = event.target.value

      this.SET_LOADING(true)

      setTimeout(() => {
        this.sort.key = key

        this.SET_LOADING(false)
      })
    },

    sortRows(rows) {
      let headerIndex = this.tableHeaders.findIndex(header => header.key === this.sort.key)

      rows.sort((prev, next) => this.sort.isAsc
          ? (+prev[headerIndex] - +next[headerIndex])
          : (+next[headerIndex] - +prev[headerIndex])
      )
    },

  },
  computed: {
    url() {
      return this.localeUrl('/economic/analysis/get-wells-by-granularity')
    },

    sumRow() {
      return this.tableHeaders.map((header, headerIndex) => {
        if (!headerIndex) {
          return this.trans('economic_reference.total')
        }

        return header.isString ? '' : 0
      })
    },

    tableParams() {
      let tableData = this.sort.isGroup ? 'tableGroupData' : 'tableData'

      return {
        data: [...[this.tableHeaders.map(header => header.name)], ...this[tableData]],
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        pageSize: 20,
        pageSizes: [20, 50, 100],
        headerHeight: 80,
        rowHeight: 50,
        columnWidth: this.tableHeaders.map((header, headerIndex) => ({
          column: headerIndex,
          width: header.width
        })),
        highlightedColor: '#2E50E9'
      }
    },

    tableHeaders() {
      return [
        {
          name: 'uwi',
          key: 'uwi',
          isString: true,
          width: 100,
        },
        {
          name: this.trans('economic_reference.date'),
          key: 'date',
          isString: true,
          width: 90,
        },
        {
          name: `
           ${this.trans('economic_reference.oil_production_q_short')}
           ${this.trans('economic_reference.tons')},
           ${this.trans('economic_reference.fact').toLocaleLowerCase()}
          `,
          key: 'oil',
          width: 90,
        },
        {
          name: `
           ${this.trans('economic_reference.liquid_production_q_short')}
           ${this.trans('economic_reference.cubic_meter')},
           ${this.trans('economic_reference.fact').toLocaleLowerCase()}
          `,
          key: 'liquid',
          width: 90,
        },
        {
          name: this.trans('economic_reference.condition'),
          key: 'status_name',
          isString: true,
          isMultiple: true,
          width: 130,
        },
        {
          name: this.trans('economic_reference.cause_of_loss'),
          key: 'loss_status_name',
          isString: true,
          isMultiple: true,
          width: 130,
        },
        {
          name: `
            ${this.trans('economic_reference.operating_profit')}
            (${this.trans('economic_reference.tenge')}),
            ${this.trans('economic_reference.fact').toLocaleLowerCase()}
          `,
          key: 'operating_profit',
          width: 160,
        },
        {
          name: this.trans('economic_reference.profitability'),
          key: 'profitability',
          isString: true,
          width: 130,
        },
        {
          name: `
           ${this.trans('economic_reference.oil_production_q_short')}
           ${this.trans('economic_reference.tons')},
           ${this.trans('economic_reference.forecast').toLocaleLowerCase()}
          `,
          key: 'oil_forecast',
          width: 100,
        },
        {
          name: `
           ${this.trans('economic_reference.liquid_production_q_short')}
           ${this.trans('economic_reference.cubic_meter')},
           ${this.trans('economic_reference.forecast').toLocaleLowerCase()}
          `,
          key: 'liquid_forecast',
          width: 100,
        },
        {
          name: this.trans('economic_reference.notes'),
          key: 'changed_status',
          isString: true,
          isMultiple: true,
          width: 160,
        },
        {
          name: `
           ${this.trans('economic_reference.oil_production_q_short')}
           ${this.trans('economic_reference.tons')},
           ${this.trans('economic_reference.proposed_short').toLocaleLowerCase()}
          `,
          key: 'oil_propose',
          width: 100,
        },
        {
          name: `
           ${this.trans('economic_reference.liquid_production_q_short')}
           ${this.trans('economic_reference.cubic_meter')},
           ${this.trans('economic_reference.proposed_short').toLocaleLowerCase()}
          `,
          key: 'liquid_propose',
          width: 100,
        },
        {
          name: `
            ${this.trans('economic_reference.operating_profit')}
            (${this.trans('economic_reference.tenge')}),
            ${this.trans('economic_reference.proposed_short')}
          `,
          key: 'operating_profit_propose',
          width: 160,
        },
      ]
    },

    tableSumHeaders() {
      return this.tableHeaders.filter(header => !header.isString)
    },

    tableData() {
      let rows = []

      if (!this.wells) {
        return rows
      }

      let sumRow = [...this.sumRow]

      this.wells.forEach(well => {
        if (well.date === well.date_month && !well.status_name && !well.loss_status_name) {
          well.date = `${well.date} - ...`
        }

        let row = this.getTableRow(well, true)

        this.tableHeaders.forEach((header, headerIndex) => {
          if (header.isString) return

          sumRow[headerIndex] += row[headerIndex]
        })

        rows.push(row)
      })

      if (this.sort.key) {
        this.sortRows(rows)
      }

      rows.unshift(sumRow)

      return rows
    },

    tableGroupData() {
      let rows = []

      if (!this.wells) {
        return rows
      }

      let sumRow = [...this.sumRow]

      let currentWell = null

      this.wells.forEach(well => {
        well = {...well}

        well.changed_status = this.getChangedStatus(well)

        this.tableHeaders.forEach((header, headerIndex) => {
          if (header.isString) return

          sumRow[headerIndex] += +well[header.key]
        })

        if (!currentWell) {
          return currentWell = well
        }

        if (currentWell.uwi === well.uwi) {
          return this.tableHeaders.forEach(header => {
            let value = well[header.key]

            if (header.isMultiple) {
              if (!currentWell[header.key]) {
                return currentWell[header.key] = value
              }

              return currentWell[header.key].includes(value)
                  ? ''
                  : currentWell[header.key] += `; ${value}`
            }

            if (!header.isString) {
              currentWell[header.key] = +currentWell[header.key] + +value
            }
          })
        }

        currentWell.profitability = currentWell.operating_profit > 0
            ? 'profitable'
            : 'profitless'

        rows.push(this.getTableRow(currentWell))

        return currentWell = well
      })

      if (currentWell) {
        rows.push(this.getTableRow(currentWell))
      }

      if (this.sort.key) {
        this.sortRows(rows)
      }

      rows.unshift(sumRow)

      return rows
    },
  }
}
</script>

<style scoped>
.max-width-88vw {
  max-width: 88vw;
}

.matrix-table >>> .v-table-body {
  height: fit-content !important;
}

.matrix-table >>> .v-table-row {
  height: 45px !important;
}

.matrix-table >>> .table-cell {
  line-height: 12px;
}

.matrix-table >>> .v-table-fixed {
  color: #fff;
}

.matrix-table >>> .v-table-header-wrap .is-header .table-cell {
  background: #2E50E9 !important;
  color: #fff;
}

.matrix-table >>> .v-table .vue-scroll-view > div:nth-child(2) .table-cell,
.matrix-table >>> .v-table .vue-scroll-view > div:nth-child(2) .table-row {
  background: #333975;
  font-weight: 600;
}

.matrix-table >>> .table-pagination .page-item,
.matrix-table >>> .table-pagination .size-item,
.matrix-table >>> .table-pagination .pagination-size,
.matrix-table >>> .v-table .table-cell,
.matrix-table >>> .v-table-row {
  background: #272953;
  color: #fff;
}

.pt-35px {
  padding-top: 35px;
}

.bg-dark-blue {
  background-color: #333975;
}
</style>