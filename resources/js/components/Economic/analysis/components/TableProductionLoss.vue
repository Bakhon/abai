<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      {{ trans('economic_reference.production_loss_from_stops') }}
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
          {{ trans('economic_reference.incl_profitless_fund') }}
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
          {{ trans('economic_reference.proposed_variant') }}
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
              :is-profitable="row.isProfitable"
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
  paused_hours: 0,
  total_hours: 0,
}

import Subtitle from "../../components/Subtitle";
import TableProductionLossRow from "./TableProductionLossRow";

import {tableDataMixin} from "../../mixins/analysisMixin";

import {TechnicalWellLossStatusModel} from "../../models/TechnicalWellLossStatusModel";

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
        if (!TechnicalWellLossStatusModel.factualIds.includes(status.status_id)) return

        status.wells.forEach(date => count += date.profitless.uwi_count)
      })

      return count
    },

    tableProposedWells() {
      let wellKeys = Object.keys(STOPPED_WELL)

      let factualStoppedWells = this.proposedStoppedWells.map(() => {
        return {...STOPPED_WELL}
      })

      this.wellsByDates.forEach(status => {
        if (!TechnicalWellLossStatusModel.factualIds.includes(status.status_id)) return

        status.wells.forEach((date, dateIndex) => {
          wellKeys.forEach(wellKey => {
            factualStoppedWells[dateIndex][wellKey] += Math.abs(+date.profitless[wellKey])
          })
        })
      })

      let proposedStoppedWells = this.proposedStoppedWells.map(well => {
        well = {...well}

        wellKeys.forEach(wellKey => well[wellKey] = +well[wellKey])

        return well
      })

      return [
        {
          status_name: this.trans('economic_reference.factual_stops'),
          wells: this.tableData.dates.map((date, dateIndex) => ({
            profitless: factualStoppedWells[dateIndex]
          }))
        },
        {
          status_name: this.trans('economic_reference.additional_stops_from_profitless_fund'),
          wells: this.tableData.dates.map((date, dateIndex) => ({
            profitless: proposedStoppedWells[dateIndex]
          }))
        },
        {
          status_name: this.trans('economic_reference.additional_stops_from_less_profitable_fund'),
          wells: this.tableData.dates.map(() => ({
            profitless: {...STOPPED_WELL}
          }))
        },
        this.wellsByDates.find(wells =>
            wells.status_id === TechnicalWellLossStatusModel.DEOPTIMIZATION
        ),
        {
          ...{isProfitable: true},
          ...this.wellsByDates.find(wells =>
              wells.status_id === TechnicalWellLossStatusModel.DOWNLOAD_LIMIT
          )
        },
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