import moment from "moment";

export default {
    data: function () {
        return {
            wellsWorkoverSelectedCompany: 'all',
        };
    },
    methods: {
        isRecordsSimple(inputDateOption,planItem,inputDzoName) {
            return inputDateOption[0] === moment(planItem.date).month() &&
                inputDateOption[1] === moment(planItem.date).year() &&
                planItem.dzo === inputDzoName;
        },
    }
}