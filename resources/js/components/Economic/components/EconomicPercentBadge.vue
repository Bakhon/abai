<template>
 <div class="badge badge-pill font-size-24px line-height-28px">
    <economic-percent-badge-icon :percent="percent"/>

    <span v-if="percent > 0">
      {{ percent }}%
    </span>

    <span v-else-if="percent < 0">
      {{ -percent }}%
    </span>
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
  .font-size-24px{
    font-size: 24px;
  }

  .line-height-28px{
    line-height: 28px;
  }
</style>