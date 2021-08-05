/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import "./directives/outsideClickDetect.js";

import VueAxios from 'vue-axios';
import axios from 'axios';
import VueTableDynamic from 'vue-table-dynamic';
import Vue from 'vue';

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
//Mixins
import showToast from '~/mixins/showToast';
import {currentUrlPage, urlLink} from "./components/geology/js/utils";

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
Vue.component('paginate', Paginate);

Vue.mixin(showToast);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('edit-history', require('./components/common/EditHistory.vue').default);
Vue.component('tree-view', require('./components/common/TreeView.vue').default);
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

Vue.component('economic-data-component', require('./components/Economic/data/index.vue').default);
Vue.component('economic-data-scenario-component', require('./components/Economic/data/scenario.vue').default);
Vue.component('tech-data-component', require('./components/technical_forecast/data/index.vue').default);

Vue.component('economic-nrs', require('./components/Economic/nrs.vue').default);
Vue.component('economic-optimization', require('./components/Economic/optimization.vue').default);
Vue.component('gno-table', require('./components/gno/Table.vue').default);
Vue.component('shgn-img', require('./components/gno/components/ShgnImg.vue').default);
Vue.component('inclinometria', require('./components/gno/components/Inclinometria.vue').default);
Vue.component('prs-crs', require('./components/gno/components/PrsCrs.vue').default);
Vue.component('inflow-curve', require('./components/gno/components/InflowCurve.vue').default);
Vue.component('economic', require('./components/gno/components/Economic.vue').default);
Vue.component('monitor-table', require('./components/complicationMonitoring/monitor/MonitorTable.vue').default);
Vue.component('monitor-chart', require('./components/complicationMonitoring/monitor/chart.vue').default);
Vue.component('monitor-chart-radialbar', require('./components/complicationMonitoring/monitor/MonitorChartRadialBar.vue').default);
Vue.component('wm-form', require('./components/wm/form.vue').default);
Vue.component('omgca-form', require('./components/complicationMonitoring/omgca/form.vue').default);
Vue.component('omguhe-form', require('./components/complicationMonitoring/omguhe/form.vue').default);
Vue.component('omgngdu-form', require('./components/complicationMonitoring/omgngdu/form.vue').default);
Vue.component('omgngdu-well-form', require('./components/complicationMonitoring/omgngdu_well/form.vue').default);
Vue.component('gu-form', require('./components/complicationMonitoring/gu/form.vue').default);
Vue.component('zu-form', require('./components/complicationMonitoring/zu/form.vue').default);
Vue.component('pipe-passport-form', require('./components/complicationMonitoring/pipePassport/form.vue').default);

Vue.component('gtm-main', require('./components/GTM/GTMLayout.vue').default);
Vue.component('gtm-main-page', require('./components/GTM/Main.vue').default);
Vue.component('gtm-main-indicator', require('./components/GTM/MainIndicator.vue').default);
Vue.component('gtm-aegtm', require('./components/GTM/components/Aegtm.vue').default);
Vue.component('gtm-aegtm-eco', require('./components/GTM/components/AegtmEco.vue').default);
Vue.component('gtm-aegtm-unsuccessful-distribution', require('./components/GTM/components/AegtmUnsuccessfulDistribution.vue').default);
Vue.component('gtm-podbor-gtm', require('./components/GTM/components/PodborGTM.vue').default);
Vue.component('gtm-digital-rating-gtm', require('./components/GTM/components/DigitalRating.vue').default);
Vue.component('gtm-etu', require('./components/GTM/components/Etu.vue').default);
Vue.component('gtm-main-menu', require('./components/GTM/MainMenu.vue').default);
Vue.component('gtm-bar-chart', require('./components/GTM/components/BarChart.vue').default);
Vue.component('gtm-line-chart', require('./components/GTM/components/LineChart.vue').default);
Vue.component('gtm-tree', require('./components/GTM/mixin/Tree.vue').default);
Vue.component('gtm-node-tree', require('./components/GTM/mixin/NodeTree.vue').default);
Vue.component('gtm-date-picker', require('./components/GTM/mixin/DatePicker.vue').default);

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
Vue.component('well-fund-revision-field', require('./components/reports/WellFundRevisionField.vue').default);
Vue.component('well-fund-revision', require('./components/reports/WellFundRevision.vue').default);
Vue.component('view-table', require('./components/complicationMonitoring/omgca/table.vue').default);
Vue.component('oilgas-form', require('./components/complicationMonitoring/oilGas/form.vue').default);
Vue.component('pipe-form', require('./components/complicationMonitoring/pipes/form.vue').default);
Vue.component('pipe-type-form', require('./components/complicationMonitoring/pipeTypes/form.vue').default);
Vue.component('las-dictionaries-form', require('./components/bigdata/las/refs/lasDictionaries/form.vue').default);
Vue.component('geo-mapping-form', require('./components/bigdata/mapping/form.vue').default);
Vue.component('inhibitor-create', require('./components/inhibitor/create.vue').default);
Vue.component('inhibitor-edit', require('./components/inhibitor/edit.vue').default);
Vue.component('corrosion-form', require('./components/complicationMonitoring/corrosion/form.vue').default);
Vue.component('map-history', require('./components/complicationMonitoring/map/mapHistory.vue').default);
Vue.component('gu-map', require('./components/complicationMonitoring/map/map.vue').default);
Vue.component('field-settings', require('./components/settings/fields.vue').default);

Vue.component('fa-table', require('./components/tr/fa.vue').default);
Vue.component('tr-table', require('./components/tr/tr.vue').default);
Vue.component('trfa-table', require('./components/tr/trfa.vue').default);
Vue.component('tr-charts-table', require('./components/tr/tr_charts.vue').default);
Vue.component('tr-sidebar-charts', require('./components/tr/TrSidebarCharts.vue').default);
Vue.component('tr-sidebar-export', require('./components/tr/TrSidebarExport.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('report-export', require('./components/reports/export.vue').default);
Vue.component('tr_mode-table', require('./components/tr/TechMode.vue').default);
Vue.component('tr_mode-table-small', require('./components/tr/TechModeSmall.vue').default);
Vue.component('fa_weekly_chart', require('./components/tr/FaWeeklyChart.vue').default);
Vue.component('well_cart', require('./components/well_cart/well_cart.vue').default);
Vue.component('report-constructor', require('./components/reportConstructor/ReportConstructor.vue').default);

Vue.component('pf-main', require('./components/PlastFluids/views/MainPage.vue').default);
Vue.component('pf-upload_monitoring', require('./components/PlastFluids/views/UploadMonitoring.vue').default);
Vue.component('pf-template_pvt_plast_oil', require('./components/PlastFluids/views/SuperTemplatePvtPlastOil.vue').default);
Vue.component('pf-oil-map', require('./components/PlastFluids/components/OilMapKz.vue').default);

Vue.component('viscenter2-create', require('./components/visualcenter/viscenter2/create.vue').default);
Vue.component('visualcenter3-excelform', require('./components/visualcenter3/importForm/ExcelForm.vue').default);

Vue.component('big-data', require('./components/bigdata/BigData.vue').default);
Vue.component('las', require('./components/bigdata/Las.vue').default);
Vue.component('geo-data-reference-book', require('./components/bigdata/GeoDataReferenceBook.vue').default);
Vue.component('proto-form', require('./components/bigdata/Forms.vue').default);
Vue.component('proto-form-wrapper', require('./components/bigdata/FormsWrapper.vue').default);
Vue.component('proto-org-select-tree', require('./components/bigdata/OrgSelectTree.vue').default);
Vue.component('report-constructor-item-select-tree', require('./components/reportConstructor/ItemSelectTree.vue').default);
Vue.component('report-header-builder', require('./components/reportConstructor/ReportHeaderBuilder.vue').default);
Vue.component('bigdata-form-mobile', require('./components/bigdata/FormMobile.vue').default);
Vue.component('bigdata-report-button', require('./components/bigdata/BigDataReportButton.vue').default);
Vue.component('bigdata-plain-form', require('./components/bigdata/forms/PlainForm.vue').default);

Vue.component('main-page', require('./components/mainpage.vue').default);

Vue.component('profile', require('./components/profile/Profile.vue').default);

Vue.component('reptt', require('./components/economy_kenzhe/reptt.vue').default);
Vue.component('budget-execution', require('./components/economy_kenzhe/budgetExecution/budgetExecution.vue').default);
Vue.component('reptt-company', require('./components/economy_kenzhe/reptt_company.vue').default);

Vue.component('proactive-factors', require('./components/economy_kenzhe/proactiveFactors/proactiveFactors.vue').default);
Vue.component('proactive-factors-select-filter', require('./components/economy_kenzhe/proactiveFactors/selectFilter.vue').default);
Vue.component('reptt-company2', require('./components/economy_kenzhe/proactiveFactors/repttCompany/reptt_company2.vue').default);

Vue.component('page-petrophysics', require('./components/geology/petrophysics/PagePetrophysics.vue').default);
Vue.component('page-core', require('./components/geology/core/PageCore.vue').default);
Vue.component('page-visualization', require('./components/geology/visualization/PageVisualization.vue').default);
Vue.component('page-geophysics', require('./components/geology/geophysics/PageGeophysics.vue').default);

Vue.component('digital-rating', require('./components/DigitalRating/index.vue').default);
Vue.component('digital-rating-report', require('./components/DigitalRating/DigitalRatingReport.vue').default);

Vue.component('admin-user-settings', require('./components/admin/user/Settings.vue').default);
Vue.component('visual-center-daily-report', require('./components/visualcenter3/dailyReport/index.vue').default);
Vue.component('visual-center-daily-approve', require('./components/visualcenter3/importForm/dailyApprove/index.vue').default);


Vue.component('project-data', require('./components/DigitalDrilling/ProjectData').default);
Vue.component('window-head', require('./components/DigitalDrilling/WindowHead').default);
Vue.component('technical-task', require('./components/DigitalDrilling/ProjectData/TechnicalTask').default);
Vue.component('geology', require('./components/DigitalDrilling/ProjectData/Geology').default);
Vue.component('well-design', require('./components/DigitalDrilling/ProjectData/WellDesign').default);
Vue.component('barrel-profile', require('./components/DigitalDrilling/ProjectData/BarrelProfile').default);
Vue.component('drilling-fluids', require('./components/DigitalDrilling/ProjectData/DrillingFluids').default);
Vue.component('well-casing', require('./components/DigitalDrilling/ProjectData/WellСasing').default);
Vue.component('technical-casing', require('./components/DigitalDrilling/ProjectData/TechnicalCasing').default);
Vue.component('daily-raport', require('./components/DigitalDrilling/DailyRaport').default);

Vue.prototype.trans = string => _.get(window.i18n, string) || string;
Vue.prototype.localeUrl = string => `/${window.current_lang}/${string[0] === '/' ? string.substr(1) : string}`;
Vue.prototype.currentLang = window.current_lang;
Vue.prototype.$urlLink = url => urlLink(url);
Vue.prototype.$currentPageUrl = currentUrlPage;


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store,
    el: '#app',
});
