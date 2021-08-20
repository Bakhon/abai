<template>
    <div class="digitalDrillingWindow">
        <window-head @getWellID="getWellID"/>
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle">{{ trans('digital_drilling.passport.well_passport') }}</p>

                <div class="row" v-if="passport">
                    <div class="col-sm-4">
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">{{ trans('digital_drilling.passport.drilling_plan') }}</th>
                            </tr>
                            <tr>
                                <td colspan="1">{{ trans('digital_drilling.passport.drilling_start_date') }}</td>
                                <td colspan="1">20.09.2017</td>
                            </tr>
                            <tr>
                                <td colspan="1">{{ trans('digital_drilling.passport.drilling_end_date') }}</td>
                                <td colspan="1">23.10.2017</td>
                            </tr>
                        </table>
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">{{ trans('digital_drilling.passport.contract') }}</th>
                            </tr>
                            <tr>
                                <td colspan="1">{{ trans('digital_drilling.passport.contractor') }}</td>
                                <td colspan="1">ТОО “Сибу Кызылорда”</td>
                            </tr>
                            <tr>
                                <td colspan="1">{{ trans('digital_drilling.passport.contract_number') }}</td>
                                <td colspan="1"></td>
                            </tr>
                            <tr>
                                <td colspan="1">Дата договора</td>
                                <td colspan="1">20.09.2017</td>
                            </tr>
                        </table>
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">{{ trans('digital_drilling.passport.drilling_summary') }}</th>
                            </tr>
                            <tr>
                                <td colspan="1">{{ trans('digital_drilling.passport.drilling_start') }}</td>
                                <td colspan="1">20.09.2017 - 00:00</td>
                            </tr>
                            <tr>
                                <td colspan="1">{{ trans('digital_drilling.passport.drilling_end') }}</td>
                                <td colspan="1">20.09.2017 - 05:15</td>
                            </tr>
                            <tr>
                                <td colspan="1">{{ trans('digital_drilling.passport.total_penetration') }}</td>
                                <td colspan="1">45</td>
                            </tr>
                        </table>
                        <table class="table firstTable">
                            <tr>
                                <th colspan="2">{{ trans('digital_drilling.passport.production_casing_information') }}</th>
                            </tr>
                            <tr>
                                <td colspan="1">{{ trans('digital_drilling.passport.column_diameter') }}</td>
                                <td colspan="1">168.3</td>
                            </tr>
                            <tr>
                                <td colspan="1">{{ trans('digital_drilling.passport.descent_depth') }}</td>
                                <td colspan="1">2453.64</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table secondTable">
                            <tr>
                                <th colspan="3">{{ trans('digital_drilling.passport.general_information') }}</th>
                            </tr>
                            <tr>
                                <td colspan="1">1</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.well') }}</td>
                                <td>{{this.passport.Скважина}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">2</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.well_type') }}</td>
                                <td colspan="1">{{this.passport.Вид}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">3</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.field') }}</td>
                                <td colspan="1">{{this.passport.Месторождение}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">4</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.block') }}</td>
                                <td colspan="1">{{this.passport.Блок}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">5</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.horizon') }}</td>
                                <td colspan="1">{{this.passport.Горизонт}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">6</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.technical_structure') }}</td>
                                <td colspan="1">{{this.passport.Тех_структура}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">7</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.organizational_structure') }}</td>
                                <td colspan="1">{{this.passport.Орг_струтура}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">8</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.well_zone') }}</td>
                                <td colspan="1">{{this.passport.Зона}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">9</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.wellhead_altitude') }}</td>
                                <td colspan="1">{{this.passport.Альтитуда}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">10</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.X_coordinates_mouth') }}</td>
                                <td colspan="1">{{this.passport.Коор_Х_устья}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">11</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.Y_coordinates_mouth') }}</td>
                                <td colspan="1">{{this.passport.Коор_У_устья}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">12</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.downhole_coordinates_X') }}</td>
                                <td colspan="1">{{this.passport.Коор_Х_заб}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">13</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.downhole_coordinates_Y') }}</td>
                                <td colspan="1">{{this.passport.Коор_У_заб}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">14</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.category') }}</td>
                                <td colspan="1">{{this.passport.Категория}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">15</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.commissioning_date') }}</td>
                                <td colspan="1">{{this.passport.Экспл_дата}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table secondTable">
                            <tr>
                                <td colspan="1">16</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.design_depth') }}</td>
                                <td colspan="1">{{this.passport.Пр_глуб}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">17</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.state') }}</td>
                                <td colspan="1">{{this.passport.Состояние}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">18</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.method_operation') }}</td>
                                <td colspan="1">{{this.passport.Экспл}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">19</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.dean_level') }}</td>
                                <td colspan="1">{{this.passport.Дин_уров}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">20</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.stat_level') }}</td>
                                <td colspan="1">{{this.passport.Стат_уровень}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">21</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.Rpl_date_measurement') }}</td>
                                <td colspan="1">{{this.passport.Рпл}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">22</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.Rzab_date_measurement') }}</td>
                                <td colspan="1">{{this.passport.Рзаб}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">23</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.fact_boggle_beat_date') }}</td>
                                <td colspan="1">{{this.passport.Факт_заб}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">24</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.date_last_workover') }}</td>
                                <td colspan="1">{{this.passport.КРС}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">25</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.date_last_ORS') }}</td>
                                <td colspan="1">{{this.passport.ПРС}}</td>
                            </tr>
                            <tr>
                                <td colspan="1">26</td>
                                <td colspan="1">{{ trans('digital_drilling.passport.date_last_GIS') }}</td>
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
    import {digitalDrillingState} from '@store/helpers';

    export default {
        name: "passport",
        data() {
            return{
                passport: null
            }
        },
        mounted() {
            if (this.currentWell){
                this.getWellID(this.currentWell.id)
            }
        },
        methods:{
            getWellID(id){
                this.axios.get(process.env.MIX_DIGITAL_DRILLING_URL + '/digital_drilling/api/passport/'+id + '/').then((response) => {
                    let data = response.data;
                    if (data) {
                        this.passport = data[0];
                    } else {
                        console.log('No data');
                    }
                });

            },
        },
        computed:{
            ...digitalDrillingState([
                'currentWell'
            ]),
        },

    }
</script>

<style scoped>

</style>