/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueAxios from 'vue-axios';
import axios from 'axios';
import VueTableDynamic from 'vue-table-dynamic';
import { PivotViewPlugin, FieldList } from '@syncfusion/ej2-vue-pivotview';



require('./bootstrap');

window.Vue = require('vue');
window.Jquery = require('jquery');

Vue.use(VueAxios, axios, VueTableDynamic, PivotViewPlugin);


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
Vue.component('visual-center-chart-area-oil', require('./components/visualcenter/VisualCenterChartAreaOil.vue').default);
Vue.component('visual-center-chart-area-usd', require('./components/visualcenter/VisualCenterChartAreaUSD.vue').default);
Vue.component('visual-center-chart-area-center', require('./components/visualcenter/VisualCenterChartAreaCenter.vue').default);
Vue.component('visual-center-chart-bar-bottom', require('./components/visualcenter/VisualCenterChartBarBottom.vue').default);
Vue.component('visual-center-chart-donut-right1', require('./components/visualcenter/VisualCenterChartDonutRight1.vue').default);
Vue.component('visual-center-chart-donut-right2', require('./components/visualcenter/VisualCenterChartDonutRight2.vue').default);
Vue.component('visual-center-table', require('./components/visualcenter/VisualCenterTable.vue').default);
Vue.component('visual-center-menu', require('./components/visualcenter/VisualCenterMenu.vue').default);
Vue.component('welcome-chart-donut-right1', require('./components/welcome/WelcomeChartDonutRight1.vue').default);
Vue.component('welcome-chart-donut-right2', require('./components/welcome/WelcomeChartDonutRight2.vue').default);
Vue.component('welcome-chart-donut-right3', require('./components/welcome/WelcomeChartDonutRight3.vue').default);
Vue.component('welcome-chart-donut-right4', require('./components/welcome/WelcomeChartDonutRight4.vue').default);
Vue.component('welcome-chart-bar-bottom1', require('./components/welcome/WelcomeChartBarBottom1.vue').default);
Vue.component('welcome-chart-bar-bottom2', require('./components/welcome/WelcomeChartBarBottom2.vue').default);
Vue.component('welcome-page', require('./components/welcome/WelcomePage.vue').default);
Vue.component('economic-pivot', require('./components/Economic/Pivot.vue').default);
Vue.component('economic-component', require('./components/Economic/main.vue').default);
Vue.component('chart1-component', require('./components/Economic/chart1.vue').default);
Vue.component('chart2-component', require('./components/Economic/chart2.vue').default);
Vue.component('chart3-component', require('./components/Economic/chart3.vue').default);
Vue.component('chart4-component', require('./components/Economic/chart4.vue').default);
Vue.component('wm-create', require('./components/wm/create.vue').default);
Vue.component('wm-edit', require('./components/wm/edit.vue').default);
Vue.component('gno-table', require('./components/gno/Table.vue').default);
Vue.component('gno-line-points-chart', require('./components/gno/LinePointsChart.vue').default);
Vue.component('syncfusion-pivot', require('./components/pivot.vue').default);
Vue.component('monitor-table', require('./components/monitor/MonitorTable.vue').default);
Vue.component('monitor-chart-bar', require('./components/monitor/MonitorChartBar.vue').default);
Vue.component('monitor-chart-bar-rounded', require('./components/monitor/MonitorChartBarRounded.vue').default);
Vue.component('monitor-chart-donut', require('./components/monitor/MonitorChartDonut.vue').default);
Vue.component('monitor-chart-tide', require('./components/monitor/MonitorChartTide.vue').default);
Vue.component('monitor-chart-radialbar', require('./components/monitor/MonitorChartRadialBar.vue').default);
Vue.component('omgca-create', require('./components/omgca/create.vue').default);
Vue.component('omgca-edit', require('./components/omgca/edit.vue').default);
Vue.component('omguhe-create', require('./components/omguhe/create.vue').default);
Vue.component('omguhe-edit', require('./components/omguhe/edit.vue').default);
Vue.component('omgngdu-create', require('./components/omgngdu/create.vue').default);
Vue.component('omgngdu-edit', require('./components/omgngdu/edit.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
