<template>
  <div>
    <div class="d-flex">
      <div class="calendar-filter-block d-flex f-1 text-center">
        <div class="d-flex block-date">
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
        <div>
          <img src="/img/GTM/calendar_icon.svg" alt="">
        </div>

      </div>

      <div class="ml-1 calendar-filter-block d-flex" v-if="showSettings" @click="showModal('modalPeriod')">
        <img class="gear-icon-svg" src="/img/GTM/gear.svg" alt="">
      </div>

      <modal class="modal-bign-wrapper" name="modalPeriod" draggable=".modal-bign-header" :width="250"
             :height="230"
             style="background: transparent;" :adaptive="true">
        <div class="modal-bign modal-bign-container">
          <div class="modal-bign-header">
            <div class="modal-bign-title">{{ trans('paegtm.period') }}</div>
            <button type="button" class="modal-bign-button" @click="closeModal('modalPeriod')">
              {{ trans('pgno.zakrit') }}
            </button>
          </div>
          <div class="d-flex jc">
            <div class="d-flex fd">
              <div>
                {{ trans('paegtm.day') }}
              </div>
              <div>
                {{ trans('paegtm.month') }}
              </div>
              <div>
                {{ trans('paegtm.year') }}
              </div>
            </div>
            <div class="d-flex fd">
              <div>
                <input class="period-settings-input" type="text">
              </div>
              <div>
                <input class="period-settings-input" type="text">
              </div>
              <div>
                <input class="period-settings-input" type="text">
              </div>
            </div>
          </div>
          <div class="block-header p-2 text-center calc-button mt-4" @click="closeModal('modalPeriod')">
            {{ trans("paegtm.calc") }}
          </div>
        </div>
      </modal>
    </div>

  </div>

</template>
<script>

import {paegtmMapGetters, paegtmMapActions, paegtmMapState} from '@store/helpers';

export default {
  props: {
    showSettings: false,
    showPeriodTitle: false,
  },
  data: function () {
    return {
      isDatePickerShow: false,
      dateFlow: ['year', 'month', 'date'],
      dateStartGtm: this.getDateStart(),
      dateEndGtm: this.getDateEnd(),
    }
  },
  computed: {
    ...paegtmMapState([
      'dateStart',
      'dateEnd',
    ]),
  },
  methods: {
    ...paegtmMapGetters([
      'getDateStart',
      'getDateEnd'
    ]),
    ...paegtmMapActions([
      'changeDateStart',
      'changeDateEnd',
    ]),
    onDateRangeChange() {
      this.isDatePickerShow = false;
      this.changeDateStart(this.dateStartGtm);
      this.changeDateEnd(this.dateEndGtm);
      this.$emit('dateChanged')
    },
    showModal(modalName) {
      this.$modal.show(modalName);
    },
    closeModal(modalName) {
      this.$modal.hide(modalName)
    },
  },
}
</script>
<style scoped>
.gear-icon-svg:hover {
  content: "";
  opacity: 100;
  -webkit-animation: gear-icon-svg 3s infinite both;
  animation: gear-icon-svg 3s infinite both;
}

@-webkit-keyframes gear-icon-svg {
  0% {
    -webkit-transform: scale(1) rotateZ(0);
    transform: scale(1) rotateZ(0);
  }
  50% {
    -webkit-transform: scale(1) rotateZ(180deg);
    transform: scale(1) rotateZ(180deg);
  }
  100% {
    -webkit-transform: scale(1) rotateZ(360deg);
    transform: scale(1) rotateZ(360deg);
  }
}

@keyframes gear-icon-svg {
  0% {
    -webkit-transform: scale(1) rotateZ(0);
    transform: scale(1) rotateZ(0);
  }
  50% {
    -webkit-transform: scale(1) rotateZ(180deg);
    transform: scale(1) rotateZ(180deg);
  }
  100% {
    -webkit-transform: scale(1) rotateZ(360deg);
    transform: scale(1) rotateZ(360deg);
  }
}

.period-settings-input {
  background: #494AA5;
  border: 1px solid #272953;
  outline: none;
  max-width: 30px;
  height: 22px;
  color: white;
  box-sizing: border-box;
  border-radius: 3px;
  line-height: 25px !important;
  padding-right: 5px;
  padding-left: 5px;
}

.period-settings-input:focus {
  background: #5657c7;
}

.period-settings-input:disabled {
  color: #928f8f;
  background: #353e70;
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