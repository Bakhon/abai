<template>
  <div>
    <div class="p-3 bg-main1 mb-3 mx-auto max-width-88vw">
      <div class="d-flex">
        <select-organization
            :form="form"
            class="flex-grow-1"
            hide-label
            @change="getData"/>

        <select-field
            v-if="form.org_id"
            :org_id="form.org_id"
            :form="form"
            class="ml-2 flex-grow-1"
            @change="getData"/>

        <select-granularity
            :form="form"
            class="ml-2 flex-grow-1"/>

        <select-interval
            :form="form"
            class="ml-2 flex-grow-1 flex-shrink-0"
            @change="getData"/>
      </div>

      <div class="mt-3 d-flex align-items-center">
        <chart-button
            v-for="(tab, index) in Object.keys(tabs)"
            :key="index"
            :text="tabs[tab]"
            :active="activeTab === tab"
            :class="index ? 'ml-2' : ''"
            class="col"
            @click.native="activeTab = tab"/>
      </div>
    </div>

    <div class="mx-auto max-width-88vw">
      <table-matrix
          v-if="activeTab === 'matrix'"
          :wells="wells"/>

      <table-tree-map
          v-else-if="wells && activeTab === 'treemap'"
          :data="wells"
          :property="activeTab"
          is-colorful/>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations, globalloadingState} from '@store/helpers';

import ChartButton from "../components/ChartButton";
import SelectInterval from "./components/SelectInterval";
import SelectOrganization from "../components/SelectOrganization";
import SelectField from "./components/SelectField";
import SelectGranularity from "../components/SelectGranularity";
import TableMatrix from "./components/TableMatrix";
import TableTreeMap from "./components/TableTreeMap";

export default {
  name: "economic-nrs-wells",
  components: {
    TableTreeMap,
    ChartButton,
    SelectInterval,
    SelectOrganization,
    SelectField,
    SelectGranularity,
    TableMatrix
  },
  data: () => ({
    form: {
      org_id: null,
      field_id: null,
      interval_start: '2021-01-01T00:00:00.000Z',
      interval_end: '2021-06-30T00:00:00.000Z',
      granularity: 'month'
    },
    wells: null,
    activeTab: 'matrix'
  }),
  computed: {
    ...globalloadingState(['loading']),

    tabs() {
      return {
        matrix: this.trans('economic_reference.matrix'),
        treemap: 'TreeMap',
      }
    },
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      if (this.form.org_id === 2) return

      this.SET_LOADING(true)

      this.wells = null

      try {
        const {data} = await this.axios.get(this.localeUrl('/economic/nrs/get-wells'), {params: this.form})

        this.wells = data
      } catch (e) {
        console.log(e)
      }

      this.SET_LOADING(false)
    },
  }
};
</script>
<style scoped>
.max-width-88vw {
  max-width: 88vw;
}
</style>
