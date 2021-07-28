import moment from "moment-timezone";
import initialRowsKOA from "../dzoData/initial_rows_koa.json";

export default {
    data: function () {
        return {
            isArchiveActive: false,
            period: moment(),
            datePickerOptions: {
                disabledDate (date) {
                    return moment(date) >= moment().subtract(1, 'days')
                }
            },
        };
    },
    methods: {
        async changeDate() {
            this.$store.commit('globalloading/SET_LOADING', true);
            let queryOptions = {
                'dzoName': this.selectedDzo.ticker,
                'isCorrected': true,
                'date': this.period
            };
            this.todayData = await this.getDzoTodayData(queryOptions);
            this.processTodayData();
            this.$store.commit('globalloading/SET_LOADING', false);
        },
        async sendToApprove() {
            this.handleValidate();
            if (this.isDataReady) {
                let uri = this.localeUrl("/store-corrected-production");
                this.excelData['is_corrected'] = true;
                this.excelData['is_approved'] = false;
                this.excelData['date'] = this.period;
                await this.storeData(uri);
                this.status = this.trans("visualcenter.importForm.status.sendedToApprove");
            }
        },
       async changeCategory() {
            this.isArchiveActive = !this.isArchiveActive;
            if (!this.isArchiveActive) {
                this.isDataExist = false;
                this.isDataReady = false;
                await this.changeDefaultDzo();
                await this.updateCurrentData();
                this.addListeners();
            }
        }
    }
}