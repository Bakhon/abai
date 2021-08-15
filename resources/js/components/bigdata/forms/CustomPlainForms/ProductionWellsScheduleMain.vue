<template>
    <div>
        <ProductionWellsSchedule
            v-if="isScheduleVisible"
            :well="well"
             @changeScheduleVisible="isScheduleVisible = !isScheduleVisible; changeColumnsVisible(true)"
        ></ProductionWellsSchedule>
        <div v-else class="main-block w-100 px-2 py-3">
            <div class="d-flex justify-content-between">
                <div>
                    График замеров по добыче нефти
                </div>
                <div>
                    <a class="underline text-white cursor-pointer">Исторические сведения по добыче нефти</a>
                </div>
            </div>
            <div class="content-block content-block-scrollable p-2">
                <div class="small-fixed-block table-responsive">
                    <table class="table table-striped text-white text-nowrap">
                        <thead>
                        <th colspan="5">Сводная информация</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Гор (проект/факт): Ю4</td>
                            <td rowspan="3">Инт.перф:</td>
                            <td rowspan="2">Г/ф: 0.0</td>
                            <td>Ø экс.к.: 0.0</td>
                            <td>дата обустройства:</td>
                        </tr>
                        <tr>
                            <td>Зона/Рнас: /69</td>
                            <td>Вид скважины: Вертикальная</td>
                            <td>дата в действ.фонд: 27.03.2021</td>
                        </tr>
                        <tr>
                            <td>Иск. заб.: 0.0</td>
                            <td rowspan="2">ТПН: 66.5</td>
                            <td>ЦДНГ/ГУ/ряд: ЦДНГ-02/ГУ-45/15-18</td>
                            <td>Тип.УО:</td>
                        </tr>
                        <tr>
                            <td>Факт.заб.: 0.0</td>
                            <td>НКТ: /-/-/-</td>
                            <td>Спут./отвод:</td>
                            <td>Экс.г:</td>
                        </tr>
                        <tr>
                            <td>Вл.наг:</td>
                            <td>Штанги: /-/-/-</td>
                            <td>ГИС: ГИС в открытом стволе/25.01.2021</td>
                            <td>Примечание:</td>
                            <td>К/Г: Заводская</td>
                        </tr>
                        <tr>
                            <td>ПФП:</td>
                            <td>Тип. СК:</td>
                            <td>Lх или Ø шкива:</td>
                            <td></td>
                            <td>обр.кл.: Нет</td>
                        </tr>
                        <tr>
                            <td>Посл. ПРС:</td>
                            <td>Тип и Ø насоса: -/-</td>
                            <td>ГРП:</td>
                            <td></td>
                            <td>Доп. оборудования:</td>
                        </tr>
                        <tr>
                            <td>Посл. Рпл:</td>
                            <td></td>
                            <td>Совм.скв.:</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Посл. КРС:</td>
                            <td>Sк:</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="table text-center text-white text-nowrap">
                        <thead>
                        <th colspan="33" class="text-left">2021/январь</th>
                        <th colspan="2">Итоговые показатели</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Показатель</td>
                            <td>Тех. режим</td>
                            <td v-for="n in 31" class="red-col">{{ n }}</td>
                            <td>Средние (по методике)</td>
                            <td>Суммарные (по методике)</td>
                        </tr>
                        <tr>
                            <td>Жидкость</td>
                            <td></td>
                            <td v-for="n in 31" class="red-col"></td>
                            <td>0.00</td>
                            <td>0.00</td>
                        </tr>
                        <tr>
                            <td>Нефть</td>
                            <td></td>
                            <td v-for="n in 31" class="red-col"></td>
                            <td>0.00</td>
                            <td>0.00</td>
                        </tr>
                        <tr>
                            <td>Обводненность</td>
                            <td></td>
                            <td v-for="n in 31" class="red-col"></td>
                            <td>0.00</td>
                            <td>0.00</td>
                        </tr>
                        <tr>
                            <td>Аном. обв.</td>
                            <td></td>
                            <td v-for="n in 31" class="red-col"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Жидкость, м3/сут (телеметрия)</td>
                            <td></td>
                            <td v-for="n in 31" class="red-col"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Показать поля</td>
                            <td></td>
                            <td v-for="n in 31" class="red-col"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Мероприятия</td>
                            <td></td>
                            <td v-for="n in 31" class="red-col"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="pl-3 d-flex align-items-center">
                        <img class="pr-1" src="/img/icons/repeat.svg" alt="">
                        Сформировать
                    </div>
                    <div class="pl-3 d-flex align-items-center">
                        <img class="pr-1" src="/img/icons/help.svg" alt="">
                        Легенда
                    </div>
                    <div class="pl-3 d-flex align-items-center">
                        <img class="pr-1" src="/img/icons/chart.svg" alt="">
                        <a class="text-white cursor-pointer"
                           @click="isScheduleVisible = !isScheduleVisible; changeColumnsVisible(false)">Показать график</a>
                    </div>
                    <div class="pl-3 d-flex align-items-center">
                        <img class="pr-1" src="/img/icons/page_excel.svg" alt="">
                        Скачать в MS-Excel
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ProductionWellsSchedule from "./ProductionWellsSchedule";
export default {
    components: {ProductionWellsSchedule},
    props: {
        well: {},
        changeColumnsVisible: Function
    },
    data() {
        return {
            isScheduleVisible: false,
        }
    },
}
</script>
<style scoped lang="scss">
.main-block {
    background-color: rgba(54, 59, 104, 1);
    color: #fff
}
.content-block {
    background-color: rgba(39, 41, 83, 1);
}
.underline {
    text-decoration: underline;
}

.small-fixed-block {
    height: 300px;
    overflow-y: auto;
}

.red-col {
    background-color: rgba(239, 83, 80, 0.7) !important;
}

.table {
    border: 1px solid rgba(69,77,125,1);

    th {
        border: 1px solid #454D7D;
        background-color: #333975;
        font-size: 0.9rem;
        font-weight: 700;
        padding: 0.3rem !important;
    }

    td {
        font-size: 0.8rem;
        padding: 0.3rem !important;
        border-top: none !important;
    }

    td.red-col {
        padding: 0.5rem !important;
    }

    td:not(last-child) {
        background-color: #303560;
    }
}

.content-block-scrollable {
    height: 70vh;
    overflow-y: scroll;
}
</style>