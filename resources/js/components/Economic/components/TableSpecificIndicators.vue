<template>
  <div>
    <subtitle font-size="18" style="line-height: 26px">
      Зависимость экономической эффективности от остановки нерентабельных скважин и доли оплаты простаивающего персонала
    </subtitle>

    <div class="mt-3 text-center border-grey">
      <div class="d-flex bg-blue">
        <div class="border-grey p-3 flex-25">
          Удельные показатели
        </div>

        <div class="border-grey p-3 flex-25"></div>

        <div class="border-grey p-3 flex-25">
          Единица измерения
        </div>

        <div class="border-grey p-3 flex-25">
          ОМГ
        </div>
      </div>

      <div class="d-flex bg-blue">
        <div class="border-grey p-3 flex-25 border-bottom-0">
          Курс доллара
        </div>

        <div class="border-grey p-3 flex-25 border-bottom-0"></div>

        <div class="border-grey p-3 flex-25 border-bottom-0">
          тенге
        </div>

        <div class="border-grey p-3 flex-25 border-bottom-0">
          450
        </div>
      </div>

      <div class="d-flex bg-dark-blue">
        <div
            class="border-grey p-3 flex-25 d-flex justify-content-center align-items-center border-top-0 border-bottom-0">
          Средняя цена на нефть при BRENT
        </div>

        <div class="border-grey flex-25 d-flex flex-column border-top-0 border-bottom-0">
          <div v-for="(price, index) in prices"
               :key="index"
               :class="index % 2 === 0 ? 'bg-light-blue' : ''"
               class="px-2 py-3">
            {{ price.oil }} $/bbl
          </div>
        </div>

        <div
            class="border-grey p-3 flex-25 d-flex justify-content-center align-items-center border-top-0 border-bottom-0">
          тенге/тонну нефти
        </div>

        <div class="border-grey flex-25 d-flex flex-column border-top-0 border-bottom-0">
          <div v-for="(price, index) in prices"
               :key="index"
               :class="index % 2 === 0 ? 'bg-light-blue' : ''"
               class="px-2 py-3 ">
            {{ price.omg }} $/bbl
          </div>
        </div>
      </div>

      <div class="d-flex bg-dark-blue">
        <div class="p-3 flex-50">
          Условно-переменные расходы (сырье, материалы, энергия, за искл. расходов на ПРС)
        </div>

        <div class="border-grey p-3 flex-25">
          тенге/тонну жидкости
        </div>

        <div class="p-3 flex-25">
          348
        </div>
      </div>

      <div class="d-flex bg-dark-blue">
        <div class="flex-50 d-flex flex-column">
          <div v-for="(price,index) in wellPrices"
               :key="index"
               :class="index % 2 === 0 ? 'bg-light-blue' : ''"
               class="p-3">
            {{ price.label }}
          </div>
        </div>

        <div class="flex-25 d-flex border-grey border-bottom-0 justify-content-center align-items-center">
          тыс. тенге/скв
        </div>

        <div class="flex-25 d-flex flex-column">
          <div v-for="(price,index) in wellPrices"
               :key="index"
               :class="index % 2 === 0 ? 'bg-light-blue' : ''"
               class="p-3">
            {{ price.value }}
          </div>
        </div>
      </div>

      <div class="d-flex bg-light-blue">
        <div class="flex-50 p-3">
          Средняя стоимость ПРС (с ФОТ)
        </div>

        <div class="flex-25 p-3 border-grey border-top-0 border-bottom-0">
          тыс.тенге на операцию
        </div>

        <div class="flex-25 p-3">
          3,950
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
  computed: {
    prices() {
      return [
        {
          oil: 20,
          omg: 59.356
        },
        {
          oil: 20,
          omg: 59.356
        },
        {
          oil: 20,
          omg: 59.356
        },
        {
          oil: 20,
          omg: 59.356
        },
        {
          oil: 20,
          omg: 59.356
        },
        {
          oil: 20,
          omg: 59.356
        },
        {
          oil: 20,
          omg: 59.356
        },
      ]
    },

    wellPrices() {
      return [
        {
          label: 'Затраты на персонал',
          value: 100,
        },
        {
          label: 'КРС',
          value: 100,
        },
        {
          label: 'Условно-постоянные расходы',
          value: 100,
        },
        {
          label: 'ОАР',
          value: 100,
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