<template>
  <div :id="canvasId" class="h-100 w-100"></div>
</template>

<script>
import Plotly from 'plotly.js-dist-min';

export default {
  name: 'CrossPlot',

  components: {
    Plotly
  },

  data() {
    return {
      title: null,

      xData: null,
      yData: null,

      xTitle: null,
      yTitle: null,

      canvasId: 'geology_petrophysics_crossplot_canvas',
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
      if (config.hasOwnProperty('yData')) {
        this.yData = config.yData;
      }

      this.title = config.title;
      this.xTitle = config.xTitle;
      this.yTitle = config.yTitle;
    },

    isDrawAllowed() {
      return this.xData !== null && this.yData !== null;
    },

    draw(config) {
      this.setConfig(config);

      if (!this.isDrawAllowed()) {
        return;
      }

      let trace1 = {
        x: this.xData,
        y: this.yData,
        mode: 'markers',
        marker: {
          color: 'black',
          size: 12,
          line: {
            color: 'white',
            width: 0.5
          }
        },
        type: 'scatter',
      };

      let data = [trace1];

      let layout = {
        title: this.title,
        xaxis: {
          title: this.xTitle,
          zeroline: false
        },
        yaxis: {
          title: this.yTitle,
          showline: false
        }
      };

      Plotly.newPlot(this.canvasId, data, layout, {displayModeBar: false});
    }
  }
}
</script>
