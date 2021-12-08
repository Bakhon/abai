<template>
  <div>
    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleEconomicTable = !isVisibleEconomicTable">
          {{ trans('economic_reference.economic_data') }}
        </h4>

        <a :href="localeUrl(`/economic/log?type_id=${EconomicDataLogTypeModel.GTM}`)"
           target="_blank"
           class="text-decoration-none text-primary mr-3">
          {{ trans('economic_reference.delete_wrong_uploaded_data') }}
        </a>

        <a :href="localeUrl('/economic/gtm/upload-excel')"
           target="_blank"
           class="text-decoration-none text-primary">
          {{ trans('economic_reference.upload') }}
          <i class="fas fa-external-link-alt text-primary ml-1"></i>
        </a>
      </div>

      <table-gtm
          v-if="isVisibleEconomicTable"
          class="mt-3"/>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <div class="d-flex align-items-center">
        <h4 class="text-secondary cursor-pointer mb-0 flex-grow-1"
            @click="isVisibleTechTable = !isVisibleTechTable">
          {{ trans('economic_reference.technical_data') }}
        </h4>

        <a :href="localeUrl(`/economic/log?type_id=${EconomicDataLogTypeModel.GTM_VALUE}`)"
           target="_blank"
           class="text-decoration-none text-primary mr-3">
          {{ trans('economic_reference.delete_wrong_uploaded_data') }}
        </a>

        <a :href="localeUrl('/economic/gtm/upload-excel?is_technical=1')"
           target="_blank"
           class="text-decoration-none text-primary">
          {{ trans('economic_reference.upload') }}
          <i class="fas fa-external-link-alt text-primary ml-1"></i>
        </a>
      </div>

      <table-gtm-value
          v-if="isVisibleTechTable"
          class="mt-3"/>
    </div>

    <div class="container p-4 mb-3 bg-light max-width-90vw">
      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleKitTable = !isVisibleKitTable">
        {{ trans('economic_reference.kits') }}
      </h4>

      <table-gtm-kit
          v-if="isVisibleKitTable"
          ref="kits"
          class="mt-3"/>
    </div>

    <div class="container p-4 bg-light max-width-90vw">
      <h4 class="text-secondary cursor-pointer mb-0"
          @click="isVisibleKitForm = !isVisibleKitForm">
        {{ trans('economic_reference.create_kit') }}
      </h4>

      <gtm-kit-form
          v-if="isVisibleKitForm"
          class="mt-3"
          @created="updateKits()"/>
    </div>
  </div>
</template>

<script>
import TableGtm from "./optimization/components/input/TableGtm";
import TableGtmValue from "./optimization/components/input/TableGtmValue";
import TableGtmKit from "./optimization/components/input/TableGtmKit";
import GtmKitForm from "./optimization/components/input/GtmKitForm";

import {EconomicDataLogTypeModel} from "./models/EconomicDataLogTypeModel";

export default {
  name: "economic-data-gtm-component",
  components: {
    TableGtmKit,
    TableGtm,
    TableGtmValue,
    GtmKitForm,
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
      this.isVisibleKitForm = false

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
