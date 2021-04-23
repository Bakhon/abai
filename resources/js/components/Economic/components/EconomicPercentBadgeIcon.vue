<template>
  <i v-if="percent > 0"
     :class="reverse ? 'fa-angle-up' : 'fa-angle-down'"
     class="fas color-green"></i>

  <i v-else
     :class="reverse ? 'fa-angle-down' : 'fa-angle-up'"
     class="fas color-red"></i>
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
.color-green{
  color: #13B062
}

.color-red{
  color: #AB130E
}
</style>