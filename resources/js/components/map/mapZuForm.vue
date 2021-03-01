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
        :label="trans('monitoring.gu')"
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
  </div>
</template>

<script>
export default {
  name: "mapZuForm",
  props: {
    zu: {
      type: Object,
      required: true,
    },
    gus: {
      type: Array,
      required: true,
    }
  },
  computed: {
    guOptions: function () {
      let options = [];
      this.gus.forEach((item) => {
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