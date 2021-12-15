<template>
  <div class=" d-flex flex-column bg-light-blue text-center text-nowrap flex-grow-1 font-size-14px line-height-16px">
    <div class="d-flex">
      <div v-if="isVisibleHeader && isVisibleDates"
           class="bg-blue border-grey p-1 font-weight-600 d-flex align-items-center justify-content-center width-100px">
        {{ trans('economic_reference.months') }}
      </div>

      <div v-if="isVisibleHeader" class="flex-grow-1">
        <div class="bg-blue border-grey p-1 font-weight-600">
          {{ row.status_name }}
        </div>

        <div class="bg-blue d-flex font-weight-600">
          <div class="border-grey flex-20 p-1">
            {{ trans('economic_reference.well_short') }}
          </div>

          <div class="border-grey flex-20 p-1">
            {{ trans('economic_reference.liquid_production_q_short') }},
            {{ trans('economic_reference.thousand') }}
            {{ trans('economic_reference.cubic_meter') }}
          </div>

          <div class="border-grey flex-20 p-1">
            {{ trans('economic_reference.oil_production_q_short') }},
            {{ trans('economic_reference.thousand_t') }}
          </div>

          <div class="border-grey flex-20 p-1">
            %
          </div>

          <div class="border-grey flex-20 p-1">
            {{ trans('economic_reference.days') }}
          </div>
        </div>
      </div>
    </div>

    <div class="flex-grow-1 d-flex flex-column customScroll">
      <div v-for="(date, dateIndex) in dates"
           :key="dateIndex"
           class="flex-grow-1 d-flex font-size-12px line-height-14px">
        <div v-if="isVisibleDates"
             class="border-grey px-3 py-1 width-100px d-flex align-items-center">
          {{ date }}
        </div>

        <div class="d-flex flex-grow-1">
          <div class="border-grey flex-20 p-1 d-flex align-items-center justify-content-center">
            {{ row[wellsKey][dateIndex][profitability].uwi_count }}
          </div>

          <div class="border-grey flex-20 p-1 d-flex align-items-center justify-content-center">
            {{ localeValue(row[wellsKey][dateIndex][profitability].liquid_loss, 1000, true) }}
          </div>

          <div class="border-grey flex-20 p-1 d-flex align-items-center justify-content-center">
            {{ localeValue(row[wellsKey][dateIndex][profitability].oil_loss, 1000, true) }}
          </div>

          <div class="border-grey flex-20 p-1 d-flex align-items-center justify-content-center">
            {{
              calcWaterCut(
                  Math.abs(row[wellsKey][dateIndex][profitability].liquid_loss),
                  Math.abs(row[wellsKey][dateIndex][profitability].oil_loss)
              )
            }}
          </div>

          <div class="border-grey flex-20 p-1 d-flex align-items-center justify-content-center">
            {{
              localeValue(row[wellsKey][dateIndex][profitability].paused_hours, 24, false, 0)
            }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {waterCutMixin} from "../../mixins/wellMixin";
import {formatValueMixin} from "../../mixins/formatMixin";

export default {
  name: "TableProductionLossRow",
  mixins: [
    waterCutMixin,
    formatValueMixin
  ],
  props: {
    row: {
      required: true,
      type: Object
    },
    wellsKey: {
      required: false,
      type: String,
      default: 'wells'
    },
    dates: {
      required: true,
      type: Array
    },
    isProfitable: {
      required: false,
      type: Boolean
    },
    isProfitless: {
      required: false,
      type: Boolean
    },
    isVisibleHeader: {
      required: false,
      type: Boolean
    },
    isVisibleDates: {
      required: false,
      type: Boolean
    }
  },
  methods: {
    calcSum(status, statusKey) {
      let sum = 0

      this.dates.forEach((date, dateIndex) => {
        if (this.isProfitable) {
          sum += status[this.wellsKey][dateIndex].profitable[statusKey]
        }

        if (this.isProfitless) {
          sum += status[this.wellsKey][dateIndex].profitless[statusKey]
        }
      })

      return sum
    },
  },
  computed: {
    profitability() {
      if (this.isProfitable && this.isProfitless) {
        return 'total'
      }

      return this.isProfitable ? 'profitable' : 'profitless'
    },
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

.width-100px {
  width: 100px;
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

.customScroll {
  overflow: hidden;
  height: 120px;
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}

.pr-10px {
  padding-right: 10px;
}
</style>