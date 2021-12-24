<template>
  <div>
    <div class="bg-dark-new list-group-item list-group-item-action">
      <div class="d-flex w-100 justify-content-start align-items-center" @click="toExcel">
        <img src="/img/digital-drilling/daily-raport.png" width="25" height="25" class="companyLogo">
      </div>
    </div>
  </div>
</template>
<script>
import {globalloadingMutations} from '@store/helpers';

export default {
  name: "downloadExcel",
  props: {
    user: {
      type: Object,
      required: true
    },
  },
  data() {
    return {
      excelData: []
    }
  },
  mounted() {
    this.$root.$on('global-excelData', this.appendExcelData)
  },
  methods: {
    ...globalloadingMutations([
      'SET_LOADING'
    ]),
    appendExcelData(elements){ this.excelData = elements; },
    toExcel(){
      this.SET_LOADING(true)
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/export-excel/'
      axios.post(url,{
        user: this.user, page_name: this.excelData.name, page_data: this.excelData.data})
          .then(function (response) {
            window.location.href = response.data
          })
          .catch(function (error) {
            console.log(error);
          });
      this.SET_LOADING(false)
    }
  }
}
</script>
<style scoped>

</style>