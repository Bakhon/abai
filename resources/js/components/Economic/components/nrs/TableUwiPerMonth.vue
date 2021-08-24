<template>
  <div class="text-white container-fluid bg-light p-4">
    <vue-table-dynamic
        ref="table"
        :params="tableParams"
        class="height-fit-content height-unset"/>
  </div>
</template>

<script>
export default {
  name: "TableUwiPerMonth",
  props: {
    data: {
      required: true,
      type: Object
    },
    property: {
      required: true,
      type: String
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
          width: index > 0 ? 75 : 80
        }))
      }
    },

    tableData() {
      return this.uwis.map(uwi => {
        let data = [uwi]

        let well = this.data.uwis[uwi]

        this.data.dates.forEach(date => {
          data.push(
              well[this.property].hasOwnProperty(date)
                  ? `${well[this.property][date][0]} ${well[this.property][date][1]}`
                  : ''
          )
        })

        return data
      })
    },

    tableHeaders() {
      return [...['UWI'], ...this.data.dates]
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