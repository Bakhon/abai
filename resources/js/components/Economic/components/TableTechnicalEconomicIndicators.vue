<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      {{ trans('economic_reference.technical_economic_indicators') }}
      “{{ org.name }}”
    </subtitle>

    <div class="mt-3 text-center border-grey">
      <div class="d-flex bg-header">
        <div class="p-3 border-grey d-flex align-items-center"
             style="flex: 0 0 80px">
          № П/П
        </div>

        <div class="p-3 border-grey d-flex align-items-center justify-content-center"
             style="flex: 0 0 300px">
          Наименование
        </div>

        <div class="p-3 border-grey d-flex align-items-center justify-content-center"
             style="flex: 0 0 150px">
          Ед. изм
        </div>

        <div class="border-grey" style="flex: 0 0 300px;">
          <div class="p-3">
            Утвержденный бюджет на 2020 год
          </div>

          <div class="d-flex">
            <div v-for="(budget, index) in budget2020"
                 :key="index"
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
                 :key="index"
                 :class="index % 2 === 1 ? 'border-grey-left' : ''"
                 class="p-2 flex-grow-1">
              {{ (+price).toLocaleString() }}$/бар
            </div>
          </div>
        </div>
      </div>

      <div v-for="(item, itemIndex) in tableData"
           :key="itemIndex"
           :style="`background: ${item.color}`"
           class="d-flex">
        <div class="py-2 px-3 border-grey border-top-0 d-flex align-items-center justify-content-center"
             style="flex: 0 0 80px">
          {{ item.index }}
        </div>

        <div class="py-2 px-3 border-grey border-top-0 border-left-0 d-flex align-items-center justify-content-center"
             style="flex: 0 0 300px">
          {{ item.title }}
        </div>

        <div class="py-2 px-3 border-grey border-top-0 border-left-0 d-flex align-items-center justify-content-center"
             style="flex: 0 0 150px">
          {{ item.dimension }}
        </div>

        <div class="d-flex" style="flex: 0 0 300px;">
          <div v-for="(budget, index) in item.budget2020"
               :key="index"
               class="py-2 px-3 border-grey border-top-0 border-left-0 flex-grow-1">
            {{ budget.value }}
          </div>
        </div>

        <div class="d-flex flex-grow-1">
          <div v-for="(value, index) in item.values"
               :key="index"
               class="py-2 px-3 border-grey border-top-0 border-left-0"
               style="flex: 1 0 100px; white-space: pre-line"
          >{{ typeof value === 'string' ? value : (+(value).toFixed(2)).toLocaleString() }}
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
          values: this.oilPrices.map(() => this.scenario.dollar_rate),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#151E70',
        },
        {
          index: '1',
          title: 'Добыча нефти',
          dimension: 'тыс тонн',
          values: this.oilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].oil.value_optimized[0]
          ),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#AC7550',
        },
        {
          index: '2',
          title: 'Реализация нефти - всего, в т.ч.:',
          dimension: 'тыс тонн',
          values: this.oilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].production_export.value_optimized[0]
              + (+this.oilPriceScenarios[index].production_local.value_optimized[0])
          ),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#AC7550',
        },
        {
          index: '',
          title: 'Экспорт',
          dimension: 'тыс тонн',
          values: this.oilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].production_export.value_optimized[0]
          ),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#313560',
        },
        {
          index: '',
          title: 'Внутренний рынок',
          dimension: 'тыс тонн',
          values: this.oilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].production_local.value_optimized[0]
          ),
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
          values: this.oilPrices.map(() => ''),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#313560',
        },
        {
          index: '',
          title: 'Экспорт',
          dimension: 'тыс тенге / тонну',
          values: this.oilPrices.map((oilPrice, index) =>
              (+this.oilPriceScenarios[index].Revenue_export.value_optimized[0]
                  / (+this.oilPriceScenarios[index].production_export.value_optimized[0]))
          ),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#272953',
        },
        {
          index: '',
          title: 'Внутренний рынок',
          dimension: `тыс тенге / тонну`,
          values: this.oilPrices.map((oilPrice, index) =>
              (+this.oilPriceScenarios[index].Revenue_local.value_optimized[0]
                  / (+this.oilPriceScenarios[index].production_local.value_optimized[0]))
          ),
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
          values: this.oilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].well_count_optimize
          ),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#AC7550',
        },
        {
          index: '4.1',
          title: 'Процент отключения',
          dimension: '',
          values: this.oilPrices.map((oilPrice, index) =>
              `Кат 1: ${this.oilPriceScenarios[index].percent_stop_cat_1 * 100}%\n` +
              `Кат 2: ${this.oilPriceScenarios[index].percent_stop_cat_2 * 100}%`,
          ),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#313560',
        },
        {
          index: '5',
          title: 'Численность ПП',
          dimension: '$ / bbl',
          values: this.oilPrices.map(() => ''),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#272953',
        },
        {
          index: '6',
          title: 'Доходы',
          dimension: '$ / bbl',
          values: this.oilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].Revenue_total.value_optimized[0]
          ),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#106B4B',
        },
        {
          index: '7',
          title: 'Расходы - всего, в т.ч.:',
          dimension: '$ / bbl',
          values: this.oilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].Overall_expenditures.value_optimized[0]
          ),
          budget2020: this.budget2020.map(budget => ({
            budget: budget,
            value: ''
          })),
          color: '#106B4B',
        },
        {
          index: '7.1',
          title: 'Себестоимость, в т.ч.:',
          dimension: 'тыс тенге / тонну',
          values: this.oilPrices.map((oilPrice, index) =>
              +this.oilPriceScenarios[index].Overall_expenditures.value_optimized[0]
              / (+this.oilPriceScenarios[index].production_local.value_optimized[0]
              + (+this.oilPriceScenarios[index].production_export.value_optimized[0]))
          ),
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
    },

    oilPriceScenarios() {
      return this.oilPrices.map(oilPrice =>
          this.scenarios
              .filter(scenario => scenario.oil_price === oilPrice)
              .reduce((prev, current) => (+prev.operating_profit_12m_optimize > +current.operating_profit_12m_optimize) ? prev : current)
      )
    },
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

.border-top-0 {
  border-top: unset;
}

.bg-header {
  background: #333975;
}
</style>