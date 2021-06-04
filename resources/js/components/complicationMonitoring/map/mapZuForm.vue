<template>
  <div>
    <b-form-group
        :label="trans('monitoring.zu.name')"
        label-for="zu-name"
    >
      <b-form-input
          id="zu-name"
          v-model="zu.name"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.ngdu')"
        label-for="ngdus">
      <b-form-select
          id="ngdus"
          v-model="zu.ngdu_id"
          :options="ngduOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.gu.gu')"
        label-for="gus">
      <b-form-select
          id="gus"
          v-model="zu.gu_id"
          :options="guOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group :label="trans('monitoring.latitude')" label-for="coord-x">
      <b-form-input
          id="coord-y"
          v-model="zu.lat"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group :label="trans('monitoring.longitude')" label-for="coord-y">
      <b-form-input
          id="coord-x"
          v-model="zu.lon"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group :label="trans('monitoring.elevation')" label-for="coord-z">
      <b-form-input
          id="coord-z"
          v-model="zu.elevation"
          required
      ></b-form-input>
    </b-form-group>
  </div>
</template>

<script>
import {guMapState} from '@store/helpers';

export default {
  name: "mapZuForm",
  props: {
    zu: {
      type: Object,
      required: true,
    },
  },
  computed: {
    ...guMapState([
      'guPoints',
      'ngdus',
    ]),
    guOptions: function () {
      let options = [];
      this.guPoints.forEach((item) => {
        options.push(
            { value: item.id, text: item.name }
        );
      });

      return options;
    },
    ngduOptions: function () {
      let options = [];
      this.ngdus.forEach((item) => {
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