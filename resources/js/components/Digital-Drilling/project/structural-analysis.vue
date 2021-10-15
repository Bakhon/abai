<template>
    <div class="digitalDrillingTablesPage">
        <div class="digitalDrillingTables-head">
            <div class="digitalDrillingTables-head-title">
                Расчет конструкции
            </div>
            <div class="export_btn">
                Скачать отчет
            </div>
        </div>
        <div class="digitalDrillingTables defaultScroll">
            <div>Табл. 1.5.1 Характеристика и устройство шахтового направления</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th colspan="6">Хapaктepиcтикa тpубы</th>
                    <th rowspan="2">Пoдгoтoвкa шaxты или cтвoлa, cпуcк и кpeплeниe нaпpaвлeния</th>
                </tr>
                <tr>
                    <th>нapужный диaмeтp, мм</th>
                    <th>длина, м</th>
                    <th>мapкa (гpуппa пpoчнocти) мaтepиaла</th>
                    <th>тoлщинa cтeнки, мм</th>
                    <th>мacca, т</th>
                    <th>ГOCТ, OCТ, ТУ, МPТУ, МУ и т. д. нa изгoтoвлeниe</th>
                </tr>
                <tr>
                    <td v-for="i in 7">{{i}}</td>
                </tr>
                <tr>
                    <td rowspan="2" colspan="7"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.5.2 Глубина спуска и характеристика обсадных колонн</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="2">Номер колонны в порядке спуска</th>
                    <th rowspan="2">Название колонны  (направление, кондуктор, первая и последующие, промежуточные, заменяющая, надставка, эксплуатационная) или открытый ствол</th>
                    <th colspan="2">Интервал по стволу  скважины (установка колонны или открытый ствол), м</th>
                    <th rowspan="2">Номинальный диаметр ствола скважины (долота) в интервале, мм</th>
                    <th rowspan="2">Высота подъема тампонажного раствора за колонно</th>
                    <th rowspan="2">Количество  раздельно спускаемых частей колонны, шт.</th>
                    <th rowspan="2">Номер раздельно спускае-мой части в порядке спуска</th>
                    <th colspan="2">Интервал установки раздельно спускаемой части, м</th>
                    <th rowspan="2">Необходимость (причина) спуска колонны (в т.ч. в один прием или секциями), установки надставки, смены или поворота секции</th>
                </tr>
                <tr>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                </tr>
                <tr>
                    <td v-for="i in 11">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 11"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.5.3 Характеристика раздельно спускаемых частей обсадных колонн</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="4">Номер колонны в порядке спуска (см. табл. 5.2, гр.1)</th>
                    <th colspan="13">Раздельно спускаемые части</th>
                </tr>
                <tr>
                    <th rowspan="3">номер в порядке спуска (см. табл. 5.2., гр. 8)</th>
                    <th rowspan="3">количество диаметров, шт.</th>
                    <th rowspan="3">номер одноразмерной части в порядке спуска</th>
                    <th rowspan="3">наружный диаметр, мм</th>
                    <th rowspan="2" colspan="2">интервал установки одноразмерной части (по стволу), м</th>
                    <th rowspan="3">ограничение на толщину стенки, не более, мм</th>
                    <th colspan="6">соединения обсадных труб в каждой одноразмерной части</th>
                </tr>
                <tr>
                    <th rowspan="2">кол-во типов сединений, шт</th>
                    <th rowspan="2">номер в порядке спуска</th>
                    <th rowspan="2">условный код типа соединения</th>
                    <th rowspan="2">максимальный наружный диаметр соединения, м</th>
                    <th colspan="2">интервал установки труб с заданным типом соединения, м</th>
                </tr>
                <tr>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                </tr>
                <tr>
                    <td v-for="i in 14">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 14"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.5.4 Tехнико-технологические мероприятия, предусмотренные при строительстве скважины по проектной конструкции</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th>П/П</th>
                    <th>НAИМEНOВAНИE МEPOПPИЯТИЯ ИЛИ КРАТКОЕ ОПИСАНИЕ</th>
                    <th>ПPИЧИНA ПPOВEДEНИЯ МEPOПPИЯТИЯ</th>
                </tr>
                <tr>
                    <td v-for="i in 3">{{i}}</td>
                </tr>
                <tr v-for="i in 15">
                    <td>{{i}}</td>
                    <td v-for="i in 2"></td>
                </tr>
                </tbody>
            </table>
            <note />
        </div>

    </div>
</template>

<script>
    export default {
        name: "structural-analysis",
        methods: {

        },
    }
</script>

<style scoped>

</style>