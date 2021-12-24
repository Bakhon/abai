<template>
  <div
      :class="`col-md-${md}`"
      class="d-flex flex-column p-3 col-sm-12 position-relative">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: "EconomicCol",
  props: {
    md: {
      required: false,
      type: Number,
      default: 3
    }
  }
}
</script>

<style scoped>
</style>