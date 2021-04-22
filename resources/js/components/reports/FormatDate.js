import moment from 'moment';

let dateFormat = 'YYYY-MM-DD HH:mm:ss';
let minOfDay = {hour: 0, minute: 0, second: 0};
let maxOfDay = {hour: 23, minute: 59, second: 59};

export const formatDate = {
    formatToFirstDayOfMonth: function (date) {
        return moment.parseZone(date).set(minOfDay).set('date', 1).format(dateFormat);
    },
    formatToLastDayOfMonth: function (date) {
        return moment.parseZone(date).set(minOfDay).endOf('month').format(dateFormat);
    },
    formatToMinOfDay: function (date) {
        return moment.parseZone(date).set(minOfDay).format(dateFormat);
    },
    formatToMaxOfDay: function (date) {
        return moment.parseZone(date).set(maxOfDay).format(dateFormat);
    }
}
