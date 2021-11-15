<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Потери добычи от остановок за май-октябрь 2020 г.
    </subtitle>

    <div class="customScroll">
      <div class="mt-2 d-flex">
        <table-production-loss-row
            v-for="(row, rowIndex) in wellsByDates"
            :key="rowIndex"
            :row="row"
            :dates="tableData.dates"
            :is-visible-dates="rowIndex === 0"
            :class="rowIndex ? 'ml-3' : ''"
            :style="`min-width: ${rowIndex ? 430 : 530}px`"
            class="h-100"
            is-profitable
            is-profitless
            is-visible-header
        />
      </div>

      <div class="mt-3">
        <subtitle font-size="16" class="mb-2 line-height-18px">
          В т.ч. нерентабельный фонд
        </subtitle>

        <div class="d-flex">
          <table-production-loss-row
              v-for="(row, rowIndex) in wellsByDates"
              :key="rowIndex"
              :row="row"
              :dates="tableData.dates"
              :is-visible-dates="rowIndex === 0"
              :class="rowIndex > 0 ? 'ml-3' : ''"
              :style="`min-width: ${rowIndex ? 430 : 530}px`"
              class="h-100"
              is-profitless
          />
        </div>
      </div>

      <div class="mt-3">
        <subtitle font-size="16" class="mb-2 line-height-18px">
          Предлагаемый вариант
        </subtitle>

        <div class="d-flex">
          <table-production-loss-row
              v-for="(row, rowIndex) in tableProposedWells"
              :key="rowIndex"
              :row="row"
              :dates="tableData.dates"
              :class="rowIndex > 0 ? 'ml-3' : ''"
              :style="`min-width: ${rowIndex ? 430 : 530}px`"
              :is-visible-dates="rowIndex === 0"
              is-profitless
              is-visible-header
              class="h-100"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const STOPPED_WELL = {
  uwi_count: 0,
  oil: 0,
  oil_forecast: 0,
  oil_loss: 0,
  liquid: 0,
  liquid_forecast: 0,
  liquid_loss: 0,
  total_hours: 0,
}

const LOSS_STATUS_DOWNLOAD_LIMIT = 3
const LOSS_STATUS_DEOPTIMIZATION = 7

import Subtitle from "../../components/Subtitle";
import TableProductionLossRow from "./TableProductionLossRow";

import {tableDataMixin} from "../../mixins/analysisMixin";

export default {
  name: "TableProductionLoss",
  components: {
    Subtitle,
    TableProductionLossRow
  },
  props: {
    proposedStoppedWells: {
      required: true,
      type: Array
    }
  },
  mixins: [
    tableDataMixin,
  ],
  created() {
    this.$emit('updateWide', this.tableData.statuses.length > 4)
  },
  computed: {
    stoppedWellsCount() {
      let count = 0

      this.wellsByDates.forEach(status => {
        if (!['НРС', 'ЧРФ', 'ОПЕК+'].includes(status.status_name)) return

        status.wells.forEach(date => count += date.profitless.uwi_count)
      })

      return count
    },

    tableProposedWells() {
      let wellKeys = Object.keys(STOPPED_WELL)

      let proposedStoppedWells = this.proposedStoppedWells.map(well => {
        well = {...well}

        wellKeys.forEach(wellKey => well[wellKey] = +well[wellKey])

        return well
      })

      let totalWellsByDate = JSON.parse(JSON.stringify(proposedStoppedWells));

      this.wellsByDates.forEach(status => {
        status.wells.forEach((date, dateIndex) => {
          wellKeys.forEach(wellKey => {
            totalWellsByDate[dateIndex][wellKey] += Math.abs(+date.profitless[wellKey])
          })
        })
      })

      return [
        {
          status_name: 'Фактические остановки',
          wells: this.tableData.dates.map((date, dateIndex) => ({
            profitless: totalWellsByDate[dateIndex]
          }))
        },
        {
          status_name: 'Доп. остановки из нерентаб. фонда',
          wells: this.tableData.dates.map((date, dateIndex) => ({
            profitless: proposedStoppedWells[dateIndex]
          }))
        },
        this.wellsByDates[this.tableData.statuses.findIndex(
            status => +status === LOSS_STATUS_DEOPTIMIZATION
        )],
        this.wellsByDates[this.tableData.statuses.findIndex(
            status => +status === LOSS_STATUS_DOWNLOAD_LIMIT
        )],
      ]
    }
  }
}
</script>

<style scoped>
.line-height-18px {
  line-height: 18px;
}

.customScroll {
  overflow-x: auto;
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}
</style>