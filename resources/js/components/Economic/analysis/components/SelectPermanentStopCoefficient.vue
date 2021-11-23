<template>
  <div>
    <label for="permanent_cost_coefficient">
      {{ trans('economic_reference.permanent_stop_coefficient') }}
    </label>

    <input
        v-model="form.permanent_stop_coefficient"
        id="permanent_cost_coefficient"
        type="number"
        step="0.1"
        min="0"
        class="form-control text-white border-0"
        style="background-color: #333975 !important;">
  </div>
</template>

<script>
export default {
  name: "SelectPermanentStopCoefficient",
  props: {
    form: {
      required: true,
      type: Object
    }
  }
}
</script>

<style scoped>

</style>