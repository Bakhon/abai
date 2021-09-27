<template>
  <div>
    <div class="p-3 bg-main1 mb-3 mx-auto max-width-88vw">
      <div class="d-flex">
        <select-interval
            :form="form"
            class="col"
            @change="getData"/>

        <select-organization
            :form="form"
            class="col ml-2"
            hide-label
            @change="getData"/>

        <select-field
            v-if="form.org_id"
            :org_id="form.org_id"
            :form="form"
            class="col ml-2"
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

    <div v-if="!loading && res" class="mx-auto max-width-88vw">
      <table-wells
          v-if="activeTab === 'revenue'"
          :data="res"
          property="NetBack_bf_pr_exp"/>

      <table-wells
          v-else-if="activeTab === 'costs'"
          :data="res"
          property="Overall_expenditures"/>

      <table-wells
          v-else-if="activeTab === 'operating_profit'"
          :data="res"
          property="Operating_profit"
          is-colorful/>

      <table-tree-map
          v-else-if="activeTab === 'treemap'"
          :data="res"
          :property="activeTab"
          is-colorful/>
    </div>
  </div>
</template>

<script>
import {globalloadingMutations, globalloadingState} from '@store/helpers';

import ChartButton from "./components/ChartButton";
import SelectInterval from "./components/SelectInterval";
import SelectOrganization from "./components/SelectOrganization";
import SelectField from "./components/SelectField";
import TableWells from "./components/nrs/TableWells";
import TableTreeMap from "./components/nrs/TableTreeMap";

export default {
  name: "economic-nrs-wells",
  components: {
    TableTreeMap,
    ChartButton,
    SelectInterval,
    SelectOrganization,
    SelectField,
    TableWells
  },
  data: () => ({
    form: {
      org_id: null,
      field_id: null,
      interval_start: '2021-01-01T00:00:00.000Z',
      interval_end: '2021-02-01T00:00:00.000Z',
    },
    res: null,
    activeTab: 'treemap'
  }),
  computed: {
    ...globalloadingState(['loading']),

    tabs() {
      let dimension = `${this.trans('economic_reference.thousand')} ${this.trans('economic_reference.tenge')}`

      return {
        treemap: 'TreeMap',
        revenue: `${this.trans('economic_reference.Revenue')}, ${dimension}`,
        costs: `${this.trans('economic_reference.costs')}, ${dimension}`,
        operating_profit: `${this.trans('economic_reference.operating_profit')}, ${dimension}`,
      }
    },
  },
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      if (this.form.org_id === 2) return

      this.SET_LOADING(true);

      try {
        const {data} = await this.axios.get(this.localeUrl('/economic/nrs/get-wells'), {params: this.form})

        this.res = data
      } catch (e) {
        this.res = null

        console.log(e)
      }

      this.SET_LOADING(false);
    },
  }
};
</script>
<style scoped>
.max-width-88vw {
  max-width: 88vw;
}
</style>
