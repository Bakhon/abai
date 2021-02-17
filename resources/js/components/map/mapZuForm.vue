<template>
  <div>
    <b-form-group
        label="Имя ЗУ"
        label-for="zu-name"
    >
      <b-form-input
          id="zu-name"
          v-model="formZu.name"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group
        label="ГУ"
        label-for="gus">
      <b-form-select
          id="gus"
          v-model="formZu.gu_id"
          :options="guOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group label="Широта" label-for="coord-x">
      <b-form-input
          id="coord-y"
          v-model="formZu.lat"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group label="Долгота" label-for="coord-y">
      <b-form-input
          id="coord-x"
          v-model="formZu.lon"
          required
      ></b-form-input>
    </b-form-group>
  </div>
</template>

<script>
export default {
  name: "mapZuForm",
  props: {
    formZu: Object,
    gus: Array
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