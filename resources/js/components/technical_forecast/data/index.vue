<template>
  <div class="container-fluid economic-wrap">

    <div class="row justify-content-between">
      <select-source
          :loading="loading"
          :form="form"
          @loading="loading = true"
          @loaded="loading = false"
          @change="getData"/>

      <vue-table-dynamic v-if="form.source_id" :params="params" ref="table">
        <a slot="column-11" slot-scope="{ props }" :href="props.cellData">
          {{ trans('app.edit') }}
        </a>
      </vue-table-dynamic>
    </div>
  </div>
</template>

<script>
import VueTableDynamic from 'vue-table-dynamic'

import {globalloadingMutations, globalloadingState} from '@store/helpers';

import SelectSource from "./../components/SelectSource";

export default {
  name: "tech-data-component",
  components: {
    VueTableDynamic,
    SelectSource
  },
  data: () => ({
    form: {
      source_id: null
    },
    sources: [],
    params: {
      data: [],
      enableSearch: true,
      whiteSpace: 'normal',
      header: 'row',
      border: true,
      stripe: true,
      pagination: true,
      sort: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12],
      pageSize: 12,
      pageSizes: [12, 24, 48],
      headerHeight: 80,
      rowHeight: 50,
      columnWidth: [
        {column: 0, width: 100},
        {column: 1, width: 60},
        {column: 2, width: 120},
        {column: 3, width: 80},
        {column: 4, width: 80},
        {column: 5, width: 80},
        {column: 6, width: 120},
        {column: 7, width: 60},
        {column: 9, width: 150},
        {column: 10, width: 150},
        {column: 11, width: 120},
        {column: 12, width: 80},
      ]
    },
  }),
  methods: {
    ...globalloadingMutations(['SET_LOADING']),

    async getData() {
      this.SET_LOADING(true);

      this.params.data = []

      const {data} = await this.axios.get(this.localeUrl('/tech_data_json'), {params: this.form})

      this.params.data = data.data

      this.SET_LOADING(false);
    },
  },
  computed: {
    ...globalloadingState(['loading']),
  }
};
</script>
<style lang="scss" scoped>
</style>
