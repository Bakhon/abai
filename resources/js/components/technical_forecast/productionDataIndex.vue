<template>
  <div class="container-fluid economic-wrap">
<!--    <cat-loader v-show="loading"/>-->
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
// import CatLoader from '../../ui-kit/CatLoader'

Vue.use(VModal, {dynamicDefault: {draggable: true, resizable: true}});

export default {
  name: "tech-data-component",
  components: {
    VueTableDynamic,
    // CatLoader
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
      },
      loading: false
    }
  },
  beforeCreate: function () {
    this.axios.get(this.localeUrl('/tech_data_json')).then(({data}) => {
      console.log(data.tech_data);
      this.params.data = data.tech_data
    })
  },
};
</script>
<style lang="scss" scoped>
</style>
