import moment from "moment";

export default {
    data: function () {
        return {
            isProductionDetailsActive: true,
            otmDetails: [],
            chemistryDetails: [],
            chemistryPeriodStartMonth: moment().subtract(2, 'months').format('MMMM YYYY'),
            chemistryPeriodEndMonth: moment().subtract(1, 'months').format('MMMM YYYY'),
        };
    },
    methods: {

    },
}