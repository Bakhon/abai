<template>
  <div>
    <subtitle font-size="16" style="line-height: 18px">
      {{ trans('economic_reference.palette') }}
    </subtitle>

    <div class="mt-2 text-center border-grey">
      <div class="d-flex bg-header font-weight-600">
        <div class="py-3 border-grey d-flex align-items-center justify-content-center flex-350px">
          {{ trans('economic_reference.course') }}
          {{ (+scenario.dollar_rate).toLocaleString() }}
          {{ trans('economic_reference.tenge') }} / $
        </div>

        <div class="py-3 border-grey d-flex align-items-center justify-content-center flex-150px">
          {{ trans('economic_reference.pp_2020') }}
        </div>

        <div class="flex-grow-1">
          <div class="py-3 border-grey text-center">
            {{ trans('economic_reference.lithimized_production_program_with_oil_prices') }}
            {{ trans('economic_reference.dollar_per_bar') }}
          </div>

          <div class="d-flex">
            <div v-for="price in reverseOilPrices"
                 :key="price"
                 class="py-3 border-grey text-center flex-grow-1">
              {{ (+price).toLocaleString() }}
            </div>
          </div>
        </div>
      </div>

      <div v-for="(row, index) in tableData"
           :key="index"
           :class="index % 2 === 1 ? 'bg-light-blue' : 'bg-deep-blue'"
           :style="row.color ? `color: ${row.color}` : ''"
           class="d-flex">
        <div :style="row.bgColor ? `background: ${row.bgColor}` : ''"
             class="px-3 py-2 border-grey text-center flex-350px">
          {{ row.title }}
        </div>

        <div class="px-3 py-2 border-grey text-center flex-150px">
          {{ row.pp2020 }}
        </div>

        <div v-for="(column, columnIndex) in row.columns"
             :key="`${index}_${columnIndex}`"
             :style="`flex-basis: ${100 / row.columns.length}%; background: ${column.color}`"
             class="px-3 py-2 border-grey text-center flex-grow-1">
          {{ column.value.toLocaleString() }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

import {paletteMixin} from "../mixins/paletteMixin";

const ROMANS = {
  M: 1000,
  CM: 900,
  D: 500,
  CD: 400,
  C: 100,
  XC: 90,
  L: 50,
  XL: 40,
  X: 10,
  IX: 9,
  V: 5,
  IV: 4,
  I: 1
}

export default {
  name: "TablePalette",
  components: {
    Subtitle
  },
  mixins: [paletteMixin],
  methods: {
    convertToRoman(value) {
      let str = '';

      for (let i of Object.keys(ROMANS)) {
        let q = Math.floor(value / ROMANS[i])

        value -= q * ROMANS[i]

        str += i.repeat(q)
      }

      return str
    },

    getColorOperatingProfit(scenarioIndex, currentIndex, operatingProfit) {
      if (scenarioIndex === currentIndex) {
        return '#374AB4'
      }

      if (currentIndex - scenarioIndex > 0) {
        return scenarioIndex % 2 === 0 ? '#377B74' : '#31906F'
      }

      return scenarioIndex % 2 === 0 ? '#106B4B' : '#21615B'
    },
  },
  computed: {
    tableData() {
      return [
        ...[
          {
            title: this.trans('economic_reference.program_number'),
            pp2020: '',
            columns: this.scenariosByOilPrice.map((item, index) => {
              return {
                value: this.convertToRoman(index + 1)
              }
            }),
            color: '#81B9FE'
          },
          {
            title: `${this.trans('economic_reference.production')}, ${this.trans('economic_reference.thousand_tons')}`,
            pp2020: '',
            columns: this.scenariosByOilPrice.map(item => {
              return {
                value: +(+item.oil.original_value_optimized / 1000).toFixed(2)
              }
            })
          },
          {
            title: this.trans('economic_reference.stop_nrs'),
            pp2020: '',
            columns: this.scenariosByOilPrice.map(item => {
              let cat1 = +item.uwi_count_profitless_cat_1.original_value_optimized

              let cat2 = +item.uwi_count_profitless_cat_2.original_value_optimized

              return {
                value: cat1 + cat2
              }
            })
          },
          {
            title: `${this.trans('economic_reference.personnel_costs_payroll')}, ${this.trans('economic_reference.million_tenge')}`,
            pp2020: '',
            columns: this.scenariosByOilPrice.map(item => {
              return {
                value: +(+item.Fixed_noWRpayroll_expenditures.original_value_optimized / 1000000).toFixed(2)
              }
            })
          },
          {
            title: `${this.trans('economic_reference.kvl')}, ${this.trans('economic_reference.million_tenge')}`,
            pp2020: '',
            columns: this.scenariosByOilPrice.map(item => {
              return {
                value: ''
              }
            })
          },
        ],
        ...this.operatingProfitByOilPrice
      ]
    },
  },
}
</script>

<style scoped>
.font-weight-600 {
  font-weight: 600;
}

.border-grey {
  border: 1px solid #454D7D
}

.bg-header {
  background: #333975;
}

.bg-header-light {
  background: #454D7D;
}

.bg-light-blue {
  background: #313560;
}

.bg-deep-blue {
  background: #272953;
}

.flex-350px {
  flex: 0 0 350px;
}

.flex-150px {
  flex: 0 0 150px;
}
</style>