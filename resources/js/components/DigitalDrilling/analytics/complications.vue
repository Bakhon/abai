<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle">Осложнения (проект/факт)</p>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table defaultTable rastersParams">
                            <tr>
                                <th colspan="2">Интервал бурения</th>
                                <th>Индекс стратиграфического подразделения</th>
                                <th colspan="2">Проходка, м</th>
                                <th colspan="2">Размер долта, м</th>
                                <th colspan="2">Удельный вес, г/см3 Вязкость по СПВ-5 в сек, Фильтрация см3/30 мин</th>
                                <th colspan="2">Вид осложнения</th>
                                <th>Характеристика фактического осложнения</th>
                            </tr>
                            <tr>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th></th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th>Проект</th>
                                <th>Факт</th>
                                <th></th>
                            </tr>
                            <tr v-for="i in 15">
                                <td v-for="i in 12"></td>
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
        name: "complications"
    }
</script>

<style scoped>

</style>