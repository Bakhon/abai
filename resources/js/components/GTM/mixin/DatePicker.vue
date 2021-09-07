<template>
  <div>
    <template>
      <div style="display: flex; justify-content: space-evenly;"
           class="calendar-filter-block d-flex* text-center align-items-center cursor-pointer">
        <div>
          от
        </div>
        <div>
          <datetime
              type="date"
              v-model="dateStartGtm"
              class="start-date-gtm"
              value-zone="Asia/Almaty"
              zone="Asia/Almaty"
              :title="trans('bd.choose_start_date')"
              :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
              :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
              :max-datetime="dateEndGtm"
              :week-start="1"
              :placeholder="[[ trans('bd.dd_mm_yyyy') ]]"
              auto
              :flow="dateFlow"
          >
          </datetime>
        </div>
        <div>
          до
        </div>
        <div>
          <datetime
              type="date"
              v-model="dateEndGtm"
              @input="onDateRangeChange"
              class="end-date-gtm"
              value-zone="Asia/Almaty"
              zone="Asia/Almaty"
              :title="trans('bd.choose_end_date')"
              :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
              :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
              :min-datetime="dateStartGtm"
              :week-start="1"
              :placeholder="[[ trans('bd.dd_mm_yyyy') ]]"
              auto
              :flow="dateFlow"
          >
          </datetime>
        </div>


      </div>

    </template>
  </div>

</template>
<script>

import { paegtmMapActions,  paegtmMapState } from '@store/helpers';

export default {
    props: {
        showSettings: true,
        showPeriodTitle: false,
    },
    data: function () {
        return {
            isDatePickerShow: false,
            dateFlow: ['year', 'month', 'date'],
            dateStartGtm: '2020-01-01',
            dateEndGtm: '2021-12-01',
        }
    },
    computed: {
        ...paegtmMapState([
          'dateStart',
          'dateEnd'
        ]),
      ...paegtmMapState([
        'getDateStart',
        'getDateEnd'
      ]),
    },
    methods: {
        ...paegtmMapActions([
            'changeDateStart',
            'changeDateEnd',
        ]),
        onDateRangeChange() {
            // this.dateStart = this.dateStartGtm
            // this.dateEnd = this.dateEndGtm
            this.isDatePickerShow = false;
            this.changeDateStart(this.dateStartGtm);
            this.changeDateEnd(this.dateEndGtm);
            this.$emit('dateChanged')
        }
    },
}
</script>