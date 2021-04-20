<template>
  <i v-if="percent > 0"
     :class="reverse ? 'fa-angle-up' : 'fa-angle-down'"
     class="fas"
     style="color: #13B062"></i>

  <i v-else
     :class="reverse ? 'fa-angle-down' : 'fa-angle-up'"
     class="fas"
     style="color: #AB130E"></i>
</template>

<script>
export default {
  name: "EconomicPercentBadgeIcon",
  props: {
    percent: {
      required: true,
      type: Number
    },
    reverse: {
      required: false,
      type: Boolean
    }
  }
}
</script>

<style scoped>

</style>