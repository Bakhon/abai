<template>
  <div>
    <b-form-group
        label="Имя ГУ"
        label-for="gu-name"
    >
      <b-form-input
          id="gu-name"
          v-model="formGu.name"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group
        label="ЦДНГ"
        label-for="cdng">
      <b-form-select
          id="cdng"
          v-model="formGu.cdng_id"
          :options="cdngOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group label="Широта" label-for="coord-x">
      <b-form-input
          id="coord-y"
          v-model="formGu.lat"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group label="Долгота" label-for="coord-y">
      <b-form-input
          id="coord-x"
          v-model="formGu.lon"
          required
      ></b-form-input>
    </b-form-group>
  </div>
</template>

<script>
export default {
  name: "mapGuForm",
  props: {
    formGu: Object,
    cdngs: Array
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