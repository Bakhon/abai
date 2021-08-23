import Vue from 'vue'
import moment from 'moment'

Vue.filter( 'dateFormat', function (value) {
        return moment(value).format('MM/YY')
});
