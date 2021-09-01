<template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Углубление скважины</p>
                <div class="dropdown">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        {{ trans(mainTable.name) }} <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu" id="dropdown-menu1">
                        <a class="dropdown-item" v-for="table in main_tables" v-if="mainTable.name!=table.name" @click="changeTable(table)">{{ trans(table.name) }}</a>
                    </div>
                </div>
                <div class="report_generation">
                    <button @click="reportModalActive=true">Формировать отчет</button>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <keep-alive>
                            <component v-bind:is="mainTable.component"></component>
                        </keep-alive>
                    </div>
                </div>
            </div>
        </div>
        <reportGeneration
                @closeReportModal="closeReportModal"
                v-if="reportModalActive"
                title="Углубление скважины"
        >
            <slot>
                <div>Табл. 1.8.1. Способы, режимы бурения, расширки (проработки) ствола скважины и применяемые КНБК</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th colspan="2">
                                Интервал (по столу), м
                            </th>
                            <th rowspan="2">
                                Вид технологической операции (бурение, отбор керна, расширка, проработка)
                            </th>
                            <th rowspan="2">
                                Способ бурения
                            </th>
                            <th rowspan="2">
                                Условный номер, КНБК
                                (см. табл. 8.2)
                            </th>
                            <th colspan="3">
                                Режим бурения
                            </th>
                            <th rowspan="2">
                                Скорость выполнения технологической операции, м/час
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
                                осевая нагрузка, тс
                            </th>
                            <th>
                                скорость вращения, об/мин
                            </th>
                            <th>
                                расход бурового раствора, л/с
                            </th>
                        </tr>
                        <tr>
                            <td v-for="i in 9">{{i}}</td>
                        </tr>
                        <tr v-for="i in 5">
                            <td v-for="i in 9"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.8.2. Компоновка низа бурильных колонн (КНБК)</div>
                <table class="table defaultTable">
                    <tbody>
                       <tr>
                           <th rowspan="3">
                               Условный номер КНБК
                           </th>
                           <th colspan="11">
                               Э Л Е М Е Н Т Ы  КНБК  (до бурильных труб)
                           </th>
                       </tr>
                        <tr>
                            <th rowspan="2">
                                № по порядку
                            </th>
                            <th rowspan="2">
                                Типоразмер, шифр или краткое название элемента КНБК (код IADC)
                            </th>
                            <th rowspan="2">
                                Расстояние от забоя до места установки
                            </th>
                            <th colspan="5">
                                Техническая характеристика
                            </th>
                            <th rowspan="2">
                                Суммарная длина КНБК, м
                            </th>
                            <th rowspan="2">
                                Суммарная масса КНБК, т
                            </th>
                            <th rowspan="2">
                                Примечание
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Наружный диаметр,мм
                            </th>
                            <th>
                                Диаметр проход-ного сечения, мм
                            </th>
                            <th>
                                Длина, м
                            </th>
                            <th>
                                Масса, кг
                            </th>
                            <th>
                                Угол перекоса осей отклонителя, град.
                            </th>
                        </tr>
                        <tr>
                            <td v-for="i in 12">{{i}}</td>
                        </tr>
                        <tr>
                            <td colspan="12">
                                Интервал бурения от … до …м
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="blueRow">1</td>
                            <td v-for="i in 8"></td>
                            <td rowspan="2" class="blueRow"></td>
                            <td rowspan="2" class="blueRow"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td v-for="i in 11"></td>
                        </tr>
                        <tr>
                            <td colspan="12">Интервал бурения и проработки от … до … м</td>
                        </tr>
                        <tr>
                            <td rowspan="8" class="blueRow"></td>
                            <td v-for="i in 8"></td>
                            <td rowspan="8" class="blueRow"></td>
                            <td rowspan="8" class="blueRow"></td>
                            <td></td>
                        </tr>
                       <tr v-for="i in 7">
                           <td v-for="i in 9"></td>
                       </tr>
                    </tbody>
                </table>
                <div>Табл. 1.8.3. Потребное количество элементов КНБК</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th rowspan="2">
                                Типоразмер, шифр или краткое название элемента КНБК
                            </th>
                            <th rowspan="2">
                                Вид технологической операции (бурение, отбор керна, расширка, проработка)
                            </th>
                            <th colspan="2">
                                Интервал работы по стволу,  м
                            </th>
                            <th colspan="2">
                                Норма проходки
                            </th>
                            <th rowspan="2">
                                Потребное количество на интервале, шт (для УБТ комплектов)
                            </th>
                        </tr>
                        <tr>
                            <th>
                                от
                                (верх
                            </th>
                            <th>
                                до
                                (низ
                            </th>
                            <th>
                                величина, м
                            </th>
                            <th>
                                источник нормы
                            </th>
                        </tr>
                        <tr>
                            <td v-for="i in 7">{{i}}</td>
                        </tr>
                        <tr>
                            <td v-for="i in 5"></td>
                            <td rowspan="14" class="blueRow"></td>
                            <td></td>
                        </tr>
                        <tr v-for="i in 13">
                            <td v-for="i in 6"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.8.4. Суммарное количество и масса КНБК</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th rowspan="3">
                                Название обсадной колонны
                            </th>
                            <th rowspan="3">
                                Типоразмер, шифр или краткое название элемента КНБК
                            </th>
                            <th rowspan="3">
                                ГОСТ, ОСТ, МРТУ, ТУ, МУ, и т. п. на изготовление
                            </th>
                            <th colspan="4">
                                Суммарная величина
                            </th>
                        </tr>
                        <tr>
                            <th colspan="3">
                                Количество элементов КНБК, шт (м)
                            </th>
                            <th rowspan="2">
                                Масса по типоразмеру или шифру, кг
                            </th>
                        </tr>
                        <tr>
                            <th>
                                для проработки ствола
                            </th>
                            <th>
                                для бурения, расширки и отбора керна
                            </th>
                            <th>
                                по типоразмеру или шифру
                            </th>
                        </tr>
                        <tr>
                            <td v-for="i in 7">{{i}}</td>
                        </tr>
                        <tr>
                            <td rowspan="2"></td>
                            <td v-for="i in 6"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 6"></td>
                        </tr>
                        <tr>
                            <td rowspan="5"></td>
                            <td v-for="i in 6"></td>
                        </tr>
                        <tr v-for="i in 4">
                            <td v-for="i in 6"></td>
                        </tr>
                        <tr>
                            <td rowspan="5" class="blueRow"></td>
                            <td v-for="i in 6"></td>
                        </tr>
                        <tr v-for="i in 4">
                            <td v-for="i in 6"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.8.5. Рекомендуемые бурильные трубы</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th>Обозначение бурильной колонны</th>
                            <th>Наружный диаметр, мм</th>
                            <th>Толщина стенки, мм</th>
                            <th>Марка (группа прочности материала)</th>
                            <th>Тип замкового соединения</th>
                            <th>Количество труб, шт.</th>
                            <th>Наличие труб (есть, нет)</th>
                        </tr>
                        <tr>
                            <td v-for="i in 7">{{i}}</td>
                        </tr>
                        <tr v-for="i in 4">
                            <td v-for="i in 7"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.8.6. Конструкция бурильных колонн</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th rowspan="2">Вид технологической операции</th>
                            <th colspan="2">Интервал по стволу, м</th>
                            <th rowspan="2">Допустимая глубина спуска на клиньях, м</th>
                            <th rowspan="2">Номер секции бурильной колонны снизу вверх без КНБК</th>
                            <th colspan="5">Характеристика бурильной трубы</th>
                            <th rowspan="2">Длина секции, м</th>
                            <th colspan="2">Масса, т</th>
                            <th colspan="2">Коэффициент запаса прочности трубы на:</th>
                        </tr>
                        <tr>
                            <th>от (верх)</th>
                            <th>до (низ)</th>
                            <th>тип (шифр)</th>
                            <th>наружный диаметр, мм</th>
                            <th>марка (группа    прочности) материала</th>
                            <th>толщина стенки, мм</th>
                            <th>тип замкового соединения</th>
                            <th>секции</th>
                            <th>нарастающая с учетом КНБК</th>
                            <th>статическую прочность</th>
                            <th>выносливость</th>
                        </tr>
                        <tr>
                            <td v-for="i in 15">{{i}}</td>
                        </tr>
                        <tr v-for="i in 3">
                            <td v-for="i in 15"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.8.7. Характеристика и масса бурильных труб, УБТ по интервалам бурения с учетом дефицита длины труб</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th rowspan="2">Название обсадной колонны</th>
                            <th colspan="2">Интервал по стволу, м</th>
                            <th colspan="5">Характеристика бурильных труб. УБТ</th>
                            <th rowspan="2">Дефицит длины труб на интервале. м</th>
                            <th colspan="3">Масса труб. т</th>
                        </tr>
                        <tr>
                            <th>от (верх)</th>
                            <th>до (низ)</th>
                            <th>тип (шифр</th>
                            <th>наружный диаметр. мм</th>
                            <th>марка (группа прочности) материала</th>
                            <th>толщина стенки. мм</th>
                            <th>тип присоединительной резьбы</th>
                            <th>теоретическая</th>
                            <th>с плюсовым допуском</th>
                            <th>с нормативным запасом</th>
                        </tr>
                        <tr>
                            <td v-for="i in 12"></td>
                        </tr>
                        <tr>
                            <td rowspan="3" class="blueRow"></td>
                            <td v-for="i in 11"></td>
                        </tr>
                        <tr v-for="i in 2">
                            <td v-for="i in 11"></td>
                        </tr>
                        <tr>
                            <td rowspan="3" class="blueRow"></td>
                            <td v-for="i in 11"></td>
                        </tr>
                        <tr v-for="i in 2">
                            <td v-for="i in 11"></td>
                        </tr>
                        <tr>
                            <td rowspan="3" class="blueRow"></td>
                            <td v-for="i in 11"></td>
                        </tr>
                        <tr v-for="i in 2">
                            <td v-for="i in 11"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.8.8. Оснастка талевой системы</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th colspan="2">Интервал по стволу, м</th>
                            <th rowspan="2">Название технологической операции (бурение, спуск обсадной колонны)</th>
                            <th colspan="2">Тип оснастки МхК</th>
                        </tr>
                        <tr>
                            <th>от (верх)</th>
                            <th>до (низ)</th>
                            <th>М</th>
                            <th>К</th>
                        </tr>
                        <tr>
                            <td v-for="i in 5">{{i}}</td>
                        </tr>
                        <tr v-for="i in 2">
                            <td v-for="i in 5"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.8.9. Режим работы буровых насосов</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th colspan="2">Интервал по стволу, м</th>
                            <th rowspan="2">Вид технологической операции (бурение, проработка, промывка и т.п.)</th>
                            <th rowspan="2">Тип буровых насосов</th>
                            <th rowspan="2">Количество насосов, шт.</th>
                            <th colspan="6">Режим работы бурового насоса</th>
                            <th rowspan="2">Суммарная производительность насосов на интервале,л/с</th>
                        </tr>
                        <tr>
                            <th>от (верх)</th>
                            <th>до (низ)</th>
                            <th>коэффициент использования гидравлической мощности</th>
                            <th>диаметр цилиндровых втулок, мм</th>
                            <th>допустимое давление кгс/см2</th>
                            <th>коэффициент наполнения</th>
                            <th>число ударов в минуту</th>
                            <th>производительность, л/с</th>
                        </tr>
                        <tr>
                            <td v-for="i in 12">{{i}}</td>
                        </tr>
                        <tr>
                            <td v-for="i in 3"></td>
                            <td rowspan="3" class="blueRow"></td>
                            <td v-for="i in 8"></td>
                        </tr>
                        <tr v-for="i in 2">
                            <td v-for="i in 11"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.8.10. Распределение потерь давлений в циркуляционной системе буровой</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th colspan="2">Интервал (по столу), м</th>
                            <th rowspan="3">Вид технологической операции (см. табл. 8.1)</th>
                            <th rowspan="3">Давление на стояке в конце интервала, кгс/см2</th>
                            <th colspan="5">Потери давлений (кгс/см2) для конца интервала в:</th>
                        </tr>
                        <tr>
                            <th rowspan="2">От (верх)</th>
                            <th rowspan="2">До (низ)</th>
                            <th colspan="2">Элементах КНБК</th>
                            <th rowspan="2">Бурильной колонне</th>
                            <th rowspan="2">Кольцевом пространстве</th>
                            <th rowspan="2">Обвязке буровой установки</th>
                        </tr>
                        <tr>
                            <th>Долоте (насадках)</th>
                            <th>ВЗД/РУС+ Телеметрия</th>
                        </tr>
                        <tr>
                            <td v-for="i in 9">{{i}}</td>
                        </tr>
                        <tr v-for="i in 3">
                            <td v-for="i in 9"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.8.11. Гидравлические показатели промывки</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th colspan="2">Интервал (по столу), м</th>
                            <th rowspan="2">Вид технологической операции (см. таблицу 8.1)</th>
                            <th rowspan="2">Наименьшая скорость восходящего потока в  открытом стволе, м/с</th>
                            <th rowspan="2">Удельный расход, л/с.см2</th>
                            <th rowspan="2">Схема промывки долота (центральная, периферийная, комбинирован-ная)</th>
                            <th rowspan="2">Диаметр сопла на центральном отверстии, мм</th>
                            <th colspan="2">Гидро-монитор-ные насадки</th>
                            <th rowspan="2">Скорость истечения, м/с</th>
                            <th rowspan="2">Мощность. срабатываемая на долоте, квт.</th>
                        </tr>
                        <tr>
                            <th>от (верх)</th>
                            <th>до (низ)</th>
                            <th>Количество, шт</th>
                            <th>Диаметр, мм</th>
                        </tr>
                        <tr>
                            <td v-for="i in 11">{{i}}</td>
                        </tr>
                        <tr v-for="i in 4">
                            <td v-for="i in 11"></td>
                        </tr>
                    </tbody>
                </table>
            </slot>
        </reportGeneration>
    </div>
</template>

<script>
    import reportGeneration from './modals/report-generation'

    export default {
        name: "well-deepening",
        components: {reportGeneration},
        data(){
            return{
                main_tables: [
                    {
                        "name":  "digital_drilling.project_data.BHA_selection",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<w-deepening></w-deepening>"
                        }
                    },
                    {
                        "name": "digital_drilling.project_data.drilling_parameters_modes",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<w-deepening-params></w-deepening-params>"
                        }
                    },
                    {
                        "name": "digital_drilling.project_data.visualization",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<w-deepening-graph></w-deepening-graph>"
                        }
                    },
                ],
                mainTable:   {
                    "name":  "digital_drilling.project_data.BHA_selection",
                    "id": 1,
                    "component": {
                        "name": "main-table",
                        "template": "<w-deepening></w-deepening>"
                    }
                },
                reportModalActive: false
            }
        },
        methods: {
            changeTable(table){
                this.mainTable = table
                let element = document.getElementById("dropdown-menu1");
                element.classList.remove("show");
            },
            closeReportModal(){
                this.reportModalActive = false
            }
        },
    }
</script>

<style scoped>
    .digital_drilling .contentBlock .digitalDrillingWindow {
        position: static;
    }
    .blueRow{
        background-color: #272953;
    }
</style>