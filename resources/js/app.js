/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueAxios from 'vue-axios';
import axios from 'axios';
import VueTableDynamic from 'vue-table-dynamic';


require('./bootstrap');

window.Vue = require('vue');
window.Jquery = require('jquery');

Vue.use(VueAxios, axios, VueTableDynamic);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Vue.component('doughnut-component', require('./components/DoughnutLevelOneComponent.vue').default);
// Vue.component('pie', require('./components/PieChart.vue').default);
//Vue.component('chartbar', require('./components/ChartBar.vue').default);
Vue.component('charttide', require('./components/ChartTide.vue').default);
Vue.component('visual-center-chart-area-oil', require('./components/VisualCenterChartAreaOil.vue').default);
Vue.component('visual-center-chart-area-usd', require('./components/VisualCenterChartAreaUSD.vue').default);
Vue.component('visual-center-chart-area-center', require('./components/VisualCenterChartAreaCenter.vue').default);
Vue.component('visual-center-chart-bar-bottom', require('./components/VisualCenterChartBarBottom.vue').default);
Vue.component('visual-center-chart-donut-right1', require('./components/VisualCenterChartDonutRight1.vue').default);
Vue.component('visual-center-chart-donut-right2', require('./components/VisualCenterChartDonutRight2.vue').default);
Vue.component('visual-center-table', require('./components/VisualCenterTable.vue').default);
Vue.component('visual-center-menu', require('./components/VisualCenterMenu.vue').default);
Vue.component('welcome-chart-donut-right1', require('./components/WelcomeChartDonutRight1.vue').default);
Vue.component('welcome-chart-donut-right2', require('./components/WelcomeChartDonutRight2.vue').default);
Vue.component('welcome-chart-donut-right3', require('./components/WelcomeChartDonutRight3.vue').default);
Vue.component('welcome-chart-donut-right4', require('./components/WelcomeChartDonutRight4.vue').default);
Vue.component('welcome-chart-bar-bottom1', require('./components/WelcomeChartBarBottom1.vue').default);
Vue.component('welcome-chart-bar-bottom2', require('./components/WelcomeChartBarBottom2.vue').default);
Vue.component('economicpivot', require('./components/Economic/Pivot.vue').default);
Vue.component('economic-component', require('./components/Economic/main.vue').default);
Vue.component('chart1-component', require('./components/Economic/chart1.vue').default);
Vue.component('chart2-component', require('./components/Economic/chart2.vue').default);
Vue.component('chart3-component', require('./components/Economic/chart3.vue').default);
Vue.component('chart4-component', require('./components/Economic/chart4.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
