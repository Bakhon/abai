<template>
  <div>
    <chart-matrix
        v-for="uwi in chartUwis"
        :key="uwi"
        :uwi="uwi"
        :well="data.uwis[uwi]"
        :dates="data.dates"
        class="text-white container-fluid bg-main1 p-4 mb-3"/>

    <div class="text-white container-fluid bg-light p-4">
      <div class="d-flex">
        <div v-for="(wellKey, index) in wellKeys"
             :key="wellKey.prop"
             :class="index ? 'ml-2' : ''"
             class="form-check">
          <input v-model="wellKey.isVisible"
                 :id="wellKey.prop"
                 type="checkbox"
                 class="form-check-input">
          <label :for="wellKey.prop"
                 class="form-check-label"
                 style="font-weight: 600; color: #000">
            {{ wellKey.name }}
          </label>
        </div>
      </div>

      <vue-table-dynamic
          :params="tableParams"
          class="height-fit-content height-unset">
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
    wellKeys: []
  }),
  created() {
    this.initWellKeys()

    this.initSelectedUwis()
  },
  computed: {
    uwis() {
      return Object.keys(this.data.uwis)
    },

    tableParams() {
      return {
        data: [...[this.tableHeaders], ...this.tableData],
        enableSearch: true,
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
          width: index > 0 ? 90 : 130
        })),
        highlight: {column: [0, 1]},
        highlightedColor: '#E6E6E6'
      }
    },

    tableData() {
      let rows = []

      this.uwis.forEach(uwi => {
        let tableRows = {uwi: []}

        this.visibleWellKeys.forEach(key => tableRows[key.prop] = [])

        let well = this.data.uwis[uwi]

        this.data.dates.forEach(date => {
          this.visibleWellKeys.forEach(key => {
            let value = well[key.prop].hasOwnProperty(date)
                ? +well[key.prop][date]
                : ''

            tableRows[key.prop].push({
              value: value,
              label: this.getLabel(value, key.dimension),
              color: this.getColor(key, value)
            })
          })

          tableRows.uwi.push({value: '', label: ''})
        })

        tableRows.uwi.unshift(
            {value: uwi, label: uwi, isCheckbox: true},
            {value: '', label: ''}
        )

        rows.push(tableRows.uwi)

        this.visibleWellKeys.forEach(key => {
          tableRows[key.prop].unshift(
              {
                value: key.name,
                label: key.name,
              },
              {
                value: +well[key.prop]['sum'],
                label: this.getLabel(+well[key.prop]['sum'], key.dimension),
                color: this.getColor(key, +well[key.prop]['sum'])
              }
          )

          rows.push(tableRows[key.prop])
        })
      })

      return rows
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

    tablePageSize(){
      return (this.visibleWellKeys.length + 1) * 3
    },

    visibleWellKeys() {
      return this.wellKeys.filter(key => key.isVisible)
    }
  },
  methods: {
    getColor(key, value) {
      if (!key.isColorful) {
        return ''
      }

      return value && value > 0 ? '#13B062' : '#AB130E'
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
          prop: 'NetBack_bf_pr_exp',
          name: this.trans('economic_reference.Revenue'),
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'Overall_expenditures',
          name: this.trans('economic_reference.costs'),
          dimension: 1000,
          isVisible: true,
        },
        {
          prop: 'Operating_profit',
          name: this.trans('economic_reference.operating_profit'),
          dimension: 1000,
          isVisible: true,
          isColorful: true,
        },
        {
          prop: 'oil',
          name: this.trans('economic_reference.oil_production'),
          isVisible: false,
        },
        {
          prop: 'liquid',
          name: this.trans('economic_reference.liquid_production'),
          isVisible: false,
        }
      ]
    },

    initSelectedUwis() {
      this.uwis.forEach(uwi => this.selectedUwis[uwi] = false)
    },
  }
}
</script>

<style scoped>
.height-fit-content >>> .v-table-body {
  height: fit-content !important;
}

.height-unset >>> .v-table-row {
  height: 40px !important;
}
</style>