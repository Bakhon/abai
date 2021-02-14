import moment from 'moment';

let dateFormat = 'YYYY-MM-DD HH:mm:ss';
let minOfDay = {hour: 0, minute: 0, second: 0};
let maxOfDay = {hour: 23, minute: 59, second: 59};

export const formatDate = {
    format_to_first_day_of_month: function (date) {
        return moment(date).set(minOfDay).set('date', 1).format(dateFormat);
    },
    format_to_min_of_day: function (date) {
        return moment(date).set(minOfDay).format(dateFormat);
    },
    format_to_max_of_day: function (date) {
        return moment(date).set(maxOfDay).format(dateFormat);
    }
}
