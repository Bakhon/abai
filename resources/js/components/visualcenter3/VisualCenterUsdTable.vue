<template>
  <div class="third-table big-area" :style="`${Table3}`">
    <div class="first-string first-string2">
      <div class="close2"
           @click="changeTable()">
        Закрыть
      </div>

      <div class="container-fluid">
        <div class="vc-period-container">
          <button
              @click="selectPeriod(menuDMY.id)"
              class="vc-period-item"
              :class="{ 'active': menuDMY.active_usd }"
              :disabled="usdChartIsLoading || selectedUsdPeriod !== 0"
              v-for="(menuDMY, index) in periodSelectFunc"
          >
            {{ menuDMY.DMY }}
          </button>
        </div>

        <visual-center-chart-area-usd3 :currency-chart-data.sync="currencyChartData"/>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'Table3',
    'selectedUsdPeriod',
    'periodSelectFunc',
    'currencyChartData',
    'usdChartIsLoading',
  ],
  mounted() {},
  methods: {
    changeTable() {
      this.$emit('change-table');
    },
    selectPeriod(period) {
      this.$emit('update:selectedUsdPeriod', period);
      this.$emit('period-select-usd');
    }
  },
}
</script>