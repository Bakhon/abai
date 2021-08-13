<template>
    <div class="digitalDrillingWindow">
        <window-head @getWellID="getWellID"/>
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle">Паспорт скважины</p>

                <div class="row" v-if="passport">
                    <div class="col-sm-4">
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">План бурения</th>
                            </tr>
                            <tr>
                                <td colspan="1">Дата начала бурения</td>
                                <td colspan="1">20.09.2017</td>
                            </tr>
                            <tr>
                                <td colspan="1">Дата окончания бурения</td>
                                <td colspan="1">23.10.2017</td>
                            </tr>
                        </table>
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">Договор</th>
                            </tr>
                            <tr>
                                <td colspan="1">Подрядчик</td>
                                <td colspan="1">ТОО “Сибу Кызылорда”</td>
                            </tr>
                            <tr>
                                <td colspan="1">Номер договора</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">Дата договора</td>
                                <td colspan="1">20.09.2017</td>
                            </tr>
                        </table>
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">Сводка по бурению</th>
                            </tr>
                            <tr>
                                <td colspan="1">Начало бурения</td>
                                <td colspan="1">20.09.2017 - 00:00</td>
                            </tr>
                            <tr>
                                <td colspan="1">Окончание бурения</td>
                                <td colspan="1">20.09.2017 - 05:15</td>
                            </tr>
                            <tr>
                                <td colspan="1">Общая проходка</td>
                                <td colspan="1">45</td>
                            </tr>
                        </table>
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">Информация по эксплуатационной колонне</th>
                            </tr>
                            <tr>
                                <td colspan="1">Диаметр экспл.колонны</td>
                                <td colspan="1">168.3</td>
                            </tr>
                            <tr>
                                <td colspan="1">Глубина спуска</td>
                                <td colspan="1">2453.64</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table secondTable">
                            <tr>
                                <th colspan="3">Общая информация</th>
                            </tr>
                            <tr>
                                <td colspan="1">1</td>
                                <td colspan="1">Скважина</td>
                                <td>{{this.passport.Скважина}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">2</td>
                                <td colspan="1">Вид скважины</td>
                                <td colspan="1">{{this.passport.Вид}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">3</td>
                                <td colspan="1">Месторождение</td>
                                <td colspan="1">{{this.passport.Месторождение}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">4</td>
                                <td colspan="1">Блок</td>
                                <td colspan="1">{{this.passport.Блок}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">5</td>
                                <td colspan="1">Горизонт</td>
                                <td colspan="1">{{this.passport.Горизонт}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">6</td>
                                <td colspan="1">Тех.структура</td>
                                <td colspan="1">{{this.passport.Тех_структура}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">7</td>
                                <td colspan="1">Орг.структура</td>
                                <td colspan="1">{{this.passport.Орг_струтура}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">8</td>
                                <td colspan="1">Зона скважины</td>
                                <td colspan="1">{{this.passport.Зона}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">9</td>
                                <td colspan="1">Альтитуда устья скважины</td>
                                <td colspan="1">{{this.passport.Альтитуда}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">10</td>
                                <td colspan="1">Координаты Х (устья)</td>
                                <td colspan="1">{{this.passport.Коор_Х_устья}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">11</td>
                                <td colspan="1">Координаты Y (устья)</td>
                                <td colspan="1">{{this.passport.Коор_У_устья}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">12</td>
                                <td colspan="1">Координаты забоя X</td>
                                <td colspan="1">{{this.passport.Коор_Х_заб}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">13</td>
                                <td colspan="1">Координаты забоя Y</td>
                                <td colspan="1">{{this.passport.Коор_У_заб}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">14</td>
                                <td colspan="1"></td>
                                <td colspan="1">{{this.passport.ГДИС}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">15</td>
                                <td colspan="1">Категория</td>
                                <td colspan="1">{{this.passport.Категория}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">16</td>
                                <td colspan="1">Дата ввода в эксплуатацию</td>
                                <td colspan="1">{{this.passport.Экспл_дата}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table secondTable">
                            <tr>
                                <td colspan="1">17</td>
                                <td colspan="1">Буровой подрядчик</td>
                                <td colspan="1">{{this.passport.Подрядчик}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">18</td>
                                <td colspan="1">Проектная глубина</td>
                                <td colspan="1">{{this.passport.Пр_глуб}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">19</td>
                                <td colspan="1">Радиус дренирования</td>
                                <td colspan="1">{{this.passport.Радиус}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">20</td>
                                <td colspan="1">Состояние</td>
                                <td colspan="1">{{this.passport.Состояние}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">21</td>
                                <td colspan="1">Способ эксплуатации</td>
                                <td colspan="1">{{this.passport.Экспл}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">22</td>
                                <td colspan="1">Дин уровень</td>
                                <td colspan="1">{{this.passport.Дин_уров}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">23</td>
                                <td colspan="1">Стат уровень</td>
                                <td colspan="1">{{this.passport.Стат_уровень}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">24</td>
                                <td colspan="1">Рпл / (дата замера)</td>
                                <td colspan="1">{{this.passport.Рпл}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">25</td>
                                <td colspan="1">Рзаб / (дата замера)</td>
                                <td colspan="1">{{this.passport.Рзаб}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">26</td>
                                <td colspan="1">Факт.забой (дата отбивки)</td>
                                <td colspan="1">{{this.passport.Факт_заб}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">27</td>
                                <td colspan="1">Дата последнего КРС</td>
                                <td colspan="1">{{this.passport.КРС}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">28</td>
                                <td colspan="1">Дата последнего ПРС</td>
                                <td colspan="1">{{this.passport.ПРС}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">29</td>
                                <td colspan="1">Дата последнего ГИС</td>
                                <td colspan="1">{{this.passport.ГИС}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name: "passport",
        data() {
            return{
                passport: null
            }
        },
        mounted() {
            if (this.well){
                this.getWellID(this.well.id)
            }
        },
        methods:{
            getWellID(id){
                this.axios.get('http://172.20.103.203:8000/digital_drilling/api/passport/'+id + '/').then((response) => {
                    let data = response.data;
                    if (data) {
                        this.passport = data[0];
                        console.log(this.passport)
                    } else {
                        console.log('No data');
                    }
                });

            },
        },
        computed:{
            well(){
                return this.$store.getters['digitalDrilling/isCurrentWell']
            }
        },

    }
</script>

<style scoped>

</style>