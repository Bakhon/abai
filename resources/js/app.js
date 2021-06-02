/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue';
import VueAxios from 'vue-axios';
import axios from 'axios';
import VueTableDynamic from 'vue-table-dynamic';

import BootstrapVue from 'bootstrap-vue';

import 'bootstrap-table/dist/bootstrap-table.js';
import 'bootstrap-table/dist/locale/bootstrap-table-ru-RU.js'
import 'bootstrap-table/dist/extensions/export/bootstrap-table-export.js';
import 'bootstrap-table/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.js';
import 'bootstrap-select/dist/js/bootstrap-select.min.js';

import VueMomentLib from 'vue-moment-lib';
import moment from 'moment';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import store from './store';
import VueSimpleAlert from "vue-simple-alert";
import PerfectScrollbar from "vue2-perfect-scrollbar";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";
import columnSortable from 'vue-column-sortable';
import Paginate from 'vuejs-paginate';
import {Datetime} from 'vue-datetime';
import 'vue-select/dist/vue-select.css'

import Calendar from "v-calendar/lib/components/calendar.umd";
import DatePicker from "v-calendar/lib/components/date-picker.umd";

require('./bootstrap');
window.Vue = require('vue');
window.Jquery = require('jquery');
moment.locale('ru');
Vue.prototype.$moment = moment

Vue.use(VueAxios, axios)
Vue.use(VueTableDynamic);
Vue.use(VueMomentLib);
Vue.use(ElementUI);
Vue.use(PerfectScrollbar);
Vue.use(columnSortable);
Vue.use(VueSimpleAlert);
Vue.use(BootstrapVue);
Vue.use(Datetime);

//TODO: need replace with b-modal from bootstrap
import VModal from 'vue-js-modal'
Vue.use(VModal, {dynamicDefault: {draggable: true, resizable: true},  componentName: 'modal'});

//TODO: need replace with showToast
import NotifyPlugin from "vue-easy-notify";
Vue.use(NotifyPlugin);
Vue.component(NotifyPlugin);

Vue.component('datetime', Datetime);
Vue.component('paginate', Paginate);
Vue.component("calendar", Calendar);
Vue.component("date-picker", DatePicker);

//Mixins
import showToast from '~/mixins/showToast';
Vue.mixin(showToast);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */


Vue.component('edit-history', () => import(/* webpackChunkName : "edit-history" */ './components/common/EditHistory.vue'));

Vue.component('visual-center-chart-area-oil', () => import(/* webpackChunkName : "visual-center-chart-area-oil" */ './components/visualcenter/VisualCenterChartAreaOil.vue'));
Vue.component('visual-center-chart-area-usd', () => import(/* webpackChunkName : "visual-center-chart-area-usd" */ './components/visualcenter/VisualCenterChartAreaUSD.vue'));
Vue.component('visual-center-chart-area-center', () => import(/* webpackChunkName : "visual-center-chart-area-center" */ './components/visualcenter/VisualCenterChartAreaCenter.vue'));
Vue.component('visual-center-chart-bar-bottom', () => import(/* webpackChunkName : 'visual-center-chart-bar-bottom' */  './components/visualcenter/VisualCenterChartBarBottom.vue'));
Vue.component('visual-center-chart-donut-right1', () => import(/* webpackChunkName : 'visual-center-chart-donut-right1' */  './components/visualcenter/VisualCenterChartDonutRight1.vue'));
Vue.component('visual-center-chart-donut-right2', () => import(/* webpackChunkName : 'visual-center-chart-donut-right2' */  './components/visualcenter/VisualCenterChartDonutRight2.vue'));
Vue.component('visual-center3-wells', () => import(/* webpackChunkName : 'visual-center3-wells' */  './components/visualcenter3/Vc3Wells.vue'));
Vue.component('visual-center-table', () => import(/* webpackChunkName : 'visual-center-table' */  './components/visualcenter/VisualCenterTable.vue'));
Vue.component('visual-center-table3', () => import(/* webpackChunkName : 'visual-center-table3' */  './components/visualcenter3/VisualCenterTable3.vue'));
Vue.component('visual-center-table4', () => import(/* webpackChunkName : 'visual-center-table4' */  './components/visualcenter3/VisualCenterTable4.vue'));
Vue.component('visual-center-table5', () => import(/* webpackChunkName : 'visual-center-table5' */  './components/visualcenter3/VisualCenterTable5.vue'));
Vue.component('visual-center-table6', () => import(/* webpackChunkName : 'visual-center-table6' */  './components/visualcenter3/VisualCenterTable6.vue'));
Vue.component('visual-center-table7', () => import(/* webpackChunkName : 'visual-center-table7' */  './components/visualcenter3/VisualCenterTable7.vue'));
Vue.component('visual-center-chart-area-usd3', () => import(/* webpackChunkName : 'visual-center-chart-area-usd3' */  './components/visualcenter3/VisualCenterChartAreaUSD.vue'));
Vue.component('visual-center-usd-table', () => import(/* webpackChunkName : 'visual-center-usd-table' */  './components/visualcenter3/VisualCenterUsdTable.vue'));
Vue.component('visual-center-speedometer', () => import(/* webpackChunkName : 'visual-center-speedometer' */  './components/visualcenter3/VCSpeedometer.vue'));

Vue.component('vc-chart', () => import(/* webpackChunkName : 'vc-chart' */  './components/visualcenter3/VcChart.vue'));
Vue.component('indicator', () => import(/* webpackChunkName : 'indicator' */  './components/visualcenter3/Indicator.vue'));
Vue.component('wide-indicator', () => import(/* webpackChunkName : 'wide-indicator' */  './components/visualcenter3/WideIndicator.vue'));
Vue.component('simple-indicator', () => import(/* webpackChunkName : 'simple-indicator' */  './components/visualcenter3/SimpleIndicator.vue'));
Vue.component('vc-speedometer-block', () => import(/* webpackChunkName : 'vc-speedometer-block' */  './components/visualcenter3/VCSpeedometerBlock.vue'));
Vue.component('horizontal-indicators', () => import(/* webpackChunkName : 'horizontal-indicators' */  './components/visualcenter3/HorizontalIndicators.vue'));
Vue.component('vertical-indicators', () => import(/* webpackChunkName : 'vertical-indicators' */  './components/visualcenter3/VerticalIndicators.vue'));
Vue.component('vc-upstream-table', () => import(/* webpackChunkName : 'vc-upstream-table' */  './components/visualcenter3/UpstreamTable.vue'));
Vue.component('visual-center-menu', () => import(/* webpackChunkName : 'visual-center-menu' */  './components/visualcenter/VisualCenterMenu.vue'));
Vue.component('economic-data-component', () => import(/* webpackChunkName : 'economic-data-component' */  './components/Economic/data/index.vue'));
Vue.component('economic-data-scenario-component', () => import(/* webpackChunkName : 'economic-data-scenario-component' */  './components/Economic/data/scenario.vue'));
Vue.component('tech-data-component', () => import(/* webpackChunkName : 'tech-data-component' */  './components/technical_forecast/data/index.vue'));
Vue.component('economic-component', () => import(/* webpackChunkName : 'economic-component' */  './components/Economic/main.vue'));
Vue.component('gno-table', () => import(/* webpackChunkName : 'gno-table' */  './components/gno/Table.vue'));
Vue.component('inclinometria', () => import(/* webpackChunkName : 'inclinometria' */  './components/gno/components/Inclinometria.vue'));
Vue.component('prs-crs', () => import(/* webpackChunkName : 'prs-crs' */  './components/gno/components/PrsCrs.vue'));
Vue.component('inflow-curve', () => import(/* webpackChunkName : 'inflow-curve' */  './components/gno/components/InflowCurve.vue'));
Vue.component('economic', () => import(/* webpackChunkName : 'economic' */  './components/gno/components/Economic.vue'));

Vue.component('monitor-table', () => import(/* webpackChunkName : 'monitor-table' */  './components/monitor/MonitorTable.vue'));
Vue.component('monitor-chart', () => import(/* webpackChunkName : 'monitor-chart' */  './components/monitor/chart.vue'));
Vue.component('monitor-chart-radialbar', () => import(/* webpackChunkName : 'monitor-chart-radialbar' */  './components/monitor/MonitorChartRadialBar.vue'));
Vue.component('wm-form', () => import(/* webpackChunkName : 'wm-form' */  './components/wm/form.vue'));
Vue.component('omgca-form', () => import(/* webpackChunkName : 'omgca-form' */  './components/omgca/form.vue'));
Vue.component('omguhe-form', () => import(/* webpackChunkName : 'omguhe-form' */  './components/omguhe/form.vue'));
Vue.component('omgngdu-form', () => import(/* webpackChunkName : 'omgngdu-form' */  './components/omgngdu/form.vue'));
Vue.component('omgngdu-well-form', () => import(/* webpackChunkName : 'omgngdu-well-form' */  './components/omgngdu_well/form.vue'));
Vue.component('gu-form', () => import(/* webpackChunkName : 'gu-form' */  './components/gu/form.vue'));
Vue.component('zu-form', () => import(/* webpackChunkName : 'zu-form' */  './components/zu/form.vue'));

Vue.component('gtm-main', () => import(/* webpackChunkName : 'gtm-main' */  './components/GTM/GTMLayout.vue'));
Vue.component('gtm-main-page', () => import(/* webpackChunkName : 'gtm-main-page' */  './components/GTM/Main.vue'));
Vue.component('gtm-main-indicator', () => import(/* webpackChunkName : 'gtm-main-indicator' */  './components/GTM/MainIndicator.vue'));
Vue.component('gtm-aegtm', () => import(/* webpackChunkName : 'gtm-aegtm' */  './components/GTM/Aegtm.vue'));
Vue.component('gtm-aegtm-eco', () => import(/* webpackChunkName : 'gtm-aegtm-eco' */  './components/GTM/AegtmEco.vue'));
Vue.component('gtm-podbor-gtm', () => import(/* webpackChunkName : 'gtm-podbor-gtm' */  './components/GTM/PodborGTM.vue'));
Vue.component('gtm-digital-rating-gtm', () => import(/* webpackChunkName : 'gtm-digital-rating-gtm' */  './components/GTM/DigitalRating.vue'));
Vue.component('gtm-etu', () => import(/* webpackChunkName : 'gtm-etu' */  './components/GTM/Etu.vue'));
Vue.component('gtm-main-menu', () => import(/* webpackChunkName : 'gtm-main-menu' */  './components/GTM/MainMenu.vue'));
Vue.component('gtm-bar-chart', () => import(/* webpackChunkName : 'gtm-bar-chart' */  './components/GTM/BarChart.vue'));
Vue.component('gtm-line-chart', () => import(/* webpackChunkName : 'gtm-line-chart' */  './components/GTM/LineChart.vue'));
Vue.component('gtm-tree', () => import(/* webpackChunkName : 'gtm-tree' */  './components/GTM/Tree.vue'));
Vue.component('gtm-node-tree', () => import(/* webpackChunkName : 'gtm-node-tree' */  './components/GTM/NodeTree.vue'));
Vue.component('gtm-date-picker', () => import(/* webpackChunkName : 'gtm-date-picker' */  './components/GTM/DatePicker.vue'));

Vue.component('reports-table2', () => import(/* webpackChunkName : 'reports-table2' */  './components/reportsGTM/ReportsGTMTable.vue'));
Vue.component('reports-table3', () => import(/* webpackChunkName : 'reports-table3' */  './components/reportDob/RepDobTable.vue'));
Vue.component('monthly-production', () => import(/* webpackChunkName : 'monthly-production' */  './components/reports/MonthlyProduction.vue'));
Vue.component('daily-production', () => import(/* webpackChunkName : 'daily-production' */  './components/reports/DailyProduction.vue'));
Vue.component('daily-injection', () => import(/* webpackChunkName : 'daily-injection' */  './components/reports/DailyInjection.vue'));
Vue.component('monthly-injection', () => import(/* webpackChunkName : 'monthly-injection' */  './components/reports/MonthlyInjection.vue'));
Vue.component('analyze-gtm', () => import(/* webpackChunkName : 'analyze-gtm' */  './components/reports/AnalyzeGtm.vue'));
Vue.component('dynamics-indicators', () => import(/* webpackChunkName : 'dynamics-indicators' */  './components/reports/DynamicsIndicators.vue'));

Vue.component('well-fund', () => import(/* webpackChunkName : 'well-fund' */  './components/reports/WellFund.vue'));
Vue.component('well-fund-block', () => import(/* webpackChunkName : 'well-fund-block' */  './components/reports/WellFundBlock.vue'));
Vue.component('well-fund-field', () => import(/* webpackChunkName : 'well-fund-field' */  './components/reports/WellFundField.vue'));
Vue.component('well-fund-inactive', () => import(/* webpackChunkName : 'well-fund-inactive' */  './components/reports/WellFundInactive.vue'));
Vue.component('well-fund-revision-field', () => import(/* webpackChunkName : 'well-fund-revision-field' */  './components/reports/WellFundRevisionField.vue'));
Vue.component('well-fund-revision', () => import(/* webpackChunkName : 'well-fund-revision' */  './components/reports/WellFundRevision.vue'));

Vue.component('view-table', () => import(/* webpackChunkName : 'view-table' */  './components/omgca/table.vue'));
Vue.component('oilgas-form', () => import(/* webpackChunkName : 'oilgas-form' */  './components/complicationMonitoring/oilGas/form.vue'));
Vue.component('pipe-form', () => import(/* webpackChunkName : 'pipe-form' */  './components/pipes/form.vue'));
Vue.component('pipe-type-form', () => import(/* webpackChunkName : 'pipe-type-form' */  './components/pipeTypes/form.vue'));
Vue.component('inhibitor-create', () => import(/* webpackChunkName : 'inhibitor-create' */  './components/inhibitor/create.vue'));
Vue.component('inhibitor-edit', () => import(/* webpackChunkName : 'inhibitor-edit' */  './components/inhibitor/edit.vue'));
Vue.component('corrosion-form', () => import(/* webpackChunkName : 'corrosion-form' */  './components/complicationMonitoring/corrosion/form.vue'));
Vue.component('gu-map', () => import(/* webpackChunkName : 'gu-map' */  './components/map/map.vue'));
Vue.component('field-settings', () => import(/* webpackChunkName : 'field-settings' */  './components/settings/fields.vue'));

Vue.component('fa-table', () => import(/* webpackChunkName : 'fa-table' */  './components/tr/fa.vue'));
Vue.component('tr-table', () => import(/* webpackChunkName : 'tr-table' */  './components/tr/tr.vue'));
Vue.component('trfa-table', () => import(/* webpackChunkName : 'trfa-table' */  './components/tr/trfa.vue'));
Vue.component('tr-charts-table', () => import(/* webpackChunkName : 'tr-charts-table' */  './components/tr/tr_charts.vue'));
Vue.component('tr-sidebar-charts', () => import(/* webpackChunkName : 'tr-sidebar-charts' */  './components/tr/TrSidebarCharts.vue'));
Vue.component('tr-sidebar-export', () => import(/* webpackChunkName : 'tr-sidebar-export' */  './components/tr/TrSidebarExport.vue'));

Vue.component('cat-loader', () => import(/* webpackChunkName : 'cat-loader' */  './components/ui-kit/CatLoader.vue'));
Vue.component('pagination', () => import(/* webpackChunkName : 'pagination' */  'laravel-vue-pagination'));
Vue.component('report-export', () => import(/* webpackChunkName : 'report-export' */  './components/reports/export.vue'));
Vue.component('tr_mode-table', () => import(/* webpackChunkName : 'tr_mode-table' */  './components/tr/TechMode.vue'));
Vue.component('tr_mode-table-small', () => import(/* webpackChunkName : 'tr_mode-table-small' */  './components/tr/TechModeSmall.vue'));
Vue.component('fa_weekly_chart', () => import(/* webpackChunkName : 'fa_weekly_chart' */  './components/tr/FaWeeklyChart.vue'));
Vue.component('well_cart', () => import(/* webpackChunkName : 'well_cart' */  './components/well_cart/well_cart.vue'));
Vue.component('report_constructor', () => import(/* webpackChunkName : 'report_constructor' */  './components/report_constructor/report_constructor.vue'));
Vue.component('pf-main', () => import(/* webpackChunkName : 'pf-main' */  './components/PlastFluids/views/MainPage.vue'));
Vue.component('pf-template_pvt_plast_oil', () => import(/* webpackChunkName : 'pf-template_pvt_plast_oil' */  './components/PlastFluids/views/SuperTemplatePvtPlastOil.vue'));

Vue.component('viscenter2-create', () => import(/* webpackChunkName : 'viscenter2-create' */  './components/visualcenter/viscenter2/create.vue'));
Vue.component('visualcenter3-excelform', () => import(/* webpackChunkName : 'visualcenter3-excelform' */  './components/visualcenter3/importForm/ExcelForm.vue'));
Vue.component('big-data', () => import(/* webpackChunkName : 'big-data' */  './components/bigdata/BigData.vue'));
Vue.component('las', () => import(/* webpackChunkName : 'las' */  './components/bigdata/Las.vue'));
Vue.component('geo-data-reference-book', () => import(/* webpackChunkName : 'geo-data-reference-book' */  './components/bigdata/GeoDataReferenceBook.vue'));

Vue.component('user-reports', () => import(/* webpackChunkName : 'user-reports' */  './components/bigdata/UserReports.vue'));
Vue.component('proto-form', () => import(/* webpackChunkName : 'proto-form' */  './components/bigdata/Forms.vue'));
Vue.component('bigdata-form-mobile', () => import(/* webpackChunkName : 'bigdata-form-mobile' */  './components/bigdata/FormMobile.vue'));
Vue.component('search-form', () => import(/* webpackChunkName : 'search-form' */  './components/ui-kit/SearchForm.vue'));
Vue.component('bigdata-report-button', () => import(/* webpackChunkName : 'bigdata-report-button' */  './components/bigdata/BigDataReportButton.vue'));
Vue.component('full-page-loader', () => import(/* webpackChunkName : 'full-page-loader' */  './components/ui-kit/FullPageLoader.vue'));
Vue.component('main-page', () => import(/* webpackChunkName : 'main-page' */  './components/mainpage.vue'));
Vue.component('profile', () => import(/* webpackChunkName : 'profile' */  './components/profile/Profile.vue'));

Vue.component('reptt', () => import(/* webpackChunkName : 'reptt' */  './components/economy_kenzhe/reptt.vue'));
Vue.component('reptt-company', () => import(/* webpackChunkName : 'reptt-company' */  './components/economy_kenzhe/reptt_company.vue'));
Vue.component('proactive-factors', () => import(/* webpackChunkName : 'proactive-factors' */  './components/economy_kenzhe/proactiveFactors/proactiveFactors.vue'));
Vue.component('proactive-factors-select-filter', () => import(/* webpackChunkName : 'proactive-factors-select-filter' */  './components/economy_kenzhe/proactiveFactors/selectFilter.vue'));
Vue.component('reptt-company2', () => import(/* webpackChunkName : 'reptt-company2' */  './components/economy_kenzhe/proactiveFactors/repttCompany/reptt_company2.vue'));

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
