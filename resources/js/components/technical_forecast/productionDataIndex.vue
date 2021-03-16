<template>
  <div class="container-fluid economic-wrap">
    <div class="row justify-content-between">
      <vue-table-dynamic
          :params="params"
          ref="table"
      >
        <template v-slot:column-11="{ props }">
          <a v-bind:href="props.cellData">Редактировать</a>
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
  name: "tech-data-component",
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
        sort: [2, 3],
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
      loading: false
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl('/tech_data_json')).then(({data}) => {
      this.params.data = data.tech_data
    })
  },
};
</script>
<style lang="scss" scoped>
</style>
