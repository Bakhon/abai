<template>
  <div class="wrapper-info">
    <div class="grid-container">
      <info-table inform_data="21" :description=amount_of_pvt></info-table>
      <info-table inform_data="17" :description=deep_samples></info-table>

      <info-table inform_data="53" :description=recombined></info-table>
      <info-table inform_data="9" :description = well_head_samples></info-table>

    </div>
   
  </div>
</template>

<script>
import InfoTable from "../components/InfoTable.vue";
export default {
   data: function () {
    return {
    amount_of_pvt: this.trans('plust_fluids.amount_of_pvt'),
    deep_samples:this.trans('plust_fluids.deep_samples'),
    recombined:this.trans('plust_fluids.recombined'),
    well_head_samples: this.trans('plust_fluids.well_head_samples')
    
    }},
  components: {
    InfoTable,
  },
};
</script>

<style scoped>
.wrapper-info {
  background: #272953;
  padding: 10px 14px 10px;
}
.grid-container {
  display: grid;
  grid-template-rows: 1fr 1fr;
  grid-template-columns: 1fr 1fr;
}
</style>
