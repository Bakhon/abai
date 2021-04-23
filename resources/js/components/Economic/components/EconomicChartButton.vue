<template>
  <div
      :class="active ? 'economic-tab-btn-active' : ''"
      class="text-white text-wrap economic-tab-btn py-2">
    {{ text }}
  </div>
</template>

<script>
export default {
  name: "EconomicChartButton",
  props: {
    text: {
      required: true,
      type: String
    },
    active: {
      required: false,
      type: Boolean
    }
  }
}
</script>

<style scoped>
.economic-tab-btn-active, .economic-tab-btn:hover {
  background: #2E50E9;
}

.economic-tab-btn {
  border-radius: 4px;
  background: #656A8A;
  font-size: 12px;
  line-height: 14px;
  min-height: 54px;
  cursor: pointer;
}
</style>