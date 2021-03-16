<template>
  <div class="container-fluid economic-wrap">
    <div class="row justify-content-between">
      <vue-table-dynamic
          :params="params"
          ref="table"
      >
        <template v-slot:column-12="{ props }">
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
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        sort: [2, 3],
        pageSize: 12,
        pageSizes: [12, 24, 48],
        columnWidth: [
            {column: 0, width: 100},
            {column: 1, width: 60},
            {column: 2, width: 100},
            {column: 3, width: 80},
            {column: 4, width: 80},
            {column: 5, width: 80},
            {column: 6, width: 80},
            {column: 7, width: 40},
            {column: 9, width: 250},
            {column: 10, width: 250},
            {column: 11, width: 80},
            {column: 12, width: 120},
            ]
      },
      loading: false
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl('/tech_data_json')).then(({data}) => {
      // console.log(data.tech_data);
      this.params.data = data.tech_data
    })
  },
};
</script>
<style lang="scss" scoped>
</style>
