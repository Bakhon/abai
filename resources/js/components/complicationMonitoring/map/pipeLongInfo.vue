<template>
  <div class="table-page">
    <table class="table table-bordered table-dark">
      <tbody v-if="pipeSegments">
      <tr v-for="(segment, sIndex) in pipeSegments">
        <template v-for="(column, index) in segment">
          <th v-if="index == 0" scope="row">{{ column }}</th>
          <td v-else-if="sIndex == 0" :style="{backgroundColor: arrayToColor(column)}"></td>
          <td v-else>{{ column }}</td>
        </template>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import pipeColors from '~/json/pipe_colors.json'

export default {
  name: "pipeLongInfo",
  props: {
    pipe: Object,
    referentValue: Number,
    activeFilter: String
  },
  data() {
    return {
      fields: [
        {
          name: 'Pin (atm)',
          field: 'pin'
        },
        {
          name: 'Pout (atm)',
          field: 'pout'
        },
        {
          name: 'Tin (C)',
          field: 'tin'
        },
        {
          name: 'Tout (C)',
          field: 'tout'
        },
        {
          name: 'EV (m/s)',
          field: 'ev'
        },
        {
          name: 'Vliq (m/s)',
          field: 'vliq'
        },
        {
          name: 'Vgas (m/s)',
          field: 'vgas'
        },
        {
          name: 'Vm (m/s)',
          field: 'vm'
        },
        {
          name: 'Comment',
          field: 'comment'
        }
      ]
    }
  },
  computed: {
    pipeSegments() {
      let segments = [];

      this.fields.forEach((field, fIndex) => {
        segments[fIndex] = [field.name];
        this.pipe.hydro_calc_long.forEach((segment) => {
          segments[fIndex].push(segment[field.field]);
        })
      });

      let distances = ['Distance'];
      let colors = [''];
      this.pipe.hydro_calc_long.forEach((segment, index) => {
        if (index == 0) {
          distances.push('0 - ' + segment.distance + ' м');
        } else {
          distances.push(this.pipe.hydro_calc_long[index - 1].distance + ' - ' + segment.distance + ' м');
        }

        colors.push(this.getPipeColor(segment));
      })

      segments.unshift(distances);
      segments.unshift(colors);

      return segments;
    }
  },
  methods: {
    getPipeColor(segment) {
      if (this.activeFilter) {
        switch (this.activeFilter) {
          case "speedFlow":
            return this.getColorByFlowSpeed(segment);
          case "pressure":
            return this.getColorByPressure(segment);
          case "temperature":
            return this.getColorByTemperature(segment);
        }
      }

      return pipeColors[this.activeFilter].good
    },
    getColorByFlowSpeed(segment) {
      let speed_flow = segment.vm ? segment.vm : null;
      switch (true) {
        case speed_flow == null:
          return pipeColors[this.activeFilter].no_data;
          break;

        case speed_flow.fluid_speed < 0.5:
          return pipeColors[this.activeFilter].danger;
          break;

        case speed_flow.fluid_speed >= 0.5 && speed_flow.fluid_speed < 0.9:
          return pipeColors[this.activeFilter].warning;
          break;

        case speed_flow.fluid_speed > 0.9:
          return pipeColors[this.activeFilter].good;
          break;
      }
    },
    getColorByPressure(segment) {
      let pressure = segment.pin ? segment.pin : null;
      switch (true) {
        case pressure == null:
          return pipeColors[this.activeFilter].no_data;

        case pressure >= this.referentValue:
          return pipeColors[this.activeFilter].danger;

        default:
          return pipeColors[this.activeFilter].good;
      }
    },
    getColorByTemperature(segment) {
      let temperature = segment.tout ? segment.tout : null;
      switch (true) {
        case temperature == null:
          return pipeColors[this.activeFilter].no_data;

        case temperature <= this.referentValue:
          return pipeColors[this.activeFilter].danger;

        default:
          return pipeColors[this.activeFilter].good;
      }
    },
    arrayToColor(arrColor) {
      return `rgb(${arrColor[0]}, ${arrColor[1]}, ${arrColor[2]})`;
    }
  }
}
</script>

<style lang="scss" scoped>

</style>