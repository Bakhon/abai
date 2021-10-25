<template>
    <div class="digitalDrillingTablesPage">
        <div class="digitalDrillingTables-head">
            <div class="digitalDrillingTables-head-title">
                {{ trans('digital_drilling.project_data.BR_component')}}
            </div>
            <div class="export_btn" @click="download = !download">
                Скачать отчет
            </div>
        </div>
        <div class="digitalDrillingTables defaultScroll">
            <div>Табл. 7.2 Компонентный состав бурового раствора и характеристика компонентов</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="2">
                        Номер интервала с одинако-вым долевым составом бурового раствора
                    </th>
                    <th colspan="2">
                        Интервал, м
                    </th>
                    <th rowspan="2">
                        Наименование (тип) раствора
                    </th>
                    <th rowspan="2">
                        Плотность раствора,
                        г/см3
                    </th>
                    <th rowspan="2">
                        Смена раствора  для бурения интервала (да, нет)
                    </th>
                    <th rowspan="2">
                        Наименование компонента
                    </th>
                    <th rowspan="2">
                        Плотность компонента,
                        г/см3
                    </th>
                    <th rowspan="2">
                        Содержание компонента в буровом растворе, кг/м3
                    </th>
                    <th rowspan="2">
                        Примечания
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
                </tr>
                <tr>
                    <td v-for="i in 10">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 10"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 7.3. Потребность бурового раствора и компонентов (товарный продукт) для его приготовления, обработки и утяжеления</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th colspan="2">
                        Интервал, м
                    </th>
                    <th rowspan="2">
                        Коэффициент запаса раствора на поверхности
                    </th>
                    <th rowspan="2">
                        Название (тип) бурового раствора и его компонентов
                    </th>
                    <th rowspan="2">
                        Нормы расхода компонентов бурового раствора, кг/м3 в интервале
                    </th>
                    <th colspan="4">
                        Потребность бурового раствора (м3) и его компонентов (кг)
                    </th>
                    <th rowspan="2">Примечания</th>
                </tr>
                <tr>
                    <th>
                        от
                        (верх)
                    </th>
                    <th>
                        до
                        (низ
                    </th>
                    <th>на запас на поверхности</th>
                    <th>на исходный объем</th>
                    <th>на бурение интервала</th>
                    <th>суммарная в интервале</th>
                </tr>
                <tr>
                    <td v-for="i in 10">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 10"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Таблица 7.4. Потребность воды или компонентов для обработки бурового раствора при разбуривании цементных стаканов</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th>
                        Номер колонны в порядке спуска
                    </th>
                    <th>
                        Наименование колонны
                    </th>
                    <th>
                        Номер раздельно спускаемой части колонны в порядке спуска
                    </th>
                    <th>
                        Номер ступени цементирования
                    </th>
                    <th>
                        Наименование компонента для обработки раствора
                    </th>
                    <th>
                        Плотность компонента, г/см3
                    </th>
                    <th>
                        Норма расхода на обработку 1 м3 раствора, кг/м3
                    </th>
                    <th>
                        Количество, кг
                    </th>
                    <th>
                        Примечания
                    </th>
                </tr>
                <tr>
                    <td v-for="i in 9">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 9"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Таблица 7.5. Потребность компонентов для обработки бурового раствора при спуске обсадных колонн</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th>
                        Номер колонны в порядке спуска
                    </th>
                    <th>
                        Наименование колонны
                    </th>
                    <th>
                        Наименование компонента для обработки раствора
                    </th>
                    <th>
                        Плотность компонента, г/см3
                    </th>
                    <th>
                        Норма расхода на обработку 1 м3 раствора, кг/м3
                    </th>
                    <th>
                        Количество, кг
                    </th>
                    <th>
                        Примечания
                    </th>
                </tr>
                <tr>
                    <td v-for="i in 7">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 7"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 7.6. Суммарная потребность компонентов бурового раствора на скважину(вариант 1)
            </div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th>
                        №№ п/п
                    </th>
                    <th>
                        Наименование компонента бур. раствора
                    </th>
                    <th>
                        ГОСТ, ОСТ, ТУ, МРТУ, МУ и т.д. изготовление
                    </th>
                    <th colspan="4">
                        Потребность компонентов бурового раствора на интервале, тн
                    </th>
                    <th>
                        Суммарная,тн
                    </th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>0-30</td>
                    <td>30-160</td>
                    <td>160-740</td>
                    <td>740-1060</td>
                    <td></td>
                </tr>
                <tr>
                    <td v-for="i in 8">{{i}}</td>
                </tr>
                <tr v-for="i in 16">
                    <td>{{i}}</td>
                    <td v-for="i in 7"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Таблица 7.6. Суммарная потребность компонентов бурового раствора на скважину </div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="6">Наименование компонентовбурового раствора</th>
                    <th colspan="22">Потребность компонентов бурового раствора, т</th>
                    <th rowspan="6">Всего на бурение</th>
                    <th rowspan="6">Всего с запасом на скважину</th>
                </tr>
                <tr>
                    <th colspan="22">номера колонн (см. табл. 5.2, гр. 1)</th>
                </tr>
                <tr>
                    <th colspan="2" v-for="i in 5">{{i+1}}</th>
                    <th colspan="2" v-for="i in 6">{{i}}</th>
                </tr>
                <tr>
                    <th colspan="10">Запасной  раствор в интервале, м</th>
                    <th colspan="12">Бурение в интервале, м</th>
                </tr>
                <tr>
                    <th v-for="i in 22">
                        <span v-if="i%2==1">от (верх)</span>
                        <span v-else>до (низ)</span>
                    </th>
                </tr>
                <tr>
                    <th v-for="i in 22"></th>
                </tr>
                <tr>
                    <td v-for="i in 25">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 25"></td>
                </tr>
                </tbody>
            </table>
            <div>Таблица 7.7. Оборудование для приготовления и очистки буровых растворов </div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="3">Наименование оборудования</th>
                    <th rowspan="3">Количество, шт.</th>
                    <th colspan="3">Использование очистных устройств</th>
                    <th rowspan="3">Примечания</th>
                </tr>
                <tr>
                    <th rowspan="2">
                        ступенчатость очистки:
                        1 - вибросито;
                        2 - 1+пескоотделитель;
                        3 - 2+илоотделитель;
                        4 – 3+центрифуга
                    </th>
                    <th colspan="2">Интервал (по стволу), м</th>
                </tr>
                <tr>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                </tr>
                <tr>
                    <td v-for="i in 6">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 6"></td>
                </tr>
                </tbody>
            </table>
            <note />
        </div>
        <report-download v-if="download" @close="download = !download">
            <template #tableBody>
                <div class="name">Компонентный состав БР</div>
                <div class="black">Табл. 7.2 Компонентный состав бурового раствора и характеристика компонентов</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="2">
                            Номер интервала с одинако-вым долевым составом бурового раствора
                        </th>
                        <th colspan="2">
                            Интервал, м
                        </th>
                        <th rowspan="2">
                            Наименование (тип) раствора
                        </th>
                        <th rowspan="2">
                            Плотность раствора,
                            г/см3
                        </th>
                        <th rowspan="2">
                            Смена раствора  для бурения интервала (да, нет)
                        </th>
                        <th rowspan="2">
                            Наименование компонента
                        </th>
                        <th rowspan="2">
                            Плотность компонента,
                            г/см3
                        </th>
                        <th rowspan="2">
                            Содержание компонента в буровом растворе, кг/м3
                        </th>
                        <th rowspan="2">
                            Примечания
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
                    </tr>
                    <tr>
                        <td v-for="i in 10">{{i}}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 10"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 7.3. Потребность бурового раствора и компонентов (товарный продукт) для его приготовления, обработки и утяжеления</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th colspan="2">
                            Интервал, м
                        </th>
                        <th rowspan="2">
                            Коэффициент запаса раствора на поверхности
                        </th>
                        <th rowspan="2">
                            Название (тип) бурового раствора и его компонентов
                        </th>
                        <th rowspan="2">
                            Нормы расхода компонентов бурового раствора, кг/м3 в интервале
                        </th>
                        <th colspan="4">
                            Потребность бурового раствора (м3) и его компонентов (кг)
                        </th>
                        <th rowspan="2">Примечания</th>
                    </tr>
                    <tr>
                        <th>
                            от
                            (верх)
                        </th>
                        <th>
                            до
                            (низ
                        </th>
                        <th>на запас на поверхности</th>
                        <th>на исходный объем</th>
                        <th>на бурение интервала</th>
                        <th>суммарная в интервале</th>
                    </tr>
                    <tr>
                        <td v-for="i in 10">{{i}}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 10"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Таблица 7.4. Потребность воды или компонентов для обработки бурового раствора при разбуривании цементных стаканов</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th>
                            Номер колонны в порядке спуска
                        </th>
                        <th>
                            Наименование колонны
                        </th>
                        <th>
                            Номер раздельно спускаемой части колонны в порядке спуска
                        </th>
                        <th>
                            Номер ступени цементирования
                        </th>
                        <th>
                            Наименование компонента для обработки раствора
                        </th>
                        <th>
                            Плотность компонента, г/см3
                        </th>
                        <th>
                            Норма расхода на обработку 1 м3 раствора, кг/м3
                        </th>
                        <th>
                            Количество, кг
                        </th>
                        <th>
                            Примечания
                        </th>
                    </tr>
                    <tr>
                        <td v-for="i in 9">{{i}}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 9"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Таблица 7.5. Потребность компонентов для обработки бурового раствора при спуске обсадных колонн</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th>
                            Номер колонны в порядке спуска
                        </th>
                        <th>
                            Наименование колонны
                        </th>
                        <th>
                            Наименование компонента для обработки раствора
                        </th>
                        <th>
                            Плотность компонента, г/см3
                        </th>
                        <th>
                            Норма расхода на обработку 1 м3 раствора, кг/м3
                        </th>
                        <th>
                            Количество, кг
                        </th>
                        <th>
                            Примечания
                        </th>
                    </tr>
                    <tr>
                        <td v-for="i in 7">{{i}}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 7"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 7.6. Суммарная потребность компонентов бурового раствора на скважину(вариант 1)
                </div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th>
                            №№ п/п
                        </th>
                        <th>
                            Наименование компонента бур. раствора
                        </th>
                        <th>
                            ГОСТ, ОСТ, ТУ, МРТУ, МУ и т.д. изготовление
                        </th>
                        <th colspan="4">
                            Потребность компонентов бурового раствора на интервале, тн
                        </th>
                        <th>
                            Суммарная,тн
                        </th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>0-30</td>
                        <td>30-160</td>
                        <td>160-740</td>
                        <td>740-1060</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td v-for="i in 8">{{i}}</td>
                    </tr>
                    <tr v-for="i in 16">
                        <td>{{i}}</td>
                        <td v-for="i in 7"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Таблица 7.6. Суммарная потребность компонентов бурового раствора на скважину </div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="6">Наименование компонентовбурового раствора</th>
                        <th colspan="22">Потребность компонентов бурового раствора, т</th>
                        <th rowspan="6">Всего на бурение</th>
                        <th rowspan="6">Всего с запасом на скважину</th>
                    </tr>
                    <tr>
                        <th colspan="22">номера колонн (см. табл. 5.2, гр. 1)</th>
                    </tr>
                    <tr>
                        <th colspan="2" v-for="i in 5">{{i+1}}</th>
                        <th colspan="2" v-for="i in 6">{{i}}</th>
                    </tr>
                    <tr>
                        <th colspan="10">Запасной  раствор в интервале, м</th>
                        <th colspan="12">Бурение в интервале, м</th>
                    </tr>
                    <tr>
                        <th v-for="i in 22">
                            <span v-if="i%2==1">от (верх)</span>
                            <span v-else>до (низ)</span>
                        </th>
                    </tr>
                    <tr>
                        <th v-for="i in 22"></th>
                    </tr>
                    <tr>
                        <td v-for="i in 25">{{i}}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 25"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Таблица 7.7. Оборудование для приготовления и очистки буровых растворов </div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="3">Наименование оборудования</th>
                        <th rowspan="3">Количество, шт.</th>
                        <th colspan="3">Использование очистных устройств</th>
                        <th rowspan="3">Примечания</th>
                    </tr>
                    <tr>
                        <th rowspan="2">
                            ступенчатость очистки:
                            1 - вибросито;
                            2 - 1+пескоотделитель;
                            3 - 2+илоотделитель;
                            4 – 3+центрифуга
                        </th>
                        <th colspan="2">Интервал (по стволу), м</th>
                    </tr>
                    <tr>
                        <th>от (верх)</th>
                        <th>до (низ)</th>
                    </tr>
                    <tr>
                        <td v-for="i in 6">{{i}}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 6"></td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </report-download>
    </div>
</template>

<script>
    export default {
        name: "rasters-component",
        data(){
            return{
                download: false
            }
        },
    }
</script>

<style scoped>

</style>