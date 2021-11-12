<template>
  <div class="mt-2 customScroll overflow-auto" style="max-height: 575px">
    <select-granularity
        :form="form"
        class="flex-grow-1 mb-2"
        @change="getData()"/>

    <div class="form-check mb-2 mr-2">
      <input v-model="isGroupData"
             id="table_sum"
             type="checkbox"
             class="form-check-input">
      <label for="table_sum"
             class="form-check-label text-blue">
        Сгруппировать значения
      </label>
    </div>

    <vue-table-dynamic
        :params="tableParams"
        class="matrix-table bg-main1 pb-0">
      <template
          v-for="(header, index) in tableHeaders"
          :slot="`column-${index}`" slot-scope="{ props }">
        <div :class="isGroupData && header.isMultiple && props.cellData && props.cellData.length > 34
                     ? 'pt-35px'
                     : 'pt-2'"
             class="h-100 customScroll pb-2 d-flex align-items-center"
             style="overflow-x: hidden; overflow-y: auto">
          {{ header.isString ? props.cellData : (+props.cellData.toFixed(2)).toLocaleString() }}
        </div>
      </template>
    </vue-table-dynamic>
  </div>
</template>

<script>
import {globalloadingMutations} from '@store/helpers';

import SelectGranularity from "../SelectGranularity";

export default {
  name: "TableMatrix",
  components: {
    SelectGranularity
  },
  data: () => ({
    form: {
      granularity: 'month'
    },
    wells: null,
    isGroupData: true
  }),
  created() {
    this.$emit('updateWide', false)

    this.getData()
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true)

      try {
        const {data} = await this.axios.get(this.url, {params: this.form})

        this.wells = data
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
      return this.tableHeaders.map(header =>
          isConvertChangedStatus && header.key === 'changed_status'
              ? this.getChangedStatus(well)
              : well[header.key]
      )
    }
  },
  computed: {
    url() {
      return this.localeUrl('/economic/analysis/get-wells-by-date')
    },

    tableParams() {
      let tableData = this.isGroupData ? 'tableGroupData' : 'tableData'

      return {
        data: [...[this.tableHeaders.map(header => header.name)], ...this[tableData]],
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        pageSize: 10,
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
          width: 80,
        },
        {
          name: 'Q ж, факт',
          key: 'liquid',
          width: 80,
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
          width: 120,
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
          name: 'Q н, предл',
          key: 'oil_propose',
          width: 80,
        },
        {
          name: 'Q ж, предл',
          key: 'liquid_propose',
          width: 80,
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

      this.wells.forEach(well => {
        if (well.date === well.date_month && !well.status_name && !well.loss_status_name) {
          well.date = `${well.date} - ...`
        }

        rows.push(this.getTableRow(well, true))
      })

      return rows
    },

    tableGroupData() {
      let rows = []

      if (!this.wells) {
        return rows
      }

      let currentWell = null

      this.wells.forEach(well => {
        well = {...well}

        well.changed_status = this.getChangedStatus(well)

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

        currentWell.profitability = currentWell.operating_profit > 0 ? 'profitable' : 'profitless'

        rows.push(this.getTableRow(currentWell))

        return currentWell = well
      })

      if (currentWell) {
        rows.push(this.getTableRow(currentWell))
      }

      return rows
    },
  }
}
</script>

<style scoped>
.matrix-table >>> .v-table-body {
  height: fit-content !important;
}

.matrix-table >>> .v-table-row {
  height: 42px !important;
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