/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueAxios from 'vue-axios';
import axios from 'axios';
import VueTableDynamic from 'vue-table-dynamic';
import Vue from 'vue';
import 'bootstrap-table/dist/bootstrap-table.js';
import 'bootstrap-table/dist/locale/bootstrap-table-ru-RU.js'
import 'bootstrap-table/dist/extensions/export/bootstrap-table-export.js';
import VueMomentLib from 'vue-moment-lib';
import moment from 'moment';
import 'bootstrap-table/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.js';
import 'bootstrap-select/dist/js/bootstrap-select.min.js';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import store from './store';
import PerfectScrollbar from "vue2-perfect-scrollbar";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";
import columnSortable from 'vue-column-sortable'


require('./bootstrap');
window.Vue = require('vue');
window.Jquery = require('jquery');
moment.locale('ru');
Vue.prototype.$moment = moment

Vue.use(VueAxios, axios, VueTableDynamic, VueMomentLib, ElementUI, PerfectScrollbar, columnSortable);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('edit-history', require('./components/common/EditHistory.vue').default);
Vue.component('visual-center-chart-area-oil', require('./components/visualcenter/VisualCenterChartAreaOil.vue').default);
Vue.component('visual-center-chart-area-usd', require('./components/visualcenter/VisualCenterChartAreaUSD.vue').default);
Vue.component('visual-center-chart-area-center', require('./components/visualcenter/VisualCenterChartAreaCenter.vue').default);
Vue.component('visual-center-chart-bar-bottom', require('./components/visualcenter/VisualCenterChartBarBottom.vue').default);
Vue.component('visual-center-chart-donut-right1', require('./components/visualcenter/VisualCenterChartDonutRight1.vue').default);
Vue.component('visual-center-chart-donut-right2', require('./components/visualcenter/VisualCenterChartDonutRight2.vue').default);
Vue.component('visual-center3-wells', require('./components/visualcenter3/Vc3Wells.vue').default);
Vue.component('visual-center-table', require('./components/visualcenter/VisualCenterTable.vue').default);
Vue.component('visual-center-table3', require('./components/visualcenter3/VisualCenterTable3.vue').default);
Vue.component('visual-center-table4', require('./components/visualcenter3/VisualCenterTable4.vue').default);
Vue.component('visual-center-table5', require('./components/visualcenter3/VisualCenterTable5.vue').default);
Vue.component('visual-center-table6', require('./components/visualcenter3/VisualCenterTable6.vue').default);
Vue.component('visual-center-table7', require('./components/visualcenter3/VisualCenterTable7.vue').default);
Vue.component('visual-center-chart-area-oil3', require('./components/visualcenter3/VisualCenterChartAreaOil.vue').default);
Vue.component('visual-center-chart-area-usd3', require('./components/visualcenter3/VisualCenterChartAreaUSD.vue').default);
Vue.component('visual-center-usd-table', require('./components/visualcenter3/VisualCenterUsdTable.vue').default);
Vue.component('visual-center-speedometer', require('./components/visualcenter3/VCSpeedometer.vue').default);
Vue.component('vc-chart', require('./components/visualcenter3/VcChart.vue').default);
Vue.component('indicator', require('./components/visualcenter3/Indicator.vue').default);
Vue.component('wide-indicator', require('./components/visualcenter3/WideIndicator.vue').default);
Vue.component('simple-indicator', require('./components/visualcenter3/SimpleIndicator.vue').default);
Vue.component('vc-speedometer-block', require('./components/visualcenter3/VCSpeedometerBlock.vue').default);
Vue.component('horizontal-indicators', require('./components/visualcenter3/HorizontalIndicators.vue').default);
Vue.component('vertical-indicators', require('./components/visualcenter3/VerticalIndicators.vue').default);
Vue.component('vc-upstream-table', require('./components/visualcenter3/UpstreamTable.vue').default);
Vue.component('visual-center-menu', require('./components/visualcenter/VisualCenterMenu.vue').default);
Vue.component('economic-component', require('./components/Economic/main.vue').default);
Vue.component('chart1-component', require('./components/Economic/chart1.vue').default);
Vue.component('chart2-component', require('./components/Economic/chart2.vue').default);
Vue.component('chart3-component', require('./components/Economic/chart3.vue').default);
Vue.component('chart4-component', require('./components/Economic/chart4.vue').default);
Vue.component('gno-table', require('./components/gno/Table.vue').default);
Vue.component('gno-incl-table', require('./components/gno/GnoInclTable.vue').default);
Vue.component('gno-wells-repairs', require('./components/gno/GnoWellsRepairs.vue').default);
Vue.component('gno-line-points-chart', require('./components/gno/GnoCurveTable.vue').default);
Vue.component('gno-chart-bar', require('./components/gno/GnoChartBar.vue').default);
Vue.component('monitor-table', require('./components/monitor/MonitorTable.vue').default);
Vue.component('monitor-chart', require('./components/monitor/chart.vue').default);
Vue.component('monitor-chart-radialbar', require('./components/monitor/MonitorChartRadialBar.vue').default);
Vue.component('wm-form', require('./components/wm/form.vue').default);
Vue.component('omgca-form', require('./components/omgca/form.vue').default);
Vue.component('omguhe-form', require('./components/omguhe/form.vue').default);
Vue.component('omgngdu-form', require('./components/omgngdu/form.vue').default);
Vue.component('gu-form', require('./components/gu/form.vue').default);
Vue.component('zu-form', require('./components/zu/form.vue').default);

Vue.component('reports-table2', require('./components/reportsGTM/ReportsGTMTable.vue').default);
Vue.component('reports-table3', require('./components/reportDob/RepDobTable.vue').default);
Vue.component('monthly-production', require('./components/reports/MonthlyProduction.vue').default);
Vue.component('daily-production', require('./components/reports/DailyProduction.vue').default);
Vue.component('daily-injection', require('./components/reports/DailyInjection.vue').default);
Vue.component('monthly-injection', require('./components/reports/MonthlyInjection.vue').default);
Vue.component('analyze-gtm', require('./components/reports/AnalyzeGtm.vue').default);
Vue.component('dynamics-indicators', require('./components/reports/DynamicsIndicators.vue').default);
Vue.component('well-fund', require('./components/reports/WellFund.vue').default);
Vue.component('well-fund-block', require('./components/reports/WellFundBlock.vue').default);
Vue.component('well-fund-field', require('./components/reports/WellFundField.vue').default);
Vue.component('well-fund-inactive', require('./components/reports/WellFundInactive.vue').default);
Vue.component('well-fund-revision', require('./components/reports/WellFundRevision.vue').default);
Vue.component('view-table', require('./components/omgca/table.vue').default);
Vue.component('oilgas-form', require('./components/сomplicationMonitoring/oilGas/form.vue').default);
Vue.component('pipe-form', require('./components/pipes/form.vue').default);
Vue.component('inhibitor-create', require('./components/inhibitor/create.vue').default);
Vue.component('inhibitor-edit', require('./components/inhibitor/edit.vue').default);
Vue.component('corrosion-form', require('./components/сomplicationMonitoring/corrosion/form.vue').default);
Vue.component('gu-map', require('./components/map.vue').default);
Vue.component('field-settings', require('./components/settings/fields.vue').default);

Vue.component('fa-table', require('./components/tr/fa.vue').default);
Vue.component('tr-table', require('./components/tr/tr.vue').default);
Vue.component('trfa-table', require('./components/tr/trfa.vue').default);
Vue.component('tr-charts-table', require('./components/tr/tr_charts.vue').default);
Vue.component('tr-sidebar-charts', require('./components/tr/TrSidebarCharts.vue').default);
Vue.component('tr-sidebar-export', require('./components/tr/TrSidebarExport.vue').default);
Vue.component('cat-loader', require('./components/ui-kit/CatLoader.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('report-export', require('./components/reports/export.vue').default);



Vue.component('viscenter2-create', require('./components/viscenter2/create.vue').default);

Vue.component('big-data', require('./components/bigdata/BigData.vue').default);
Vue.component('search-form', require('./components/ui-kit/SearchForm.vue').default);
Vue.component('bigdata-report-button', require('./components/bigdata/BigDataReportButton.vue').default);
Vue.component('full-page-loader', require('./components/ui-kit/FullPageLoader.vue').default);

Vue.component('main-page', require('./components/mainpage.vue').default);


Vue.prototype.trans = string => _.get(window.i18n, string) || string;
Vue.prototype.localeUrl = string => `/${window.current_lang}/${string[0] === '/' ? string.substr(1) : string}`;
Vue.prototype.currentLang = window.current_lang;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store,
    el: '#app',
});
