<template>
  <div class="text-white">
    <subtitle font-size="18" style="line-height: 26px">
      <div>{{ trans('economic_reference.table_chess_title') }}</div>
    </subtitle>

    <div class="mt-3 border-grey bg-header">
      <div class="px-3 py-1 border-grey"
           style="font-size: 16px; line-height: 20px; font-weight: 600">
        {{ trans('economic_reference.table_chess_subtitle') }}
      </div>

      <div v-for="(row, index) in tableData"
           :key="index"
           :class="row.styleClass"
           class="d-flex">
        <div class="px-3 py-1 border-grey text-center flex-300px">
          {{ row.title }}
        </div>

        <div class="px-3 py-1 border-grey text-center flex-120px">
          {{ row.pp2020 }}
        </div>

        <div v-if="row.subtitle"
             class="px-3 py-1 border-grey bg-dark-blue text-center flex-grow-1">
          {{ row.subtitle }}
        </div>

        <div v-else
             v-for="(column, columnIndex) in row.columns"
             :key="`${index}_${columnIndex}`"
             :style="`flex: 1 1 ${100 / row.columns.length}%; background: ${column.color}`"
             class="px-3 py-1 border-grey text-center">
          {{ (+column.value).toLocaleString() }}
          {{ row.columnDimension }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

import {paletteMixin} from "../mixins/paletteMixin";

export default {
  name: "TableChess",
  components: {
    Subtitle
  },
  mixins: [paletteMixin],
  computed: {
    tableData() {
      let oilProduction = [
        {
          title: '',
          pp2020: '',
          subtitle: this.trans('economic_reference.production_program_at_oil_price'),
        },
        {
          title: `${this.trans('economic_reference.course')}
                  ${+this.scenario.dollar_rate}
                  ${this.trans('economic_reference.tenge')} / $`,
          pp2020: this.trans('economic_reference.pp_2020'),
          columns: this.reverseOilPrices.map(oilPrice => {
            return {
              value: oilPrice,
              color: ''
            }
          }),
          columnDimension: this.trans('economic_reference.dollar_per_bar'),
          styleClass: 'bg-light-blue'
        },
        {
          title: `${this.trans('economic_reference.production')},
                  ${this.trans('economic_reference.thousand_tons')}`,
          pp2020: '',
          columns: this.reverseOilPrices.map((price, index) => {
            return {
              value: (this.scenariosByOilPrice[index].oil.original_value_optimized / 1000).toFixed(2),
              color: ''
            }
          })
        },
      ]

      return [
        ...oilProduction,
        ...[{
          title: '',
          pp2020: '',
          subtitle: `${this.trans('economic_reference.income')}, ${this.trans('economic_reference.million_tenge')}`,
          styleClass: 'bg-deep-blue'
        }],
        ...this.revenueTotalByOilPrice,
        ...[{
          title: '',
          pp2020: '',
          subtitle: `${this.trans('economic_reference.costs')}, ${this.trans('economic_reference.million_tenge')}`,
          styleClass: 'bg-deep-blue'
        }],
        ...this.overallExpendituresByOilPrice,
        ...[{
          title: '',
          pp2020: '',
          subtitle: `${this.trans('economic_reference.operating_profit')}, ${this.trans('economic_reference.million_tenge')}`,
          styleClass: 'bg-deep-blue'
        }],
        ...this.operatingProfitByOilPrice
      ]
    }
  },
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.bg-header {
  background: #333975;
}

.bg-dark-blue {
  background: #1A2370;
}

.bg-light-blue {
  background: #505585;
}

.bg-deep-blue {
  background: #272953;
}

.flex-120px {
  flex: 0 0 120px;
}

.flex-300px {
  flex: 0 0 300px;
}

.height-31px {
  height: 31px;
}
</style>