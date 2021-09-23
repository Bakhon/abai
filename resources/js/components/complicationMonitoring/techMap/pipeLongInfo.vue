<template>
  <div class="table-page">
    <table class="table table-bordered table-dark">
      <tbody v-if="longInfoRows.length">
      <tr v-for="(row, rIndex) in longInfoRows">
        <template v-for="(column, cIndex) in row">
          <th v-if="cIndex == 0" scope="row">{{ column.name }}</th>
          <td v-else-if="rIndex == 0" :style="{backgroundColor: arrayToColor(column)}"></td>
          <td v-else :style="{color: paramColor(rIndex, cIndex)}">{{ column }}</td>
        </template>
      </tr>
      </tbody>
    </table>

    <div class="color-white">
      <p>{{ trans('monitoring.pipe.fields.sizes')}}:
        {{ pipe.pipe_type.outside_diameter + ' x ' + pipe.pipe_type.thickness }}
      </p>
      <p>{{ trans('monitoring.gu.fields.daily_fluid_production') }}:
        {{ pipe.hydro_calc.qliq.toFixed(2) + ' ' + trans('measurements.m3/day') }}
      </p>
      <p>{{ trans('monitoring.gu.fields.bsw') }}: {{ pipe.hydro_calc.bsw.toFixed(2) + trans('measurements.percent') }}
      </p>
      <p>{{ trans('monitoring.omgngdu.fields.gas_factor') }}:
        {{ pipe.hydro_calc.gazf.toFixed(2) }}
      </p>
    </div>
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
          name: '',
          field: 'color'
        },
        {
          name: 'Distance',
          field: 'distance'
        },
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
      ],
      filterFields: {
        speedFlow: 'vm',
        pressure: 'pin',
        temperature: 'tout'
      }
    }
  },
  computed: {
    longInfoRows() {
      let longInfoRows = [];

      if (!this.pipe) {
        return longInfoRows;
      }

      this.fields.forEach((field, fIndex) => {
        longInfoRows[fIndex] = [field];

        this.pipe.hydro_calc_long.forEach((segment, sIndex) => {
          switch (field.field) {
            case "color":
              longInfoRows[fIndex].push(this.getPipeColor(segment));
              break;

            case "distance":
              if (sIndex == 0) {
                longInfoRows[fIndex].push('0 - ' + segment.distance + ' м');
              } else {
                longInfoRows[fIndex].push(this.pipe.hydro_calc_long[sIndex - 1].distance + ' - ' + segment.distance + ' м');
              }
              break;

            default:
              longInfoRows[fIndex].push(segment[field.field]);
          }
        })
      });

      return longInfoRows;
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
      let speed_flow = segment.vm ? parseFloat(segment.vm) : null;

      switch (true) {
        case speed_flow == null:
          return pipeColors[this.activeFilter].no_data;
          break;

        case speed_flow < 0.5:
          return pipeColors[this.activeFilter].danger;
          break;

        case speed_flow >= 0.5 && speed_flow < 0.9:
          return pipeColors[this.activeFilter].warning;
          break;

        case speed_flow > 0.9:
          return pipeColors[this.activeFilter].good;
          break;
      }
    },
    getColorByPressure(segment) {
      let pressure = segment.pin ? parseFloat(segment.pin) : null;

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
      let temperature = segment.tout ? parseFloat(segment.tout) : null;

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
    },
    paramColor(rIndex, cIndex) {
      if (this.longInfoRows[rIndex][0].field == this.filterFields[this.activeFilter]) {
        return this.arrayToColor(this.longInfoRows[0][cIndex])
      }

      return 'rgb(255,255,255)';
    },
  }
}
</script>