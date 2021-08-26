<template>
  <div class="text-white container-fluid bg-light p-4">
    <vue-table-dynamic
        ref="table"
        :params="tableParams"
        class="height-fit-content height-unset">
      <template
          v-for="(date, index) in data.dates"
          :slot="`column-${index+1}`"
          slot-scope="{ props }">
        <div :style="isColorful ? `color: ${props.cellData.color}` : ''">
          {{ props.cellData.label }}
        </div>
      </template>

      <template
          :slot="`column-${data.dates.length+1}`"
          slot-scope="{ props }">
        <div :style="isColorful ? `color: ${props.cellData.color}` : ''">
          {{ props.cellData.label }}
        </div>
      </template>
    </vue-table-dynamic>
  </div>
</template>

<script>
export default {
  name: "TableWells",
  props: {
    data: {
      required: true,
      type: Object
    },
    property: {
      required: true,
      type: String
    },
    isColorful: {
      required: false,
      type: Boolean
    }
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
        pageSize: 12,
        pageSizes: [12, 24, 48],
        headerHeight: 80,
        rowHeight: 50,
        columnWidth: this.tableHeaders.map((col, index) => ({
          column: index,
          width: index > 0 ? 90 : 100
        }))
      }
    },

    tableData() {
      return this.uwis.map(uwi => {
        let data = [uwi]

        let well = this.data.uwis[uwi]

        let wellSum = 0

        this.data.dates.forEach(date => {
          let value = well[this.property].hasOwnProperty(date)
              ? +well[this.property][date]
              : ''

          if (value) {
            wellSum += value
          }

          data.push({value: value, label: this.getLabel(value), color: this.getColor(value)})
        })

        data.push({value: wellSum, label: this.getLabel(wellSum), color: this.getColor(wellSum)})

        return data
      })
    },

    tableHeaders() {
      return [...['UWI'], ...this.data.dates, ...[this.trans('economic_reference.total')]]
    },
  },
  methods: {
    getColor(value) {
      return value && value > 0 ? '#13B062' : '#AB130E'
    },

    getLabel(value) {
      return value ? (+(value / 1000).toFixed(1)).toLocaleString() : value
    },
  }
}
</script>

<style scoped>
.height-fit-content >>> .v-table-body {
  height: fit-content !important;
}

.height-unset >>> .v-table-row {
  height: unset !important;
  padding: 5px 0;
}
</style>