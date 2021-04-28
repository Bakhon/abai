<template>
  <div class="border-dark">
    <h5 class="text-secondary">
      Название
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

      <delete-button @click.native="deleteOilPrice(index)"/>
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

      <delete-button @click.native="deleteCoursePrice(index)"/>
    </div>

    <add-button @click.native="addCoursePrice"/>

    <div class="text-center">
      <save-button/>
    </div>
  </div>
</template>

<script>
import SelectScFa from "./SelectScFa";
import AddButton from "./AddButton";
import DeleteButton from "./DeleteButton";
import SaveButton from "./SaveButton";

let scenarioForm = {
  name: null,
  sc_fa: null,
  oil_prices: [],
  course_prices: [],
}

export default {
  name: "ScenarioForm",
  components: {
    SelectScFa,
    AddButton,
    DeleteButton,
    SaveButton
  },
  data: () => ({
    form: scenarioForm
  }),
  methods: {
    addOilPrice() {
      this.form.oil_prices.push({value: null})
    },

    addCoursePrice() {
      this.form.course_prices.push({value: null})
    },

    deleteOilPrice(index) {
      this.form.oil_prices.splice(index, 1)
    },

    deleteCoursePrice(index) {
      this.form.course_prices.splice(index, 1)
    },

    saveForm() {
      this.form = scenarioForm
    }
  }
}
</script>

<style scoped>

</style>