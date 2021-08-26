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
            v-for="(tab, index) in tabs"
            :key="index"
            :text="tab"
            :active="activeTab === index"
            :class="index ? 'ml-2' : ''"
            class="col"
            @click.native="activeTab = index"/>
      </div>
    </div>

    <div v-if="res" class="mx-auto max-width-88vw">
      <table-wells
          v-if="activeTab === 0"
          :data="res"
          property="NetBack_bf_pr_exp"/>

      <table-wells
          v-else-if="activeTab === 1"
          :data="res"
          property="Overall_expenditures"/>

      <table-wells
          v-else-if="activeTab === 2"
          :data="res"
          property="Operating_profit"
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

export default {
  name: "economic-nrs-wells",
  components: {
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
    activeTab: 0
  }),
  computed: {
    ...globalloadingState(['loading']),

    tabs() {
      let dimension = `${this.trans('economic_reference.thousand')} ${this.trans('economic_reference.tenge')}`

      return [
        `${this.trans('economic_reference.Revenue')}, ${dimension}`,
        `${this.trans('economic_reference.costs')}, ${dimension}`,
        `${this.trans('economic_reference.operating_profit')}, ${dimension}`,
      ]
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
