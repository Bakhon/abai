<template>
  <div class="text-white container-fluid bg-light p-4">
    <vue-table-dynamic
        ref="table"
        :params="tableParams"
        class="height-fit-content height-unset">
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
</template>

<script>
export default {
  name: "TableMatrix",
  props: {
    data: {
      required: true,
      type: Object
    },
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
        fixed: 1,
        columnWidth: this.tableHeaders.map((col, index) => ({
          column: index,
          width: index > 0 ? 90 : 110
        })),
        highlight: {column: [0, 1]},
        highlightedColor: '#E6E6E6'
      }
    },

    tableData() {
      let rows = []

      this.uwis.forEach(uwi => {
        let tableRows = {uwi: []}

        this.wellKeys.forEach(key => tableRows[key.prop] = [])

        let well = this.data.uwis[uwi]

        this.data.dates.forEach(date => {
          this.wellKeys.forEach(key => {
            let value = well[key.prop].hasOwnProperty(date)
                ? +well[key.prop][date]
                : ''

            tableRows[key.prop].push({
              value: value,
              label: this.getLabel(value),
              color: this.getColor(key, value)
            })
          })

          tableRows.uwi.push({value: '', label: ''})
        })

        tableRows.uwi.unshift({value: '', label: ''})

        tableRows.uwi.unshift(uwi)

        rows.push(tableRows.uwi)

        this.wellKeys.forEach(key => {
          tableRows[key.prop].unshift({
            value: +well[key.prop]['sum'],
            label: this.getLabel(+well[key.prop]['sum']),
            color: this.getColor(key, +well[key.prop]['sum'])
          })

          tableRows[key.prop].unshift(key.name)

          rows.push(tableRows[key.prop])
        })
      })

      return rows
    },

    tableHeaders() {
      return [...['', this.trans('economic_reference.total')], ...this.data.dates]
    },

    wellKeys() {
      return [
        {
          prop: 'NetBack_bf_pr_exp',
          name: this.trans('economic_reference.Revenue')
        },
        {
          prop: 'Overall_expenditures',
          name: this.trans('economic_reference.costs')
        },
        {
          prop: 'Operating_profit',
          name: this.trans('economic_reference.operating_profit'),
          colorful: true
        }
      ]
    }
  },
  methods: {
    getColor(key, value) {
      if (!key.colorful) return ''

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
  height: 40px !important;
}
</style>