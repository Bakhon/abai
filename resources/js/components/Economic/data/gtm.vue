<template>
  <div>
    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleEconomicTable = !isVisibleEconomicTable">
          {{ trans('economic_reference.economic_data') }}
        </h4>

        <a :href="localeUrl('/economic/gtm/upload-excel')"
           target="_blank"
           class="text-decoration-none">
          <i class="fas fa-external-link-alt text-primary"></i>
        </a>
      </div>

      <gtm-table v-if="isVisibleEconomicTable" class="mt-2"/>
    </div>

    <div class="container p-4 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleTechTable = !isVisibleTechTable">
          {{ trans('economic_reference.technical_data') }}
        </h4>

        <a :href="localeUrl('/economic/gtm/upload-excel?is_technical=1')"
           target="_blank"
           class="text-decoration-none">
          <i class="fas fa-external-link-alt text-primary"></i>
        </a>
      </div>

      <gtm-value-table v-if="isVisibleTechTable" class="mt-2"/>
    </div>
  </div>
</template>

<script>
import GtmTable from "../components/GtmTable";
import GtmValueTable from "../components/GtmValueTable";

export default {
  name: "economic-data-gtm-component",
  components: {
    GtmTable,
    GtmValueTable,
  },
  data: () => ({
    isVisibleEconomicTable: false,
    isVisibleTechTable: false,
  }),
};
</script>
<style scoped>
.max-width-90vw {
  max-width: 90vw;
}
</style>
