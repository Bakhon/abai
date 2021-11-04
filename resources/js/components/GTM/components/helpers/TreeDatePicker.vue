<template>
  <div>
    <div class="d-flex gap-10">
      <div class="calendar-filter-block d-flex f-1 text-center">
        <div class="d-flex block-date">
          <datetime
              type="date"
              v-model="treeDate.begin_date"
              class="start-date-gtm"
              value-zone="Asia/Almaty"
              zone="Asia/Almaty"
              :title="trans('bd.choose_start_date')"
              :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
              :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
              :week-start="1"
              :placeholder="[[ trans('bd.dd_mm_yyyy') ]]"
              auto
              :flow="dateFlow"
          ></datetime>
        </div>
        <div>
          <img src="/img/GTM/calendar_icon.svg" alt="">
        </div>
      </div>

      <div class="calendar-filter-block d-flex text-center f-1 ml-5px">
        <div class="d-flex block-date">
          <datetime
              type="date"
              v-model="treeDate.end_date"
              @input="onDateRangeChange"
              class="end-date-gtm"
              value-zone="Asia/Almaty"
              zone="Asia/Almaty"
              :title="trans('bd.choose_end_date')"
              :format="{ year: 'numeric', month: 'numeric', day: 'numeric'}"
              :phrases="{ok: trans('app.choose'), cancel: trans('app.cancel')}"
              :week-start="1"
              :placeholder="[[ trans('bd.dd_mm_yyyy') ]]"
              auto
              :flow="dateFlow"
          >
          </datetime>
        </div>
        <div>
          <img src="/img/GTM/calendar_icon.svg" alt="">
        </div>

      </div>

      <div class="ml-1 calendar-filter-block d-flex" v-if="showSettings" @click="showModal('modalPeriod')">
        <img class="gear-icon-svg" src="/img/GTM/gear.svg" alt="">
      </div>

    </div>

  </div>

</template>
<script>

import {paegtmMapGetters, paegtmMapActions, paegtmMapState} from '@store/helpers';
import moment from "moment"

export default {
  props: {
    showSettings: false,
    showPeriodTitle: false,
  },
  data: function () {
    return {
      isDatePickerShow: false,
      dateFlow: ['year', 'month', 'date'],
    }
  },
  computed: {
    ...paegtmMapState([
      'treeDate'
    ]),
  },
  methods: {
    ...paegtmMapGetters([
      'getTreeDate'
    ]),
    ...paegtmMapActions([
      'changeTreeDate',
    ]),
    onDateRangeChange() {
      this.isDatePickerShow = false;
      this.changeTreeDate(this.treeDate);
    },
  },
}
</script>
<style scoped>
.gap-10 {
  gap: 10px;
}

.mt-7px {
  margin-top: 7px;
}

.modal-bign-wrapper {
  left: 815px;
  top: -340px;
}

.block-date {
  justify-content: space-around;
}

.start-date-gtm .vdatetime-input, .end-date-gtm .vdatetime-input {
  float: left;
}

.f-1 {
  flex: 1;
  justify-content: space-around;
}

.fd {
  flex-direction: column;
}
</style>