<template>
  <div class="bg-light-blue text-center text-nowrap flex-grow-1 font-size-14px line-height-16px">
    <div class="d-flex">
      <div v-if="isVisibleMonths"
           class="bg-blue border-grey px-2 py-1 font-weight-600 d-flex align-items-center justify-content-center width-100px">
        Месяцы
      </div>

      <div class="flex-grow-1">
        <div class="bg-blue border-grey px-2 py-1 font-weight-600">
          {{ row.name }}
        </div>

        <div v-if="isVisibleHeader"
             class="bg-blue d-flex font-weight-600">
          <div class="border-grey flex-20 px-2 py-1">
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

          <div class="border-grey flex-20 px-2 py-1">
            Дни
          </div>
        </div>
      </div>
    </div>

    <div v-for="(date, dateIndex) in dates"
         :key="dateIndex"
         class="d-flex font-size-12px line-height-14px">
      <div v-if="isVisibleMonths" class="border-grey px-2 py-1 width-100px">
        {{ date }}
      </div>

      <div class="d-flex flex-grow-1">
        <div class="border-grey flex-20 px-2 py-1">
          {{ row.dates[dateIndex][profitability].uwi_count }}
        </div>

        <div class="border-grey flex-20 px-2 py-1">
          {{ localeValue(row.dates[dateIndex][profitability].liquid_loss, 1000) }}
        </div>

        <div class="border-grey flex-20 px-2 py-1">
          {{ localeValue(row.dates[dateIndex][profitability].oil_loss, 1000) }}
        </div>

        <div class="border-grey flex-20 px-2 py-1">
          {{
            calcWaterCut(
                Math.abs(row.dates[dateIndex][profitability].liquid),
                Math.abs(row.dates[dateIndex][profitability].oil)
            )
          }}
        </div>

        <div class="border-grey flex-20 px-2 py-1">
          {{
            localeValue(row.dates[dateIndex][profitability].paused_hours, 24)
          }}
        </div>
      </div>
    </div>

    <div class="d-flex bg-blue font-weight-600">
      <div v-if="isVisibleMonths" class="border-grey px-2 py-1 width-100px">
        Всего
      </div>

      <div class="d-flex flex-grow-1">
        <div class="border-grey flex-20 px-2 py-1">
          {{ calcSum(row, 'uwi_count') }}
        </div>

        <div class="border-grey flex-20 px-2 py-1">
          {{ localeValue(calcSum(row, 'liquid_loss'), 1000) }}
        </div>

        <div class="border-grey flex-20 px-2 py-1">
          {{ localeValue(calcSum(row, 'oil_loss'), 1000) }}
        </div>

        <div class="border-grey flex-20 px-2 py-1">
          {{ calcWaterCut(calcSum(row, 'liquid'), calcSum(row, 'oil')) }}
        </div>

        <div class="border-grey flex-20 px-2 py-1">
          {{ localeValue(calcSum(row, 'paused_hours'), 24) }}
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
    isVisibleMonths: {
      required: false,
      type: Boolean
    }
  },
  methods: {
    calcSum(status, statusKey) {
      let sum = 0

      this.dates.forEach((date, dateIndex) => {
        if (this.isProfitable) {
          sum += status.dates[dateIndex].profitable[statusKey]
        }

        if (this.isProfitless) {
          sum += status.dates[dateIndex].profitless[statusKey]
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
</style>