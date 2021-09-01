<script src="../../../store/helpers.js"></script>
<template>
    <div>
        <div class="position-absolute r-100">
            <date-picker v-if="isDatePickerShow" v-model="dateRange" is-range @input="onDateRangeChange"></date-picker>
        </div>
        <div class="row m-0">
            <div v-bind:class="[showSettings ? 'col-10' : 'col-12']" class="p-0">
                <div @click.stop="isDatePickerShow = !isDatePickerShow" class="calendar-filter-block d-flex* text-center align-items-center cursor-pointer">
                    <span v-if="showPeriodTitle">{{ this.trans('paegtm.period')}}</span> {{ dateStartString }} - {{ dateEndString }}
                    <img class="calendar-icon" src="/img/GTM/calendar_icon.svg">
                </div>
            </div>
            <div class="col-1 p-0" v-if="showSettings">
                <div class="ml-1 calendar-filter-block d-flex align-items-center">
                    <img class="gear-icon m-auto" src="/img/GTM/gear.svg">
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import { paegtmMapActions } from '@store/helpers';
import { paegtmMapState } from "../../../store/helpers";

export default {
    props: {
        showSettings: true,
        showPeriodTitle: false,
    },
    data: function () {
        return {
            isDatePickerShow: false,
            dateRange: {
                start: this.dateStart,
                end: this.dateEnd,
            },
        }
    },
    computed: {
        ...paegtmMapState([
          'dateStart',
          'dateEnd'
        ]),
        dateStartString: function () {
            if (this.dateRange.start) {
                return this.dateRange.start.toLocaleDateString();
            }
        },
        dateEndString: function () {
            if (this.dateRange.end) {
                return this.dateRange.end.toLocaleDateString();
            }
        }
    },
    methods: {
        ...paegtmMapActions([
            'changeDateStart',
            'changeDateEnd',
        ]),
        onDateRangeChange() {
            this.isDatePickerShow = false;
            this.changeDateStart(this.dateRange.start);
            this.changeDateEnd(this.dateRange.end);
            this.$emit('dateChanged')
        }
    },
}
</script>