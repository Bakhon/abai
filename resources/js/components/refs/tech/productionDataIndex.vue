<template>
  <div class="container-fluid">

    <cat-loader v-show="loading"/>

    <div class="row justify-content-between">
      <modal name="tech_refs_list" :width="1150" :height="400" :adaptive="true">
        <div class="modal-bign">
          <vue-table-dynamic
              :params="params"
              ref="table"
          >
          </vue-table-dynamic>
        </div>
      </modal>
    </div>

  </div>
</template>

<script>
import VModal from 'vue-js-modal'
import VueTableDynamic from 'vue-table-dynamic'
import CatLoader from '../../ui-kit/CatLoader'

Vue.use(VModal, {dynamicDefault: {draggable: true, resizable: true}});

export default {
  name: "productionDataIndex",
  components: {
    VueTableDynamic,
    CatLoader
  },
  data: function () {
    return {
      tech_data: [],
      params: {
        data: [
        ],
        enableSearch: true,
        header: 'row',
        border: true,
        stripe: true,
        pagination: true,
        pageSize: 10,
        pageSizes: [10, 20, 50],
        height: 300
      },
      loading: false
    }
  },
  beforeCreate: function () {
    this.axios.get('/ru/tech_data_list/').then(({data}) => {
      this.tech_data = data.tech_data

    })
  },
};
</script>
<style lang="scss" scoped>
</style>
