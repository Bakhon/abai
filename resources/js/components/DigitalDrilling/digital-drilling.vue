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
                                <span>скважин</span>
                            </p>
                            <p class="title green">В бурении</p>
                            <p class="percent"><span>5,2%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">506</span>
                                <span>скважин</span>
                            </p>
                            <p class="title yellow">Пробурено</p>
                            <p class="percent"><span>1,4%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">0</span>
                                <span>скважин</span>
                            </p>
                            <p class="title red">В освоении</p>
                            <p class="percent"><span>0,0%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">520</span>
                                <span>скважин</span>
                            </p>
                            <p class="title">Итого</p>
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
                    <p class="name">Технико-экономические показатели</p>
                    <label>Механическая скорость</label>
                    <div class="lineBlock">
                        <p>21 м/ч</p>
                        <input type="range" max="40" min="0" value="21" class="rangeInput" disabled>
                    </div>
                    <label>Рейсовая скорость</label>
                    <div class="lineBlock">
                        <p>15 м/ч</p>
                        <input type="range" max="40" min="0" value="15" class="rangeInput" disabled>
                    </div>
                    <label>Техническая скорость</label>
                    <div class="lineBlock">
                        <p>2200 м/ст.мес</p>
                        <input type="range" max="3000" min="0" value="2200" class="rangeInput" disabled>
                    </div>
                    <label>Коммерческая скорость</label>
                    <div class="lineBlock">
                        <p>1500 м/ст.мес</p>
                        <input type="range" max="3000" min="0" value="1500" class="rangeInput" disabled>
                    </div>
                    <label>Цикловая скорость</label>
                    <div class="lineBlock">
                        <p>1700 м/ст.мес</p>
                        <input type="range" max="3000" min="0" value="1700" class="rangeInput" disabled>
                    </div>
                </div>
            </div>
            <div class="analyticsBlock">
                <p class="num"><span>1230</span>метров</p>
                <p class="name"><img src="/img/digital-drilling/drilling.svg" alt=""><span>Пробурено за сутки</span></p>
            </div>
            <div class="analyticsBlock">
                <p class="num"><span>14251</span>метров</p>
                <p class="name"><img src="/img/digital-drilling/drilling.svg" alt=""><span>Пробурено итого</span></p>
            </div>
            <button class="alarm">ALARM</button>
        </div>
    </div>
</template>

<script>
    import pages from './pages'
    import menuHead from './menu'

    export default {
        name: "digital-drilling",
        components: { menuHead },
        data(){
            return{
                mainPage: pages.bd[0]
            }
        },
        methods:{
            changePage(page){
                this.mainPage = page
            }
        },
    }
</script>

<style scoped>

</style>