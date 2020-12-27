<template>
  <div class="third-table big-area" :style="`${Table3}`">
    <div class="first-string first-string2">
      <div class="close2"
           @click="changeTable()">
        Закрыть
      </div>

      <div class="container-fluid">
        <br/>

        <div
            @click="selectedDMY2 = menuDMY.id"
            class="period"
            v-for="(menuDMY, index) in periodSelectFunc"
            :style="{
                color: menuDMY.current2,
              }"
            v-on:click="periodSelectUSD"
        >
          <div>{{ menuDMY.DMY }}</div>
        </div>

        <visual-center-chart-area-usd3></visual-center-chart-area-usd3>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    'Table3',
    'selectedDMY2',
    'periodSelectUSD',
    'periodSelectFunc',
    'currencyChartData',
  ],
  mounted() {},
  methods: {
    changeTable() {
      this.$emit('change-table');
    }
  }
}
</script>