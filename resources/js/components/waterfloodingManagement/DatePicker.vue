<template>
  <div>
    <div class="position-absolute " style="right: 50px; z-index: 2">
      <date-picker v-if="isDatePickerShow" v-model="dateRange"  @input="onDateRangeChange"></date-picker>
    </div>
    <div class="row m-0">
      <div class="col-12 p-0">
        <div @click.stop="isDatePickerShow = !isDatePickerShow" class="calendar-filter-block d-flex align-items-center justify-content-between cursor-pointer calendar-block p-0 ">
          <div class="d-flex align-items-center justify-content-center date-string">{{ dateString }}</div>
          <div class="calendar-sign d-flex align-items-center justify-content-center">
            <img class="calendar-icon" src="/img/GTM/calendar_icon.svg">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {waterfloodingManagementMapActions} from "../../store/helpers";
import axios from "axios";
import moment from 'moment'

export default {
  data: function () {
    return {
      isDatePickerShow: false,
      dateRange: new Date(),
    }
  },
  mounted() {
    this.getDate()
  },
  computed: {
    dateString: function(){
      return moment(this.dateRange.toLocaleDateString()).format('DD.MM.YYYY');
    }
  },
  methods: {
    ...waterfloodingManagementMapActions([
      'changeChooseObjectDate',
    ]),
    getDate(){
      let url = 'http://127.0.0.1:8001/api/v1/object_selections/start_date/'
      axios.get(url)
          .then((response) =>{
            let start_date = response.data.start_date.split('-')
            this.dateRange = new Date(parseInt(start_date[0]), parseInt(start_date[1]) - 1, parseInt(start_date[2]))
            this.changeChooseObjectDate(this.dateRange);
          }).catch((error) => {
        console.log(error)
      });
    },
    onDateRangeChange() {
      this.isDatePickerShow = false;
      this.changeChooseObjectDate(this.dateRange);
      this.$emit('dateChanged')
    }
  }
}
</script>
<style>
.calendar-block{
  background: #1A1D46;
  border: 0.4px solid #363B68;
  box-sizing: border-box;
  border-radius: 4px;
  height: 28px;
  margin: 8px;
}
.calendar-block .date-string{
  width: calc(100% - 28px);
}
.calendar-block .calendar-sign{
  width: 28px;
  height: 100%;
  background: #363B68;
}
</style>