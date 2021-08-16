<template>
  <div :class="percent > 0 ? 'progress-reverse' : ''"
       class="progress my-2 bg-progress"
       style="height: 5px">
    <div
        :style="{width: width + '%'}"
        :aria-valuenow="50"
        :aria-valuemin="0"
        :aria-valuemax="100"
        class="progress-bar"
        role="progressbar"
    ></div>
  </div>
</template>

<script>
export default {
  name: "PercentProgress",
  props: {
    percent: {
      required: true,
      type: Number
    }
  },
  computed: {
    width() {
      return this.percent <= 0
          ? this.percent + 100
          : +Math.floor(100 * this.percent / (100 + this.percent))
    },
  }
}
</script>

<style scoped>
.bg-progress {
  background: #323370;
}

.progress-reverse {
  transform: rotateY(180deg);
}
</style>