    <template>
    <div class="digitalDrillingWindow">
        <window-head />
        <div class="windowBody">
            <div class="bodyContent">
                <p class="bigTitle left">Буровые растворы</p>
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
                title="Буровые растворы"
        >
            <slot>
                <div>Табл. 1.7.1 Типы и параметры буровых растворов</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="3">
                            Название (тип) раствора
                        </th>
                        <th rowspan="2" colspan="2">
                            Интервал (по стволу), м
                        </th>
                        <th></th>
                        <th colspan="13">
                            Параметры бурового раствора
                        </th>
                    </tr>
                    <tr>
                        <th rowspan="2">
                            Плотность,  г/см3
                        </th>
                        <th rowspan="2">
                            Условная вязкость, сек
                        </th>
                        <th rowspan="2">
                            Водоотдача,  см3/30 мин
                        </th>
                        <th colspan="2">
                            СНС, фунт/100фут²
                        </th>
                        <th rowspan="2">
                            Корка, мм
                        </th>
                        <th colspan="2">
                            Содержа-ние твердой фазы, % (об.)
                        </th>
                        <th rowspan="2">
                            рН
                        </th>
                        <th rowspan="2">
                            Минерализация по Са2+, мг/л, не более
                        </th>
                        <th rowspan="2">
                            Пластическая вязкость,
                            сантипуаз
                        </th>
                        <th rowspan="2">
                            Динамическое напряжение сдвига, фунт/ 100фут2
                        </th>
                        <th rowspan="2">
                            KCL, %
                        </th>
                        <th rowspan="2">
                            Плотность до утяжеления кг/м3
                        </th>
                    </tr>
                    <tr>
                        <th>
                            от (верх)
                        </th>
                        <th>
                            до (низ
                        </th>
                        <th>
                            10 сек
                        </th>
                        <th>
                            10 мин
                        </th>
                        <th>
                            (активной)
                        </th>
                        <th>
                            песка
                        </th>
                    </tr>
                    <tr>
                        <td v-for="i in 17">{{ i }}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 17"></td>
                    </tr>
                    </tbody>
                </table>
                <div>Табл. 1.7.2 Компонентный состав бурового раствора и характеристика компонентов</div>
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
                                Название (тип) раствора
                            </th>
                            <th rowspan="2">
                                Плотность раствора, кг/м3
                            </th>
                            <th rowspan="2">
                                Смена раствора  для бурения интервала (да, нет)
                            </th>
                            <th rowspan="2">
                                Название компонента
                            </th>
                            <th rowspan="2">
                                Плотность кг/м3
                            </th>
                            <th rowspan="2">
                                Содержание вещества в товар-ном продукте (жидкос-ти), %
                            </th>
                            <th rowspan="2">
                                Влажность, %
                            </th>
                            <th rowspan="2">
                                Сорт
                            </th>
                            <th rowspan="2">
                                Содержание компонента в буровом растворе, кг/м3
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
                            <td v-for="i in 12">{{i}}</td>
                        </tr>
                        <tr>
                           <td rowspan="6" v-for="i in 6" class="blueRow"></td>
                            <td v-for="i in 6"></td>
                        </tr>
                        <tr v-for="i in 5">
                            <td v-for="i in 6"></td>
                        </tr>
                        <tr>
                            <td rowspan="6" v-for="i in 6" class="blueRow"></td>
                            <td v-for="i in 6"></td>
                        </tr>
                        <tr v-for="i in 5">
                            <td v-for="i in 6"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.7.3. Потребность бурового раствора и компонентов (товарный продукт) для его приготовления, обработки и утяжеления</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th colspan="2">
                                Интервал, м
                            </th>
                            <th rowspan="2">
                                Коэффициент запаса раство-ра на поверх-ности
                            </th>
                            <th rowspan="2">
                                Название (тип) бурового раствора и его компонентов
                            </th>
                            <th colspan="3">
                                Нормы расхода компонентов бурового раствора м3/м и его компонентов, кг/м3
                            </th>
                            <th colspan="5">
                                Потребность бурового раствора (м3) и его компонентов (кг)
                            </th>
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
                            <th>
                                величина
                            </th>
                            <th>
                                источник нормы
                            </th>
                            <th>
                                поправочный коэффициент
                            </th>
                            <th>
                                объем скважины, м3
                            </th>
                            <th>
                                а запас на поверхности
                            </th>
                            <th>
                                на исходный объем
                            </th>
                            <th>
                                на бурение интервала
                            </th>
                            <th>
                                на интервале
                            </th>
                        </tr>
                        <tr>
                            <td v-for="i in 12">{{i}}</td>
                        </tr>
                        <tr>
                            <td rowspan="5" v-for="i in 3" class="blueRow"></td>
                            <td v-for="i in 9"></td>
                        </tr>
                        <tr v-for="i in 4">
                            <td v-for="i in 9"></td>
                        </tr>
                        <tr>
                            <td rowspan="5" v-for="i in 3" class="blueRow"></td>
                            <td v-for="i in 9"></td>
                        </tr>
                        <tr v-for="i in 4">
                            <td v-for="i in 9"></td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.7.4. Потребность компонентов для обработки бурового раствора при спуске обсадных колонн</div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th>
                                Номер колонны в порядке спуска
                            </th>
                            <th>
                                Название колонны
                            </th>
                            <th>
                                Название компонентов для обработки раствора
                            </th>
                            <th>
                                Плотность, кг/м3
                            </th>
                            <th>
                                Влажность, %
                            </th>
                            <th>
                                Содержание вещества в товарном продукте, %
                            </th>
                            <th>
                                Сорт
                            </th>
                            <th>
                                Норма расхода на обработку 1 м3 раствора, кг/м3
                            </th>
                            <th>
                                Количество кг
                            </th>
                        </tr>
                        <tr>
                            <td v-for="i in 9">{{i}}</td>
                        </tr>
                        <tr v-for="i in 3">
                            <td v-for="i in 9"></td>
                        </tr>
                    </tbody>
                </table>
                <div>
                    Табл. 1.7.5. Потребность воды или компонентов для обработки бурового раствора при разбуривании цементных стаканов
                </div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th rowspan="2">
                                Номер колонны в порядке спуска
                            </th>
                            <th rowspan="2">
                                Название колонны
                            </th>
                            <th rowspan="2">
                                Номер раздельно спускаемой части колонны в порядке спуска
                            </th>
                            <th rowspan="2">
                                Номер ступени цементи-рования
                            </th>
                            <th rowspan="2">
                                Название компонентов для обработки раствора
                            </th>
                            <th colspan="4">
                                Характеристика компонентов
                            </th>
                            <th rowspan="2">
                                Норма расхода на обработку 1м3 раствора, кг/м3
                            </th>
                            <th rowspan="2">
                                Количество, кг
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Плотность, кг/м
                            </th>
                            <th>
                                Влажность, %
                            </th>
                            <th>
                                Содержание вещества в товарном продукте, %
                            </th>
                            <th>
                                Сорт
                            </th>
                        </tr>
                        <tr>
                            <td v-for="i in 11">{{i}}</td>
                        </tr>
                        <tr>
                            <td v-for="i in 4"></td>
                            <td rowspan="3" class="blueRow"></td>
                            <td v-for="i in 6"></td>
                        </tr>
                        <tr v-for="i in 2">
                            <td v-for="i in 10"></td>
                        </tr>
                        <tr>
                            <td colspan="11" class="text-left">
                                Итого:
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div>Табл. 1.7.6. Суммарная потребность компонентов бурового раствора на скважину
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
                <div>
                    Табл. 1.7.7 Оборудование для приготовления и очистки буровых растворов
                </div>
                <table class="table defaultTable">
                    <tbody>
                        <tr>
                            <th rowspan="2">
                                №№ п/п
                            </th>
                            <th rowspan="2">
                                Нaзвaниe оборудования
                            </th>
                            <th rowspan="2">
                                Типoрaзмeр, шифр или характеристика
                            </th>
                            <th rowspan="2">
                                Кoличествo, шт
                            </th>
                            <th rowspan="2">
                                ГOCТ, OCТ, МРТУ, ТУ, МУ и т.п. на изготовление
                            </th>
                            <th colspan="2">
                                Интeрвaл примeнeния по вертикали, м
                            </th>
                        </tr>
                        <tr>
                            <th>
                                от
                                (верх
                            </th>
                            <th>
                                дo
                                (низ)
                            </th>
                        </tr>
                        <tr>
                            <td v-for="i in 7">{{i}}</td>
                        </tr>
                        <tr v-for="i in 10">
                            <td>{{i}}</td>
                            <td v-for="i in 6"></td>
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
        name: "drilling_fluids",
        components: {reportGeneration},

        data(){
            return{
                main_tables: [
                    {
                        "name":  "digital_drilling.project1.geological_data",
                        "id": 1,
                        "component": {
                            "name": "main-table",
                            "template": "<rasters></rasters>"
                        }
                    },
                    {
                        "name": "digital_drilling.project1.BR_parameters",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<rasters-params></rasters-params>"
                        }
                    },
                    {
                        "name": "digital_drilling.project1.BR_component",
                        "id": 2,
                        "component": {
                            "name": "main-table",
                            "template": "<rasters-component></rasters-component>"
                        }
                    },
                ],
                mainTable:  {
                    "name":  "digital_drilling.project1.geological_data",
                    "id": 1,
                    "component": {
                        "name": "main-table",
                        "template": "<rasters></rasters>"
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