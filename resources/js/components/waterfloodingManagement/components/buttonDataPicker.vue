<template>
  <div>
    <div class="position-absolute " style="right: 50px; z-index: 2">
      <date-picker v-if="isDatePickerShow"
                   v-model="dateRange"
                   @input="onDateRangeChange"></date-picker>
    </div>
    <div class="row m-0">
      <div class="col-12 p-0">
        <div
            @click.stop="isDatePickerShow = !isDatePickerShow"
            class="calendar-filter-block d-flex align-items-center justify-content-center cursor-pointer calendar-block p-0 ">
          <div class="d-flex align-items-center justify-content-center date-string">{{ dateString }}</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment"
import DatePicker from 'v-calendar/lib/components/date-picker.umd'

export default {
  name: "buttonDataPicker",
  props: ['date'],
  components: {
    DatePicker
  },
  data: function () {
    return {
      isDatePickerShow: false,
      dateRange: new Date(this.date),
    }
  },
  computed: {
    dateString: function(){
      return moment(this.dateRange.toLocaleDateString()).format('DD.MM.YYYY');;
    }
  },
  methods: {
    onDateRangeChange() {
      this.isDatePickerShow = false;
    }
  }
}
</script>
<style scoped>
.calendar-block{
  margin:0;
  height: 42px;
  background: #2c44bd;
  border: 0.4px solid #454FA1;
  box-sizing: border-box;
  border-radius: 4px;
}
.date-string{
  font-weight: bold;
  font-size: 14px;
  line-height: 17px;
}
</style>