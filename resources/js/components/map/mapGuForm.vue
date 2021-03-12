<template>
  <div>
    <b-form-group
        :label="trans('monitoring.gu.name')"
        label-for="gu-name"
    >
      <b-form-input
          id="gu-name"
          v-model="gu.name"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group
        :label="trans('monitoring.cdng')"
        label-for="cdng">
      <b-form-select
          id="cdng"
          v-model="gu.cdng_id"
          :options="cdngOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group :label="trans('monitoring.latitude')" label-for="coord-x">
      <b-form-input
          id="coord-y"
          v-model="gu.lat"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group :label="trans('monitoring.longitude')" label-for="coord-y">
      <b-form-input
          id="coord-x"
          v-model="gu.lon"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group :label="trans('monitoring.elevation')" label-for="coord-z">
      <b-form-input
          id="coord-z"
          v-model="gu.elevation"
          required
      ></b-form-input>
    </b-form-group>
  </div>
</template>

<script>
export default {
  name: "mapGuForm",
  props: {
    gu: {
      type: Object,
      required: true,
    },
    cdngs: {
      type: Array,
      required: true,
    }
  },
  computed: {
    cdngOptions: function () {
      let options = [];
      this.cdngs.forEach((item) => {
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