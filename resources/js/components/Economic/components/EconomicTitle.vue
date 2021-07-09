<template>
  <div :style="`font-size: ${fontSize}px; line-height:${lineHeight}px`"
       class="flex-grow-1 font-weight-bold">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: "EconomicTitle",
  props: {
    fontSize: {
      required: false,
      type: Number,
      default: 68
    },
    lineHeight: {
      required: false,
      type: Number,
      default: 82
    }
  }
}
</script>

<style scoped>
</style>