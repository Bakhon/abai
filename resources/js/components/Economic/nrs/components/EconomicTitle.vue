<template>
  <div :style="`flex-grow: ${flexGrow}; font-size: ${fontSize}px; line-height:${lineHeight}px`"
       class="font-weight-bold">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: "EconomicTitle",
  props: {
    fontSize: {
      required: false,
      type: [Number, String],
      default: 48
    },
    lineHeight: {
      required: false,
      type: [Number, String],
      default: 56
    },
    flexGrow: {
      required: false,
      type: [Number, String],
      default: 1
    }
  }
}
</script>

<style scoped>
</style>