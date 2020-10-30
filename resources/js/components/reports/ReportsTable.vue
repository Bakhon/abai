<template>
  <div>
    <calendar
      is-dark
      color="orange"
      is-expanded
      :first-day-of-week="2"
      locale="ru"
      :max-date="new Date()"
      @dayclick="dayClicked"
    >
    </calendar>

    <div>
      Your date is {{ date }}

      <vue-table-dynamic :params="params"> </vue-table-dynamic>
    </div>
  </div>
</template>

<script>
import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";
import VueTableDynamic from "vue-table-dynamic";

// Register components in your 'main.js'
Vue.component("calendar", Calendar);
Vue.component("date-picker", DatePicker);
export default {
  components: {
    VueTableDynamic,
    Calendar,
    DatePicker,
  },
  data: function () {
    return {
      params: {
        data: [
          ["Cell-1", "Cell-2", "Cell-3"],
          ["Cell-4", "Cell-5", "Cell-6"],
          ["Cell-7", "Cell-8", "Cell-9"],
        ],
      },
      date: null,
      showCalendar: false,
    };
  },
  methods: {
    dayClicked(day) {
      this.date = day.id;
    },
  },
};
</script>
<style>
body {
  color: white !important;
}
</style>
