<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      {{ subTitle }}
    </subtitle>

    <div class="customScroll overflow-auto">
      <div :style="`min-width: ${100 + tableData.statuses.length * 270}px`"
           class="mt-2 text-white font-size-12px line-height-14px">
        <div class="bg-blue font-weight-600 text-center border-grey position-relative py-2 height-30px">
          <div class="fixed-header">
            {{ wellTitle }}
          </div>
        </div>

        <div class="font-weight-600 pr-10px d-flex">
          <div class="bg-blue p-1 border-grey d-flex align-items-center justify-content-center flex-grow-1"
               style="min-width: 100px">
            {{ trans('economic_reference.months') }}
          </div>

          <div v-for="(statusName, statusIndex) in tableData.statusNames"
               :key="statusIndex"
               :style="`flex: 0 0 ${90 / tableData.statuses.length}%`"
               class="bg-blue text-center">
            <div class="p-1 border-grey text-nowrap">
              {{ statusName }}
            </div>

            <div class="d-flex">
              <div v-for="(column, columnIndex) in columns"
                   :key="columnIndex"
                   :style="`flex: 0 0 ${100 / columns.length}%; min-width: 90px`"
                   class="py-2 px-1 border-grey">
                {{ column.name }}
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex flex-column customScroll table-oil-production">
          <table-oil-production-loss-row
              v-for="(row, rowIndex) in tableUwiCount"
              :key="rowIndex"
              :row="row"
              :statuses="tableData.statuses"
              :columns="columns"
              :style="row.style"
              class="flex-grow-1"/>

          <table-oil-production-loss-row
              v-if="isUwiCountWithOilLoss"
              :row="totalRowOilLoss"
              :statuses="tableData.statuses"
              :columns="columns"
              :style="totalRowOilLoss.style"
              class="flex-grow-1"
              is-absolute/>

          <table-oil-production-loss-row
              v-if="isUwiCountWithOperatingProfit"
              :row="totalRowOperatingProfit"
              :statuses="tableData.statuses"
              :columns="columns"
              :style="totalRowOperatingProfit.style"
              class="flex-grow-1"
              is-absolute/>
        </div>
      </div>

      <div :style="`min-width: ${100 + tableData.statuses.length * 270}px`"
           class="text-white font-size-12px line-height-14px mt-3">
        <div class="bg-blue font-weight-600 text-center border-grey position-relative py-2 height-30px">
          <div class="fixed-header">
            {{ lossTitle }}
          </div>
        </div>

        <div class="customScroll table-oil-production">
          <div class="h-100 d-flex flex-column">
            <table-oil-production-loss-row
                v-for="(row, rowIndex) in isPrs ? tablePrs : tableOilLoss"
                :key="rowIndex"
                :row="row"
                :statuses="tableData.statuses"
                :columns="columns"
                :style="row.style"
                :dimension="1000"
                is-absolute
                class="flex-grow-1"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../../components/Subtitle";
import TableOilProductionLossRow from "./TableOilProductionLossRow";

import {tableDataMixin} from "../../mixins/analysisMixin";

export default {
  name: "TableOilProductionLoss",
  components: {
    Subtitle,
    TableOilProductionLossRow
  },
  mixins: [
    tableDataMixin
  ],
  props: {
    wells: {
      required: true,
      type: Array
    },
    isTechLoss: {
      required: false,
      type: Boolean
    },
    isPrs: {
      required: false,
      type: Boolean
    },
    isUwiCountWithOilLoss: {
      required: false,
      type: Boolean
    },
    isUwiCountWithOperatingProfit: {
      required: false,
      type: Boolean
    },
    title: {
      required: false,
      type: String
    }
  },
  created() {
    this.$emit('updateWide', this.tableData.statuses.length > 6)
  },
  computed: {
    wellTitle() {
      return this.isTechLoss
          ? this.trans('economic_reference.count_well_for_technological_reasons')
          : this.trans('economic_reference.count_stopped_wells')
    },

    lossTitle() {
      return this.isPrs
          ? `${this.trans('economic_reference.prs_costs')}, ${this.trans('economic_reference.million_tenge')}`
          : `${this.trans('economic_reference.oil_losses')}, ${this.trans('economic_reference.thousand_tons')}`
    },

    subTitle() {
      if (this.title) {
        return this.title
      }

      return this.isTechLoss
          ? this.trans('economic_reference.table_oil_production_tech_loss_title')
          : this.trans('economic_reference.table_oil_production_loss_title')
    }
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

.table-oil-production {
  overflow-y: scroll;
  overflow-x: hidden;
  height: 210px
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}

.height-30px {
  height: 30px;
}

.fixed-header {
  position: fixed;
  left: 45%;
  transform: translateX(-50%);
}
</style>