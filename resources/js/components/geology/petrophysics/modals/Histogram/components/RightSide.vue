<template>
  <div class="histogram__content">
    <Canvas ref="Canvas"/>
  </div>
</template>

<script>
import Canvas from "../../../graphics/PlotlyHistogram";

export default {
  name: 'RightSide',

  components: {
    Canvas
  },

  methods: {

    draw(xData) {
      let config = {
        title: null,
        xTitle: null,
        xData: xData,
      };

      this.$refs.Canvas.draw(config);
    }
  }
}
</script>

<style scoped lang="scss">
.histogram__content {
  width: 100%;
  margin-left: 8px;
  background: #363B68;
  border: 1px solid #545580;
}
</style>

