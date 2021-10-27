<template>
    <div class="row ml-10">
        <div class="col-sm-10 leftBlock pl-0 pr-0">
            <div class="resultsBlock">
                <ul>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">14</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title green">{{ trans('digital_drilling.default.in_drilling') }}</p>
                            <p class="percent">
                                <img src="/img/digital-drilling/triangle.svg" alt="" class="mr-1"><span>5,2%</span> vs 23.03.2021
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="block">
                            <p class="num">
                                <span class="big">506</span>
                                <span>{{ trans('digital_drilling.default.well') }}</span>
                            </p>
                            <p class="title yellow">{{ trans('digital_drilling.default.drilled') }}</p>
                            <p class="percent"><img src="/img/digital-drilling/triangle.svg" alt="" class="mr-1"><span>1,4%</span> vs 23.03.2021</p>
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
                            <p class="percent"><img src="/img/digital-drilling/triangle.svg" alt="" class="mr-1"><span>1,4%</span> vs 23.03.2021</p>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="contentBlock">
                <div class="contentBlock__map">
                    <div class="contentBlock__map-header">
                        <div class="contentBlock__map-search">
                            <div class="contentBlock__map-search-title">
                                <img src="/img/digital-drilling/icon-map.png" alt="">
                                <div class="title">Буровые установки</div>
                            </div>
                            <div class="contentBlock__map-search-block">
                                <div class="contentBlock__map-search-input">
                                    <img src="/img/digital-drilling/search.png" alt="">
                                    <input type="text" placeholder="Поиск">
                                    <button>Поиск</button>
                                </div>
                                <button class="full"><img src="/img/digital-drilling/button2.svg" alt=""></button>
                            </div>
                        </div>
                    </div>
                    <div class="rigs__content defaultScroll">
                        <table class="table defaultTable">
                            <tbody>
                                <tr>
                                    <th>Наименование компании</th>
                                    <th>Наименование БУ</th>
                                    <th>Начальник буровой</th>
                                    <th>Грузо-подъёмность кН</th>
                                    <th>Номинальная глубина бурения</th>
                                    <th>Продолжительность монтажа, сут</th>
                                    <th>Продолжительность демонтажа, сут</th>
                                    <th>График планирования</th>
                                    <th>Схема перемещения</th>
                                </tr>
                                <tr v-for="i in 12">
                                    <td></td>
                                    <td>
                                        <div class="text-center mb-2">ZJ-40</div>
                                        <button class="characteristic" @click="openCharacteristicModal">Тех. характеристики</button>
                                    </td>

                                    <td v-for="i in 4"></td>
                                    <td></td>
                                    <td>
                                        <div class="text-center mb-2">
                                            8-ая скв.
                                            с 01.01.2021
                                        </div>
                                        <button class="characteristic" @click="openCharacteristicGraphModal">
                                            График
                                            <img src="/img/digital-drilling/install-graph.svg" alt="">
                                        </button>
                                    </td>
                                    <td>
                                        <div class="text-center mb-2">
                                            АО ЭМГ
                                            М/е: Актобе
                                            Скв.№112</div>
                                        <button class="characteristic" @click="openCharacteristicSchemeModal">
                                            Схема
                                            <img src="/img/digital-drilling/install-cheme.svg" alt="">
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2 rightBlock pr-0">
            <div class="analyticsBlock">
                <p class="num"><span>1230</span>{{ trans('digital_drilling.default.meters') }}</p>
                <p class="name"><img src="/img/digital-drilling/drilling-day.svg" alt=""><span>{{ trans('digital_drilling.default.drilled_per_day') }}</span></p>
            </div>
            <div class="analyticsBlock">
                <p class="num"><span>14251</span>метров</p>
                <p class="name"><img src="/img/digital-drilling/drilling-all.svg" alt=""><span>{{ trans('digital_drilling.default.total_drilled') }}</span></p>
            </div>
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
        </div>
        <div class="characteristic__modal" v-if="characteristicModal">
            <div class="characteristic_content">
                <div class="characteristic_header">
                    <span>Технические характеристики ZJ-40</span>
                    <div class="characteristic_header-close" @click="openCharacteristicModal">
                        Закрыть
                    </div>
                </div>
                <div class="characteristic_body defaultScroll">
                    <table class="table defaultTable modalTable">
                        <tbody>
                            <tr>
                                <th>Параметры</th>
                                <th>Ед.измерения</th>
                                <th>Значение</th>
                            </tr>
                            <tr v-for="i in 20">
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="characteristic__modal graph" v-if="characteristicGraph">
            <div class="characteristic_content">
                <div class="characteristic_header">
                    <span>График бурения буровой установки ZJ-40 (ТОО СПБ “КазМунайГаз-Бурение)</span>
                    <div class="characteristic_header-close" @click="openCharacteristicGraphModal">
                        Закрыть
                    </div>
                </div>
                <div class="characteristic_body defaultScroll">
                    <img src="/img/digital-drilling/scheme.png" alt="">
                </div>
                <button class="btn__ok" @click="openCharacteristicGraphModal">
                    Ok
                </button>
            </div>
        </div>
        <div class="characteristic__modal scheme" v-if="characteristicScheme">
            <div class="characteristic_content">
                <div class="characteristic_header">
                    <span>Схема передвижения буровой установки ZJ-40 (ТОО СПБ “КазМунайГаз-Бурение)</span>
                    <div class="characteristic_header-close" @click="openCharacteristicSchemeModal">
                        Закрыть
                    </div>
                </div>
                <div class="characteristic_body defaultScroll">
                    <div class="map__content">
                        <MglMap
                                container="map-test"
                                :center.sync="center"
                                :accessToken="accessToken"
                                :mapStyle="mapStyle"
                                :zoom="zoom"
                                class="mglMap"
                        >
                            <MglMarker
                                    :coordinates.sync="center"
                                    color='green'
                            />
                        </MglMap>
                    </div>
                    <button class="btn__ok" @click="openCharacteristicSchemeModal">
                        Ok
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        MglMap,
        MglMarker,
        MglGeojsonLayer
    } from 'vue-mapbox'

    export default {
        name: "DrillingRigs",
        components:{ MglMap, MglMarker, MglGeojsonLayer},
        data(){
            return{
                accessToken: process.env.MIX_MAPBOX_TOKEN,
                mapStyle: 'mapbox://styles/mapbox/satellite-v9?optimize=true',
                center: [52.1108, 43.68999],
                zoom: 9,
                characteristicModal: false,
                characteristicGraph: false,
                characteristicScheme: false,
            }
        },
        methods:{
            openCharacteristicModal(){
                if (this.characteristicModal){
                    this.characteristicModal = false
                } else{
                    document.body.overflow = 'hidden'
                    this.characteristicModal = true
                }
            },
            openCharacteristicGraphModal(){
                if (this.characteristicGraph){
                    this.characteristicGraph = false
                } else{
                    document.body.overflow = 'hidden'
                    this.characteristicGraph = true
                }
            },
            openCharacteristicSchemeModal(){
                if (this.characteristicScheme){
                    this.characteristicScheme = false
                } else{
                    document.body.overflow = 'hidden'
                    this.characteristicScheme = true
                }
            },
        }
    }
</script>

<style scoped>
    .characteristic__modal{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        z-index: 20000;
        background: rgba(0, 0, 0, 0.5);
    }
    .characteristic_content{
        max-width: 600px;
        margin: 60px auto;
        height: 80vh;
        background: #272953;
        box-shadow: 0px 7px 7px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        padding: 15px;
    }
    .characteristic__modal.graph,
    .characteristic__modal.scheme{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .characteristic__modal.graph .characteristic_content,
    .characteristic__modal.scheme .characteristic_content{
        max-width: 90%;
        width: 90%;
        height: auto;
    }
    .characteristic_content .characteristic_body{
        margin-top: 15px;
        height: calc(100% - 40px);
        overflow-y: scroll;
        overflow-x: hidden;
    }
    .characteristic_header{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .characteristic_header span{
        font-family: Harmonia Sans Pro Cyr;
        font-style: normal;
        font-weight: bold;
        font-size: 16px;
        line-height: 19px;

        color: #FFFFFF;
    }
    .characteristic_header-close{
        background: #656A8A;
        border-radius: 10px;
        padding:0 15px;
        font-weight: bold;
        font-size: 16px;
        height: 26px;
        cursor: pointer;
    }

    .ml-10{
        padding: 0 10px 0 18px!important;
    }
    .rigs__content{
        background-color: #272953;
        width: 100%;
        height: 675px;
        padding: 0 4px 0;
        position: relative;
        overflow-x: hidden;
        overflow-y: scroll;

    }
    .modalTable td{
        padding: 15px!important;
    }
    .characteristic__modal td{
        padding: 10px 5px!important;
    }
    .characteristic{
        background: #205AA3;
        border: 0.5px solid #454FA1;
        box-shadow: 0px 4px 3px rgba(0, 0, 0, 0.25);
        border-radius: 10px;
        padding: 5px;
        display: flex;
        align-items: center;
        margin: 0 auto;
    }
    .characteristic img{
        margin-left: 5px;
    }
    .characteristic__modal.scheme .characteristic_body{
        height: calc(100vh - 200px);
    }
    .map__content{
        height: calc(100% - 80px);
    }
    .btn__ok{
        border: 0;
        background: #464A8A;
        border-radius: 6px;
        width: 170px;
        height: 26px;
        font-weight: 600;
        font-size: 12px;
        line-height: 14px;

        color: #FFFFFF;
        margin: 25px auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>