<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Технологические потери: добыча рентабельных и нерентабельных скважин
    </subtitle>

    <div class="mt-2 text-white font-size-12px line-height-14px">
      <div class="bg-blue font-weight-600 pr-10px">
        <div class="pr-1 py-2 text-center border-grey pl-10">
          Количество скважин в простое по технологическим причинам
        </div>

        <div class="d-flex">
          <div class="py-1 px-2 border-grey d-flex align-items-center justify-content-center flex-10">
            Месяцы
          </div>

          <div v-for="(status, statusIndex) in statuses"
               :key="statusIndex"
               class="text-center flex-18">
            <div class="p-1 border-grey text-nowrap">
              {{ status.name }}
            </div>

            <div class="d-flex">
              <div v-for="(column, columnIndex) in columns"
                   :key="columnIndex"
                   :style="`flex: 0 0 ${100 / columns.length}%`"
                   class="py-2 px-1 border-grey">
                {{ column.name }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex flex-column customScroll">
        <table-oil-production-tech-loss-row
            v-for="(row, rowIndex) in tableRows"
            :key="rowIndex"
            :row="row"
            :titles="statuses"
            :sub-titles="columns"
            :style="row.style"
            class="flex-grow-1"/>
      </div>
    </div>

    <div class="text-white font-size-12px line-height-14px mt-3">
      <div class="bg-blue font-weight-600 pr-1 py-2 text-center border-grey pl-10">
        Потери нефти, тонн
      </div>

      <div class="d-flex flex-column customScroll">
        <table-oil-production-tech-loss-row
            v-for="(row, rowIndex) in tableOilRows"
            :key="rowIndex"
            :row="row"
            :titles="statuses"
            :sub-titles="columns"
            :style="row.style"
            class="flex-grow-1"/>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../Subtitle";
import TableOilProductionTechLossRow from "./TableOilProductionTechLossRow";

export default {
  name: "TableOilProductionTechLoss",
  components: {
    Subtitle,
    TableOilProductionTechLossRow
  },
  props: {
    wells: {
      required: true,
      type: Array
    }
  },
  computed: {
    tableData() {
      let wellsByStatuses = {}

      let dates = {}

      this.wells.forEach(well => {
        dates[well.date] = 1

        if (!wellsByStatuses.hasOwnProperty(well.status_id)) {
          wellsByStatuses[well.status_id] = []
        }

        wellsByStatuses[well.status_id].push(well)
      })

      dates = Object.keys(dates)

      let statuses = Object.keys(wellsByStatuses).map(status => {
        let wells = wellsByStatuses[status]

        return {
          name: wells[0].status_name,
          dates: dates.map(date => {
            let wellsByDate = wells.filter(well => well.date === date)

            let profitable = wellsByDate.find(well => well.profitability = 'profitable') || DEFAULT_WELL

            let profitless = wellsByDate.find(well => well.profitability = 'profitless') || DEFAULT_WELL

            let total = {}

            Object.keys(DEFAULT_WELL).forEach(wellKey => {
              total[wellKey] = profitable[wellKey] + profitless[wellKey]
            })

            return {
              profitable: profitable,
              profitless: profitless,
              total: total
            }
          })
        }
      })

      return {
        dates: dates,
        statuses: statuses
      }
    },

    tableRows() {
      let rows = this.tableData.dates.map((date, dateIndex) => {
        return {
          date: date,
          values: this.statuses.map((status, statusIndex) => {
            return this.columns.map(column => {
              return this.tableData.statuses[statusIndex].dates[dateIndex][column.key].uwi_count
            })
          }),
          style: `background: ${dateIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`
        }
      })

      rows.push({
        date: 'Общий итог',
        values: this.statuses.map((status, statusIndex) => {
          return this.columns.map((column, columnIndex) => {
            let sum = 0

            rows.forEach(row => {
              sum += row.values[statusIndex][columnIndex]
            })

            return sum
          })
        }),
        style: 'background: #323D85; font-weight: 600'
      })

      return rows
    },

    tableOilRows() {
      let rows = this.tableData.dates.map((date, dateIndex) => {
        return {
          date: date,
          values: this.statuses.map((status, statusIndex) => {
            return this.columns.map(column => {
              return this.tableData.statuses[statusIndex].dates[dateIndex][column.key].oil_loss
            })
          }),
          style: `background: ${dateIndex % 2 === 0 ? '#2B2E5E' : '#333868'}`
        }
      })

      rows.push({
        date: 'Общий итог',
        values: this.statuses.map((status, statusIndex) => {
          return this.columns.map((column, columnIndex) => {
            let sum = 0

            rows.forEach(row => {
              sum += row.values[statusIndex][columnIndex]
            })

            return sum
          })
        }),
        style: 'background: #323D85; font-weight: 600'
      })

      return rows
    },

    statuses() {
      return this.tableData.statuses.map(status => ({name: status.name}))
    },

    columns() {
      return [
        {
          name: 'Всего',
          key: 'total'
        },
        {
          name: 'Рентаб.',
          key: 'profitable'
        },
        {
          name: 'Нерент.',
          key: 'profitless'
        },
      ]
    },
  }
}
</script>

<style scoped>
.bg-blue {
  background: #333975;
}

.border-grey {
  border: 1px solid #454D7D
}

.flex-10 {
  flex: 0 0 10%;
}

.flex-18 {
  flex: 0 0 18%;
}

.pl-10 {
  padding-left: 10%;
}

.pr-10px {
  padding-right: 10px;
}

.font-weight-600 {
  font-weight: 600;
}

.font-size-12px {
  font-size: 12px;
}

.line-height-14px {
  line-height: 14px;
}

.line-height-18px {
  line-height: 18px;
}

.customScroll {
  overflow-y: scroll;
  height: 210px
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}
</style>