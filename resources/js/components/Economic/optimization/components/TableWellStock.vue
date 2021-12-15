<template>
  <div class="text-white" :style="`height: ${tableHeight};`">
    <subtitle font-size="16" style="line-height: 18px">
      {{ trans('economic_reference.production_wells_fund') }}
    </subtitle>

    <div class="mt-2 text-center border-grey">
      <div class="d-flex bg-header font-weight-600">
        <div class="py-3 border-grey d-flex align-items-center justify-content-center flex-350px">
          {{ trans('economic_reference.course') }}
          {{ (+scenario.dollar_rate).toLocaleString() }}
          {{ trans('economic_reference.tenge') }} / $
        </div>

        <div class="flex-grow-1 d-flex">
          <div v-for="price in reverseOilPrices"
               :key="price"
               class="py-3 border-grey text-center flex-grow-1">
            {{ (+price).toLocaleString() }}
          </div>
        </div>
      </div>

      <table-well-stock-row
          v-for="(row, index) in tableData"
          :key="index"
          :index="index"
          :row="row"
          :class="index % 2 === 1 ? 'bg-light-blue' : 'bg-deep-blue'"
          :style="row.color ? `color: ${row.color}` : ''"/>
    </div>

    <div class="mt-3 text-center border-grey">
      <div class="d-flex bg-header font-weight-600">
        <div class="px-3 py-2 border-grey d-flex align-items-center justify-content-center flex-350px">
          {{ trans('economic_reference.optimized') }}
        </div>
      </div>

      <table-well-stock-row
          v-for="(row, index) in tableOptimizedData"
          :key="index"
          :index="index"
          :row="row"
          :class="index % 2 === 1 ? 'bg-light-blue' : 'bg-deep-blue'"
          :style="row.color ? `color: ${row.color}` : ''"/>
    </div>
  </div>
</template>

<script>
import {paletteMixin} from "../../mixins/paletteMixin";

import Subtitle from "../../components/Subtitle";
import TableWellStockRow from "./TableWellStockRow";

export default {
  name: "TableWellStock",
  components: {
    Subtitle,
    TableWellStockRow,
  },
  mixins: [paletteMixin],
  computed: {
    tableData() {
      return [
        {
          title: this.trans('economic_reference.total'),
          columns: this.scenariosByOilPrice.map(scenario => {
            return {
              value: +scenario.uwi_count_profitable +
                  +scenario.uwi_count_profitless_cat_1 +
                  +scenario.uwi_count_profitless_cat_2
            }
          })
        },
        {
          title: this.trans('economic_reference.profitable'),
          columns: this.scenariosByOilPrice.map(scenario => {
            return {
              value: +scenario.uwi_count_profitable
            }
          })
        },
        {
          title: this.trans('economic_reference.profitless_all'),
          columns: this.scenariosByOilPrice.map(scenario => {
            return {
              value: +scenario.uwi_count_profitless_cat_1 +
                  +scenario.uwi_count_profitless_cat_2
            }
          })
        },
        {
          title: this.trans('economic_reference.profitless_cat_1'),
          columns: this.scenariosByOilPrice.map(scenario => {
            return {
              value: +scenario.uwi_count_profitless_cat_1
            }
          })
        },
        {
          title: this.trans('economic_reference.profitless_cat_2'),
          columns: this.scenariosByOilPrice.map(scenario => {
            return {
              value: +scenario.uwi_count_profitless_cat_2
            }
          })
        },
      ]
    },

    tableOptimizedData() {
      return [
        {
          title: this.trans('economic_reference.total'),
          columns: this.scenariosByOilPrice.map(scenario => {
            return {
              value: +scenario.uwi_count_profitable_optimize +
                  +scenario.uwi_count_profitless_cat_1_optimize +
                  +scenario.uwi_count_profitless_cat_2_optimize
            }
          })
        },
        {
          title: this.trans('economic_reference.profitable'),
          columns: this.scenariosByOilPrice.map(scenario => {
            return {
              value: +scenario.uwi_count_profitable_optimize
            }
          })
        },
        {
          title: this.trans('economic_reference.profitless_all'),
          columns: this.scenariosByOilPrice.map(scenario => {
            return {
              value: +scenario.uwi_count_profitless_cat_1_optimize +
                  +scenario.uwi_count_profitless_cat_2_optimize
            }
          })
        },
        {
          title: this.trans('economic_reference.profitless_cat_1'),
          columns: this.scenariosByOilPrice.map(scenario => {
            return {
              value: +scenario.uwi_count_profitless_cat_1_optimize
            }
          })
        },
        {
          title: this.trans('economic_reference.profitless_cat_2'),
          columns: this.scenariosByOilPrice.map(scenario => {
            return {
              value: +scenario.uwi_count_profitless_cat_2_optimize
            }
          })
        },
      ]
    },

    tableHeight() {
      return this.isFullscreen ? '705px' : '555px'
    }
  }
}
</script>

<style scoped>
.font-weight-600 {
  font-weight: 600;
}

.flex-350px {
  flex: 0 0 350px;
}

.border-grey {
  border: 1px solid #454D7D
}

.bg-header {
  background: #333975;
}

.bg-light-blue {
  background: #313560;
}

.bg-deep-blue {
  background: #272953;
}
</style>