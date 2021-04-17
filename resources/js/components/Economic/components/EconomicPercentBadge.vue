<template>
  <div class="font-size-24px line-height-28px font-weight-bold">
    <economic-percent-badge-icon :percent="percent"/>

    <span>{{ Math.abs(percent) }}% </span>
  </div>
</template>

<script>
import EconomicPercentBadgeIcon from "./EconomicPercentBadgeIcon";

export default {
  name: "EconomicPercentBadge",
  components: {
    EconomicPercentBadgeIcon
  },
  props: {
    percent: {
      required: true,
      type: Number
    },
  },
}
</script>

<style scoped>
.font-size-24px {
  font-size: 24px;
}

.line-height-28px {
  line-height: 28px;
}
</style>