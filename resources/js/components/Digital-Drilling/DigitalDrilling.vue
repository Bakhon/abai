<template>
    <div class="row digital_drilling">
        <div class="col-sm-12 centerBlock">
            <menuHead @changePage="changePage" @createNewWel="createNewWel" @openNewWell="openNewWell"/>
        </div>
        <div class="col-sm-12 mainBlock">
            <div class="mainBlock__body">
                <div class="mainBlock__left" :class="{open: leftMenuOpen}">
                    <div class="mainBlock__left-header">
                        <div class="mainBlock__left-title">
                            <img src="/img/digital-drilling/left-menu-toggle.svg" alt="">
                            <div class="title">{{ trans('digital_drilling.default.selecting_submodule') }}</div>
                        </div>
                        <div class="mainBlock__left-arrow">
                            <div class="mainBlock__left-arrow-inner" @click="toggleLeftMenu">
                                <img src="/img/digital-drilling/left-arrow.svg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="mainBlock__left-closed title">
                        {{ trans('digital_drilling.default.selecting_submodule') }}
                    </div>
                    <div class="mainBlock__left-pages">
                        <left-menu :pages="pages.bd" @changePageComponent="changePageComponent"/>
                    </div>
                </div>
                <div class="mainBlock__content" :class="{allPage: !leftMenuOpen}">
                    <component v-bind:is="mainPage.component" v-if="!pageComponent"></component>
                    <Main :page="pageComponent" v-else/>
                </div>
            </div>
        </div>
        <new-well v-if="newWellOpen" @closeNewWell="newWellOpen=false"/>
        <old-well v-if="oldWellOpen" @closeOldWell="oldWellOpen=false"/>
    </div>
</template>

<script>
    import menuHead from './menu'
    import NewWell from './project/NewWell'
    import OldWell from './project/OldWell'
    import leftMenu from './leftMenu'
    import pages from './pages'
    import Vue from 'vue';
    import Main from './Main'

    export default {
        name: "DigitalDrilling",
        components: {menuHead, leftMenu, Main, NewWell, OldWell},
        data(){
            return{
                leftMenuOpen: true,
                newWellOpen: false,
                oldWellOpen: true,
                pages: pages,
                pageComponent: null,
                mainPage: {
                    "name": "digital_drilling.general_information",
                    "img": "/img/digital-drilling/menu2.svg",
                    "id": 1,
                    "component": {
                        "name": "main-table",
                        "template": "<home></home>"
                    }
                },

            }
        },
        methods:{
            changePage(page){
                this.pageComponent = null
            },
            changePageComponent(component){
                this.pageComponent = component
            },
            toggleLeftMenu(){
                this.leftMenuOpen = !this.leftMenuOpen
            },
            createNewWel(){
                this.newWellOpen = true
            },
            openNewWell(){
                this.oldWellOpen = true
            },
        }
    }


    Vue.component('home', require('./bd/home').default);
    Vue.component('passport', require('./bd/passport').default);
    Vue.component('gis', require('./bd/gis').default);
    Vue.component('inclino', require('./bd/inclino').default);
    Vue.component('structure', require('./bd/structure').default);
    Vue.component('structure-graph', require('./bd/structure-graph').default);
    Vue.component('complications', require('./bd/complications').default);
    Vue.component('technical-task', require('./bd/ProjectData/TechnicalTask').default);
    Vue.component('geology', require('./bd/ProjectData/Geology').default);
    Vue.component('well-design', require('./bd/ProjectData/WellDesign').default);
    Vue.component('barrel-profile', require('./bd/ProjectData/BarrelProfile').default);
    Vue.component('pd-drilling-fluids', require('./bd/ProjectData/DrillingFluids').default);
    Vue.component('well-casing', require('./bd/ProjectData/WellСasing').default);
    Vue.component('technical-casing', require('./bd/ProjectData/TechnicalCasing').default);

</script>

<style scoped>

</style>