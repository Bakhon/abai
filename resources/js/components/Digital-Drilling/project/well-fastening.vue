<template>
    <div class="digitalDrillingTablesPage">
        <div class="digitalDrillingTables-head">
            <div class="digitalDrillingTables-head-title">
                {{ trans('digital_drilling.cementing_jobs') }}
            </div>
            <div class="export_btn" @click="download = !download">
                Скачать отчет
            </div>
        </div>
        <div class="digitalDrillingTables defaultScroll">
            <div>Табл. 1.9.1. Способы расчета наружных давлений и опрессовки колонн</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="2">
                        Номер колонны в порядке спуск
                    </th>
                    <th rowspan="2">
                        Номер раздельно спускаемой части колонны в порядке спуска
                    </th>
                    <th colspan="2">
                        Номер раздельно спускаемой части колонны в порядке спуска                    </th>
                    <th rowspan="2">
                        Плотность пластовой воды в интервале спуска колонны, г/см3
                    </th>
                    <th colspan="2">
                        Опрессовочный агент
                    </th>
                    <th rowspan="2">
                        Рекомендуемая глубина установки пакеров для опрессовки (сверху-вниз) по вертикали, м
                    </th>
                </tr>
                <tr>
                    <th>
                        допустима ли поэтапная опрессовка
                    </th>
                    <th>
                        рекомендуется ли вести расчет наружного давления по столбу бурового раствора
                    </th>
                    <th>
                        краткое название, тип шифр (буровой раствор, вода, воздух и т.п.)
                    </th>
                    <th>
                        плотность (для газообразного агента относительно воздуха), г/см3
                    </th>
                </tr>
                <tr>
                    <td v-for="i in 8">{{i}}</td>
                </tr>
                <tr v-for="i in 2">
                    <td v-for="i in 8"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.2. Распределение давлений по длине колонны</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="3">
                        Номер колонны в порядке спуска (см. табл. 5.2. гр.1)
                    </th>
                    <th rowspan="3">
                        Название колонны
                    </th>
                    <th rowspan="3">
                        Номер раздельно спускаемой части колонны в порядке спуска (см. табл. 5.2. гр.8)
                    </th>
                    <th colspan="6">
                        Распределение избыточных давлений по длине раздельно спускаемой части колонны
                    </th>
                </tr>
                <tr>
                    <th colspan="2">глубина (по вертикали), м</th>
                    <th colspan="2">наружное,МПа</th>
                    <th colspan="2">внутреннее, МПа</th>
                </tr>
                <tr>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                </tr>
                <tr>
                    <td v-for="i in 9">{{i}}</td>
                </tr>
                <tr v-for="i in 2">
                    <td v-for="i in 9"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.3 Рекомендуемые типоразмеры обсадных труб</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th colspan="6">Характеристики обсадных труб</th>
                    <th rowspan="2">Рекомендуется к использованию: да, нет</th>
                </tr>
                <tr>
                    <th>наружный диаметр, мм (см. табл. 1.5.3, гр.5)</th>
                    <th>производство: отечественное, импортное</th>
                    <th>условный код типа соединения (см. табл. 1.5.3, гр.11)</th>
                    <th>марка (группа прочности) труб</th>
                    <th>толщина стенки, мм</th>
                    <th>масса, кг/м</th>
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
            <div>Табл. 1.9.4. Параметры обсадных труб</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="3">
                        Номер колонны в орядке спуска (см. табл.5.2, гр.1)
                    </th>
                    <th rowspan="3">Номер раздельно спускаемой части колонны в порядке спуска (см. табл.5.2, гр.8)</th>
                    <th rowspan="3">Номер равнопрочной секции трубв раздельно спускаемой части колонны, (снизу-верх)</th>
                    <th colspan="2">Интервал установки равнопрочной секции, м (по стволу)</th>
                    <th rowspan="3">Длина секции, м</th>
                    <th rowspan="3">Масса секции, т</th>
                    <th rowspan="3">Нарастающая масса, тн</th>
                    <th colspan="4">Характеристика обсадной трубы</th>
                    <th colspan="3">Коэффициент запаса прочности на:</th>
                </tr>
                <tr>
                    <th rowspan="2">от, (верх)</th>
                    <th rowspan="2">до, (низ)</th>
                    <th rowspan="2">Номинальный наружный диа метр, мм</th>
                    <th rowspan="2">Код типа соединения (см. таб.16.2, гр.2.4.)</th>
                    <th rowspan="2">Марка (группа прочности) материала труб</th>
                    <th rowspan="2">Толщина стенки</th>
                    <th colspan="2">Избыточное давление</th>
                    <th rowspan="2">Растяжение</th>
                </tr>
                <tr>
                    <th>Наружное</th>
                    <th>Внутреннее</th>
                </tr>
                <tr>
                    <td v-for="i in 15">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 15"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.5. Суммарная масса обсадных труб</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th colspan="2">Характеристика трубы</th>
                    <th colspan="3">Масса труб с заданной характеристикой,  т</th>
                </tr>
                <tr>
                    <th rowspan="2">код типа соединения</th>
                    <th>Условное обозначение трубы по ГОСТ</th>
                    <th rowspan="2">теоретическая</th>
                    <th rowspan="2">с плюсовым допуском 5%       (4% при толщине стенки  < 7 мм </th>
                    <th rowspan="2">с нормативным запасом 5%</th>
                </tr>
                <tr>
                    <th>Условное обозначение муфты по ГОСТ</th>
                </tr>
                <tr>
                    <td v-for="i in 5">{{i}}</td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 5"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.6. Технологическая оснастка обсадных колонн</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="3">Номер колонны в порядке спуска</th>
                    <th rowspan="3">Название колонны</th>
                    <th rowspan="3">Номер части колонны в порядке спуска</th>
                    <th colspan="6">Элементы технологической оснастки колонны</th>
                    <th colspan="2">Суммарные на колонну</th>
                </tr>
                <tr>
                    <th rowspan="2">наименование, шифр, типоразмер</th>
                    <th rowspan="2">ГОСТ, ОСТ, ТУ, МРТУ, МУ и т. Д. на изготовление</th>
                    <th rowspan="2">масса элемента, кг</th>
                    <th colspan="2">интервал установки, м (по стволу)</th>
                    <th rowspan="2">количество элементов на интервале</th>
                    <th rowspan="2">коли-чест-во, шт.</th>
                    <th rowspan="2">масса, кг</th>
                </tr>
                <tr>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                </tr>
                <tr>
                    <td v-for="i in 11">{{i}}</td>
                </tr>
                <tr>
                    <td rowspan="2"></td>
                    <td v-for="i in 10"></td>
                </tr>
                <tr>
                    <td v-for="i in 10"></td>
                </tr>
                <tr>
                    <td rowspan="5"></td>
                    <td v-for="i in 10"></td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 10"></td>
                </tr>
                <tr>
                    <td rowspan="5" class="blueRow"></td>
                    <td v-for="i in 10"></td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 10"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.7. Режим спуска обсадных труб</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="2">Номер колонны в порядке спуска</th>
                    <th rowspan="2">Название колонны</th>
                    <th rowspan="2">Номер части колонны в порядке спуск</th>
                    <th rowspan="2">Тип, шифр инструмента для спуска (элеватор, спайдер, спайдер-элеватор)</th>
                    <th colspan="2">Средства смазки и уплотнения резьбовых соединений</th>
                    <th rowspan="2">Расход смазки, кг</th>
                    <th colspan="2">Интервал глубины с одинаковой допустимой скоростью спуска труб, м</th>
                    <th rowspan="2">Допустимая скорость спуска труб,  м/с</th>
                    <th rowspan="2">Допустимая  глубина спуска труб на клиньях, м</th>
                    <th rowspan="2">Периодичность долива колонны, м</th>
                    <th colspan="3">Промежуточные промывки</th>
                </tr>
                <tr>
                    <th>шифр или назва-ние</th>
                    <th>ГОСТ, ОСТ, МРТУ, ТУ, МУ и т. п. на изготовление</th>
                    <th>от (верх</th>
                    <th>до (низ)</th>
                    <th>глубина, м</th>
                    <th>продолжительность, мин.</th>
                    <th>расход, л/с</th>
                </tr>
                <tr>
                    <td v-for="i in 15">{{i}}</td>
                </tr>
                <tr>
                    <td v-for="i in 11"></td>
                    <td rowspan="4" class="blueRow"></td>
                    <td v-for="i in 3"></td>
                </tr>
                <tr v-for="i in 3">
                    <td v-for="i in 14"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.8. Опрессовка обсадных труб и натяжение эксплуатационной колонны</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="2">Номер колонны в порядке спуска</th>
                    <th rowspan="2">Название колонны</th>
                    <th rowspan="2">Номер раздельно спускаемой части колонны в порядке спуска</th>
                    <th rowspan="2">Натяжение эксплуатационной колонны, тс</th>
                    <th colspan="2">Плотность жидкости для опрессовки, кг/м</th>
                    <th colspan="3">Давление на устье скважины при опрессовке, МПа</th>
                    <th rowspan="2">Глубина установки пакера, м</th>
                    <th rowspan="2">Давление на устье скважины при опрессовке труб ниже пакера, МПа</th>
                    <th rowspan="2">Номер равнопрочной секции труб в раздельно спускаемой части (снизу-вверх)  см. табл. .1.5.8</th>
                    <th rowspan="2">Давление опрессовки труб  равнопрочной секции на поверхности, МПа</th>
                </tr>
                <tr>
                    <th>раздельно спускаемой части</th>
                    <th>цементного кольца</th>
                    <th>раздельно спускаемой  части</th>
                    <th>цементного кольца</th>
                    <th>Части колонны ниже муфты для 2^Х ступ. цементирования</th>
                </tr>
                <tr>
                    <td v-for="i in 13">{{i}}</td>
                </tr>
                <tr v-for="i in 2">
                    <td v-for="i in 13"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.9. Общие сведения о цементировании обсадных колонн</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="3">Номер колонны в порядке спуска</th>
                    <th rowspan="3">Название колонны (см. табл. 5.2, гр. 2)</th>
                    <th rowspan="3">Способ цементиро-вания (прямой, ступенчатый, обратный</th>
                    <th colspan="4">Данные по раздельно спускаемой части колонны</th>
                    <th colspan="5">Данные о каждой ступени цементирования</th>
                </tr>
                <tr>
                    <th rowspan="2">номер раздельно спускаемой части колонны в порядке спуска  (см. табл. 5.2, гр. 8)</th>
                    <th colspan="2">интервал установки (по стволу), м</th>
                    <th rowspan="2">глубина  установки муфты для ступен-чатого цементи-рования, м</th>
                    <th rowspan="2">номер ступени цементирования</th>
                    <th rowspan="2">высота цемент-ного стакана м</th>
                    <th rowspan="2">название порции тампонажного раствора</th>
                    <th colspan="2">интервал  глубины цементирова-ния (по стволу), м</th>
                </tr>
                <tr>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                    <th>от (верх)</th>
                    <th>до (низ)</th>
                </tr>
                <tr>
                    <td v-for="i in 12"></td>
                </tr>
                <tr>
                    <td rowspan="2" v-for="i in 9" class="blueRow"></td>
                    <td v-for="i in 3"></td>
                </tr>
                <tr>
                    <td v-for="i in 3"></td>
                </tr>
                <tr>
                    <td rowspan="3" v-for="i in 9"></td>
                    <td v-for="i in 3" class="blueRow"></td>
                </tr>
                <tr v-for="i in 2">
                    <td v-for="i in 3"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.10. Характеристика жидкостей для цементирования</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="2">Табл. 1.9.10. Характеристика жидкостей для цементирования</th>
                    <th rowspan="2">Название колонны (см. табл. 5.2, гр. 2)</th>
                    <th rowspan="2">Номер части колонны в порядке спуска (см. табл. 5.2, гр. 8)</th>
                    <th rowspan="2">Номер ступени (снизу-вверх)</th>
                    <th colspan="8">Характеристика жидкости (раствора)</th>
                </tr>
                <tr>
                    <th>Характеристика жидкости (раствора)</th>
                    <th>Объем порции, м3</th>
                    <th>Плотность, кг/м3</th>
                    <th>пластическая вязкость, сП</th>
                    <th>динамическое напряжение сдвига, мгс/см2</th>
                    <th>Время начала схватывания, мин.</th>
                    <th>Время ОЗЦ, час</th>
                    <th>Производительность при затворении, л/сек</th>
                </tr>
                <tr>
                    <td v-for="i in 12"></td>
                </tr>
                <tr>
                    <td rowspan="2" v-for="i in 4" class="blueRow"></td>
                    <td v-for="i in 8"></td>
                </tr>
                <tr>
                    <td v-for="i in 8"></td>
                </tr>
                <tr>
                    <td rowspan="3" v-for="i in 4" class="blueRow"></td>
                    <td v-for="i in 8"></td>
                </tr>
                <tr v-for="i in 2">
                    <td v-for="i in 8"></td>
                </tr>
                <tr>
                    <td rowspan="3" v-for="i in 4" class="blueRow"></td>
                    <td v-for="i in 8"></td>
                </tr>
                <tr v-for="i in 2">
                    <td v-for="i in 8"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.11. Компонентный состав жидкостей для цементирования и характеристики компонентов</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th>Номер колонны в порядке спуска</th>
                    <th>Название колонны (см. табл. 1.5.2, гр. 2)</th>
                    <th>Номер части колонны в порядке спуска (см. табл. 1.5.2, гр.8)</th>
                    <th>Номер ступени (снизу-вверх)</th>
                    <th>Тип или название жидкости для цементирования</th>
                    <th>Название компонента</th>
                    <th>Плотность, г/см3</th>
                    <th>Влажность, %</th>
                    <th>Сорт</th>
                    <th>ГОСТ,ОСТ, МРТУ, ТУ, МУ и т.п на изготовление</th>
                    <th>Норма расхода компонента, кг/м3</th>
                </tr>
                <tr>
                    <td v-for="i in 11">{{i}}</td>
                </tr>
                <tr>
                    <td rowspan="6" v-for="i in 4" class="blueRow"></td>
                    <td v-for="i in 7"></td>
                </tr>
                <tr>
                    <td rowspan="4" class="blueRow"></td>
                    <td v-for="i in 6"></td>
                </tr>
                <tr v-for="i in 3">
                    <td v-for="i in 6"></td>
                </tr>
                <tr>
                    <td v-for="i in 7"></td>
                </tr>
                <tr>
                    <td rowspan="8" v-for="i in 4" class="blueRow"></td>
                    <td v-for="i in 7"></td>
                </tr>
                <tr>
                    <td rowspan="5" class="blueRow"></td>
                    <td v-for="i in 6"></td>
                </tr>
                <tr v-for="i in 4">
                    <td v-for="i in 6"></td>
                </tr>
                <tr>
                    <td v-for="i in 7"></td>
                </tr>
                <tr>
                    <td v-for="i in 7"></td>
                </tr>
                <tr>
                    <td rowspan="13" v-for="i in 4"></td>
                    <td v-for="i in 7"></td>
                </tr>
                <tr>
                    <td rowspan="3"></td>
                    <td v-for="i in 6"></td>
                </tr>
                <tr v-for="i in 2">
                    <td v-for="i in 6"></td>
                </tr>
                <tr>
                    <td rowspan="8"></td>
                    <td v-for="i in 6"></td>
                </tr>
                <tr v-for="i in 7">
                    <td v-for="i in 6"></td>
                </tr>
                <tr>
                    <td v-for="i in 7"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.12. Технологические операции при цементировании и режим работы цементировочных агрегатов (буровых насосов)</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="3">Номер колонны в порядке спуска</th>
                    <th rowspan="3">Номер  части колонны в порядке спуска, (см. таб. 1.5.2, гр.8)</th>
                    <th rowspan="3">Номер ступени цементирования (снизу-вверх)</th>
                    <th rowspan="3">Наименование технологической операции</th>
                    <th rowspan="3">Тип или название жидкости</th>
                    <th rowspan="3">Тип (шифр) агрегата или бурового насоса</th>
                    <th rowspan="3">Назначение агрегата или бурового насоса</th>
                    <th rowspan="3">Количество агрегатов (буровых насосов), работающих на одном режиме</th>
                    <th colspan="6">Режим работы агрегатов (буровых) насосов</th>
                    <th rowspan="2" colspan="2">Время выполнения технологической операции, мин</th>
                </tr>
                <tr>
                    <th rowspan="2">диаметр цилиндровых втулок, мм</th>
                    <th rowspan="2">скорость агрегата или число двойных ходов бурового насоса</th>
                    <th rowspan="2">суммарная производительность агрегатов (бурового насосов), л/с</th>
                    <th colspan="2">давление, кгс/см2</th>
                    <th rowspan="2">объем порции на данном режиме</th>
                </tr>
                <tr>
                    <th>допустимое для агрегатов (буровых  насос)</th>
                    <th>на устье скважины в конце операции</th>
                    <th>в данном режиме</th>
                    <th>нарастающее от начала затворения до момента «стоп»</th>
                </tr>
                <tr>
                    <td v-for="i in 16">{{i}}</td>
                </tr>
                <tr>
                    <td rowspan="8" class="text-left align-text-top">1</td>
                    <td rowspan="8" v-for="i in 2"></td>
                    <td rowspan="2" v-for="i in 2"></td>
                    <td v-for="i in 11"></td>
                </tr>
                <tr>
                    <td v-for="i in 11"></td>
                </tr>
                <tr>
                    <td rowspan="4" v-for="i in 2" class="blueRow"></td>
                    <td rowspan="4" v-for="i in 2" class="blueRow"></td>
                    <td v-for="i in 11"></td>
                </tr>
                <tr v-for="i in 3">
                    <td v-for="i in 11"></td>
                </tr>
                <tr>
                    <td  rowspan="2" v-for="i in 3"></td>
                    <td v-for="i in 9"></td>
                </tr>
                <tr>
                    <td v-for="i in 9"></td>
                </tr>
                <tr>
                    <td rowspan="10" class="text-left align-text-top">2</td>
                    <td rowspan="10" v-for="i in 2"></td>
                    <td v-for="i in 13"></td>
                </tr>
                <tr>
                    <td rowspan="2" v-for="i in 2" class="blueRow"></td>
                    <td v-for="i in 11"></td>
                </tr>
                <tr>
                    <td v-for="i in 11"></td>
                </tr>
                <tr>
                    <td rowspan="3" v-for="i in 2" class="blueRow"></td>
                    <td v-for="i in 11"></td>
                </tr>
                <tr v-for="i in 2">
                    <td v-for="i in 11"></td>
                </tr>
                <tr v-for="i in 2">
                    <td colspan="2"></td>
                    <td v-for="i in 11"></td>
                </tr>
                <tr>
                    <td rowspan="2" v-for="i in 3"></td>
                    <td v-for="i in 10"></td>
                </tr>
                <tr>
                    <td v-for="i in 10"></td>
                </tr>
                <tr>
                    <td rowspan="10" class="text-left align-text-top">3</td>
                    <td rowspan="10" v-for="i in 2"></td>
                    <td v-for="i in 13"></td>
                </tr>
                <tr v-for="i in 5">
                    <td v-for="i in 13"></td>
                </tr>
                <tr v-for="i in 2">
                    <td colspan="2"></td>
                    <td v-for="i in 11"></td>
                </tr>
                <tr>
                    <td rowspan="2" v-for="i in 3"></td>
                    <td v-for="i in 10"></td>
                </tr>
                <tr>
                    <td v-for="i in 10"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.13. Схема обвязки и потребность в цементировочных агрегатах</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="4">Номер колонны в порядке спуска</th>
                    <th rowspan="4">Номер части колонны</th>
                    <th rowspan="4">Номер ступени цементирования</th>
                    <th rowspan="2" colspan="2">Интервал цементирования</th>
                    <th rowspan="4">Номер схемы обвязки цементировочной техники</th>
                    <th colspan="11">Потребное количество</th>
                </tr>
                <tr>
                    <th colspan="8">Основные ЦА</th>
                    <th colspan="3">Дополнительные ЦА</th>
                </tr>
                <tr>
                    <th rowspan="2">от, (верх)</th>
                    <th rowspan="2">до, (низ)</th>
                    <th rowspan="2">тип</th>
                    <th rowspan="2">всего</th>
                    <th colspan="6">в том числе на:</th>
                    <th rowspan="2">тип</th>
                    <th rowspan="2">всего</th>
                    <th rowspan="2">резерв</th>
                </tr>
                <tr>
                    <th>затворение</th>
                    <th>перемешивание</th>
                    <th>Закачка</th>
                    <th>продавка</th>
                    <th>амбар</th>
                    <th>резерв</th>
                </tr>
                <tr>
                    <td v-for="i in 17">{{i}}</td>
                </tr>
                <tr>
                    <td class="text-left">1</td>
                    <td v-for="i in 16"></td>
                </tr>
                <tr>
                    <td rowspan="3" class="blueRow text-left align-text-top">2</td>
                    <td rowspan="3" v-for="i in 5" class="blueRow"></td>
                    <td v-for="i in 11"></td>
                </tr>
                <tr v-for="i in 2">
                    <td v-for="i in 11"></td>
                </tr>
                <tr>
                    <td rowspan="3" class="blueRow text-left align-text-top">3</td>
                    <td rowspan="3" v-for="i in 5" class="blueRow"></td>
                    <td v-for="i in 11"></td>
                </tr>
                <tr v-for="i in 2">
                    <td v-for="i in 11"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.14. Потребность в смесительных машинах, цементовозах и автоцистернах</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="4">Номер колонны в порядке спуска</th>
                    <th rowspan="4">Номер  части колонны</th>
                    <th rowspan="4">Номер ступени цементирования</th>
                    <th rowspan="2" colspan="2">Интервал, м</th>
                    <th colspan="14">Потребное количество</th>
                </tr>
                <tr>
                    <th colspan="5">Смесительные машины</th>
                    <th colspan="4">Цементовозы</th>
                    <th colspan="5">Автоцистерны</th>
                </tr>
                <tr>
                    <th rowspan="2">от (верх)</th>
                    <th rowspan="2">до (низ)</th>
                    <th rowspan="2">тип</th>
                    <th rowspan="2">всего</th>
                    <th colspan="3">в том числе</th>
                    <th rowspan="2">тип</th>
                    <th rowspan="2">всего</th>
                    <th colspan="3">в том числе</th>
                    <th rowspan="2">тип</th>
                    <th rowspan="2">всего</th>
                    <th colspan="3">в том числе</th>
                </tr>
                <tr>
                    <th>тампонаж-1</th>
                    <th>тампонаж-2</th>
                    <th>тампонаж-3</th>
                    <th>тампонаж-1</th>
                    <th>тампонаж-2</th>
                    <th>буферная</th>
                    <th>затворение</th>
                    <th>продавочная</th>
                </tr>
                <tr>
                    <td v-for="i in 19">{{i}}</td>
                </tr>
                <tr v-for="i in 3">
                    <td>{{i}}</td>
                    <td v-for="i in 18"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.15. Потребное количество цементировочной техники для цементирования обсадных колонн</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="3">№ по порядку</th>
                    <th rowspan="3">Название или шифр</th>
                    <th colspan="4">Потребное количество, шт.</th>
                </tr>
                <tr>
                    <th colspan="3">номера колонн (см. таблицу 1.5.2., графа 1)</th>
                    <th rowspan="2">суммарное на скважину</th>
                </tr>
                <tr>
                    <th v-for="i in 3">{{i}}</th>
                </tr>
                <tr>
                    <td v-for="i in 6">{{i}}</td>
                </tr>
                <tr v-for="i in 6">
                    <td v-for="i in 6"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.16. Потребное количество материалов для цементирования обсадных колонн</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th rowspan="4">Номер по порядку</th>
                    <th rowspan="4">Название или шифр</th>
                    <th rowspan="4">ГОСТ, ОСТ, МРТУ, ТУ, МУ и т.п. на изготовление</th>
                    <th rowspan="4">Единица измерения</th>
                    <th colspan="4">Потребное количество</th>
                </tr>
                <tr>
                    <th colspan="3">Номера колонн (см. таблицу 1.5.2, графа 1)</th>
                    <th rowspan="2">Суммарное на скважину</th>
                </tr>
                <tr>
                    <th rowspan="2">0-30</th>
                    <th rowspan="2">0-160</th>
                    <th rowspan="2">0-740</th>
                </tr>
                <tr>
                    <th></th>
                </tr>
                <tr>
                    <th v-for="i in 8">{{i}}</th>
                </tr>
                <tr v-for="i in 14">
                    <td>{{i}}</td>
                    <td v-for="i in 7"></td>
                </tr>
                </tbody>
            </table>
            <note />
            <div>Табл. 1.9.17. Спецификация устьевого и противовыбросового оборудования (ПВО)</div>
            <table class="table defaultTable">
                <tbody>
                <tr>
                    <th colspan="2">Обсадная колонна</th>
                    <th rowspan="2">Номер схемы обвязки ПВО</th>
                    <th colspan="2">Давление опрессовки устьевого оборудования и ПВО,  МПа</th>
                    <th rowspan="2">Типоразмер, шифр или название устанавливаемого устьевого и ПВО оборудования</th>
                    <th rowspan="2">ГОСТ, ОСТ, МРТУ, ТУ, МУ и т. д. на изготовление</th>
                    <th rowspan="2">Количество, шт.</th>
                    <th rowspan="2">Допустимое рабочее давление, МПа</th>
                </tr>
                <tr>
                    <th>номер в порядке спуска</th>
                    <th>название</th>
                    <th>после установки</th>
                    <th>перед вскрытием напорного горизонта</th>
                </tr>
                <tr>
                    <td v-for="i in 9">{{i}}</td>
                </tr>
                <tr v-for="i in 2">
                    <td>{{i+1}}</td>
                    <td v-for="i in 8"></td>
                </tr>
                </tbody>
            </table>
            <note />
        </div>
        <report-download v-if="download" @close="download = !download">
            <template #tableBody>
                <div class="name">Крепление</div>
                <div class="black">Табл. 1.9.1. Способы расчета наружных давлений и опрессовки колонн</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="2">
                            Номер колонны в порядке спуск
                        </th>
                        <th rowspan="2">
                            Номер раздельно спускаемой части колонны в порядке спуска
                        </th>
                        <th colspan="2">
                            Номер раздельно спускаемой части колонны в порядке спуска                    </th>
                        <th rowspan="2">
                            Плотность пластовой воды в интервале спуска колонны, г/см3
                        </th>
                        <th colspan="2">
                            Опрессовочный агент
                        </th>
                        <th rowspan="2">
                            Рекомендуемая глубина установки пакеров для опрессовки (сверху-вниз) по вертикали, м
                        </th>
                    </tr>
                    <tr>
                        <th>
                            допустима ли поэтапная опрессовка
                        </th>
                        <th>
                            рекомендуется ли вести расчет наружного давления по столбу бурового раствора
                        </th>
                        <th>
                            краткое название, тип шифр (буровой раствор, вода, воздух и т.п.)
                        </th>
                        <th>
                            плотность (для газообразного агента относительно воздуха), г/см3
                        </th>
                    </tr>
                    <tr>
                        <td v-for="i in 8">{{i}}</td>
                    </tr>
                    <tr v-for="i in 2">
                        <td v-for="i in 8"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.2. Распределение давлений по длине колонны</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="3">
                            Номер колонны в порядке спуска (см. табл. 5.2. гр.1)
                        </th>
                        <th rowspan="3">
                            Название колонны
                        </th>
                        <th rowspan="3">
                            Номер раздельно спускаемой части колонны в порядке спуска (см. табл. 5.2. гр.8)
                        </th>
                        <th colspan="6">
                            Распределение избыточных давлений по длине раздельно спускаемой части колонны
                        </th>
                    </tr>
                    <tr>
                        <th colspan="2">глубина (по вертикали), м</th>
                        <th colspan="2">наружное,МПа</th>
                        <th colspan="2">внутреннее, МПа</th>
                    </tr>
                    <tr>
                        <th>от (верх)</th>
                        <th>до (низ)</th>
                        <th>от (верх)</th>
                        <th>до (низ)</th>
                        <th>от (верх)</th>
                        <th>до (низ)</th>
                    </tr>
                    <tr>
                        <td v-for="i in 9">{{i}}</td>
                    </tr>
                    <tr v-for="i in 2">
                        <td v-for="i in 9"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.3 Рекомендуемые типоразмеры обсадных труб</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th colspan="6">Характеристики обсадных труб</th>
                        <th rowspan="2">Рекомендуется к использованию: да, нет</th>
                    </tr>
                    <tr>
                        <th>наружный диаметр, мм (см. табл. 1.5.3, гр.5)</th>
                        <th>производство: отечественное, импортное</th>
                        <th>условный код типа соединения (см. табл. 1.5.3, гр.11)</th>
                        <th>марка (группа прочности) труб</th>
                        <th>толщина стенки, мм</th>
                        <th>масса, кг/м</th>
                    </tr>
                    <tr>
                        <td v-for="i in 7">{{i}}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 7"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.4. Параметры обсадных труб</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="3">
                            Номер колонны в орядке спуска (см. табл.5.2, гр.1)
                        </th>
                        <th rowspan="3">Номер раздельно спускаемой части колонны в порядке спуска (см. табл.5.2, гр.8)</th>
                        <th rowspan="3">Номер равнопрочной секции трубв раздельно спускаемой части колонны, (снизу-верх)</th>
                        <th colspan="2">Интервал установки равнопрочной секции, м (по стволу)</th>
                        <th rowspan="3">Длина секции, м</th>
                        <th rowspan="3">Масса секции, т</th>
                        <th rowspan="3">Нарастающая масса, тн</th>
                        <th colspan="4">Характеристика обсадной трубы</th>
                        <th colspan="3">Коэффициент запаса прочности на:</th>
                    </tr>
                    <tr>
                        <th rowspan="2">от, (верх)</th>
                        <th rowspan="2">до, (низ)</th>
                        <th rowspan="2">Номинальный наружный диа метр, мм</th>
                        <th rowspan="2">Код типа соединения (см. таб.16.2, гр.2.4.)</th>
                        <th rowspan="2">Марка (группа прочности) материала труб</th>
                        <th rowspan="2">Толщина стенки</th>
                        <th colspan="2">Избыточное давление</th>
                        <th rowspan="2">Растяжение</th>
                    </tr>
                    <tr>
                        <th>Наружное</th>
                        <th>Внутреннее</th>
                    </tr>
                    <tr>
                        <td v-for="i in 15">{{i}}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 15"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.5. Суммарная масса обсадных труб</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th colspan="2">Характеристика трубы</th>
                        <th colspan="3">Масса труб с заданной характеристикой,  т</th>
                    </tr>
                    <tr>
                        <th rowspan="2">код типа соединения</th>
                        <th>Условное обозначение трубы по ГОСТ</th>
                        <th rowspan="2">теоретическая</th>
                        <th rowspan="2">с плюсовым допуском 5%       (4% при толщине стенки  < 7 мм </th>
                        <th rowspan="2">с нормативным запасом 5%</th>
                    </tr>
                    <tr>
                        <th>Условное обозначение муфты по ГОСТ</th>
                    </tr>
                    <tr>
                        <td v-for="i in 5">{{i}}</td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 5"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.6. Технологическая оснастка обсадных колонн</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="3">Номер колонны в порядке спуска</th>
                        <th rowspan="3">Название колонны</th>
                        <th rowspan="3">Номер части колонны в порядке спуска</th>
                        <th colspan="6">Элементы технологической оснастки колонны</th>
                        <th colspan="2">Суммарные на колонну</th>
                    </tr>
                    <tr>
                        <th rowspan="2">наименование, шифр, типоразмер</th>
                        <th rowspan="2">ГОСТ, ОСТ, ТУ, МРТУ, МУ и т. Д. на изготовление</th>
                        <th rowspan="2">масса элемента, кг</th>
                        <th colspan="2">интервал установки, м (по стволу)</th>
                        <th rowspan="2">количество элементов на интервале</th>
                        <th rowspan="2">коли-чест-во, шт.</th>
                        <th rowspan="2">масса, кг</th>
                    </tr>
                    <tr>
                        <th>от (верх)</th>
                        <th>до (низ)</th>
                    </tr>
                    <tr>
                        <td v-for="i in 11">{{i}}</td>
                    </tr>
                    <tr>
                        <td rowspan="2"></td>
                        <td v-for="i in 10"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 10"></td>
                    </tr>
                    <tr>
                        <td rowspan="5"></td>
                        <td v-for="i in 10"></td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 10"></td>
                    </tr>
                    <tr>
                        <td rowspan="5" class="blueRow"></td>
                        <td v-for="i in 10"></td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 10"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.7. Режим спуска обсадных труб</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="2">Номер колонны в порядке спуска</th>
                        <th rowspan="2">Название колонны</th>
                        <th rowspan="2">Номер части колонны в порядке спуск</th>
                        <th rowspan="2">Тип, шифр инструмента для спуска (элеватор, спайдер, спайдер-элеватор)</th>
                        <th colspan="2">Средства смазки и уплотнения резьбовых соединений</th>
                        <th rowspan="2">Расход смазки, кг</th>
                        <th colspan="2">Интервал глубины с одинаковой допустимой скоростью спуска труб, м</th>
                        <th rowspan="2">Допустимая скорость спуска труб,  м/с</th>
                        <th rowspan="2">Допустимая  глубина спуска труб на клиньях, м</th>
                        <th rowspan="2">Периодичность долива колонны, м</th>
                        <th colspan="3">Промежуточные промывки</th>
                    </tr>
                    <tr>
                        <th>шифр или назва-ние</th>
                        <th>ГОСТ, ОСТ, МРТУ, ТУ, МУ и т. п. на изготовление</th>
                        <th>от (верх</th>
                        <th>до (низ)</th>
                        <th>глубина, м</th>
                        <th>продолжительность, мин.</th>
                        <th>расход, л/с</th>
                    </tr>
                    <tr>
                        <td v-for="i in 15">{{i}}</td>
                    </tr>
                    <tr>
                        <td v-for="i in 11"></td>
                        <td rowspan="4" class="blueRow"></td>
                        <td v-for="i in 3"></td>
                    </tr>
                    <tr v-for="i in 3">
                        <td v-for="i in 14"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.8. Опрессовка обсадных труб и натяжение эксплуатационной колонны</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="2">Номер колонны в порядке спуска</th>
                        <th rowspan="2">Название колонны</th>
                        <th rowspan="2">Номер раздельно спускаемой части колонны в порядке спуска</th>
                        <th rowspan="2">Натяжение эксплуатационной колонны, тс</th>
                        <th colspan="2">Плотность жидкости для опрессовки, кг/м</th>
                        <th colspan="3">Давление на устье скважины при опрессовке, МПа</th>
                        <th rowspan="2">Глубина установки пакера, м</th>
                        <th rowspan="2">Давление на устье скважины при опрессовке труб ниже пакера, МПа</th>
                        <th rowspan="2">Номер равнопрочной секции труб в раздельно спускаемой части (снизу-вверх)  см. табл. .1.5.8</th>
                        <th rowspan="2">Давление опрессовки труб  равнопрочной секции на поверхности, МПа</th>
                    </tr>
                    <tr>
                        <th>раздельно спускаемой части</th>
                        <th>цементного кольца</th>
                        <th>раздельно спускаемой  части</th>
                        <th>цементного кольца</th>
                        <th>Части колонны ниже муфты для 2^Х ступ. цементирования</th>
                    </tr>
                    <tr>
                        <td v-for="i in 13">{{i}}</td>
                    </tr>
                    <tr v-for="i in 2">
                        <td v-for="i in 13"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.9. Общие сведения о цементировании обсадных колонн</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="3">Номер колонны в порядке спуска</th>
                        <th rowspan="3">Название колонны (см. табл. 5.2, гр. 2)</th>
                        <th rowspan="3">Способ цементиро-вания (прямой, ступенчатый, обратный</th>
                        <th colspan="4">Данные по раздельно спускаемой части колонны</th>
                        <th colspan="5">Данные о каждой ступени цементирования</th>
                    </tr>
                    <tr>
                        <th rowspan="2">номер раздельно спускаемой части колонны в порядке спуска  (см. табл. 5.2, гр. 8)</th>
                        <th colspan="2">интервал установки (по стволу), м</th>
                        <th rowspan="2">глубина  установки муфты для ступен-чатого цементи-рования, м</th>
                        <th rowspan="2">номер ступени цементирования</th>
                        <th rowspan="2">высота цемент-ного стакана м</th>
                        <th rowspan="2">название порции тампонажного раствора</th>
                        <th colspan="2">интервал  глубины цементирова-ния (по стволу), м</th>
                    </tr>
                    <tr>
                        <th>от (верх)</th>
                        <th>до (низ)</th>
                        <th>от (верх)</th>
                        <th>до (низ)</th>
                    </tr>
                    <tr>
                        <td v-for="i in 12"></td>
                    </tr>
                    <tr>
                        <td rowspan="2" v-for="i in 9" class="blueRow"></td>
                        <td v-for="i in 3"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 3"></td>
                    </tr>
                    <tr>
                        <td rowspan="3" v-for="i in 9"></td>
                        <td v-for="i in 3" class="blueRow"></td>
                    </tr>
                    <tr v-for="i in 2">
                        <td v-for="i in 3"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.10. Характеристика жидкостей для цементирования</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="2">Табл. 1.9.10. Характеристика жидкостей для цементирования</th>
                        <th rowspan="2">Название колонны (см. табл. 5.2, гр. 2)</th>
                        <th rowspan="2">Номер части колонны в порядке спуска (см. табл. 5.2, гр. 8)</th>
                        <th rowspan="2">Номер ступени (снизу-вверх)</th>
                        <th colspan="8">Характеристика жидкости (раствора)</th>
                    </tr>
                    <tr>
                        <th>Характеристика жидкости (раствора)</th>
                        <th>Объем порции, м3</th>
                        <th>Плотность, кг/м3</th>
                        <th>пластическая вязкость, сП</th>
                        <th>динамическое напряжение сдвига, мгс/см2</th>
                        <th>Время начала схватывания, мин.</th>
                        <th>Время ОЗЦ, час</th>
                        <th>Производительность при затворении, л/сек</th>
                    </tr>
                    <tr>
                        <td v-for="i in 12"></td>
                    </tr>
                    <tr>
                        <td rowspan="2" v-for="i in 4" class="blueRow"></td>
                        <td v-for="i in 8"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 8"></td>
                    </tr>
                    <tr>
                        <td rowspan="3" v-for="i in 4" class="blueRow"></td>
                        <td v-for="i in 8"></td>
                    </tr>
                    <tr v-for="i in 2">
                        <td v-for="i in 8"></td>
                    </tr>
                    <tr>
                        <td rowspan="3" v-for="i in 4" class="blueRow"></td>
                        <td v-for="i in 8"></td>
                    </tr>
                    <tr v-for="i in 2">
                        <td v-for="i in 8"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.11. Компонентный состав жидкостей для цементирования и характеристики компонентов</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th>Номер колонны в порядке спуска</th>
                        <th>Название колонны (см. табл. 1.5.2, гр. 2)</th>
                        <th>Номер части колонны в порядке спуска (см. табл. 1.5.2, гр.8)</th>
                        <th>Номер ступени (снизу-вверх)</th>
                        <th>Тип или название жидкости для цементирования</th>
                        <th>Название компонента</th>
                        <th>Плотность, г/см3</th>
                        <th>Влажность, %</th>
                        <th>Сорт</th>
                        <th>ГОСТ,ОСТ, МРТУ, ТУ, МУ и т.п на изготовление</th>
                        <th>Норма расхода компонента, кг/м3</th>
                    </tr>
                    <tr>
                        <td v-for="i in 11">{{i}}</td>
                    </tr>
                    <tr>
                        <td rowspan="6" v-for="i in 4" class="blueRow"></td>
                        <td v-for="i in 7"></td>
                    </tr>
                    <tr>
                        <td rowspan="4" class="blueRow"></td>
                        <td v-for="i in 6"></td>
                    </tr>
                    <tr v-for="i in 3">
                        <td v-for="i in 6"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 7"></td>
                    </tr>
                    <tr>
                        <td rowspan="8" v-for="i in 4" class="blueRow"></td>
                        <td v-for="i in 7"></td>
                    </tr>
                    <tr>
                        <td rowspan="5" class="blueRow"></td>
                        <td v-for="i in 6"></td>
                    </tr>
                    <tr v-for="i in 4">
                        <td v-for="i in 6"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 7"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 7"></td>
                    </tr>
                    <tr>
                        <td rowspan="13" v-for="i in 4"></td>
                        <td v-for="i in 7"></td>
                    </tr>
                    <tr>
                        <td rowspan="3"></td>
                        <td v-for="i in 6"></td>
                    </tr>
                    <tr v-for="i in 2">
                        <td v-for="i in 6"></td>
                    </tr>
                    <tr>
                        <td rowspan="8"></td>
                        <td v-for="i in 6"></td>
                    </tr>
                    <tr v-for="i in 7">
                        <td v-for="i in 6"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 7"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.12. Технологические операции при цементировании и режим работы цементировочных агрегатов (буровых насосов)</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="3">Номер колонны в порядке спуска</th>
                        <th rowspan="3">Номер  части колонны в порядке спуска, (см. таб. 1.5.2, гр.8)</th>
                        <th rowspan="3">Номер ступени цементирования (снизу-вверх)</th>
                        <th rowspan="3">Наименование технологической операции</th>
                        <th rowspan="3">Тип или название жидкости</th>
                        <th rowspan="3">Тип (шифр) агрегата или бурового насоса</th>
                        <th rowspan="3">Назначение агрегата или бурового насоса</th>
                        <th rowspan="3">Количество агрегатов (буровых насосов), работающих на одном режиме</th>
                        <th colspan="6">Режим работы агрегатов (буровых) насосов</th>
                        <th rowspan="2" colspan="2">Время выполнения технологической операции, мин</th>
                    </tr>
                    <tr>
                        <th rowspan="2">диаметр цилиндровых втулок, мм</th>
                        <th rowspan="2">скорость агрегата или число двойных ходов бурового насоса</th>
                        <th rowspan="2">суммарная производительность агрегатов (бурового насосов), л/с</th>
                        <th colspan="2">давление, кгс/см2</th>
                        <th rowspan="2">объем порции на данном режиме</th>
                    </tr>
                    <tr>
                        <th>допустимое для агрегатов (буровых  насос)</th>
                        <th>на устье скважины в конце операции</th>
                        <th>в данном режиме</th>
                        <th>нарастающее от начала затворения до момента «стоп»</th>
                    </tr>
                    <tr>
                        <td v-for="i in 16">{{i}}</td>
                    </tr>
                    <tr>
                        <td rowspan="8" class="text-left align-text-top">1</td>
                        <td rowspan="8" v-for="i in 2"></td>
                        <td rowspan="2" v-for="i in 2"></td>
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr>
                        <td rowspan="4" v-for="i in 2" class="blueRow"></td>
                        <td rowspan="4" v-for="i in 2" class="blueRow"></td>
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr v-for="i in 3">
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr>
                        <td  rowspan="2" v-for="i in 3"></td>
                        <td v-for="i in 9"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 9"></td>
                    </tr>
                    <tr>
                        <td rowspan="10" class="text-left align-text-top">2</td>
                        <td rowspan="10" v-for="i in 2"></td>
                        <td v-for="i in 13"></td>
                    </tr>
                    <tr>
                        <td rowspan="2" v-for="i in 2" class="blueRow"></td>
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr>
                        <td rowspan="3" v-for="i in 2" class="blueRow"></td>
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr v-for="i in 2">
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr v-for="i in 2">
                        <td colspan="2"></td>
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr>
                        <td rowspan="2" v-for="i in 3"></td>
                        <td v-for="i in 10"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 10"></td>
                    </tr>
                    <tr>
                        <td rowspan="10" class="text-left align-text-top">3</td>
                        <td rowspan="10" v-for="i in 2"></td>
                        <td v-for="i in 13"></td>
                    </tr>
                    <tr v-for="i in 5">
                        <td v-for="i in 13"></td>
                    </tr>
                    <tr v-for="i in 2">
                        <td colspan="2"></td>
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr>
                        <td rowspan="2" v-for="i in 3"></td>
                        <td v-for="i in 10"></td>
                    </tr>
                    <tr>
                        <td v-for="i in 10"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.13. Схема обвязки и потребность в цементировочных агрегатах</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="4">Номер колонны в порядке спуска</th>
                        <th rowspan="4">Номер части колонны</th>
                        <th rowspan="4">Номер ступени цементирования</th>
                        <th rowspan="2" colspan="2">Интервал цементирования</th>
                        <th rowspan="4">Номер схемы обвязки цементировочной техники</th>
                        <th colspan="11">Потребное количество</th>
                    </tr>
                    <tr>
                        <th colspan="8">Основные ЦА</th>
                        <th colspan="3">Дополнительные ЦА</th>
                    </tr>
                    <tr>
                        <th rowspan="2">от, (верх)</th>
                        <th rowspan="2">до, (низ)</th>
                        <th rowspan="2">тип</th>
                        <th rowspan="2">всего</th>
                        <th colspan="6">в том числе на:</th>
                        <th rowspan="2">тип</th>
                        <th rowspan="2">всего</th>
                        <th rowspan="2">резерв</th>
                    </tr>
                    <tr>
                        <th>затворение</th>
                        <th>перемешивание</th>
                        <th>Закачка</th>
                        <th>продавка</th>
                        <th>амбар</th>
                        <th>резерв</th>
                    </tr>
                    <tr>
                        <td v-for="i in 17">{{i}}</td>
                    </tr>
                    <tr>
                        <td class="text-left">1</td>
                        <td v-for="i in 16"></td>
                    </tr>
                    <tr>
                        <td rowspan="3" class="blueRow text-left align-text-top">2</td>
                        <td rowspan="3" v-for="i in 5" class="blueRow"></td>
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr v-for="i in 2">
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr>
                        <td rowspan="3" class="blueRow text-left align-text-top">3</td>
                        <td rowspan="3" v-for="i in 5" class="blueRow"></td>
                        <td v-for="i in 11"></td>
                    </tr>
                    <tr v-for="i in 2">
                        <td v-for="i in 11"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.14. Потребность в смесительных машинах, цементовозах и автоцистернах</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="4">Номер колонны в порядке спуска</th>
                        <th rowspan="4">Номер  части колонны</th>
                        <th rowspan="4">Номер ступени цементирования</th>
                        <th rowspan="2" colspan="2">Интервал, м</th>
                        <th colspan="14">Потребное количество</th>
                    </tr>
                    <tr>
                        <th colspan="5">Смесительные машины</th>
                        <th colspan="4">Цементовозы</th>
                        <th colspan="5">Автоцистерны</th>
                    </tr>
                    <tr>
                        <th rowspan="2">от (верх)</th>
                        <th rowspan="2">до (низ)</th>
                        <th rowspan="2">тип</th>
                        <th rowspan="2">всего</th>
                        <th colspan="3">в том числе</th>
                        <th rowspan="2">тип</th>
                        <th rowspan="2">всего</th>
                        <th colspan="3">в том числе</th>
                        <th rowspan="2">тип</th>
                        <th rowspan="2">всего</th>
                        <th colspan="3">в том числе</th>
                    </tr>
                    <tr>
                        <th>тампонаж-1</th>
                        <th>тампонаж-2</th>
                        <th>тампонаж-3</th>
                        <th>тампонаж-1</th>
                        <th>тампонаж-2</th>
                        <th>буферная</th>
                        <th>затворение</th>
                        <th>продавочная</th>
                    </tr>
                    <tr>
                        <td v-for="i in 19">{{i}}</td>
                    </tr>
                    <tr v-for="i in 3">
                        <td>{{i}}</td>
                        <td v-for="i in 18"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.15. Потребное количество цементировочной техники для цементирования обсадных колонн</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="3">№ по порядку</th>
                        <th rowspan="3">Название или шифр</th>
                        <th colspan="4">Потребное количество, шт.</th>
                    </tr>
                    <tr>
                        <th colspan="3">номера колонн (см. таблицу 1.5.2., графа 1)</th>
                        <th rowspan="2">суммарное на скважину</th>
                    </tr>
                    <tr>
                        <th v-for="i in 3">{{i}}</th>
                    </tr>
                    <tr>
                        <td v-for="i in 6">{{i}}</td>
                    </tr>
                    <tr v-for="i in 6">
                        <td v-for="i in 6"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.16. Потребное количество материалов для цементирования обсадных колонн</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th rowspan="4">Номер по порядку</th>
                        <th rowspan="4">Название или шифр</th>
                        <th rowspan="4">ГОСТ, ОСТ, МРТУ, ТУ, МУ и т.п. на изготовление</th>
                        <th rowspan="4">Единица измерения</th>
                        <th colspan="4">Потребное количество</th>
                    </tr>
                    <tr>
                        <th colspan="3">Номера колонн (см. таблицу 1.5.2, графа 1)</th>
                        <th rowspan="2">Суммарное на скважину</th>
                    </tr>
                    <tr>
                        <th rowspan="2">0-30</th>
                        <th rowspan="2">0-160</th>
                        <th rowspan="2">0-740</th>
                    </tr>
                    <tr>
                        <th></th>
                    </tr>
                    <tr>
                        <th v-for="i in 8">{{i}}</th>
                    </tr>
                    <tr v-for="i in 14">
                        <td>{{i}}</td>
                        <td v-for="i in 7"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="black">Табл. 1.9.17. Спецификация устьевого и противовыбросового оборудования (ПВО)</div>
                <table class="table defaultTable">
                    <tbody>
                    <tr>
                        <th colspan="2">Обсадная колонна</th>
                        <th rowspan="2">Номер схемы обвязки ПВО</th>
                        <th colspan="2">Давление опрессовки устьевого оборудования и ПВО,  МПа</th>
                        <th rowspan="2">Типоразмер, шифр или название устанавливаемого устьевого и ПВО оборудования</th>
                        <th rowspan="2">ГОСТ, ОСТ, МРТУ, ТУ, МУ и т. д. на изготовление</th>
                        <th rowspan="2">Количество, шт.</th>
                        <th rowspan="2">Допустимое рабочее давление, МПа</th>
                    </tr>
                    <tr>
                        <th>номер в порядке спуска</th>
                        <th>название</th>
                        <th>после установки</th>
                        <th>перед вскрытием напорного горизонта</th>
                    </tr>
                    <tr>
                        <td v-for="i in 9">{{i}}</td>
                    </tr>
                    <tr v-for="i in 2">
                        <td>{{i+1}}</td>
                        <td v-for="i in 8"></td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </report-download>
    </div>
</template>

<script>
    export default {
        name: "well-fastening",
        data(){
            return{
                download: false
            }
        },
    }
</script>

<style scoped>
</style>