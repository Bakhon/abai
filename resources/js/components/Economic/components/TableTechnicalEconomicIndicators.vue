<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.technical_economic_indicators') }}
      “{{ org.name }}”
    </subtitle>

    <div class="mt-3 text-center border-grey">
      <div class="d-flex bg-header">
        <div class="p-3 border-grey d-flex align-items-center" style="flex: 0 0 80px">
          № П/П
        </div>

        <div class="p-3 border-grey d-flex align-items-center justify-content-center" style="flex: 0 0 300px">
          Наименование
        </div>

        <div class="p-3 border-grey d-flex align-items-center justify-content-center" style="flex: 0 0 100px">
          Ед. изм
        </div>

        <div class="border-grey" style="flex: 0 0 300px;">
          <div class="p-3">
            Утвержденный бюджет на 2020 год
          </div>

          <div class="d-flex">
            <div v-for="(budget, index) in budget2020"
                 :key="budget"
                 :class="index % 2 === 1 ? 'border-grey-left' : ''"
                 class="p-2 flex-grow-1">
              {{ budget }}$/бар
            </div>
          </div>
        </div>

        <div class="border-grey flex-grow-1">
          <div class="p-3">
            При изменении макропоказателей
          </div>

          <div class="d-flex">
            <div v-for="(price, index) in oilPrices"
                 :key="price"
                 :class="index % 2 === 1 ? 'border-grey-left' : ''"
                 class="p-2 flex-grow-1">
              {{ (+price).toLocaleString() }}$/бар
            </div>
          </div>
        </div>
      </div>

      <div v-for="item in tableData"
           :key="item.title"
           :style="`background: ${item.color}`"
           class="d-flex">
        <div class="py-2 px-3 border-grey border-top-0" style="flex: 0 0 80px">
          {{ item.index }}
        </div>

        <div class="py-2 px-3 border-grey border-top-0 border-left-0" style="flex: 0 0 300px">
          {{ item.title }}
        </div>

        <div class="py-2 px-3 border-grey border-top-0 border-left-0" style="flex: 0 0 100px">
          {{ item.dimension }}
        </div>

        <div class="d-flex" style="flex: 0 0 300px;">
          <div v-for="budget in item.budget2020"
               :key="budget"
               class="py-2 px-3 border-grey border-top-0 border-left-0 flex-grow-1">
            {{ budget.value }}
          </div>
        </div>

        <div class="d-flex flex-grow-1">
          <div v-for="(subItem, index) in item.values"
               :key="index"
               class="py-2 px-3 border-grey border-top-0 border-left-0"
               style="flex: 1 0 100px">
            {{ subItem.value }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

export default {
  name: "TableTechnicalEconomicIndicators",
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
          index: '',
          title: 'Курс KZT/USD',
          dimension: 'тенге',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value: this.scenario.dollar_rate
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#151E70',
        },
        {
          index: '1',
          title: 'Добыча нефти',
          dimension: 'тыс. тонн',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value:
                this.scenarios
                    .filter(x => x.oil_price === oilPrice)
                    .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
                    .oil.value_optimized[0]
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#AC7550',
        },
        {
          index: '2',
          title: 'Реализация нефти - всего, в т.ч.:',
          dimension: 'тыс. тонн',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value:
                ((+this.scenarios
                        .filter(x => x.oil_price === oilPrice)
                        .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
                        .production_export.value_optimized[0])
                    + (+this.scenarios
                        .filter(x => x.oil_price === oilPrice)
                        .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
                        .production_local.value_optimized[0])).toFixed(2)
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#AC7550',
        },
        {
          index: '',
          title: 'Экспорт',
          dimension: 'тыс. тонн',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value:
                (+this.scenarios
                    .filter(x => x.oil_price === oilPrice)
                    .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
                    .production_export.value_optimized[0]).toFixed(2)
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#313560',
        },
        {
          index: '',
          title: 'Внутренний рынок',
          dimension: 'тыс. тонн',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value:
                (+this.scenarios
                    .filter(x => x.oil_price === oilPrice)
                    .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
                    .production_local.value_optimized[0]).toFixed(2)
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#272953',
        },
        {
          index: '3',
          title: 'Цены реализации нефти',
          dimension: '',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value: ''
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#313560',
        },
        {
          index: '',
          title: 'Экспорт',
          dimension: '',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value: ''
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#272953',
        },
        {
          index: '',
          title: 'Внутренний рынок',
          dimension: '',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value: ''
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#313560',
        },
        {
          index: '4',
          title: 'Фонд скважин',
          dimension: '',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value:
            this.scenarios
                .filter(x => x.oil_price === oilPrice)
                .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
                .well_count_optimize
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#AC7550',
        },
        {
          index: '5',
          title: 'Численность ПП',
          dimension: '$/bbl',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value: ''
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#272953',
        },
        {
          index: '6',
          title: 'Доходы',
          dimension: '$/bbl',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value: this.scenarios
                .filter(x => x.oil_price === oilPrice)
                .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
                .Revenue_total
                .value_optimized[0]
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#106B4B',
        },
        {
          index: '7',
          title: 'Расходы - всего, в т.ч.:',
          dimension: '$/bbl',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value: this.scenarios
                .filter(x => x.oil_price === oilPrice)
                .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
                .Overall_expenditures
                .value_optimized[0]
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#106B4B',
        },
        {
          index: '7.1',
          title: 'Себе стоимость, в т.ч.:',
          dimension: 'чел',
          values: this.oilPrices.map(oilPrice => ({
            oilPrice: oilPrice,
            value: ''
          })),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#313560'
        },
      ]
    },

    budget2020() {
      return [
        50,
        60
      ]
    }

  },
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.border-grey-left {
  border-left: 1px solid #454D7D
}

.border-left-0 {
  border-left: unset;
}

.border-bottom-0 {
  border-bottom: unset;
}

.border-top-0 {
  border-top: unset;
}

.bg-header {
  background: #333975;
}

.flex-5 {
  flex: 1 0 5%;
}

.flex-10 {
  flex: 1 0 10%;
}

.flex-20 {
  flex: 1 0 20%;
}
</style>