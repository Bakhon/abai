<template>
  <div class="text-nowrap d-flex justify-content-end">
    <div class="d-flex align-items-center form-check">
      <input v-model="visibleForm.profitable"
             id="visible_profitable"
             type="checkbox"
             class="form-check-input mt-0"
             @change="$emit('update')">
      <label for="visible_profitable"
             class="form-check-label">
        {{ trans('economic_reference.profitable') }}
      </label>
    </div>

    <div class="d-flex align-items-center form-check ml-2">
      <input v-model="visibleForm.profitless"
             id="visible_profitless"
             type="checkbox"
             class="form-check-input mt-0"
             @change="$emit('update')">
      <label for="visible_profitless"
             class="form-check-label">
        {{ trans('economic_reference.profitless') }}
      </label>
    </div>

    <div class="d-flex align-items-center form-check ml-2">
      <input v-model="visibleForm.conditionallyProfitable"
             id="visible_conditionally_profitable"
             type="checkbox"
             class="form-check-input mt-0"
             @change="$emit('update')">
      <label for="visible_conditionally_profitable"
             class="form-check-label">
        {{ trans('economic_reference.conditionally_profitable') }}
      </label>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProfitabilityCheckboxes",
  props: {
    visibleForm: {
      required: false,
      type: Object
    }
  }
}
</script>

<style scoped>

</style>