<template>
  <div>
    <b-form-group
        label="Имя Скважины"
        label-for="well-name"
    >
      <b-form-input
          id="well-name"
          v-model="well.name"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group
        label="ЗУ"
        label-for="zus">
      <b-form-select
          id="zus"
          v-model="well.zu_id"
          :options="zuOptions"
      ></b-form-select>
    </b-form-group>

    <b-form-group label="Широта" label-for="coord-x">
      <b-form-input
          id="coord-y"
          v-model="well.lat"
          required
      ></b-form-input>
    </b-form-group>

    <b-form-group label="Долгота" label-for="coord-y">
      <b-form-input
          id="coord-x"
          v-model="well.lon"
          required
      ></b-form-input>
    </b-form-group>
  </div>
</template>

<script>
export default {
  name: "mapWellForm",
  props: {
    well: {
      type: Object,
      required: true,
    },
    zus: {
      type: Array,
      required: true,
    }
  },
  computed: {
    zuOptions: function () {
      let options = [];
      this.zus.forEach((item) => {
        if (item.gu_id) {
          options.push(
              { value: item.id, text: item.name }
          );
        }
      });

      return options;
    },
  },
}
</script>

<style scoped>

</style>