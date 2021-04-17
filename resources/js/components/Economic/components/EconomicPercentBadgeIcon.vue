<template>
  <i v-if="percent > 0"
     class="fas fa-angle-down"
     style="color:#13B062"></i>

  <i v-else-if="percent < 0"
     class="fas fa-angle-up"
     style="color:#AB130E"></i>
</template>

<script>
export default {
  name: "EconomicPercentBadgeIcon",
  props: {
    percent: {
      required: true,
      type: Number
    }
  }
}
</script>

<style scoped>

</style>