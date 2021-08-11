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
            changeReason: '',
            userName: '',
            isUserNameCompleted: false,
            isChangeReasonCompleted: false,
        };
    },
    methods: {
        async changeDate() {
            this.SET_LOADING(true);
            let queryOptions = {
                'dzoName': this.selectedDzo.ticker,
                'isCorrected': true,
                'date': this.period
            };
            this.todayData = await this.getDzoTodayData(queryOptions);
            this.processTodayData();
            this.SET_LOADING(false);
        },
        async sendToApprove() {
            this.handleValidate();
            if (this.isDataReady) {
                let uri = this.localeUrl("/store-corrected-production");
                this.excelData['is_corrected'] = true;
                this.excelData['is_approved'] = false;
                this.excelData['date'] = moment(this.period).format("YYYY-MM-DD HH:mm:ss");
                this.excelData['user_name'] = this.userName;
                this.excelData['change_reason'] = this.changeReason;
                await this.storeData(uri);
                this.status = this.trans("visualcenter.importForm.status.sendedToApprove") + '!';
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
    },
    computed: {
        nameState() {
            this.isUserNameCompleted = this.userName.length > 3;
            return this.isUserNameCompleted;
        },
        changeReasonState() {
            this.isChangeReasonCompleted = this.changeReason.length > 3;
            return this.isChangeReasonCompleted;
        },
    }
}