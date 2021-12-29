<template>
  <div class="cross-plot__content">
    <CrossPlot ref="CrossPlot"/>
  </div>
</template>

<script>
import CrossPlot from "../../../graphics/CrossPlot";

export default {
  name: 'RightSide',

  components: {
    CrossPlot
  },

  methods: {

    draw(xData, yData) {
      let config = {
        // title: 'Скважина<br>Интервал',
        // xTitle: 'Коэффициент пористости, д.ед.',
        // yTitle: 'Коэффициент проницаемости, мД',
      };
      if (xData !== null) {
        config.xData = xData;
      }
      if (yData !== null) {
        config.yData = yData;
      }

      this.$refs.CrossPlot.draw(config);
    }
  }
}
</script>
