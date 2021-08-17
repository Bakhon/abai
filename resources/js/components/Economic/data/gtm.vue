<template>
  <div class="container p-4 bg-light" style="max-width: 90vw">
    <div>
      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleEconomicUpload = !isVisibleEconomicUpload">
        Загрузка входных экономических данных
      </h4>

      <a v-if="isVisibleEconomicUpload"
         :href="localeUrl('/eco_refs_gtm/upload_excel')"
         class="mt-3">
        {{ trans('economic_reference.upload_excel') }}
      </a>

      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleEconomicTable = !isVisibleEconomicTable">
        Входные экономические данные
      </h4>

      <gtm-table v-if="isVisibleEconomicTable"/>
    </div>

    <div>
      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleTechUpload = !isVisibleTechUpload">
        Загрузка входных технических данных
      </h4>

      <a v-if="isVisibleTechUpload"
         :href="localeUrl('/eco_refs_gtm_value/upload_excel')"
         class="mt-3">
        {{ trans('economic_reference.upload_excel') }}
      </a>

      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleTechTable = !isVisibleTechTable">
        Входные технические данные
      </h4>

      <gtm-value-table v-if="isVisibleTechTable"/>
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
    GtmValueTable
  },
  data: () => ({
    isVisibleEconomicUpload: false,
    isVisibleEconomicTable: false,
    isVisibleTechUpload: false,
    isVisibleTechTable: false,
  })
};
</script>
<style scoped>

</style>
