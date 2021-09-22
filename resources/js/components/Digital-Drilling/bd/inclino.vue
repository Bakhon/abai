<template>
    <div class="digitalDrillingWindow">
        <main-content
            left_content="Табличные данные"
            right_content="Визуализация"
        >
            <template #left_function>
                <div class="inc__left_functions">
                    <img src="/img/digital-drilling/excel-icon.png" alt="">
                    Выгрузить в MS-Excel
                </div>
            </template>
            <template #content_body>
                <div class="table">
                    <table class="table defaultTable">
                        <tbody>
                        <tr>
                            <th colspan="3">План</th>
                            <th colspan="3">Факт</th>
                        </tr>
                        <tr>
                            <th>Глубина по стволу, м</th>
                            <th>зенитный угол, гр.</th>
                            <th>азимут, гр.</th>
                            <th>Глубина по стволу, м</th>
                            <th>зенитный угол, гр.</th>
                            <th>азимут, гр.</th>
                        </tr>
                        <tr v-for="i in 20">
                            <td v-for="i in 6"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </template>
            <template #right_function>
                <div class="inc__right_functions">
                    <div class="inc__2d"
                        :class="{not_active: !d2_Show}"
                    >
                        <div class="inc__2d-title">2D</div>
                        <div class="inc__2d-name">окно</div>
                        <div class="inc__2d-close" v-if="d2_Show">
                            <img src="/img/digital-drilling/inc-graph-close.png" alt="">
                        </div>
                    </div>
                    <div class="inc__2d"
                         :class="{not_active: !d3_Show}"
                    >
                        <div class="inc__2d-title">3D</div>
                        <div class="inc__2d-name">окно</div>
                        <div class="inc__2d-close" v-if="d3_Show">
                            <img src="/img/digital-drilling/inc-graph-close.png" alt="">
                        </div>
                    </div>
                </div>
            </template>
        </main-content>
    </div>
</template>

<script>
    import MainContent from '../components/MainContent'
    export default {
        name: "inclino",
        components: {MainContent},
        data(){
            return{
                d2_Show: true,
                d3_Show: false,

            }
        }
    }
</script>

<style scoped>
    .inc__left_functions{
        display: flex;
        align-items: center;
    }
    .inc__left_functions img{
        margin-right: 8px;
    }
    .inc__right_functions{
        display: flex;
        align-items: center;
    }
    .inc__2d{
        display: flex;
        align-items: center;
        background: #2E50E9;
        padding: 6px 10px;
        border-radius: 6px;
        margin-right: 5px;
        cursor: pointer;
    }
    .inc__2d.not_active{
        opacity: 0.5;
    }
    .inc__2d-title{
        padding: 3px 5px;
        font-weight: bold;
        border-radius: 6px;
        background-color: #FFFFFF;
        margin-right: 7px;
        color: blue;
    }
    .inc__2d-close{
        margin-left: 10px;
    }
</style>