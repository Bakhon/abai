<template>
    <div class="digitalDrillingTablesPage">
        <div class="digitalDrillingTables-head">
            <div class="digitalDrillingTables-head-title">
                Профиль Скважины
            </div>
            <div class="export_btn">
                Скачать отчет
            </div>
        </div>
        <div class="digitalDrillingTables defaultScroll">
            <div>Табл. 1.6.1 Входные данные по профилю скважины</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="2" colspan="2">
                        Интервал установки погружных насосов по вертикали, м
                    </th>
                    <th rowspan="2" colspan="2">
                        Mаксимально допустимые параметры профиля в интервале установки погружных насосов
                    </th>
                    <th colspan="3">
                        Зенитный угол, град.
                    </th>
                </tr>
                <tr>
                    <th rowspan="2">
                        Максимально  допустимый на интервале его увеличения
                    </th>
                    <th colspan="2">
                        При входе в продуктивный пласт
                    </th>
                </tr>
                <tr>
                    <th>
                        от
                        (верх)
                    </th>
                    <th>
                        до
                        (низ)
                    </th>
                    <th>
                        зенитный угол, град.
                    </th>
                    <th>
                        интенсивность изменения зенитного угла, град./10м
                    </th>
                    <th>
                        минимально допустимый
                    </th>
                    <th>
                        максимально допустимый
                    </th>
                </tr>
                <tr>
                    <td v-for="i in 7">{{ i }}</td>
                </tr>
                <tr>
                    <td rowspan="2" v-for="i in 7"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.6.2 Профиль ствола скважины</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th>Глубина по стволу [m]</th>
                    <th>Зенитный угол [град.]</th>
                    <th>Азимут [град.]</th>
                    <th>Глубина по вертикали [m]</th>
                    <th>Север [m]</th>
                    <th>Восток [m]</th>
                    <th>Интенсивность искривления [град./30m]</th>
                    <th>Горизонтальное отклонение [m]</th>
                </tr>
                <tr>
                    <td v-for="i in 8">{{ i }}</td>
                </tr>
                <tr v-for="i in 5">
                    <td v-for="i in 8"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Координаты точек</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th>Название</th>
                    <th>Скважина</th>
                    <th>Координаты Х</th>
                    <th>Координаты Y</th>
                    <th>Название карты</th>
                </tr>
                <tr>
                    <td v-for="i in 5">{{ i }}</td>
                </tr>
                <tr>
                    <td>Координаты устья</td>
                    <td rowspan="3"></td>
                    <td></td>
                    <td></td>
                    <td rowspan="3"></td>
                </tr>
                <tr>
                    <td>Цель-Т1 </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Цель-Т2 </td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
            <note />
        </div>
    </div>
</template>

<script>
    export default {
        name: "project",
        methods: {

        },
    }
</script>

<style scoped>

</style>