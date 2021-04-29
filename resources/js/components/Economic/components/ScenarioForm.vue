<template>
  <div class="border-dark">
    <cat-loader v-show="loading"/>

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
      {{ trans('economic_reference.scenario') }}
    </h5>

    <select-sc-fa
        :form="form"
        forecast/>

    <h5 class="text-secondary mt-3">
      {{ trans('economic_reference.oil_prices') }}
    </h5>

    <div v-for="(price, index) in form.params.oil_prices"
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

    <div v-for="(price, index) in form.params.course_prices"
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

    <div v-for="(optimization, index) in form.params.optimizations"
         :key="`optimization_${index}`"
         class="form-group d-flex align-items-end">
      <div v-for="optimizationKey in EcoRefsScenarioModel.optimizationKeys"
           :key="optimizationKey"
           class="flex-grow-1 mr-2">
        <label :for="`optimization_${index}_${optimizationKey}`"
               class="text-secondary">
          {{ optimizationKey }}
        </label>
        <input v-model="optimization[optimizationKey]"
               :id="`optimization_${index}_${optimizationKey}`"
               type="numeric"
               class="form-control">
      </div>

      <delete-button
          @click.native="deleteRelation(index, 'optimizations')"/>
    </div>

    <add-button @click.native="addOptimization"/>

    <div class="text-center">
      <save-button @click.native="saveForm"/>
    </div>
  </div>
</template>

<script>
import CatLoader from "../../ui-kit/CatLoader";
import SelectScFa from "./SelectScFa";
import AddButton from "./AddButton";
import DeleteButton from "./DeleteButton";
import SaveButton from "./SaveButton";

import {EcoRefsScenarioModel} from "../models/EcoRefsScenarioModel";

export default {
  name: "ScenarioForm",
  components: {
    CatLoader,
    SelectScFa,
    AddButton,
    DeleteButton,
    SaveButton
  },
  data: () => ({
    EcoRefsScenarioModel,
    loading: false,
    form: new EcoRefsScenarioModel().form
  }),
  methods: {
    addOilPrice() {
      this.form.params.oil_prices.push(new EcoRefsScenarioModel().oil_price)
    },

    addCoursePrice() {
      this.form.params.course_prices.push(new EcoRefsScenarioModel().course_price)
    },

    addOptimization() {
      this.form.params.optimizations.push(new EcoRefsScenarioModel().optimization)
    },

    deleteRelation(index, key) {
      if (this.form.params[key].length < 2) return

      this.form.params[key].splice(index, 1)
    },

    async saveForm() {

      this.loading = true

      try {
        const {data} = await this.axios.post(this.localeUrl('/eco_refs_scenario'), this.form)

        this.$emit('created', data)

        this.form = new EcoRefsScenarioModel().form
      } catch (e) {
        console.log(e)
      }

      this.loading = false
    }
  }
}
</script>

<style scoped>

</style>