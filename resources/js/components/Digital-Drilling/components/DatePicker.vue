<template>
  <div>
    <div class="position-absolute " style="right: 50px; z-index: 2;">
      <date-picker v-if="isDatePickerShow" v-model="dateRange" @input="onDateRangeChange" style="background-color: #3366ffbd"></date-picker>
    </div>
    <div class="row m-0">
      <div class="col-12 p-0">
        <div @click.stop="isDatePickerShow = !isDatePickerShow" class="calendar__date">
          <div class="calendar__date-date">{{ dateString }}</div>
          <div class="calendar__date-icon">
            <img class="calendar-icon" src="/img/GTM/calendar_icon.svg">
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment'

export default {
  data: function () {
    return {
      isDatePickerShow: false,
      dateRange: new Date(),
    }
  },
  mounted() {
  },
  computed: {
    dateString: function(){
        return moment(this.dateRange).format('DD.MM.YYYY');
    }
  },
  methods: {
    onDateRangeChange() {
      this.isDatePickerShow = false;
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
  .calendar__date{
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #1A1D46;
    border: 0.4px solid #363B68;
    border-radius: 4px;
    width: 224px;
  }
  .calendar__date-date{
      margin: 0 0 0 10px;
  }
  .calendar__date-icon{
    background: #363B68;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6px;
    border-radius: 4px;
  }
</style>