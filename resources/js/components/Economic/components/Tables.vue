<template>
  <div class="row p-3 mt-3 bg-main1">
    <div class="d-flex">
      <chart-button
          v-for="(tab, index) in tabs"
          :key="index"
          :text="tab"
          :active="activeTab === index"
          :class="index ? 'ml-2' : ''"
          class="col"
          @click.native="activeTab = index"/>
    </div>

    <div
        v-for="(tab, index) in tabs"
        v-show="activeTab === index"
        :key="tab"
        class="mt-3 w-100">
      <table-specific-indicators
          v-if="index === 0"
          :org="res.org"
          :scenario="scenario"
          :oil-prices="oilPrices"
          :data="res.specificIndicator"
          class="text-white"/>
    </div>
  </div>
</template>

<script>
import ChartButton from "./ChartButton";
import TableSpecificIndicators from "./TableSpecificIndicators";

export default {
  name: "Tables",
  components: {
    TableSpecificIndicators,
    ChartButton
  },
  props: {
    scenario: {
      required: true,
      type: Object
    },
    oilPrices: {
      required: true,
      type: Array
    },
    res: {
      required: true,
      type: Object
    }
  },
  data: () => ({
    activeTab: 0
  }),
  computed: {
    tabs() {
      return [
        'Удельные показатели',
        'Технологические показатели',
        'Технико-экономические показатели',
        'Обзорная карта скважин',
        'Таблица изменений скважины «Светофор»',
        'Зависимость прибыли скважин “Дикобраз”',
        'Варианты при цене на нефть в Х $/баррель',
        'Денежный поток НДО “Шахматка”',
        'Экономическая эффективность',
        'Палетка'
      ]
    }
  }
}
</script>

<style scoped>

</style>