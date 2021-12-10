<template>
    <div class="digitalDrillingTablesPage">
        <div class="digitalDrillingTables-head">
            <div class="digitalDrillingTables-head-title">
                {{ trans('digital_drilling.project_data.BR_parameters')}}
            </div>
            <div class="export_btn" @click="download =!download">
                Скачать отчет
            </div>
        </div>
        <div class="digitalDrillingTables defaultScroll">
            <div>Таблица 7.1a. Типы и параметры буровых растворов (для растворов на водной основе)</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="4">Наименование (тип) раствора</th>
                    <th colspan="2">Интервал (по стволу), м</th>
                    <th colspan="16">Параметры бурового раствора</th>
                    <th rowspan="4">Примечания</th>
                </tr>
                <tr>
                    <th rowspan="3">от (верх)</th>
                    <th rowspan="3">до (низ)</th>
                    <th rowspan="3">Плотность,  г/см3</th>
                    <th rowspan="3">Условная вязкость, сек</th>
                    <th rowspan="3">Пластическая вязкость, сП</th>
                    <th rowspan="3">Динамическое напряжение сдвига, фунт/100 фут2</th>
                    <th colspan="2">Статическое напряжение сдвига, фунт/100 фут2, через</th>
                    <th colspan="3">Фильтрация (водоотдача), см3 / 30 мин</th>
                    <th rowspan="3">Корка, мм</th>
                    <th rowspan="3">рН</th>
                    <th rowspan="3">Минерализация, мг/л</th>
                    <th rowspan="3">Содержание ионов K+ в фильтрате, мг/л</th>
                    <th colspan="3">Содержание твёрдой фазы</th>
                </tr>
                <tr>
                    <th rowspan="2">10 сек</th>
                    <th rowspan="2">10 мин</th>
                    <th rowspan="2">При низкой температуре / низком давлении  (API FL)</th>
                    <th colspan="2">При высокой температуре /высоком давлении (HTHP FL)</th>
                    <th rowspan="2">Коллоидной (активной) части – по тесту метиленовой сини (MBT), кг/м3</th>
                    <th colspan="2">Выбуренной породы, об.%</th>
                </tr>
                <tr>
                    <th>Температура испытания, ℃</th>
                    <th>Фильтрат, см3</th>
                    <th>Всего</th>
                    <th>В т.ч. песка</th>
                </tr>
                <tr>
                    <td v-for="i in 20">{{ i }}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 20"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Таблица 7.1b. Типы и параметры буровых растворов (для растворов на углеводородной основе)</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="4">Наименование (тип) раствора</th>
                    <th colspan="2">Интервал (по стволу), м</th>
                    <th colspan="13">Параметры бурового раствора</th>
                    <th rowspan="4">Примечания</th>
                </tr>
                <tr>
                    <th rowspan="3">от (верх)</th>
                    <th rowspan="3">до (низ)</th>
                    <th rowspan="3">Плотность,  г/см3</th>
                    <th rowspan="3">Пластическая вязкость, сП</th>
                    <th rowspan="3">Динамическое напряжение сдвига, фунт/100 фут2</th>
                    <th colspan="2">Статическое напряжение сдвига, фунт/100 фут2, через</th>
                    <th colspan="3">Фильтрация (водоотдача), см3 / 30 мин</th>
                    <th rowspan="3">Содержание твердых частиц, об. %</th>
                    <th rowspan="3">Избыточная известь, кг/м3</th>
                    <th rowspan="3">Электростабильность, V</th>
                    <th rowspan="3">Солёность водной фазы, мг/л</th>
                    <th rowspan="3">Отношение Масло/ Вода, об. % / об. %</th>
                </tr>
                <tr>
                    <th rowspan="2">10 сек</th>
                    <th rowspan="2">10 мин</th>
                    <th rowspan="2">При низкой температуре / низком давлении  (API FL)</th>
                    <th colspan="2">При высокой температуре /высоком давлении (HTHP FL)</th>
                </tr>
                <tr>
                    <th>Температура испытания, ℃</th>
                    <th>Фильтрат, см3</th>
                </tr>
                <tr>
                    <td v-for="i in 17">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 17"></td>
                </tr>
                </tbody>
            </table>
            <note />
        </div>
        <report-download v-if="download" @close="download = !download">
            <template #tableBody>
                <div class="name">
                    Параметры БР
                </div>
                <div class="black">Таблица 7.1a. Типы и параметры буровых растворов (для растворов на водной основе)</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="4">Наименование (тип) раствора</th>
                        <th colspan="2">Интервал (по стволу), м</th>
                        <th colspan="16">Параметры бурового раствора</th>
                        <th rowspan="4">Примечания</th>
                    </tr>
                    <tr>
                        <th rowspan="3">от (верх)</th>
                        <th rowspan="3">до (низ)</th>
                        <th rowspan="3">Плотность,  г/см3</th>
                        <th rowspan="3">Условная вязкость, сек</th>
                        <th rowspan="3">Пластическая вязкость, сП</th>
                        <th rowspan="3">Динамическое напряжение сдвига, фунт/100 фут2</th>
                        <th colspan="2">Статическое напряжение сдвига, фунт/100 фут2, через</th>
                        <th colspan="3">Фильтрация (водоотдача), см3 / 30 мин</th>
                        <th rowspan="3">Корка, мм</th>
                        <th rowspan="3">рН</th>
                        <th rowspan="3">Минерализация, мг/л</th>
                        <th rowspan="3">Содержание ионов K+ в фильтрате, мг/л</th>
                        <th colspan="3">Содержание твёрдой фазы</th>
                    </tr>
                    <tr>
                        <th rowspan="2">10 сек</th>
                        <th rowspan="2">10 мин</th>
                        <th rowspan="2">При низкой температуре / низком давлении  (API FL)</th>
                        <th colspan="2">При высокой температуре /высоком давлении (HTHP FL)</th>
                        <th rowspan="2">Коллоидной (активной) части – по тесту метиленовой сини (MBT), кг/м3</th>
                        <th colspan="2">Выбуренной породы, об.%</th>
                    </tr>
                    <tr>
                        <th>Температура испытания, ℃</th>
                        <th>Фильтрат, см3</th>
                        <th>Всего</th>
                        <th>В т.ч. песка</th>
                    </tr>
                    <tr>
                        <td v-for="i in 20">{{ i }}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 20"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Таблица 7.1b. Типы и параметры буровых растворов (для растворов на углеводородной основе)</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="4">Наименование (тип) раствора</th>
                        <th colspan="2">Интервал (по стволу), м</th>
                        <th colspan="13">Параметры бурового раствора</th>
                        <th rowspan="4">Примечания</th>
                    </tr>
                    <tr>
                        <th rowspan="3">от (верх)</th>
                        <th rowspan="3">до (низ)</th>
                        <th rowspan="3">Плотность,  г/см3</th>
                        <th rowspan="3">Пластическая вязкость, сП</th>
                        <th rowspan="3">Динамическое напряжение сдвига, фунт/100 фут2</th>
                        <th colspan="2">Статическое напряжение сдвига, фунт/100 фут2, через</th>
                        <th colspan="3">Фильтрация (водоотдача), см3 / 30 мин</th>
                        <th rowspan="3">Содержание твердых частиц, об. %</th>
                        <th rowspan="3">Избыточная известь, кг/м3</th>
                        <th rowspan="3">Электростабильность, V</th>
                        <th rowspan="3">Солёность водной фазы, мг/л</th>
                        <th rowspan="3">Отношение Масло/ Вода, об. % / об. %</th>
                    </tr>
                    <tr>
                        <th rowspan="2">10 сек</th>
                        <th rowspan="2">10 мин</th>
                        <th rowspan="2">При низкой температуре / низком давлении  (API FL)</th>
                        <th colspan="2">При высокой температуре /высоком давлении (HTHP FL)</th>
                    </tr>
                    <tr>
                        <th>Температура испытания, ℃</th>
                        <th>Фильтрат, см3</th>
                    </tr>
                    <tr>
                        <td v-for="i in 17">{{i}}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 17"></td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </report-download>

    </div>
</template>

<script>
    export default {
        name: "rasters-params",
        data(){
            return{
                download: false
            }
        },
    }
</script>

<style scoped>

</style>