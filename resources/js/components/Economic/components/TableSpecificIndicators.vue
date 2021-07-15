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
          {{ scenario.dollar_rate }}
        </div>
      </div>

      <div class="d-flex bg-dark-blue">
        <div class="flex-50 p-3 d-flex align-items-center justify-content-center">
          Средняя цена на нефть при BRENT
        </div>

        <div class="flex-25 p-3 border-grey d-flex align-items-center justify-content-center">
          $ / bbl
        </div>

        <div class="flex-25 bg-blue d-flex flex-column">
          <div v-for="(item, index) in oilPrices"
               :key="index"
               :class="index % 2 === 0 ? 'bg-light-blue' : 'bg-dark-blue'"
               class="px-2 py-3 ">
            {{ item }}
          </div>
        </div>
      </div>

      <div class="d-flex bg-dark-blue">
        <div class="flex-50 p-3 border-grey border-bottom-0"
             style="white-space: normal">
          Условно-переменные расходы (сырье, материалы, энергия, за искл. расходов на ПРС)
        </div>

        <div
            class="flex-25 p-3 border-grey border-bottom-0 border-top-0 d-flex align-items-center justify-content-center">
          тенге/тонну жидкости
        </div>

        <div
            class="flex-25 border-grey p-3 border-bottom-0 border-top-0 d-flex align-items-center justify-content-center">
          {{ data.sum_variable }}
        </div>
      </div>

      <div class="d-flex bg-dark-blue">
        <div class="flex-50">
          <div v-for="(item, index) in sumData"
               :key="index"
               :class="index % 2 === 0 ? 'bg-light-blue' : 'bg-dark-blue'"
               class="p-3">
            {{ item.label }}
          </div>
        </div>

        <div class="flex-25 p-3 border-grey border-bottom-0 d-flex align-items-center justify-content-center">
          тыс. тенге/скв
        </div>

        <div class="flex-25">
          <div v-for="(item, index) in sumData"
               :key="index"
               :class="index % 2 === 0 ? 'bg-light-blue' : 'bg-dark-blue'"
               class="p-3">
            {{ Math.floor(item.value / 1000) }}
          </div>
        </div>
      </div>

      <div class="d-flex bg-light-blue">
        <div class="flex-50 p-3">
          Средняя стоимость ПРС (с ФОТ)
        </div>

        <div class="flex-25 p-3 border-grey border-bottom-0 border-top-0">
          тыс.тенге на операцию
        </div>

        <div class="flex-25 p-3">
          {{ Math.floor((data.sum_wr_nopayroll + data.sum_wr_payroll) / 1000) }}
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
          label: 'Затраты на персонал',
          value: this.data.sum_fix_payroll,
        },
        {
          label: 'КРС',
          value: this.data.sum_wo,
        },
        {
          label: 'Условно-постоянные расходы',
          value: this.data.sum_fix,
        },
        {
          label: 'ОАР',
          value: this.data.sum_gaoverheads,
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