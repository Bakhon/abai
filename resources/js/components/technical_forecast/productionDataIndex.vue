<template>
  <div class="container-fluid economic-wrap">
    <cat-loader v-show="loading"/>

    <div class="row justify-content-between">
      <select-source
          :loading="loading"
          :form="form"
          @loading="loading = true"
          @loaded="loading = false"
          @change="getTechData"/>

      <vue-table-dynamic
          v-if="form.source_id"
          :params="params"
          ref="table"/>
    </div>
  </div>
</template>

<script>
import VModal from 'vue-js-modal'
import VueTableDynamic from 'vue-table-dynamic'
import CatLoader from "../ui-kit/CatLoader";
import SelectSource from "./components/SelectSource";

Vue.use(VModal, {dynamicDefault: {draggable: true, resizable: true}});

export default {
  name: "tech-data-component",
  components: {
    VueTableDynamic,
    CatLoader,
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
    loading: true
  }),
  methods: {
    async getTechData() {
      this.loading = true

      this.params.data = []

      const {data} = await this.axios.get(this.localeUrl('/tech_data_json'), {params: this.form})

      this.params.data = data.tech_data

      this.loading = false
    },
  }
};
</script>
<style lang="scss" scoped>
</style>
