<template>
  <div>
    <subtitle font-size="16" class="line-height-18px">
      Потери добычи от остановок за май-октябрь 2020 г.
    </subtitle>

    <div class="mt-3">
      <div class="d-flex">
        <div v-for="(status, statusIndex) in tableData.statuses"
             :key="statusIndex"
             :class="statusIndex > 1 ? 'ml-3' : ''"
             class="bg-light-blue text-center text-nowrap flex-grow-1 font-size-14px line-height-16px">
          <div class="bg-blue border-grey px-2 py-1 font-weight-600">
            {{ status.name }}
          </div>

          <div class="bg-blue d-flex font-weight-600">
            <div class="border-grey flex-40 px-2 py-1">
              Скв
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              Q ж, м3
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              Q н, т
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              %
            </div>
          </div>

          <div v-for="(date, dateIndex) in tableData.dates"
               :key="`${statusIndex}_${dateIndex}`"
               class="d-flex font-size-12px line-height-14px">
            <div class="border-grey flex-40 px-2 py-1">
              {{ status.dates[dateIndex].total.uwi_count }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{ status.dates[dateIndex].total.liquid_loss }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{ status.dates[dateIndex].total.oil_loss }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{
                calcWaterCut(
                    status.dates[dateIndex].total.liquid,
                    status.dates[dateIndex].total.oil
                )
              }}
            </div>
          </div>

          <div class="d-flex bg-blue font-weight-600">
            <div class="border-grey flex-40 px-2 py-1">
              {{ calcSum(status, 'uwi_count', true, true) }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{ calcSum(status, 'liquid_loss', true, true) }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{ calcSum(status, 'oil_loss', true, true) }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{
                calcWaterCut(
                    calcSum(status, 'liquid', true, true),
                    calcSum(status, 'oil', true, true)
                )
              }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-2">
      <subtitle font-size="16" class="mb-2 line-height-18px">
        В т.ч. нерентабельный фонд
      </subtitle>

      <div class="d-flex">
        <div v-for="(status, statusIndex) in tableData.statuses"
             :key="statusIndex"
             :class="statusIndex > 1 ? 'ml-3' : ''"
             class="bg-light-blue text-center text-nowrap flex-grow-1 font-size-14px line-height-16px">

          <div v-for="(date, dateIndex) in tableData.dates"
               :key="`${statusIndex}_${dateIndex}`"
               class="d-flex font-size-12px line-height-14px">
            <div class="border-grey flex-40 px-2 py-1">
              {{ status.dates[dateIndex].profitless.uwi_count }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{ status.dates[dateIndex].profitless.liquid_loss }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{ status.dates[dateIndex].profitless.oil_loss }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{
                calcWaterCut(
                    status.dates[dateIndex].profitless.liquid,
                    status.dates[dateIndex].profitless.oil
                )
              }}
            </div>
          </div>

          <div class="d-flex bg-blue font-weight-600">
            <div class="border-grey flex-40 px-2 py-1">
              {{ calcSum(status, 'uwi_count', false, true) }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{ calcSum(status, 'liquid_loss', false, true) }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{ calcSum(status, 'oil_loss', false, true) }}
            </div>

            <div class="border-grey flex-20 px-2 py-1">
              {{
                calcWaterCut(
                    calcSum(status, 'liquid', false, true),
                    calcSum(status, 'oil', false, true)
                )
              }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "../Subtitle";

import {waterCutMixin} from "../../mixins/wellMixin";

const DEFAULT_WELL = {
  uwi_count: 0,
  oil: 0,
  oil_loss: 0,
  liquid: 0,
  liquid_loss: 0,
}

export default {
  name: "TableProductionLoss",
  components: {
    Subtitle
  },
  mixins: [waterCutMixin],
  props: {
    wells: {
      required: true,
      type: Array
    },
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
  },
  methods: {
    calcSum(status, statusKey, isProfitable, isProfitless) {
      let sum = 0

      this.tableData.dates.forEach((date, dateIndex) => {
        if (isProfitable) {
          sum += status.dates[dateIndex].profitable[statusKey]
        }

        if (isProfitless) {
          sum += status.dates[dateIndex].profitless[statusKey]
        }
      })

      return sum
    }
  }
}
</script>

<style scoped>
.bg-blue {
  background: #333975;
}

.bg-light-blue {
  background: #2B2E5E;
}

.border-grey {
  border: 1px solid #454D7D
}

.flex-40 {
  flex: 1 0 40%;
}

.flex-20 {
  flex: 1 0 20%;
}

.font-weight-600 {
  font-weight: 600;
}

.font-size-12px {
  font-size: 12px;
}

.font-size-14px {
  font-size: 14px;
}

.line-height-14px {
  line-height: 14px;
}

.line-height-16px {
  line-height: 16px;
}

.line-height-18px {
  line-height: 18px;
}
</style>