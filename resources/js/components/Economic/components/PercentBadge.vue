<template>
  <div class="font-size-24px line-height-28px font-weight-bold">
    <percent-badge-icon :percent="percent" :reverse="reverse"/>

    <span>{{ Math.abs(percent) }}% </span>
  </div>
</template>

<script>
import PercentBadgeIcon from "./PercentBadgeIcon";

export default {
  name: "PercentBadge",
  components: {
    PercentBadgeIcon
  },
  props: {
    percent: {
      required: true,
      type: Number
    },
    reverse: {
      required: false,
      type: Boolean
    }
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