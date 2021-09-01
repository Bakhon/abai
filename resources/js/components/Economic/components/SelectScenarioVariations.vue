<template>
  <div :class="isInline ? 'd-flex' : ''"
       class="bg-main1 text-white text-wrap">
    <div :class="isInline ? 'd-flex align-items-center' : 'mb-2'"
         class="form-check">
      <input v-model="scenarioVariation.isFullScreen"
             id="isFullScreen"
             type="checkbox"
             class="form-check-input">

      <label for="isFullScreen" class="form-check-label">
        {{ trans('economic_reference.full_screen') }}
      </label>
    </div>

    <div :class="isInline ? 'flex-grow-1 ml-2' : ''">
      <label for="oil_price">
        {{ trans('economic_reference.oil_price') }}
      </label>

      <select
          v-model="scenarioVariation.oil_price"
          id="oil_price"
          class="mb-3 form-control text-white border-0 bg-dark-blue">
        <option
            v-for="item in scenarioVariations.oil_prices"
            :key="item"
            :value="item">
          {{ item }}
        </option>
      </select>
    </div>

    <div :class="isInline ? 'flex-grow-1 ml-2' : ''">
      <label for="dollar_rate">
        {{ trans('economic_reference.course_prices') }}
      </label>

      <select
          v-model="scenarioVariation.dollar_rate"
          id="dollar_rate"
          class="mb-3 form-control text-white border-0 bg-dark-blue">
        <option
            v-for="item in scenarioVariations.dollar_rates"
            :key="item"
            :value="item">
          {{ item }}
        </option>
      </select>
    </div>

    <div :class="isInline ? 'flex-grow-1 ml-2' : ''">
      <label for="salary_percent">
        {{ trans('economic_reference.salary_optimization') }}
      </label>

      <select
          v-model="scenarioVariation.salary_percent"
          id="salary_percent"
          class="mb-3 form-control text-white border-0 bg-dark-blue">
        <option
            v-for="item in scenarioVariations.salary_percents"
            :key="item.value"
            :value="item.value">
          {{ item.label }}
        </option>
      </select>
    </div>

    <div :class="isInline ? 'flex-grow-1 ml-2' : ''">
      <label for="retention_percent">
        {{ trans('economic_reference.retention_percents') }}
      </label>

      <select
          v-model="scenarioVariation.retention_percent"
          id="retention_percent"
          class="mb-3 form-control text-white border-0 bg-dark-blue">
        <option
            v-for="item in scenarioVariations.retention_percents"
            :key="item.value"
            :value="item.value">
          {{ item.label }}
        </option>
      </select>
    </div>

    <div :class="isInline ? 'flex-grow-1 ml-2' : ''">
      <label for="optimization_percent">
        {{ trans('economic_reference.stop_unprofitable_fund') }}
      </label>

      <select
          v-model="scenarioVariation.optimization_percent"
          id="optimization_percent"
          class="mb-3 form-control text-white border-0 bg-dark-blue">
        <option
            v-for="item in scenarioVariations.optimization_percents"
            :key="item.label"
            :value="item.value">
          {{ item.label }}
        </option>
      </select>
    </div>
  </div>
</template>

<script>
export default {
  name: "SelectScenarioVariations",
  props: {
    scenarioVariation: {
      required: true,
      type: Object
    },
    scenarioVariations: {
      required: true,
      type: Array
    },
    isInline: {
      required: false,
      type: Boolean
    }
  }
}
</script>

<style scoped>
.bg-dark-blue {
  background: #333975;
}
</style>