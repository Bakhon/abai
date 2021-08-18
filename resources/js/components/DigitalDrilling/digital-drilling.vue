<template>
    <div class="row digital_drilling">
        <div class="col-sm-12 centerBlock">
            <menuHead @changePage="changePage"/>
        </div>
        <div class="col-sm-10 leftBlock">
            <div class="resultsBlock">
                <ul>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">14</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title green">{{ trans('digital_drilling.default.in_drilling') }}</p>
                            <p class="percent"><span>5,2%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">506</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title yellow">{{ trans('digital_drilling.default.drilled') }}</p>
                            <p class="percent"><span>1,4%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">0</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title red">{{ trans('digital_drilling.default.in_mastering') }}</p>
                            <p class="percent"><span>0,0%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">520</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title">{{ trans('digital_drilling.default.Total') }}</p>
                            <p class="percent"><span>1,4%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="contentBlock">
               <keep-alive >
                    <component v-bind:is="mainPage.component" v-if="mainPage.name=='digital_drilling.menu1'"></component>
               </keep-alive>
                <component v-bind:is="mainPage.component" v-if="mainPage.name!='digital_drilling.menu1'"></component>
            </div>
        </div>
        <div class="col-sm-2 rightBlock">
            <div class="analyticsBlock">
                <div class="techNumsBlock">
                    <p class="name">{{ trans('digital_drilling.default.technical_and_economic') }}</p>
                    <label>{{ trans('digital_drilling.default.mechanical_speed') }}</label>
                    <div class="lineBlock">
                        <p>21 {{ trans('digital_drilling.default.m_h') }}</p>
                        <input type="range" max="40" min="0" value="21" class="rangeInput" disabled>
                    </div>
                    <label>{{ trans('digital_drilling.default.cruising_speed') }}</label>
                    <div class="lineBlock">
                        <p>15 {{ trans('digital_drilling.default.m_h') }}</p>
                        <input type="range" max="40" min="0" value="15" class="rangeInput" disabled>
                    </div>
                    <label>{{ trans('digital_drilling.default.technical_speed') }}</label>
                    <div class="lineBlock">
                        <p>2200 {{ trans('digital_drilling.default.m_st_month') }}</p>
                        <input type="range" max="3000" min="0" value="2200" class="rangeInput" disabled>
                    </div>
                    <label>{{ trans('digital_drilling.default.commercial_speed') }}</label>
                    <div class="lineBlock">
                        <p>1500 {{ trans('digital_drilling.default.m_st_month') }}</p>
                        <input type="range" max="3000" min="0" value="1500" class="rangeInput" disabled>
                    </div>
                    <label>{{ trans('digital_drilling.default.cycle_speed') }}</label>
                    <div class="lineBlock">
                        <p>1700 {{ trans('digital_drilling.default.m_st_month') }}</p>
                        <input type="range" max="3000" min="0" value="1700" class="rangeInput" disabled>
                    </div>
                </div>
            </div>
            <div class="analyticsBlock">
                <p class="num"><span>1230</span>{{ trans('digital_drilling.default.meters') }}</p>
                <p class="name"><img src="/img/digital-drilling/drilling.svg" alt=""><span>{{ trans('digital_drilling.default.drilled_per_day') }}</span></p>
            </div>
            <div class="analyticsBlock">
                <p class="num"><span>14251</span>метров</p>
                <p class="name"><img src="/img/digital-drilling/drilling.svg" alt=""><span>{{ trans('digital_drilling.default.total_drilled') }}</span></p>
            </div>
            <button class="alarm">ALARM</button>
        </div>
    </div>
</template>

<script>
    import pages from './pages'
    import menuHead from './menu'
    import Vue from 'vue';


    export default {
        name: "digital-drilling",
        components: { menuHead },
        data(){
            return{
                mainPage: pages.bd[0]
            }
        },
        mounted(){
            $(document).ready(function () {
                $('.rangeInput').each(function () {
                    var value = ((this.value - this.min) / (this.max - this.min)) * 100;
                    var inputVal = this.value;
                    var back = "linear-gradient(to right, #454D7D 0%, #454D7D " + value + "%, #3C4270 " + value + "%, #3C4270 100%)";
                    $(this).css("background", back);
                });
            });
        },
        methods:{
            changePage(page){
                this.mainPage = page
            }
        },
    }
    Vue.component('home', require('./bd/home').default);
    Vue.component('project-data', require('./bd/ProjectData').default);
    Vue.component('technical-task', require('./bd/ProjectData/TechnicalTask').default);
    Vue.component('geology', require('./bd/ProjectData/Geology').default);
    Vue.component('well-design', require('./bd/ProjectData/WellDesign').default);
    Vue.component('barrel-profile', require('./bd/ProjectData/BarrelProfile').default);
    Vue.component('pd-drilling-fluids', require('./bd/ProjectData/DrillingFluids').default);
    Vue.component('well-casing', require('./bd/ProjectData/WellСasing').default);
    Vue.component('technical-casing', require('./bd/ProjectData/TechnicalCasing').default);
    Vue.component('passport', require('./bd/passport').default);
    Vue.component('gis', require('./bd/gis').default);
    Vue.component('inclino', require('./bd/inclino').default);
    Vue.component('structure', require('./bd/structure').default);

    Vue.component('project', require('./project/project').default);
    Vue.component('well-profile', require('./project/well-profile').default);
    Vue.component('well-profile-graph', require('./project/well-profile-graph').default);
    Vue.component('structural-analysis', require('./project/structural-analysis').default);
    Vue.component('calculation', require('./project/calculation').default);
    Vue.component('calculation-graph', require('./project/calculation-graph').default);
    Vue.component('drilling-fluids', require('./project/drilling-fluids').default);
    Vue.component('rasters', require('./project/rasters').default);
    Vue.component('rasters-component', require('./project/rasters-component').default);
    Vue.component('rasters-params', require('./project/rasters-params').default);
    Vue.component('well-deepening', require('./project/well-deepening').default);
    Vue.component('w-deepening', require('./project/deepening').default);
    Vue.component('w-deepening-params', require('./project/deepening-params').default);
    Vue.component('w-deepening-graph', require('./project/deepening-graph').default);
    Vue.component('well-fastening', require('./project/well-fastening').default);
    Vue.component('fastening', require('./project/fastening').default);
    Vue.component('fastening-page2', require('./project/fastening-page2').default);
    Vue.component('fastening-page3', require('./project/fastening-page3').default);
    Vue.component('fastening-page4', require('./project/fastening-page4').default);
    Vue.component('fastening-page5', require('./project/fastening-page5').default);
    Vue.component('fastening-page6', require('./project/fastening-page6').default);
    Vue.component('fastening-page7', require('./project/fastening-page7').default);

    Vue.component('alarm', require('./online/alarm').default);
    Vue.component('geo', require('./online/geo').default);
    Vue.component('geo-first', require('./online/geo-first').default);
    Vue.component('geo-second', require('./online/geo-second').default);
    Vue.component('geo-third', require('./online/geo-third').default);
    Vue.component('sector', require('./online/sector').default);
    Vue.component('visual', require('./online/visual').default);
    Vue.component('report', require('./online/report').default);
    Vue.component('report1', require('./online/report1').default);
    Vue.component('report2', require('./online/report2').default);

    Vue.component('reports', require('./supervising/reports').default);
    Vue.component('balance', require('./supervising/balance').default);
    Vue.component('balance-graph-first', require('./supervising/balance-graph-first').default);
    Vue.component('balance-graph-second', require('./supervising/balance-graph-second').default);
    Vue.component('fact', require('./supervising/fact').default);
    Vue.component('npv', require('./supervising/npv').default);
    Vue.component('akc', require('./supervising/akc').default);

    Vue.component('analytics-deepening', require('./analytics/analytics-deepening').default);
    Vue.component('deepening', require('./analytics/deepening').default);
    Vue.component('deepening-visual', require('./analytics/deepening-visual').default);
    Vue.component('deepening-knbk', require('./analytics/deepening-knbk').default);
    Vue.component('deepening-params', require('./analytics/deepening-params').default);
    Vue.component('deepening-bur', require('./analytics/deepening-bur').default);
    Vue.component('deepening-gidro', require('./analytics/deepening-gidro').default);
    Vue.component('deepening-sorting', require('./analytics/deepening-sorting').default);
    Vue.component('deepening-selection', require('./analytics/deepening-selection').default);
    Vue.component('well-fastening', require('./analytics/well-fastening').default);
    Vue.component('fastening-first', require('./analytics/fastening-first').default);
    Vue.component('fastening-second', require('./analytics/fastening-second').default);
    Vue.component('fastening-third', require('./analytics/fastening-third').default);
    Vue.component('complications', require('./analytics/complications').default);
    Vue.component('analytics-akc', require('./analytics/akc').default);
    Vue.component('balance', require('./analytics/balance').default);


</script>