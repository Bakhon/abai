<template>
  <div :style="`font-size: ${fontSize}px`"
       class="font-weight-bold text-wrap">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: "Subtitle",
  props: {
    fontSize: {
      required: false,
      type: [Number, String],
      default: 16
    }
  }
}
</script>

<style scoped>
.font-size-16px {
  font-size: 16px;
}
</style>