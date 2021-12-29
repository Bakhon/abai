<template>
  <div :id="canvasId" class="h-100 w-100"></div>
</template>

<script>
import Plotly from 'plotly.js-dist-min';

export default {
  name: 'PlotlyHistogram',

  components: {
    Plotly
  },

  data() {
    return {
      title: null,
      xData: null,
      xTitle: null,
      canvasId: 'geology_petrophysics_histogram_canvas',
    };
  },

  methods: {

    setConfig(config) {
      if (typeof config !== 'object') {
        return;
      }

      if (config.hasOwnProperty('xData')) {
        this.xData = config.xData;
      }

      this.title = config.title;
      this.xTitle = config.xTitle;
    },

    isDrawAllowed() {
      return this.xData !== null;
    },

    draw(config) {
      this.setConfig(config);

      if (!this.isDrawAllowed()) {
        return;
      }

      let trace1 = {
        x: this.xData,
        type: 'histogram',
        mode: 'markers',
        marker: {
          color: 'black',
          line: {
            color: 'white',
            width: 1.5
          }
        },
      };

      let data = [trace1];

      let layout = {
        title: this.title,
        xaxis: {
          title: this.xTitle,
          showgrid: true,
          zeroline: false
        },
      };

      Plotly.newPlot(this.canvasId, data, layout, {displayModeBar: false});
    }
  }
}
</script>
