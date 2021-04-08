<template>
  <div class="container-fluid economic-wrap">
    <div class="row justify-content-between">
      <vue-table-dynamic
          :params="params"
          ref="table"
      >
        <template v-slot:column-15="{ props }">
          <a v-bind:href="props.cellData">EDIT</a>
        </template>
      </vue-table-dynamic>
    </div>
  </div>
</template>

<script>
import VModal from 'vue-js-modal'
import VueTableDynamic from 'vue-table-dynamic'

Vue.use(VModal, {dynamicDefault: {draggable: true, resizable: true}});

export default {
  name: "economic-data-component",
  components: {
    VueTableDynamic,
  },
  data: function () {
    return {
      params: {
        data: [],
        enableSearch: true,
        whiteSpace: 'normal',
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        sort: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13],
        pageSize: 12,
        pageSizes: [12, 24, 48],
        headerHeight: 120,
        rowHeight: 50,
        columnWidth: [
            {column: 0, width: 100},
            {column: 1, width: 120},
            {column: 2, width: 80},
            {column: 3, width: 80},
            {column: 4, width: 150},
            {column: 5, width: 120},
            {column: 6, width: 120},
            {column: 7, width: 120},
            {column: 8, width: 120},
            {column: 9, width: 100},
            {column: 10, width: 100},
            {column: 11, width: 100},
            {column: 13, width: 150},
            {column: 14, width: 150},
            {column: 15, width: 120},
            {column: 16, width: 80},
            ]
      },
      loading: false
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl('/economic_data_json')).then(({data}) => {
      this.params.data = data.economic_data
    })
  },
};
</script>
<style lang="scss" scoped>
</style>
