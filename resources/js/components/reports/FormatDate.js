import moment from 'moment';

let dateFormat = 'YYYY-MM-DD HH:mm:ss';
let minOfDay = {hour: 0, minute: 0, second: 0};
let maxOfDay = {hour: 23, minute: 59, second: 59};

export const formatDate = {
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
