<template>
  <div class="text-white">
    <subtitle font-size="16" style="line-height: 18px">
      <div>{{ trans('economic_reference.table_chess_title') }}</div>
    </subtitle>

    <div class="mt-2 border-grey bg-header">
      <div class="px-3 py-1 border-grey"
           style="font-size: 14px; line-height: 16px; font-weight: 600">
        {{ trans('economic_reference.table_chess_subtitle') }}
      </div>

      <table-chess-row
          v-for="(row, index) in tableHeaders"
          :key="index"
          :index="index"
          :row="row"
          :class="row.styleClass"/>

      <div :style="`overflow-y: scroll; height: ${tableHeight}`"
           class="customScroll d-flex flex-column">
        <table-chess-row
            v-for="(row, index) in tableData"
            :key="index"
            :index="index"
            :row="row"
            :class="row.styleClass"
            class="flex-grow-1"/>
      </div>
    </div>
  </div>
</template>

<script>
import {paletteMixin} from "../../mixins/paletteMixin";

import Subtitle from "../../components/Subtitle";
import TableChessRow from "./TableChessRow";

export default {
  name: "TableChess",
  components: {
    Subtitle,
    TableChessRow
  },
  mixins: [paletteMixin],
  computed: {
    tableData() {
      return [
        ...[{
          title: `${this.trans('economic_reference.production')},
                  ${this.trans('economic_reference.thousand_tons')}`,
          manufacturingProgram: this.manufacturingProgram
              ? +this.manufacturingProgram.oil
              : '',
          columns: this.reverseOilPrices.map((price, index) => {
            return {
              value: (this.scenariosByOilPrice[index].oil / 1000).toFixed(2),
              color: ''
            }
          })
        }],
        ...[{
          title: '',
          manufacturingProgram: '',
          subtitle: `
            ${this.trans('economic_reference.income')},
            ${this.trans('economic_reference.million_tenge')}
          `,
          styleClass: 'bg-deep-blue'
        }],
        ...this.revenueTotalByOilPrice,
        ...[{
          title: '',
          manufacturingProgram: '',
          subtitle: `
            ${this.trans('economic_reference.costs')},
            ${this.trans('economic_reference.million_tenge')}
          `,
          styleClass: 'bg-deep-blue'
        }],
        ...this.overallExpendituresByOilPrice,
        ...[{
          title: '',
          manufacturingProgram: '',
          subtitle: `
            ${this.trans('economic_reference.operating_profit')},
            ${this.trans('economic_reference.million_tenge')}
          `,
          styleClass: 'bg-deep-blue'
        }],
        ...this.operatingProfitByOilPrice
      ]
    },

    tableHeaders() {
      return [
        {
          title: '',
          manufacturingProgram: '',
          subtitle: this.trans('economic_reference.production_program_at_oil_price'),
        },
        {
          title: `${this.trans('economic_reference.course')}
                  ${+this.scenario.dollar_rate}
                  ${this.trans('economic_reference.tenge')} / $`,
          manufacturingProgram: this.trans('economic_reference.pp'),
          columns: this.reverseOilPrices.map(oilPrice => {
            return {
              value: oilPrice,
              color: ''
            }
          }),
          columnDimension: this.trans('economic_reference.dollar_per_bar'),
          styleClass: 'bg-light-blue padding-right-10px'
        },
      ]
    },

    tableHeight() {
      return this.isFullscreen ? '565px' : '415px'
    }
  },
  methods: {
    getBgColor(index) {
      return index % 2 === 0 ? '#505585' : '#272953'
    }
  }
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.bg-header {
  background: #333975;
}

.bg-light-blue {
  background: #505585;
}

.bg-deep-blue {
  background: #272953;
}

.customScroll::-webkit-scrollbar {
  width: 10px;
}

.padding-right-10px {
  padding-right: 10px;
}
</style>