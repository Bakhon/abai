<template>
  <div class="d-flex bg-main1 text-white text-wrap">
    <div class="ml-2">
      <div class="text-nowrap" style="font-size: 14px; line-height: 18px; font-weight: 600;">
        {{ trans('economic_reference.select_optimization_scenarios') }}
      </div>

      <div class="form-check" style="margin-top: 16px;">
        <input v-model="scenarioVariation.isFullScreen"
               id="isFullScreen"
               type="checkbox"
               class="form-check-input">

        <label for="isFullScreen" class="form-check-label">
          {{ trans('economic_reference.full_screen') }}
        </label>
      </div>
    </div>

    <select-organization
        :form="form"
        class="flex-grow-1 ml-2"
        @change="$emit('changeOrg')"/>

    <select-scenario
        :form="form"
        class="flex-grow-1 ml-2"
        @change="selectScenario()"/>

    <div v-if="form.scenario_id" class="flex-grow-1 flex-shrink-0 ml-2">
      <label for="oil_price">
        {{ trans('economic_reference.oil_price') }}
      </label>

      <select
          v-model="scenarioVariation.oil_price"
          id="oil_price"
          class="form-control text-white border-0 bg-dark-blue">
        <option
            v-for="item in scenarioVariations.oil_prices"
            :key="item"
            :value="item">
          {{ item }}
        </option>
      </select>
    </div>

    <div v-if="form.scenario_id" class="flex-grow-1 flex-shrink-0 ml-2">
      <label for="dollar_rate">
        {{ trans('economic_reference.course_prices') }}
      </label>

      <select
          v-model="scenarioVariation.dollar_rate"
          id="dollar_rate"
          class="form-control text-white border-0 bg-dark-blue">
        <option
            v-for="item in scenarioVariations.dollar_rates"
            :key="item"
            :value="item">
          {{ item }}
        </option>
      </select>
    </div>

    <div v-if="form.scenario_id" class="flex-grow-1 flex-shrink-0 ml-2">
      <label for="salary_percent">
        {{ trans('economic_reference.salary_optimization') }}
      </label>

      <select
          v-model="scenarioVariation.salary_percent"
          id="salary_percent"
          class="form-control text-white border-0 bg-dark-blue">
        <option
            v-for="item in scenarioVariations.salary_percents"
            :key="item.value"
            :value="item.value">
          {{ item.label }}
        </option>
      </select>
    </div>

    <div v-if="form.scenario_id" class="flex-grow-1 flex-shrink-0 ml-2">
      <label for="retention_percent">
        {{ trans('economic_reference.retention_percents') }}
      </label>

      <select
          v-model="scenarioVariation.retention_percent"
          id="retention_percent"
          class="form-control text-white border-0 bg-dark-blue">
        <option
            v-for="item in scenarioVariations.retention_percents"
            :key="item.value"
            :value="item.value">
          {{ item.label }}
        </option>
      </select>
    </div>

    <div v-if="form.scenario_id" class="flex-grow-1 flex-shrink-0 ml-2">
      <label for="optimization_percent">
        {{ trans('economic_reference.stop_options_for_unprofitable_fund') }}
      </label>

      <select
          v-model="scenarioVariation.optimization_percent"
          id="optimization_percent"
          class="form-control text-white border-0 bg-dark-blue">
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
import SelectOrganization from "./SelectOrganization";
import SelectScenario from "./SelectScenario";

export default {
  name: "SelectScenarioVariations",
  components: {
    SelectOrganization,
    SelectScenario,
  },
  props: {
    form: {
      required: true,
      type: Object
    },
    scenarioVariation: {
      required: true,
      type: Object
    },
    scenarioVariations: {
      required: true,
      type: Object
    },
  },
  methods: {
    selectScenario() {
      this.scenarioVariation.dollar_rate = this.scenarioVariations.dollar_rates[0]

      this.scenarioVariation.oil_price = this.scenarioVariations.oil_prices[0]

      this.scenarioVariation.salary_percent = this.scenarioVariations.salary_percents[0].value

      this.scenarioVariation.retention_percent = this.scenarioVariations.retention_percents[0].value

      this.scenarioVariation.optimization_percent.cat_1 = this.scenarioVariations.optimization_percents[0].value.cat_1

      this.scenarioVariation.optimization_percent.cat_2 = this.scenarioVariations.optimization_percents[0].value.cat_2
    },
  }
}
</script>

<style scoped>
.bg-dark-blue {
  background: #333975;
}
</style>