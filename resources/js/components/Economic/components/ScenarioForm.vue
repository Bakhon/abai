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
          @click.native="deleteRelation(index, 'oil_prices')"/>
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
          @click.native="deleteRelation(index, 'course_prices')"/>
    </div>

    <add-button @click.native="addCoursePrice"/>

    <h5 class="text-secondary mt-3">
      {{ trans('economic_reference.optimization_percents') }}
    </h5>

    <div v-for="(optimization, index) in form.optimizations"
         :key="`optimization_${index}`"
         class="form-group d-flex">
      <input v-model="optimization.value1"
             type="numeric"
             class="form-control">

      <input v-model="optimization.value2"
             type="numeric"
             class="form-control ml-2">

      <delete-button
          class="ml-2"
          @click.native="deleteRelation(index, 'optimizations')"/>
    </div>

    <add-button @click.native="addOptimization"/>

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

    addOptimization() {
      this.form.optimizations.push({value1: 0, value2: 0})
    },

    deleteRelation(index, key) {
      if (this.form[key].length < 2) return

      this.form[key].splice(index, 1)
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