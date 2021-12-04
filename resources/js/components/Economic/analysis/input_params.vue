<template>
  <div>
    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleEconomicTable = !isVisibleEconomicTable">
          {{ trans('economic_reference.economic_data') }}
        </h4>

        <a :href="localeUrl(`/economic/log?type_id=${EconomicDataLogTypeModel.ANALYSIS_PARAM}`)"
           target="_blank"
           class="text-decoration-none text-primary mr-3">
          {{ trans('economic_reference.delete_wrong_uploaded_data') }}
        </a>

        <a :href="localeUrl('/economic/analysis/param/upload-excel')"
           target="_blank"
           class="text-decoration-none text-primary">
          {{ trans('economic_reference.upload') }}
          <i class="fas fa-external-link-alt text-primary ml-1"></i>
        </a>
      </div>

      <table-analysis-param
          v-if="isVisibleEconomicTable"
          class="mt-2"/>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleTechTable = !isVisibleTechTable">
          {{ trans('economic_reference.technical_data') }}
        </h4>

        <a :href="localeUrl(`/economic/log?type_id=${EconomicDataLogTypeModel.WELL_FORECAST}`)"
           target="_blank"
           class="text-decoration-none text-primary mr-3">
          {{ trans('economic_reference.delete_wrong_uploaded_data') }}
        </a>

        <a :href="localeUrl('/economic/technical/well_forecast/upload-excel')"
           target="_blank"
           class="text-decoration-none text-primary">
          {{ trans('economic_reference.upload') }}
          <i class="fas fa-external-link-alt text-primary ml-1"></i>
        </a>
      </div>

      <table-technical-well-forecast
          v-if="isVisibleTechTable"
          class="mt-2"/>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleKitTable = !isVisibleKitTable">
        {{ trans('economic_reference.kits') }}
      </h4>

      <table-technical-well-forecast-kit
          v-if="isVisibleKitTable"
          ref="kits"
          class="mt-3"/>
    </div>

    <div class="container p-4 bg-light max-width-90vw">
      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleKitForm = !isVisibleKitForm">
        {{ trans('economic_reference.create_kit') }}
      </h4>

      <technical-well-forecast-kit-form
          v-if="isVisibleKitForm"
          class="mt-3"
          @created="updateKits()"/>
    </div>
  </div>
</template>

<script>
import {EconomicDataLogTypeModel} from "../models/EconomicDataLogTypeModel";

import TableAnalysisParam from "./components/input/TableAnalysisParam";
import TableTechnicalWellForecast from "./components/input/TableTechnicalWellForecast";
import TableTechnicalWellForecastKit from "./components/input/TableTechnicalWellForecastKit";
import TechnicalWellForecastKitForm from "./components/input/TechnicalWellForecastKitForm";

export default {
  name: "economic-analysis-input-params",
  components: {
    TableAnalysisParam,
    TableTechnicalWellForecast,
    TableTechnicalWellForecastKit,
    TechnicalWellForecastKitForm
  },
  data: () => ({
    EconomicDataLogTypeModel,
    isVisibleEconomicTable: false,
    isVisibleTechTable: false,
    isVisibleKitTable: false,
    isVisibleKitForm: false,
  }),
  methods: {
    updateKits() {
      if (!this.isVisibleKitTable) {
        return this.isVisibleKitTable = true
      }

      this.$refs['kits'].getData()
    }
  }
};
</script>
<style scoped>
.max-width-90vw {
  max-width: 90vw;
}
</style>
