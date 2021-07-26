import moment from "moment-timezone";

export default {
    data: function () {
        return {
            isArchiveActive: false,
            period: moment().subtract(1,'days'),
            datePickerOptions: {
                disabledDate (date) {
                    return moment(date) >= moment().subtract(1, 'days')
                }
            },
        };
    },
    methods: {
        changeDate() {
            console.log('new date')
            console.log(this.period)
        },
        sendToApprove() {

        }
    }
}