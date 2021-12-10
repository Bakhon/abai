<template>
    <div class="gtm-indicator-item flex-fill d-inline-block p-2">
        <div class="bigNumber">{{ successfulGtmsCount }}</div>
        <div class="title">{{ trans('paegtm.successful_events_count') }}</div>
        <div class="progress gtm-progress mb-0">
            <div
                class="progress-bar"
                role="progressbar"
                :style="{width: successfulGtmsPercent + '%'}"
            >
            </div>
        </div>
        <div class="d-flex justify-content-between m-0 mt-1">
            <div class="d-inline-block m-0 text-white dr-fw-700">{{ successfulGtmsPercent }}%</div>
            <div class="progressMax d-inline-block m-0">{{ totalGtmsCount }}</div>
        </div>
    </div>
</template>
<script>

import {paegtmMapState, globalloadingMutations} from '@store/helpers';

export default {
    data: function () {
        return {
            totalGtmsCount: 0,
            successfulGtmsCount: 0,
            unsuccessfulGtmsCount: 0,
            successfulGtmsPercent: 0,
        }
    },
    computed: {
        ...paegtmMapState([
            'dateStart',
            'dateEnd',
            'dzoName',
            'selectedGtm'
        ]),
    },
    methods: {
        ...globalloadingMutations([
            'SET_LOADING'
        ]),
        getGtmFactorsAnalysisCount() {
            this.SET_LOADING(true);

            this.axios.get(
                this.localeUrl('/paegtm/aegtm/get-gtms-factor-analysis-count'),
                {params: {dzoName: this.dzoName, dateStart: this.dateStart, dateEnd: this.dateEnd, selectedGtm: this.selectedGtm}}
            ).then((response) => {
                let data = response.data;
                if (data) {
                    this.totalGtmsCount = data.total_gtms_count
                    this.successfulGtmsCount = data.successful_gtms_count
                    this.unsuccessfulGtmsCount = data.unsuccessful_gtms_count
                    this.successfulGtmsPercent = data.successful_gtms_percent
                }
            }).catch(err => {
                this.setNotify(this.trans('paegtm.empty_responce'), this.trans('app.error'), "danger")
            }).finally(() => this.SET_LOADING(false));
        },
        onFilterChanged() {
            this.getGtmFactorsAnalysisCount();
        }
    },
    mounted() {
        this.getGtmFactorsAnalysisCount();
    },
}
</script>