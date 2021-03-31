<template>
  <div>
    <b-form-group
        :label="trans('monitoring.well.name')"
        label-for="well-name"
    >
      <b-form-input
          id="well-name"
          v-model="well.name"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.ngdu')"
        label-for="ngdus">
      <b-form-select
          id="ngdus"
          v-model="well.ngdu_id"
          :options="ngduOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.gu.gu')"
        label-for="gus">
      <b-form-select
          id="gus"
          v-model="well.gu_id"
          :options="guOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.zu.zu')"
        label-for="zus">
      <b-form-select
          id="zus"
          v-model="well.zu_id"
          :options="zuOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group :label="trans('monitoring.latitude')" label-for="coord-x">
      <b-form-input
          id="coord-y"
          v-model="well.lat"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group :label="trans('monitoring.longitude')" label-for="coord-y">
      <b-form-input
          id="coord-x"
          v-model="well.lon"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group :label="trans('monitoring.elevation')" label-for="coord-z">
      <b-form-input
          id="coord-z"
          v-model="well.elevation"
          required
      ></b-form-input>
    </b-form-group>
  </div>
</template>

<script>
import {guMapState} from '@store/helpers';

export default {
  name: "mapWellForm",
  props: {
    well: {
      type: Object,
      required: true,
    },
  },
  computed: {
    ...guMapState([
      'guPoints',
      'zuPoints',
      'ngdus'
    ]),
    zuOptions: function () {
      let options = [];
      this.zuPoints.forEach((item) => {
        if (item.gu_id) {
          options.push(
              { value: item.id, text: item.name }
          );
        }
      });

      return options;
    },
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