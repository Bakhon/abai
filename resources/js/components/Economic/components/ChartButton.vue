<template>
  <div :class="active ? 'economic-tab-btn-active' : ''"
       class="text-white text-wrap economic-tab-btn py-2">
    {{ text }}
  </div>
</template>

<script>
export default {
  name: "ChartButton",
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
  background: #2E50E9 !important;
}

.economic-tab-btn {
  border-radius: 4px;
  background: #656A8A;
  font-size: 12px;
  line-height: 16px;
  min-height: 40px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}
</style>