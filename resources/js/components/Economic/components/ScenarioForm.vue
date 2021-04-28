<template>
  <div class="border-dark">
    <h5 class="text-secondary">
      {{ trans('economic_reference.name') }}
    </h5>

    <div class="form-group">
      <input
          v-model="form.name"
          type="text"
          class="form-control">
    </div>

    <h5 class="text-secondary mt-3">
      {{ trans('economic_reference.source_data') }}
    </h5>

    <select-sc-fa :form="form"/>

    <h5 class="text-secondary mt-3">
      {{ trans('economic_reference.oil_prices') }}
    </h5>

    <div v-for="(price, index) in form.oil_prices"
         :key="`oil_${index}`"
         class="form-group d-flex">
      <input v-model="price.value"
             type="numeric"
             class="form-control">

      <delete-button
          class="ml-2"
          @click.native="deleteOilPrice(index)"/>
    </div>

    <add-button @click.native="addOilPrice"/>

    <h5 class="text-secondary mt-3">
      {{ trans('economic_reference.course_prices') }}
    </h5>

    <div v-for="(price, index) in form.course_prices"
         :key="`course_${index}`"
         class="form-group d-flex">
      <input v-model="price.value"
             type="numeric"
             class="form-control">

      <delete-button
          class="ml-2"
          @click.native="deleteCoursePrice(index)"/>
    </div>

    <add-button @click.native="addCoursePrice"/>

    <div class="text-center">
      <save-button @click.native="saveForm"/>
    </div>
  </div>
</template>

<script>
import SelectScFa from "./SelectScFa";
import AddButton from "./AddButton";
import DeleteButton from "./DeleteButton";
import SaveButton from "./SaveButton";

import {EcoRefsScenarioModel} from "../models/EcoRefsScenarioModel";

export default {
  name: "ScenarioForm",
  components: {
    SelectScFa,
    AddButton,
    DeleteButton,
    SaveButton
  },
  data: () => ({
    form: new EcoRefsScenarioModel().form
  }),
  methods: {
    addOilPrice() {
      this.form.oil_prices.push({value: 0})
    },

    addCoursePrice() {
      this.form.course_prices.push({value: 0})
    },

    deleteOilPrice(index) {
      if (this.form.oil_prices.length < 2) return

      this.form.oil_prices.splice(index, 1)
    },

    deleteCoursePrice(index) {
      if (this.form.course_prices.length < 2) return

      this.form.course_prices.splice(index, 1)
    },

    saveForm() {
      this.$emit('update', this.form)

      this.form = new EcoRefsScenarioModel().form
    }
  }
}
</script>

<style scoped>

</style>