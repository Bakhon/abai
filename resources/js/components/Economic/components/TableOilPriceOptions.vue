<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      <div>{{ trans('economic_reference.table_oil_price_options_title') }}</div>
      <div>“{{ org.name }}”</div>
    </subtitle>

    <div class="mt-3 text-center border-grey">
      <div class="d-flex bg-header">
        <div
            v-for="item in tableKeys"
            :key="item.value"
            :style="`flex: ${item.flexGrow} 0 ${item.flexWidth}`"
            class="px-3 border-grey d-flex align-items-center justify-content-center"
            style="white-space: normal">
          {{ item.title }}
        </div>
      </div>
    </div>

    <div v-for="(item, index) in tableData"
         :key="index"
         :style="`background: ${item.color}`"
         class="d-flex">
      <div v-for="key in tableKeys"
           :key="key.value"
           :class="index ? 'p-3' : 'px-3 py-1'"
           :style="`flex: ${key.flexGrow} 0 ${key.flexWidth}`"
           class="border-grey text-center">
        {{
          typeof item[key.value] === 'string'
              ? item[key.value]
              : (+(item[key.value]).toFixed(2)).toLocaleString()
        }}
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

export default {
  name: "TableOilPriceOptions",
  components: {
    Subtitle
  },
  props: {
    org: {
      required: true,
      type: String
    },
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
    data: {
      required: true,
      type: Object
    }
  },
  computed: {
    tableData() {
      return [
        {
          title: `при цене на экспорт - ${this.scenario.oil_price}$/bbl`,
          wellCount: 'ед',
          prsCount: 'ед',
          prsPerWellCount: 'ед',
          liquid: '%',
          avgQn: 'тн/сут',
          oil: `${this.scenario.oil.value[1]} тонн`,
          number: 'чел.',
          revenueTotal: `${this.scenario.Revenue_total.value[1]} тенге`,
          color: '#151E70',
        },
        {
          title: 'Всего скважин, в т.ч.:',
          wellCount: +this.scenario.well_count.original_value,
          prsCount: +this.scenario.prs.original_value,
          prsPerWellCount: +this.scenario.prs.original_value / (+this.scenario.well_count.original_value),
          liquid: (100 * (+this.scenario.liquid.original_value - (+this.scenario.oil.original_value)) / +this.scenario.liquid.original_value),
          avgQn: +this.scenario.oil.original_value / +this.scenario.avg_days_worked.original_value,
          oil: +this.scenario.oil.value[0],
          number: '',
          revenueTotal: +this.scenario.Revenue_total.value[0]
        },
        {
          title: 'Рентабельные',
          wellCount: +this.scenario.well_count.original_value,
          prsCount: +this.scenario.prs.original_value,
          prsPerWellCount: +this.scenario.prs.original_value / (+this.scenario.well_count.original_value),
          liquid: (100 * (+this.scenario.liquid.original_value - (+this.scenario.oil.original_value)) / +this.scenario.liquid.original_value),
          avgQn: +this.scenario.oil.original_value / +this.scenario.avg_days_worked.original_value,
          oil: +this.scenario.oil.value[0],
          number: '',
          revenueTotal: +this.scenario.Revenue_total.value[0]
        },
      ]
    },

    tableKeys() {
      return [
        {
          title: 'Показатели',
          value: 'title',
          flexWidth: '300px',
          flexGrow: 1,
        },
        {
          title: 'Скважин',
          value: 'wellCount',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: 'Кол-во ПРС',
          value: 'prsCount',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: 'Кол-во ПРС на 1 скв',
          value: 'prsPerWellCount',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: 'Обводненность',
          value: 'liquid',
          flexWidth: '140px',
          flexGrow: 0,
        },
        {
          title: 'qн средний',
          value: 'avgQn',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: 'Добыча',
          value: 'oil',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: 'Численность',
          value: 'number',
          flexWidth: '120px',
          flexGrow: 0,
        },
        {
          title: 'Выручка',
          value: 'revenueTotal',
          flexWidth: '120px',
          flexGrow: 0,
        },
      ]
    },
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
</style>