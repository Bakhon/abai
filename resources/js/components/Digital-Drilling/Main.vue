<template>
    <div class="main__component">
        <div class="main__component-header">
            <div class="main__component-header-content">
                <div class="main__component-back">
                    <img src="/img/digital-drilling/back-icon.png" alt="">
                    <img src="/img/digital-drilling/reboot-icon.png" alt="">
                </div>
                <div class="main__component-filters">
                    <dropdown title="ДЗО" :options="options" class="dropdown__area"/>
                    <dropdown title="Месторождение" :options="options" class="dropdown__area"/>
                    <dropdown title="Сважина" :options="options" class="dropdown__area"/>
                </div>
            </div>
        </div>
        <div class="main__component-body defaultScroll">
            <component v-bind:is="page.component" />
            <div class="filter__not">
                <div class="filter__not-background">
                    <img src="/img/digital-drilling/toFilter.svg" alt="" class="notFilter">
                    <div class="text">
                        Выберите  скважину с помощью фильтра
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Dropdown from './components/dropdown'
    export default {
        name: "Main",
        components: {Dropdown},
        props: ['page'],
        data(){
            return{
                options: ['Test','Test','Test','Test','Test'],
            }
        },
    }
</script>

<style scoped>
    .main__component{
        width: 100%;
        height: 100%;
        border: 6px solid #20274F;
        border-top: 0;
    }
    .main__component-header{
        background: #20274F;
        width: 100%;
        padding: 6px 0;
    }
    .main__component-header-content{
        background: #323370;
        border: 1px solid #545580;
        height: 31px;
        width: 100%;
        display: flex;
        align-items: center;
        padding: 0 6px 0 15px;
    }
    .main__component-back img{
        margin-right: 14px;
        cursor: pointer;
    }
    .main__component-filters{
        height: 100%;
        display: flex;
        align-items: center;
        margin-left: auto;
    }
    .main__component-filters .dropdown__area{
        margin-left: 6px;
    }
    .main__component-body{
        position: relative;
        width: 100%;
        height: calc(100% - 43px);
        padding: 5px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .filter__not.active{
        display: block;
    }
    .filter__not{
        display: none;
        top: 0;
        left: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 15;
    }
    .filter__not-background{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .filter__not-background .text{
        margin-top: 30px;
        font-weight: bold;
        font-size: 22px;
        line-height: 26px;
        text-align: center;

        color: #FFFFFF;
        text-align: center;
    }

</style>