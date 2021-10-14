import moment from "moment-timezone";
import initialRowsKOA from "../dzoData/initial_rows_koa.json";

export default {
    data: function () {
        return {
            isArchiveActive: false,
            period: moment().subtract(1,'days').format("YYYY-MM-DD HH:mm:ss"),
            datePickerOptions: {
                disabledDate (date) {
                    return moment(date) >= moment().startOf('day');
                }
            },
            changeReason: '',
            userName: '',
            userPosition: '',
            isUserNameCompleted: false,
            isChangeReasonCompleted: false,
            isUserPositionCompleted: false,
            isDataSended: false
        };
    },
    methods: {
        async changeDate() {
            this.isDataSended = false;
            this.handleSwitchFilter();
        },
        async sendToApprove() {
            this.handleValidate();
            if (this.isDataReady) {
                this.isDataSended = true;
                let uri = this.localeUrl("/store-corrected-production");
                this.excelData['is_corrected'] = true;
                this.excelData['is_approved'] = false;
                this.excelData['date'] = moment(this.period).format("YYYY-MM-DD HH:mm:ss");
                this.excelData['user_name'] = this.userName;
                this.excelData['user_position'] = this.userPosition;
                this.excelData['change_reason'] = this.changeReason;
                this.excelData['toList'] = ['firstMaster','secondMaster','mainMaster'];
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
        },
        async switchCompany(e) {
            this.SET_LOADING(true);
            this.selectedDzo.ticker = e.target.value;
            if (this.selectedDzo.ticker === 'КОА') {
                this.addColumnsToGrid();
            }
            this.selectedDzo.name = this.getDzoName();
            this.changeDefaultDzo();
            this.handleSwitchFilter();
            this.addListeners();
            this.SET_LOADING(false);
        },
        async handleSwitchFilter() {
            let self = this;
            this.SET_LOADING(true);
            _.forEach(Object.keys(this.todayDataOptions), async function(key) {
                let uri = self.todayDataOptions[key]['url'] + '?dzoName=' + self.selectedDzo.ticker;
                let inputData = await self.getCurrentData(uri);
                if (Object.keys(inputData).length > 0) {
                    let dataset = self[self.todayDataOptions[key]['name']];
                    self.processCurrentData(inputData,dataset);
                }
            });
            let queryOptions = {
                'dzoName': this.selectedDzo.ticker,
                'isCorrected': true,
                'date': this.period
            };
            this.todayData = await this.getDzoTodayData(queryOptions);
            this.processTodayData();
            this.SET_LOADING(false);
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
        userPositionState() {
            this.isUserPositionCompleted = this.userPosition.length > 1;
            return this.isUserPositionCompleted;
        },
    }
}