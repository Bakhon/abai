<template>
  <div class="flex-grow-1 font-size-68px line-height-82px font-weight-bold">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: "EconomicTitle"
}
</script>

<style scoped>
.font-size-68px{
  font-size: 68px;
}

.line-height-82px{
  line-height: 82px;
}
</style>