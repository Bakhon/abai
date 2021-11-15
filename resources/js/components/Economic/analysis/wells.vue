<template>
  <div>
    <div class="p-3 bg-main1 mb-3 mx-auto max-width-88vw">
      <select-granularity
          :form="form"
          class="flex-grow-1 mb-3"
          @change="toggleGranularity()"/>

      <div>
        <div v-if="form.granularity === 'month'" class="form-check">
          <input id="sort_group"
                 type="checkbox"
                 class="form-check-input"
                 :checked="sort.isGroup"
                 @change="toggleSortKey('isGroup')">
          <label for="sort_group"
                 class="form-check-label text-blue">
            Сгруппировать значения
          </label>
        </div>

        <select
            v-show="form.granularity === 'day'"
            v-model="form.uwi"
            title="Выберите скважину"
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
      <vue-table-dynamic
          :params="tableParams"
          class="matrix-table">
        <template
            v-for="(header, index) in tableHeaders"
            :slot="`column-${index}`" slot-scope="{ props }">
          <div :class="sort.isGroup && header.isMultiple && props.cellData && props.cellData.length > 34
                     ? 'pt-35px'
                     : 'pt-2'"
               class="h-100 customScroll pb-2 d-flex align-items-center"
               style="overflow-x: hidden; overflow-y: auto">
            {{ header.isString ? props.cellData : (+props.cellData.toFixed(2)).toLocaleString() }}
          </div>
        </template>
      </vue-table-dynamic>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import SelectGranularity from "../components/SelectGranularity";

import 'bootstrap-select/dist/css/bootstrap-select.min.css';
import 'bootstrap-select/dist/js/bootstrap-select.min';
import 'bootstrap-select/dist/js/i18n/defaults-ru_RU.min';

export default {
  name: "economic-analysis-wells",
  components: {
    SelectGranularity
  },
  data: () => ({
    form: {
      uwi: null,
      granularity: 'month'
    },
    wells: null,
    sort: {
      isGroup: true
    },
    uwis: []
  }),
  async mounted() {
    this.$emit('updateWide', false)

    await this.getData()
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

        this.wells = data

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
          return 'Кандидат на остановку'
        case 0:
          return ''
        case 1:
          return 'Кандидат на запуск'
        case 2:
          return 'Не деоптимизировать'
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

    setUwis() {
      let uwis = {}

      this.wells.forEach(well => {
        uwis[well.uwi] = 1
      })

      this.uwis = Object.keys(uwis)
    },

    toggleSortKey(sortKey) {
      this.SET_LOADING(true)

      setTimeout(() => {
        this.sort[sortKey] = !this.sort[sortKey]

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

      this.getData()
    }
  },
  computed: {
    url() {
      return this.localeUrl('/economic/analysis/get-wells')
    },

    sumRow() {
      return this.tableHeaders.map((header, headerIndex) => {
        if (!headerIndex) {
          return 'Всего'
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
          name: 'Дата',
          key: 'date',
          isString: true,
          width: 90,
        },
        {
          name: 'Q н, факт',
          key: 'oil',
          width: 90,
        },
        {
          name: 'Q ж, факт',
          key: 'liquid',
          width: 90,
        },
        {
          name: 'Состояние',
          key: 'status_name',
          isString: true,
          isMultiple: true,
          width: 130,
        },
        {
          name: 'Причина потерь',
          key: 'loss_status_name',
          isString: true,
          isMultiple: true,
          width: 130,
        },
        {
          name: 'Операционная прибыль',
          key: 'operating_profit',
          width: 160,
        },
        {
          name: 'Рентабельность',
          key: 'profitability',
          isString: true,
          width: 130,
        },
        {
          name: 'Q н, прогноз',
          key: 'oil_forecast',
          width: 100,
        },
        {
          name: 'Q ж, прогноз',
          key: 'liquid_forecast',
          width: 100,
        },
        {
          name: 'Примечания',
          key: 'changed_status',
          isString: true,
          isMultiple: true,
          width: 140,
        },
        {
          name: 'Q н, предл.',
          key: 'oil_propose',
          width: 100,
        },
        {
          name: 'Q ж, предл.',
          key: 'liquid_propose',
          width: 100,
        },
        {
          name: 'Операционная прибыль, предл.',
          key: 'operating_profit_propose',
          width: 180,
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

      let sumRow = this.sumRow

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

      rows.unshift(sumRow)

      return rows
    },

    tableGroupData() {
      let rows = []

      if (!this.wells) {
        return rows
      }

      let sumRow = this.sumRow

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
</style>