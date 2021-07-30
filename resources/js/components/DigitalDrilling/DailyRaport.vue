<template>
    <div class="container-main">
        <div class="col-sm-12">
            <div class="daily_raport_block">
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th rowspan="3" colspan="10" class="align-middle text-center border-right-0 title">СУТОЧНЫЙ БУРОВОЙ РАПОРТ</th>
                            <th class="text-right border-left-0 border-right-0 border-bottom-0">Дата</th>
                            <th><input type="text"></th>
                        </tr>
                        <tr>
                            <th class="text-right border-0">Рапорт №</th>
                            <th><input type="text"></th>
                        </tr>
                        <tr>
                            <th class="text-right border-0">Страница</th>
                            <th><input type="text"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">
                                Название Установки
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                               Режим бурения:
                            </td>
                            <td colspan="2">
                                Показатели
                            </td>
                            <td colspan="2">
                                Компания оператор:
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Тип буровой Установки
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                Нагрузка на долото, т:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Буровой подрядчик:
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Скважина №:
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                Скорость вращения, об/мин:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Дата начало бурения:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Месторождение
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                               Момент при вращении, кН*м:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Всего дней бурения:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Проект глуб., поств./верт.(м):
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Пройзводительность насосов, л/с:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Температура воздуха:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Предыдущий забой, м:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Давление на стояке, атм:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">

                            </td>
                            <td colspan="2">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Забой на 24:00, м:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Вес на крюке, т:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">

                            </td>
                            <td colspan="2">

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Суточная проходка, м:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Вес на крюке при подъеме, т:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Супервайзер:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Время бурения/расширки, час:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Вес на крюке при спуске, т:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                Буровой мастер:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row tables">
                    <div class="col-sm-5 pr-0 pl-0">
                        <table class="table defaultTable border-top-0" >
                            <thead>
                                <tr>
                                    <th rowspan="2" colspan="2" class="align-middle">
                                        Конструкция скважины
                                    </th>
                                    <th colspan="2">
                                        Проектная, м
                                    </th>
                                    <th colspan="2">
                                        Фактическая
                                    </th>
                                </tr>
                                <tr>
                                    <th>По вертикали</th>
                                    <th>По стволу</th>

                                    <th>По вертикали</th>
                                    <th>По стволу</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="w-10">
                                        <select name="" id="">
                                            <option value="">Test</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w-10">
                                        <select name="" id="">
                                            <option value="">Test</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w-10">
                                        <select name="" id="">
                                            <option value="">Test</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w-10">
                                        <select name="" id="">
                                            <option value="">Test</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="w-10">
                                        <select name="" id="">
                                            <option value="">Test</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table defaultTable  border-top-0">
                            <thead>
                                <tr class="h-31">
                                    <th rowspan="2" colspan="2" class="w-50">Персонал на буровой</th>
                                    <th rowspan="2" colspan="2">Сведение о смене вахт</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="w-40"><input type="text"></td>
                                    <td class="w-10"><input type="text"></td>
                                    <td class="w-25">Прибыло:</td>
                                    <td class="w-25"><input type="text"></td>
                                </tr>
                                <tr>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td>Убыло:</td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td>Осталось:</td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr v-for="i in 10">
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="text-right">Итого:</td>
                                    <td><input type="text"></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-7 pl-0 pr-0">
                        <table class="table defaultTable ">
                            <thead>
                                <tr>
                                    <th colspan="4">
                                        Затраты производительного времени, час
                                    </th>
                                    <th colspan="4">
                                        Затраты непроизводительного времени, час
                                    </th>
                                </tr>
                                <tr>
                                    <th>Операции</th>
                                    <th>Предыдущее</th>
                                    <th>За сутки</th>
                                    <th>Всего</th>

                                    <th>Операции</th>
                                    <th>Предыдущее</th>
                                    <th>За сутки</th>
                                    <th>Всего</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="expense in Expenses">
                                    <td class="w-15">{{expense.operation1}}</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td class="w-20">{{expense.operation2}}</td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                    <td><input type="text"></td>
                                </tr>
                                <tr class="h-31">
                                    <td colspan="3">
                                        Итого производительного времени
                                    </td>
                                    <td>
                                        0,00
                                    </td>
                                    <td colspan="3">
                                        Итого непроизводительного времени
                                    </td>
                                    <td>
                                        0,00
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="11" class="align-middle title">ОПИСАНИЕ РАБОТ ЗА СУТКИ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">
                                Время
                            </td>
                            <td rowspan="2">
                                Ставка
                            </td>
                            <td rowspan="2" colspan="2">
                                Операция
                            </td>
                            <td rowspan="2" colspan="4">
                                Комментарии
                            </td>
                        </tr>
                        <tr>
                            <td>от</td>
                            <td>до</td>
                            <td>всего</td>
                        </tr>
                        <tr>
                            <td>0:00</td>
                            <td>24:00</td>
                            <td>0:00</td>
                            <td></td>
                            <td>Код операции</td>
                            <td class="w-40">
                                Примечание: Для проведения полноценного анализа каждую технологическую
                                операцию необходимо фиксировать по отдельности с указанием интервала времени.
                            </td>
                            <td colspan="4" class="border-bottom-0 text-left">Завезено:</td>
                        </tr>
                        <tr>
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td >
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td ><input type="text"></td>
                            <td rowspan="16" colspan="4" class="w-20 border-top-0"><textarea name="" id="" cols="30" rows="32"></textarea></td>
                        </tr>
                        <tr v-for="i in 15">
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td ><input type="text"></td>
                            <td ><select name="" id="">
                                <option value="">Test</option>
                            </select></td>
                            <td ><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="2">ИТОГО</td>
                            <td >24:00</td>
                            <td ><input type="text"></td>
                            <td ><select name="" id="">
                                <option value="">Test</option>
                            </select></td>
                            <td ><input type="text"></td>
                            <td class="w-5"></td>
                            <td class="w-5"></td>
                            <td class="w-5"></td>
                            <td class="w-5"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="19" class="title">ТЕХНОЛОГИЧЕСКАЯ ИНФОРМАЦИЯ</th>
                        </tr>
                        <tr>
                            <th colspan="5">
                                Информация о долоте
                            </th>
                            <th colspan="9">
                                КНБК в скважине
                            </th>
                            <th colspan="5">
                                Контроль за скважиной
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Долото №</td>
                            <td  colspan="2">1</td>
                            <td  colspan="2">2</td>

                            <td colspan="9">Характеристика спускаемого инструмента</td>
                            <td colspan="4" class="w-20">Диаметр последней колоны, мм:</td>
                            <td class="w-7"><input type="text"></td>
                        </tr>
                        <tr>
                            <td>
                                Тип долота:
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                Элементы КНБК
                            </td>
                            <td>
                                НаружО,мм
                            </td>
                            <td>
                                ВнутрО,мм
                            </td>
                            <td colspan="2">
                                Тип резьбы
                            </td>
                            <td >
                                Длина, м
                            </td>
                            <td colspan="2">
                                Нараст. длина, м
                            </td>
                            <td colspan="4">
                                Глуб. спуска последней колонны, мм:
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 IADCКод:
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                Диаметр следующей колонны, мм:
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Производитель:
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                               Глуб. спуска следующей колонны, мм:
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Диаметр, мм:
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                               Испытание целостности пласта, МПа
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Сериный номер:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                               Эквивалентная плотность бур. раствора, г/см:
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Насадки:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                               Плотность бурового раствора при испытании пласта г/см3:
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Площадь, TFA:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                               Дата последного испытания ПВО:
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Бурения с,м
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                                Объем бур. раствора в скважине, м3
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 до,м:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                               Объем бур. раствора в прием. емкостях, м3
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Проходка, м:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                               Объем бур. раствора в запасе, м3
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Проходка с начала интервала, м:
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="4">
                               Плотность бур. раствора в запасе, г/см3
                            </td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Время бурения, ч
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="5">
                                Насос №1 тип SL3NB-1 300D
                            </td>
                        </tr>
                        <tr>
                            <td>
                                 Всего бурения, ч
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                Втулки, мм
                            </td>
                            <td><input type="text"></td>
                            <td colspan="2">Литр/ход</td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="align-middle">
                                 Износ долота по IADC
                            </td>
                            <td rowspan="2" colspan="2" class="align-middle">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td rowspan="2" colspan="2" class="align-middle">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td>
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td >
                                <input type="text">
                            </td>
                            <td colspan="2">
                                <input type="text">
                            </td>
                            <td>
                                Коэф. напол-я
                            </td>
                            <td><input type="text"></td>
                            <td colspan="2">Плотность, г/см3</td>
                            <td>
                                <input type="text">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td rowspan="6"><input type="text">Давление прокачки</td>
                            <td><input type="text">Ход/мин</td>
                            <td><input type="text">Глуб, м</td>
                            <td><input type="text">Давл, атм</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>

                            <td colspan="7">Длина КНБК</td>

                            <td colspan="2">0,00</td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2">0,00</td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="bg">Система очистки раствора</td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">Часы работы центрифуги</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="7">Общая длинна бурильной колонны, м </td>
                            <td colspan="2">0,00</td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">Часы работы вибросито №1</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="5">Насос №2 ти6L3NB-1 300D</td>
                        </tr>
                        <tr>
                            <td colspan="3">Часы работы вибросито №2</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td>Втулки, мм</td>
                            <td><input type="text"></td>
                            <td colspan="2">Литр/ ход</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">Часы работы вибросито №3</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td>Коэф, напол.</td>
                            <td><input type="text"></td>
                            <td colspan="2">Плотность, г/см3</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                        <tr>
                            <td colspan="3">Работапескоотделителя, час</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td rowspan="4" class="align-middle">Давление прокачки</td>
                            <td>Ход/мин</td>
                            <td>Глуб, м</td>
                            <td>Давл, атм</td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">Работа илоотделителя, час:</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3">Дегозатор, час:</td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="7">Общая длина бурильной колоны с ведущей трубой, м</td>
                            <td colspan="2">0.00</td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                Вывоз твердой и жидкой фазы
                            </td>
                            <td colspan="12" class="text-left">
                                Состояние по ОЗТОС
                            </td>
                        </tr>
                        <tr>
                            <td>Наименование</td>
                            <td>ЕД</td>
                            <td>Рейсов</td>
                            <td colspan="2">Предыдущее</td>
                            <td>За сутки</td>
                            <td>Итого</td>
                            <td colspan="12" class="border-bottom-0 text-left align-bottom">Заявка/Требуется:</td>
                        </tr>
                        <tr>
                            <td>ТФ (шлам)</td>
                            <td>тн</td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td rowspan="4" colspan="12" class="border-top-0">
                                <textarea name=""  cols="30" rows="10"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>ЖФ (ОБР)</td>
                            <td>м3</td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>ТБО</td>
                            <td>тн</td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td>Отходы канализ.</td>
                            <td>м3</td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="7" lass="title">ИНФОРМАЦИЯ НА 06:00 ч</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">Время</td>
                            <td rowspan="2" class="align-middle">Ставка</td>
                            <td rowspan="2" colspan="2" class="align-middle">Операция</td>
                            <td rowspan="2" class="align-middle">Планируемые работы на следующие сутки</td>
                        </tr>
                        <tr>
                            <td>от</td>
                            <td>до</td>
                            <td>всего</td>
                        </tr>
                        <tr>
                            <td>0:00</td>
                            <td>6:00</td>
                            <td>6:00</td>
                            <td><input type="text"></td>
                            <td>Код операции</td>
                            <td>
                                Примечание: Для проведения полноценного анализа каждую технологическую
                                операцию необходимо фиксировать по отдельности с указанием интервала времени.
                            </td>
                            <td rowspan="12">
                                <textarea name=""  cols="30" rows="22"></textarea>
                            </td>
                        </tr>
                        <tr v-for="i in 11">
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td>
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th rowspan="2" colspan="18" class="align-middle">
                                ТЕХНИЧЕСКИЕ ПАРАМЕТРЫ БУРОВОГО РАСТВОРА И ГЕОЛОГИЧЕСКИЕ ДАННЫЕ
                            </th>
                            <th colspan="2">
                                Дата:
                            </th>
                            <th colspan="2">
                                <input type="text">
                            </th>
                        </tr>
                        <tr>
                            <th colspan="2">
                                Страница:
                            </th>
                            <th colspan="2">
                                <input type="text">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="22">
                                Параметры бурового раствора на 24:00 часа (проектные/фактические)
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2" colspan="4" class="align-middle">
                                Тип бурового раствора
                            </td>
                            <td colspan="2">
                                Плотн. на входе, г/см3
                            </td>
                            <td colspan="2">
                                Плотн. на выходе, г/см3
                            </td>
                            <td colspan="2">
                                 Вязкость, сек
                            </td>
                            <td colspan="2">
                                Пластическая вязкость, сП
                            </td>
                            <td colspan="2">
                                ДНС, Ib/100ft2
                            </td>
                            <td colspan="2">
                                pH
                            </td>
                            <td colspan="2">
                                Водоотдача, см/30мин
                            </td>
                            <td colspan="2">
                                Коэф. трения корки
                            </td>
                            <td colspan="2">
                                T. вход/выход, ℃
                            </td>
                        </tr>
                        <tr>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                        </tr>
                        <tr v-for="i in 3">
                            <td colspan="3" class="w-10">
                                <select name="" id="">
                                    <option value="">Test</option>
                                </select>
                            </td>
                            <td v-for="i in 19">
                                <input type="text">
                            </td>

                        </tr>
                        <tr>
                            <td colspan="19"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td rowspan="2" colspan="2" class="align-middle">Содержание тв.фазы, %</td>
                            <td rowspan="2" colspan="2" class="align-middle">Содержание песка, %</td>
                            <td rowspan="2" colspan="2" class="align-middle">МВТ</td>
                            <td rowspan="2" colspan="2" class="align-middle">Содержание воды, %</td>
                            <td rowspan="2" colspan="2" class="align-middle">Содержание смазки в растворе, %</td>
                            <td colspan="4">CHC I,b/100ft2</td>
                            <td rowspan="2" colspan="2" class="align-middle">Корка, мм</td>
                            <td rowspan="2" colspan="2" class="align-middle">Общая жесткость, мг/л</td>
                            <td colspan="4">Концентрация</td>
                        </tr>
                        <tr>
                            <td colspan="2">10 сек</td>
                            <td colspan="2">10 мин</td>
                            <td colspan="2">CI - мг/л</td>
                            <td colspan="2">KCI - %</td>
                        </tr>
                        <tr>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                            <td>проект</td>
                            <td>факт</td>
                        </tr>
                        <tr>
                            <td v-for="i in 22"><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="11" class="title">Компонентный состав бурового раствора и расход на приготовление</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Наименование химреагентов</td>
                            <td>Назначение материала</td>
                            <td>Единица измерения</td>
                            <td>Плотность материала, кг/м?</td>
                            <td>Массовы расход, кг/м?</td>
                            <td>Наличие на буровой</td>
                            <td colspan="2">Получение в день</td>
                            <td colspan="2">Расход за сутки</td>
                            <td>Остаток на буровой</td>
                        </tr>
                        <tr v-for="i in 8">
                            <td v-for="j in 6"><input type="text"></td>
                            <td v-for="j in 2" colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 11"><input type="text"></td>
                        </tr>
                        <tr v-for="i in 6">
                            <td v-for="j in 6"><input type="text"></td>
                            <td v-for="j in 2" colspan="2"><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="16" class="title">Расход оснавных материалов</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w-20">Наименование материалов</td>
                            <td>Прежде</td>
                            <td>Приход</td>
                            <td>Расход</td>
                            <td>Общий остаток</td>
                            <td colspan="5">Наименование материалов</td>
                            <td>Прежде</td>
                            <td>Приход</td>
                            <td colspan="2">Расход</td>
                            <td colspan="2">Общий остаток</td>
                        </tr>
                        <tr v-for="i in 7">
                            <td v-for="i in 5"><input type="text"></td>
                            <td colspan="5"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                        </tr>
                        <tr v-for="i in 2">
                            <td v-for="i in 16"><input type="text"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 5"><input type="text"></td>
                            <td colspan="5"><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="7" class="title">ГЕОЛОГИЧЕСКАЯ ИНФОРМАЦИЯ</th>
                            <th colspan="5" class="title">ОТБОР КЕРНА</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="2" class="align-middle">Стратиграфия</td>
                            <td colspan="3">Кровля</td>
                            <td rowspan="2" class="align-middle">Литология</td>
                            <td rowspan="2" class="align-middle">Градиент Рплас, кг/см? на м</td>
                            <td rowspan="2" class="align-middle">Градиент ГРП, кг/см? на м</td>
                            <td>Возраст</td>
                            <td>Интервал отбора</td>
                            <td>План, м</td>
                            <td>Факт, м</td>
                            <td>Вынос %</td>
                        </tr>
                        <tr>
                            <td>План, м</td>
                            <td>Факт, м</td>
                            <td>Мощн, м</td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                            <td><input type="text"></td>
                        </tr>
                        <tr v-for="i in 10">
                            <td v-for="i in 12"><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="10" class="title">ИНКЛИНОМЕТРИЯ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Глубина, м</td>
                            <td>Альтитуд α</td>
                            <td>Уголь (°)</td>
                            <td>Азимут(°)</td>
                            <td>Три прибора</td>
                            <td>Глубина, м</td>
                            <td>Альтитуд α</td>
                            <td>Уголь (°)</td>
                            <td>Азимут(°)</td>
                            <td>Три прибора</td>
                        </tr>
                        <tr v-for="i in 20">
                            <td v-for="i in 10"><input type="text"></td>
                        </tr>
                    </tbody>
                </table>
                <table class="tables table defaultTable">
                    <thead>
                        <tr>
                            <th colspan="22" class="title">ТЕХНИКА БЕЗОПАСНОСТИ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2">Пожарная тревога</td>
                            <td colspan="2">Уч. тревога H2S</td>
                            <td colspan="2">Инструктаж по Т/Б</td>
                            <td colspan="2">ГНВП при СПО</td>
                            <td colspan="3">Оппресовка ПВО</td>
                            <td colspan="3">Фукц. Проверка ПВО</td>
                            <td colspan="3">Тревога "ГНВП"</td>
                            <td colspan="3">Пер. мед. помощь</td>
                            <td colspan="2">Собрание по Т/Б</td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="2"><input type="text"></td>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="3"><input type="text"></td>
                            <td colspan="2 "><input type="text"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 22"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 5"></td>
                            <td colspan="2" class="text-right border-right-0 align-bottom">Супервайзер по бурению:</td>
                            <td colspan="6" class="border-left-0"><input type="text" style="border-bottom: 2px solid #FFFFFF"></td>
                            <td colspan="9"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 22"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 5"></td>
                            <td colspan="2" class="text-right border-right-none align-bottom">Буровой мастер:</td>
                            <td colspan="6" class="border-left-0"><input type="text" style="border-bottom: 2px solid #FFFFFF"></td>
                            <td colspan="9"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 22"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 5"></td>
                            <td colspan="2" class="text-right border-right-none align-bottom">Инженер по буровым раствором:</td>
                            <td colspan="6" class="border-left-0"><input type="text" style="border-bottom: 2px solid #FFFFFF"></td>
                            <td colspan="9"></td>
                        </tr>
                        <tr>
                            <td v-for="i in 22"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="decryption-block">
                    <div class="decryption-title">
                        *** Расшифровка сокрашении для персонала КТМ :
                    </div>
                    <div class="decryption-content">
                        <div class="decryption-content-left">
                            <p>БО - буровое оборудование</p>
                            <p>ПВО - противовыбросовое оборудование</p>
                            <p>ОУ - оборудование устья</p>
                            <p>УМК - универсальные машинные ключи</p>
                            <p>АКБ - автоматический бурильный ключ</p>
                            <p>ВУС - вязко-упругая смесь</p>
                            <p>БН - буровой насос, "F-1300" и "F-1600" типы БН</p>
                            <p>УБТ - утяжеленные бурильные трубы</p>
                            <p>СБТ - стальные бурильные трубы</p>
                            <p>ТБТ - толстостенные бурильные турбы</p>
                            <p>ГБЯ - гидравлический бурильный Ясс</p>
                        </div>
                        <div class="decryption-content-right">
                            <p>КУБТ - короткая утяжеленная бурильная труба</p>
                            <p>КШ - кран шаровый</p>
                            <p>ВД - высокое давление</p>
                            <p>ВСП - верхний силовой привод</p>
                            <p>БД / БГ - блок дросселирование / блок глушение</p>
                            <p>ПУГ - превентор универсальный гидравлический</p>
                            <p>ППГ - превентор плашечный гидравлический</p>
                            <p>БПР - блок приготовления раствора</p>
                            <p>ОБР - отработанный буровой раствор</p>
                            <p>ВПУБ - вспомогательный пульт управления бурильщика</p>
                            <p>ЦН - центробежный насос</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DailyRaport",
        data(){
            return{
                Expenses: [
                    {operation1: 'Бурение', operation2: 'Организ. простой'},
                    {operation1: 'Наращивание', operation2: 'Ремонт после 21 часа'},
                    {operation1: 'Проработка ствола', operation2: 'Осложения по стволу'},
                    {operation1: 'Промывка скважины', operation2: 'Авария'},
                    {operation1: 'СПО', operation2: 'Неэффективность работы'},
                    {operation1: 'ПЗР', operation2: 'Ожидание оборудование'},
                    {operation1: 'Т/О ВСП', operation2: 'Ожидание персонала'},
                    {operation1: 'ГИС', operation2: 'Ожидание техники'},
                    {operation1: 'Спуск ОК', operation2: 'Некачествен. цементир.'},
                    {operation1: 'Цементирование ОК', operation2: 'Ожидание указ. Заказчика'},
                    {operation1: 'ОЗЦ', operation2: 'Подогрев оборудования'},
                    {operation1: 'ОУ и ПВО', operation2: 'Ожидание химреагентов'},
                    {operation1: 'Ремонт до 21 часов', operation2: 'Отключение электр.энерг.'},
                    {operation1: 'РБЦ', operation2: 'Превыш. нормы времени'},
                    {operation1: 'Испытание пластов', operation2: ''},
                    {operation1: 'Монтаж КГ', operation2: ''},
                    {operation1: 'Другие', operation2: ''},
                    {operation1: '', operation2: ''},
                    {operation1: '', operation2: ''},
                ]
            }
        }
    }
</script>

<style scoped>

</style>