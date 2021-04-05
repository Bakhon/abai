<template>
 <span class="badge badge-pill">
    <percent-badge-icon :percent="percent"/>

    <span v-if="percent > 0">
      {{ persent }}%
    </span>

    <span v-else-if="percent < 0">
      {{ -percent }}%
    </span>
 </span>
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
  },
}
</script>

<style scoped>

</style>