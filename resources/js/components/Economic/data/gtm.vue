<template>
  <div class="container p-4 bg-light" style="max-width: 90vw">
    <div>
      <a :href="localeUrl('/eco_refs_gtm/upload_excel')"
         class="list-group-item list-group-item-action">
        {{ trans('economic_reference.upload_excel') }}
      </a>

      <gtm-table/>
    </div>

    <div>
      <a :href="localeUrl('/eco_refs_gtm_value/upload_excel')"
         class="list-group-item list-group-item-action">
        {{ trans('economic_reference.upload_excel') }}
      </a>

      <gtm-value-table/>
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
};
</script>
<style scoped>

</style>
