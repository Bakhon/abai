import Vue from "vue";
import _ from 'lodash';

const axiosMock = () => {
    return {
        get: () => new Promise((resolve, reject) => {}),
        post: () => new Promise((resolve, reject) => {})
    }
}

Vue.prototype.trans = string => _.get(window.i18n, string) || string;
Object.defineProperty(window, 'axios', {value: axiosMock()});