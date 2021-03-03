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

    <h5>{{ trans('monitoring.pipe.coords') }}</h5>

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
      <hr class="mb-2" />
    </b-row>

    <b-form-group
        :label="trans('monitoring.pipe.type')"
        label-for="zu">
      <b-form-select
          id="gu"
          v-model="pipe.pipe_type_id"
          :options="pipeTypesOptions"
      ></b-form-select>
    </b-form-group>

    <h5>{{ trans('monitoring.pipe.params') }}</h5>
  </div>
</template>

<script>
import {guMapState} from '@store/helpers';

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
            { value: item.id, text: item.name }
        );
      });

      return options;
    },
    guOptions: function () {
      let options = [];
      this.gus.forEach((item) => {
        options.push(
            { value: item.id, text: item.name }
        );
      });

      return options;
    },
    zuOptions: function () {
      let options = [];
      this.zus.forEach((item) => {
        options.push(
            { value: item.id, text: item.name }
        );
      });

      return options;
    },
  },
}
</script>

<style scoped>

</style>