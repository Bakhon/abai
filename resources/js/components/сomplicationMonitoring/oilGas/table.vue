<template>
  <div class="col-xs-12 col-sm-12 col-md-12 row">
        <vue-table-dynamic
        :params="params"
        ref="table"
        >
        </vue-table-dynamic>
  </div>
</template>

<script>

import VueTableDynamic from 'vue-table-dynamic';

export default {
  data: function () {
    return {
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
        }
    }
  },
  beforeCreate: function () {
    let uri = '/vcoreconomic';
    this.axios.get(uri).then((response) => {
        let data = response.data;
        if(data) {
            this.params.data = data.wellsList
        }
        else {
            console.log('No data');
        }
    });
  },
  components: { VueTableDynamic }
};
</script>
<style scoped>
</style>
