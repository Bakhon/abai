import moment from 'moment';

let dateFormat = 'YYYY-MM-DD HH:mm:ss';
let defaultFormat = "YYYY-MM-DDTHH:mm:ss.SSSSZ";
let minOfDay = {hour: 0, minute: 0, second: 0};
let maxOfDay = {hour: 23, minute: 59, second: 59};

export const formatDate = {
    getStartOfYear: function(date) {
        return moment.parseZone(date).set(minOfDay).startOf('year').format(defaultFormat);
    },
    getEndOfYear: function(date) {
        return moment.parseZone(date).set(maxOfDay).endOf('year').format(defaultFormat);
    },
    getFirstDayOfMonth: function (date) {
        return moment.parseZone(date).set(minOfDay).set('date', 1).format(defaultFormat);
    },
    getLastDayOfMonth: function (date) {
        return moment.parseZone(date).set(maxOfDay).endOf('month').format(defaultFormat);
    },
    getFirstDayOfMonthFormatted: function (date) {
        return moment.parseZone(date).set(minOfDay).set('date', 1).format(dateFormat);
    },
    getLastDayOfMonthFormatted: function (date) {
        return moment.parseZone(date).set(minOfDay).endOf('month').format(dateFormat);
    },
    getMinOfDayFormatted: function (date) {
        return moment.parseZone(date).set(minOfDay).format(dateFormat);
    },
    getMaxOfDayFormatted: function (date) {
        return moment.parseZone(date).set(maxOfDay).format(dateFormat);
    }
}
