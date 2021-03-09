<template>
  <div>
    <b-form-group
        :label="trans('monitoring.gu.gu')"
        label-for="gu"
        v-if="pipe.gu_id"
    >
      <b-form-select
          id="gu"
          v-model="pipe.gu_id"
          :options="guOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.zu.zu')"
        label-for="zu">
      <b-form-select
          id="gu"
          v-model="pipe.zu_id"
          :options="zuOptions"
      ></b-form-select>
    </b-form-group>

    <h5 class="coords-collapse" v-b-toggle.coordsVisible>{{ trans('monitoring.pipe.coords') }}
      <i class="fas fa-chevron-down"></i>
    </h5>

    <b-collapse id="coordsVisible">
      <b-row v-for="(coord, index) in pipe.coordinates" :key="index">
        <b-col cols="12" sm="6">
          <b-form-group :label="trans('monitoring.latitude')" :label-for="'coord-x'+index">
            <b-form-input
                :id="'coord-x'+index"
                v-model="pipe.coordinates[index][1]"
                required
            ></b-form-input>
          </b-form-group>
        </b-col>
        <b-col cols="12" sm="6">
          <b-form-group :label="trans('monitoring.longitude')" :label-for="'coord-y'+index">
            <b-form-input
                :id="'coord-y'+index"
                v-model="pipe.coordinates[index][0]"
                required
            ></b-form-input>
          </b-form-group>
        </b-col>
        <hr class="mb-2"/>
      </b-row>
    </b-collapse>

    <b-form-group
        :label="trans('monitoring.pipe.type')"
        label-for="pipeType">
      <b-form-select
          id="pipeType"
          v-model="pipe.pipe_type_id"
          :options="pipeTypesOptions"
      ></b-form-select>
    </b-form-group>

    <h5>{{ trans('monitoring.pipe.params') }}</h5>
    <div class="params_block">
      <p>{{ trans('monitoring.pipe.fields.outside_diameter') }}: {{ pipeTypeParams.outside_diameter + trans('measurements.mm') }}</p>
      <p>{{ trans('monitoring.pipe.fields.thickness') }}: {{ pipeTypeParams.thickness + trans('measurements.mm') }}</p>
      <p>{{ trans('monitoring.pipe.fields.inner_diameter') }}: {{ pipeTypeParams.inner_diameter + trans('measurements.mm') }}</p>
      <p>{{ trans('monitoring.pipe.fields.roughness') }}: {{ pipeTypeParams.roughness }}</p>
      <p>{{ trans('monitoring.pipe.fields.plot') }}: {{ pipeTypeParams.plot }}</p>

    </div>

  </div>
</template>

<script>
import {guMapState} from '@store/helpers';

const blankPipeParams = {
  inner_diameter: '',
  outside_diameter: '',
  plot: '',
  roughness: '',
  thickness: ''
};

export default {
  name: "mapPipeForm",
  props: {
    pipe: {
      type: Object,
      required: true,
    },
    gus: {
      type: Array,
      required: true,
    },
    zus: {
      type: Array,
      required: true,
    }
  },
  computed: {
    ...guMapState([
      'pipeTypes'
    ]),
    pipeTypesOptions: function () {
      let options = [];
      this.pipeTypes.forEach((item) => {
        options.push(
            {value: item.id, text: item.name}
        );
      });

      return options;
    },
    pipeTypeParams() {
      if (this.pipe.pipe_type_id) {
        let index = this.pipeTypes.findIndex(type => type.id == this.pipe.pipe_type_id);
        if (typeof index !== 'undefined') {
          return this.pipeTypes[index]
        }
      }

      return blankPipeParams;
    },
    guOptions: function () {
      let options = [];
      this.gus.forEach((item) => {
        options.push(
            {value: item.id, text: item.name}
        );
      });

      return options;
    },
    zuOptions: function () {
      let options = [];
      this.zus.forEach((item) => {
        options.push(
            {value: item.id, text: item.name}
        );
      });

      return options;
    },
  },
}
</script>

<style scoped lang="scss">
.coords-collapse {
  outline: none;
  box-shadow: none !important;

  i {
    float: right;
    top: 3px;
    position: relative;
    transition: transform .15s cubic-bezier(1, -.115, .975, .855);
  }

  &.not-collapsed i {
    -webkit-transform: rotate(180deg);
    -moz-transform: rotate(180deg);
    -o-transform: rotate(180deg);
    -ms-transform: rotate(180deg);
    transform: rotate(180deg);
  }
}

.params_block {
  color: white;
}
</style>