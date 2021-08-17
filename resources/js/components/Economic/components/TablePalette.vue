<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.palette') }}
    </subtitle>

    <div class="mt-3 text-center border-grey">
      <div class="d-flex bg-header font-weight-600">
        <div class="py-3 border-grey d-flex align-items-center justify-content-center flex-300px">
          {{ trans('economic_reference.course') }}
          {{ (+scenario.dollar_rate).toLocaleString() }}
          {{ trans('economic_reference.tenge') }} / $
        </div>

        <div class="py-3 border-grey d-flex align-items-center justify-content-center flex-150px">
          ПП-2020
        </div>

        <div class="flex-grow-1">
          <div class="py-3 border-grey text-center">
            Литимизированная производственная программа, при цене на нефть,
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

      <div v-for="(item, index) in tableData"
           :key="index"
           :class="index % 2 === 1 ? 'bg-light-blue' : 'bg-deep-blue'"
           :style="item.color ? `color: ${item.color}` : ''"
           class="d-flex">
        <div class="px-3 py-2 border-grey text-center flex-300px">
          {{ item.title }}
        </div>

        <div class="px-3 py-2 border-grey text-center flex-150px">
          {{ item.pp2020 }}
        </div>

        <div v-for="(price, priceIndex) in reverseOilPrices"
             :key="price"
             :style="`flex-basis: ${100 / reverseOilPrices.length}%`"
             class="px-3 py-2 border-grey text-center flex-grow-1">
          {{ item.values[priceIndex].toLocaleString() }}
        </div>
      </div>

      <div v-for="(oilPrice, index) in reverseOilPrices"
           :key="index"
           :class="index % 2 === 0 ? 'bg-header-light' : 'bg-header'"
           class="d-flex">
        <div class="px-3 py-2 border-grey text-center flex-300px">
          {{ (+oilPrice).toLocaleString() }}
          {{ trans('economic_reference.dollar_per_bar') }}
        </div>

        <div
            :class="index % 2 === 1 ? 'bg-light-blue' : 'bg-deep-blue'"
            class="px-3 py-2 border-grey text-center flex-150px">
        </div>

        <div v-for="(price, priceIndex) in reverseOilPrices"
             :key="price"
             :style="`flex-basis: ${100 / reverseOilPrices.length}%`"
             :class="index % 2 === 1 ? 'bg-light-blue' : 'bg-deep-blue'"
             class="px-3 py-2 border-grey text-center flex-grow-1">

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

export default {
  name: "TablePalette",
  components: {
    Subtitle
  },
  props: {
    scenarios: {
      required: true,
      type: Array
    },
    scenario: {
      required: true,
      type: Object
    },
    oilPrices: {
      required: true,
      type: Array,
    },
  },
  methods: {
    convertToRoman(value) {
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
      };

      let str = '';

      for (let i of Object.keys(ROMANS)) {
        let q = Math.floor(value / ROMANS[i])

        value -= q * ROMANS[i]

        str += i.repeat(q)
      }

      return str
    }
  },
  computed: {
    reverseOilPrices() {
      return [...this.oilPrices].reverse()
    },

    filteredData() {
      let scenarios = this.scenarios.filter(scenario =>
          scenario.dollar_rate === this.scenario.dollar_rate &&
          scenario.coef_cost_WR_payroll === this.scenario.coef_cost_WR_payroll &&
          scenario.coef_Fixed_nopayroll === this.scenario.coef_Fixed_nopayroll
      )

      return this.reverseOilPrices.map(oilPrice => {
        return scenarios
            .filter(scenario => scenario.oil_price === oilPrice)
            .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
      })
    },

    tableData() {
      return [
        {
          title: 'Номер программы',
          pp2020: '',
          values: this.filteredData.map((item, index) => this.convertToRoman(index + 1)),
          color: '#81B9FE'
        },
        {
          title: 'Добыча, тыс. тонн',
          pp2020: '',
          values: this.filteredData.map(item =>
              (+item.oil.original_value_optimized / 1000).toFixed(2)
          )
        },
        {
          title: 'Остановка НРС',
          pp2020: '',
          values: this.filteredData.map(item => {
            let cat1 = +item.uwi_count_profitless_cat_1.original_value_optimized

            let cat2 = +item.uwi_count_profitless_cat_2.original_value_optimized

            return cat1 + cat2
          })
        },
        {
          title: 'Расходы на персонал (ФОТ)',
          pp2020: '',
          values: this.filteredData.map(item => '')
        },
        {
          title: 'КВЛ, млн. тенге',
          pp2020: '',
          values: this.filteredData.map(item => '')
        },
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

.flex-300px {
  flex: 0 0 300px;
}

.flex-150px {
  flex: 0 0 150px;
}
</style>