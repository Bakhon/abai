<template>
  <div>
    <div v-for="link in links"
         :key="link.url"
         class="container p-4 mb-3 bg-light max-width-90vw">
      <a :href="link.url"
         target="_blank"
         class="text-decoration-none">
        <h4 class="text-secondary cursor-pointer mb-0">
          {{ link.title }}
        </h4>
      </a>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleEconomicTable = !isVisibleEconomicTable">
        {{ trans('economic_reference.economic_data') }}
      </h4>

      <gtm-table v-if="isVisibleEconomicTable"/>
    </div>

    <div class="container p-4 bg-light max-width-90vw">
      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleTechTable = !isVisibleTechTable">
        {{ trans('economic_reference.technical_data') }}
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
    isVisibleEconomicTable: false,
    isVisibleTechTable: false,
  }),
  computed: {
    links() {
      return [
        {
          title: this.trans('economic_reference.upload_economic_data'),
          url: this.localeUrl('/eco_refs_gtm/upload_excel')
        },
        {
          title: this.trans('economic_reference.upload_technical_data'),
          url: this.localeUrl('/eco_refs_gtm_value/upload_excel')
        }
      ]
    }
  }
};
</script>
<style scoped>
.max-width-90vw {
  max-width: 90vw;
}
</style>
