<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Суточные рапорта</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Суточные рапорты по бурению <i class="far fa-calendar"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tbody>
                                <tr>
                                    <th rowspan="3" class="verticalText">Дата</th>
                                    <th rowspan="3"><span>Забой, м</span></th>
                                    <th colspan="24">расшифровка времени на бурение</th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="verticalText"><span>Календарное время, всего</span></th>
                                    <th colspan="5">работа по проходке</th>
                                    <th colspan="8">вспомогательные работы</th>
                                    <th colspan="5">крепление</th>
                                    <th colspan="5">аварийные работы</th>
                                </tr>
                                <tr>
                                    <th colspan="1" class="verticalText"><span>мехбурение</span></th>
                                    <th colspan="1" class="verticalText"><span>отбор керна</span></th>
                                    <th colspan="1" class="verticalText"><span>расширка</span></th>
                                    <th colspan="1" class="verticalText"><span>СПО</span></th>
                                    <th colspan="1" class="verticalText"><span>наращивание</span></th>
                                    <th colspan="1" class="verticalText"><span>ПЗР</span></th>
                                    <th colspan="1" class="verticalText"><span>проработка</span></th>
                                    <th colspan="1" class="verticalText"><span>промывка</span></th>
                                    <th colspan="1" class="verticalText"><span>спо при проработке</span></th>
                                    <th colspan="1" class="verticalText"><span>обработка/ приготовление раствора</span></th>
                                    <th colspan="1" class="verticalText"><span>сборка/ разборка компоновки</span></th>
                                    <th colspan="1" class="verticalText"><span>смена тальканата</span></th>
                                    <th colspan="1" class="verticalText"><span>прочие вспом</span></th>
                                    <th colspan="1" class="verticalText"><span>спуск колон</span></th>
                                    <th colspan="1" class="verticalText"><span>цементаж</span></th>
                                    <th colspan="1" class="verticalText"><span>ОЗЦ</span></th>
                                    <th colspan="1" class="verticalText"><span>оборудов. устья и оппресовка</span></th>
                                    <th colspan="1" class="verticalText"><span>разбурив ц/ст</span></th>
                                    <th colspan="1" class="verticalText"><span>расхаживание и промывка</span></th>
                                    <th colspan="1" class="verticalText"><span>правильные и разбурочные работы</span></th>
                                    <th colspan="1" class="verticalText"><span>компоновка и СПО ловильного инст-та</span></th>
                                    <th colspan="1" class="verticalText"><span>прочие</span></th>
                                    <th colspan="1" class="verticalText"><span>устан-ка нефтян. ванны и техстоянка</span></th>
                                </tr>
                                <tr>
                                    <td v-for="i in 26">{{i+1}}</td>
                                </tr>
                                <tr v-for="i in 10">
                                    <td v-for="i in 26"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "reports"
    }
</script>

<style scoped>
th, td{
    padding: 0.5rem!important;
    font-size: 10px!important;
}

</style>