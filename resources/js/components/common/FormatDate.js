import moment from 'moment';

let dateFormats = {
    'reportFormat': 'YYYY-MM-DD HH:mm:ss',
    'datetimePickerFormat': 'YYYY-MM-DDTHH:mm:ss.SSSSZ',
};
let minOfDay = {hour: 0, minute: 0, second: 0};
let maxOfDay = {hour: 23, minute: 59, second: 59};

export const formatDate = {
    getStartOfYearFormatted: function(date, formatType='reportFormat') {
        return moment.parseZone(date).set(minOfDay).startOf('year').format(dateFormats[formatType]);
    },
    getEndOfYearFormatted: function(date, formatType='reportFormat') {
        return moment.parseZone(date).set(maxOfDay).endOf('year').format(dateFormats[formatType]);
    },
    getFirstDayOfMonthFormatted: function (date, formatType='reportFormat') {
        return moment.parseZone(date).set(minOfDay).set('date', 1).format(dateFormats[formatType]);
    },
    getLastDayOfMonthFormatted: function (date, formatType='reportFormat') {
        return moment.parseZone(date).set(maxOfDay).endOf('month').format(dateFormats[formatType]);
    },
    getMinOfDayFormatted: function (date, formatType='reportFormat') {
        return moment.parseZone(date).set(minOfDay).format(dateFormats[formatType]);
    },
    getMaxOfDayFormatted: function (date, formatType='reportFormat') {
        return moment.parseZone(date).set(maxOfDay).format(dateFormats[formatType]);
    }
}
