<template>
  <div>
    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleEconomicTable = !isVisibleEconomicTable">
          {{ trans('economic_reference.economic_data') }}
        </h4>

        <a :href="localeUrl(`/economic/log?type_id=${EconomicDataLogTypeModel.COST}`)"
           target="_blank"
           class="text-decoration-none text-primary mr-3">
          {{ trans('economic_reference.delete_wrong_uploaded_data') }}
        </a>

        <a :href="localeUrl('/economic/cost/upload-excel?is_forecast=1')"
           target="_blank"
           class="text-decoration-none text-primary">
          {{ trans('economic_reference.upload') }}
          <i class="fas fa-external-link-alt text-primary ml-1"></i>
        </a>
      </div>

      <table-costs
          v-if="isVisibleEconomicTable"
          class="mt-3"/>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleTechTable = !isVisibleTechTable">
          {{ trans('economic_reference.technical_data') }}
        </h4>

        <a :href="localeUrl(`/economic/log?type_id=${EconomicDataLogTypeModel.DATA_FORECAST}`)"
           target="_blank"
           class="text-decoration-none text-primary mr-3">
          {{ trans('economic_reference.delete_wrong_uploaded_data') }}
        </a>

        <a :href="localeUrl('/economic/technical/forecast/upload-excel')"
           target="_blank"
           class="text-decoration-none text-primary">
          {{ trans('economic_reference.upload') }}
          <i class="fas fa-external-link-alt text-primary ml-1"></i>
        </a>
      </div>

      <table-technical-data-forecast
          v-if="isVisibleTechTable"
          class="mt-3"/>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleManufacturingTable = !isVisibleManufacturingTable">
          {{ trans('economic_reference.manufacturing_program') }}
        </h4>

        <a :href="localeUrl(`/economic/log?type_id=${EconomicDataLogTypeModel.MANUFACTURING_PROGRAM}`)"
           target="_blank"
           class="text-decoration-none text-primary mr-3">
          {{ trans('economic_reference.delete_wrong_uploaded_data') }}
        </a>

        <a :href="localeUrl('/economic/manufacturing_program/upload-excel')"
           target="_blank"
           class="text-decoration-none text-primary">
          {{ trans('economic_reference.upload') }}
          <i class="fas fa-external-link-alt text-primary ml-1"></i>
        </a>
      </div>

      <table-manufacturing-program
          v-if="isVisibleManufacturingTable"
          class="mt-3"/>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <a :href="localeUrl('/economic/gtm')"
         target="_blank"
         class="text-decoration-none">
        <h4 class="text-secondary cursor-pointer mb-0">
          {{ trans('economic_reference.eco_refs_gtm') }}
        </h4>
      </a>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleScenarioTable = !isVisibleScenarioTable">
        {{ trans('economic_reference.scenarios') }}
      </h4>

      <table-scenario
          v-if="isVisibleScenarioTable"
          ref="scenarios"
          class="mt-3"/>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleScenarioForm = !isVisibleScenarioForm">
        {{ trans('economic_reference.create_scenario') }}
      </h4>

      <scenario-form
          v-if="isVisibleScenarioForm"
          class="mt-3"
          @created="updateScenarios()"/>
    </div>
  </div>
</template>

<script>
import {EconomicDataLogTypeModel} from "../models/EconomicDataLogTypeModel";

import TableCosts from "./components/input/TableCosts";
import TableTechnicalDataForecast from "./components/input/TableTechnicalDataForecast";
import TableScenario from "./components/input/TableScenario";
import TableManufacturingProgram from "./components/input/TableManufacturingProgram";
import ScenarioForm from "./components/input/ScenarioForm";

export default {
  name: "economic-optimization-input-params",
  components: {
    TableCosts,
    TableTechnicalDataForecast,
    TableScenario,
    TableManufacturingProgram,
    ScenarioForm,
  },
  data: () => ({
    EconomicDataLogTypeModel,
    isVisibleEconomicTable: false,
    isVisibleTechTable: false,
    isVisibleManufacturingTable: false,
    isVisibleScenarioTable: false,
    isVisibleScenarioForm: false,
  }),
  methods: {
    updateScenarios() {
      this.isVisibleScenarioForm = false

      if (!this.isVisibleScenarioTable) {
        return this.isVisibleScenarioTable = true
      }

      this.$refs['scenarios'].getData()
    }
  }
};
</script>
<style scoped>
.max-width-90vw {
  max-width: 90vw;
}
</style>
