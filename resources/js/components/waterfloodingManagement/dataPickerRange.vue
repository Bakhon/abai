<template>
  <div>
    <div class="position-absolute " style="right: 50px; z-index: 2">
      <date-picker v-if="isDatePickerShow" v-model="dateRange" is-range  @input="onDateRangeChange"></date-picker>
    </div>
    <div class="row m-0">
      <div class="col-6 p-0">
        <div @click.stop="isDatePickerShow = !isDatePickerShow" class="calendar-filter-block d-flex align-items-center justify-content-between cursor-pointer calendar-block p-0 ">
          <div class="d-flex align-items-center justify-content-center date-string">{{ dateStartString }}</div>
          <div class="calendar-sign d-flex align-items-center justify-content-center">
            <img class="calendar-icon" src="/img/GTM/calendar_icon.svg">
          </div>
        </div>
      </div>
      <div class="col-6 p-0">
        <div @click.stop="isDatePickerShow = !isDatePickerShow" class="calendar-filter-block d-flex align-items-center justify-content-between cursor-pointer calendar-block p-0 ">
          <div class="d-flex align-items-center justify-content-center date-string">{{ dateEndString }}</div>
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
import moment from 'moment'
import axios from "axios";


export default {
  data: function () {
    return {
      isDatePickerShow: false,
      dateRange: {
        start: new Date(),
        end: new Date(),
      },    }
  },
  created() {
    this.getDate();
  },
  computed: {
    dateStartString: function () {
      if (this.dateRange.start) {
        return moment(this.dateRange.start.toLocaleDateString()).format('DD.MM.YYYY');
      }
    },
    dateEndString: function () {
      if (this.dateRange.end) {
        return moment(this.dateRange.end.toLocaleDateString()).format('DD.MM.YYYY');
      }
    },
  },
  methods: {
    ...waterfloodingManagementMapActions([
        'changeGraphicStartDate',
        'changeGraphicEndDate',
    ]),
    onDateRangeChange() {
      this.isDatePickerShow = false;
      this.changeGraphicStartDate(this.dateRange.start);
      this.changeGraphicEndDate(this.dateRange.end);
      this.$emit('dateRangeChanged')
    },
    getDate(){
      let url = process.env.MIX_WATERFLOODING_MANAGMENT + 'object_selections/start_date/'
      axios.get(url)
          .then((response) =>{
            this.dateRange.end = moment(response.data.start_date).toDate();
            this.dateRange.start = this.dateRange.end.subtract(1, 'months').toDate()
            this.onDateRangeChange()
          }).catch((error) => {
        console.log(error)
      });
    }
  }
}

</script>

<style scoped>

</style>