<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      Зависимость экономической эффективности от остановки нерентабельных скважин и доли оплаты простаивающего персонала
    </subtitle>

    <div class="mt-3 text-center border-grey">
      <div class="d-flex bg-blue">
        <div class="flex-50 p-3 border-grey ">
          Удельные показатели
        </div>

        <div class="flex-25 p-3 border-grey">
          Единица измерения
        </div>

        <div class="flex-25 p-3 border-grey">
          {{ org.name }}
        </div>
      </div>

      <div class="d-flex bg-blue">
        <div class="flex-50 p-3 border-grey border-bottom-0">
          Курс доллара
        </div>

        <div class="flex-25 p-3 border-grey">
          тенге
        </div>

        <div class="flex-25 p-3 border-grey bg-blue">
          {{ (+scenario.dollar_rate).toLocaleString() }}
        </div>
      </div>

      <div class="d-flex bg-dark-blue">
        <div class="flex-50 p-3 border-grey d-flex align-items-center justify-content-center">
          Средняя цена на нефть при BRENT
        </div>

        <div class="flex-25 p-3 border-grey d-flex align-items-center justify-content-center">
          $ / bbl
        </div>

        <div class="flex-25 border-grey d-flex flex-column">
          <div v-for="(item, index) in oilPrices"
               :key="index"
               :class="index % 2 === 0 ? 'bg-light-blue' : 'bg-dark-blue'"
               class="px-2 py-3 ">
            {{ (+item).toLocaleString() }}
          </div>
        </div>
      </div>

      <div v-for="(item, index) in sumData"
           :key="index"
           :class="index % 2 === 0 ? 'bg-dark-blue' : 'bg-light-blue'"
           class="d-flex"
           style="white-space: normal">
        <div class="flex-50 p-3">
          {{ item.label }}
        </div>

        <div
            class="flex-25 p-3 border-grey border-bottom-0 border-top-0 d-flex align-items-center justify-content-center">
          {{ item.valueWord }}
        </div>

        <div class="flex-25 p-3">
          {{ (+item.value.toFixed(2)).toLocaleString() }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Subtitle from "./Subtitle";

export default {
  name: "TableSpecificIndicators",
  components: {
    Subtitle
  },
  props: {
    org: {
      required: true,
      type: String
    },
    scenario: {
      required: true,
      type: Object
    },
    oilPrices: {
      required: true,
      type: Array
    },
    data: {
      required: true,
      type: Object
    }
  },
  computed: {
    sumData() {
      return [
        {
          label: 'Условно-переменные расходы (сырье, материалы, энергия, за искл. расходов на ПРС)',
          value: this.data.avg_variable,
          valueWord: 'тенге / тонну жидкости'
        },
        {
          label: 'Затраты на персонал',
          value: this.data.avg_fix_payroll * 12 / 1000000,
          valueWord: 'млн тенге / год'
        },
        {
          label: 'КРС',
          value: this.data.avg_wo,
          valueWord: 'млн тенге / год'
        },
        {
          label: 'Условно-постоянные расходы',
          value: this.data.avg_fix * 12 / 1000000,
          valueWord: 'млн тенге / год'
        },
        {
          label: 'ОАР',
          value: this.data.avg_gaoverheads * 12 / 1000000,
          valueWord: 'млн тенге / год'
        },
        {
          label: 'Средняя стоимость ПРС (с ФОТ)',
          value: this.data.avg_wr_nopayroll + this.data.avg_wr_payroll,
          valueWord: 'млн тенге на операцию'
        }
      ]
    }
  }
}
</script>

<style scoped>
.border-grey {
  border: 1px solid #454D7D
}

.border-bottom-0 {
  border-bottom: unset;
}

.border-top-0 {
  border-top: unset;
}

.bg-blue {
  background: #333975;
}

.bg-dark-blue {
  background: #2B2E5E;
}

.bg-light-blue {
  background: #333868;
}

.flex-50 {
  flex: 1 0 50%;
}

.flex-25 {
  flex: 1 0 25%;
}

</style>