<template>
  <div>
    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleEconomicTable = !isVisibleEconomicTable">
          {{ trans('economic_reference.economic_data') }}
        </h4>

        <a :href="localeUrl('/economic/analysis/input/eco/upload-excel')"
           target="_blank"
           class="text-decoration-none text-primary">
          {{ trans('economic_reference.upload') }}
          <i class="fas fa-external-link-alt text-primary ml-1"></i>
        </a>
      </div>

      <economic-table v-if="isVisibleEconomicTable" class="mt-2"/>
    </div>

    <div class="container p-4 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleTechTable = !isVisibleTechTable">
          {{ trans('economic_reference.technical_data') }}
        </h4>

        <a :href="localeUrl('/economic/technical/well_forecast/upload-excel')"
           target="_blank"
           class="text-decoration-none text-primary">
          {{ trans('economic_reference.upload') }}
          <i class="fas fa-external-link-alt text-primary ml-1"></i>
        </a>
      </div>

      <tech-table v-if="isVisibleTechTable" class="mt-2"/>
    </div>
  </div>
</template>

<script>
import VueTableDynamic from 'vue-table-dynamic';

import EconomicTable from "../../gno/modals/EconomicTable";
import TechTable from "../components/analysis/TechTable";

export default {
  name: "economic-data-analysis-component",
  components: {
    VueTableDynamic,
    EconomicTable,
    TechTable,
  },
  data: () => ({
    isVisibleEconomicTable: false,
    isVisibleTechTable: false,
  }),
};
</script>
<style scoped>
</style>
