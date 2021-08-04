import moment from 'moment';

let dateFormats = {
    'reportFormat': 'YYYY-MM-DD HH:mm:ss',
    'datetimePickerFormat': 'YYYY-MM-DDTHH:mm:ss.SSSSZ',
};

export const formatDate = {
    getStartOfYearFormatted: function(date, formatType='reportFormat') {
        return moment.parseZone(date).startOf('day').startOf('year').format(dateFormats[formatType]);
    },
    getEndOfYearFormatted: function(date, formatType='reportFormat') {
        return moment.parseZone(date).endOf('day').endOf('year').format(dateFormats[formatType]);
    },
    getFirstDayOfMonthFormatted: function (date, formatType='reportFormat') {
        return moment.parseZone(date).startOf('day').startOf('month').format(dateFormats[formatType]);
    },
    getLastDayOfMonthFormatted: function (date, formatType='reportFormat') {
        return moment.parseZone(date).endOf('day').endOf('month').format(dateFormats[formatType]);
    },
    getMinOfDayFormatted: function (date, formatType='reportFormat') {
        return moment.parseZone(date).startOf('day').format(dateFormats[formatType]);
    },
    getMaxOfDayFormatted: function (date, formatType='reportFormat') {
        return moment.parseZone(date).endOf('day').format(dateFormats[formatType]);
    }
}
