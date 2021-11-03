<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      {{
        isTechLoss
            ? 'Технологические потери: добыча рентабельных и нерентабельных скважин'
            : 'Потери от остановок: добыча рентабельных и нерентабельных скважин'
      }}
    </subtitle>

    <div class="mt-2 text-white font-size-12px line-height-14px">
      <div class="bg-blue font-weight-600 pr-10px">
        <div class="pr-1 py-2 text-center border-grey pl-10">
          {{
            isTechLoss
                ? 'Количество скважин в простое по технологическим причинам'
                : 'Количество скважин, остановленных НРС, ЧРФ, Опек+'
          }}
        </div>

        <div class="d-flex">
          <div class="py-1 px-2 border-grey d-flex align-items-center justify-content-center flex-10">
            Месяцы
          </div>

          <div v-for="(status, statusIndex) in statuses"
               :key="statusIndex"
               :style="`flex: 0 0 ${90 / statuses.length}%`"
               class="text-center">
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
        <table-oil-production-loss-row
            v-for="(row, rowIndex) in tableUwiCount"
            :key="rowIndex"
            :row="row"
            :statuses="statuses"
            :columns="columns"
            :style="row.style"
            class="flex-grow-1"/>
      </div>
    </div>

    <div class="text-white font-size-12px line-height-14px mt-3">
      <div class="bg-blue font-weight-600 pr-1 py-2 text-center border-grey pl-10">
        {{ isPrs ? 'Расходы на ПРС, млн тенге' : 'Потери нефти, тонн' }}
      </div>

      <div class="d-flex flex-column customScroll">
        <table-oil-production-loss-row
            v-for="(row, rowIndex) in isPrs ? tablePrs : tableOilLoss"
            :key="rowIndex"
            :row="row"
            :statuses="statuses"
            :columns="columns"
            :style="row.style"
            class="flex-grow-1"/>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../Subtitle";
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
    }
  },
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